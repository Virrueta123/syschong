<?php

namespace App\Http\Controllers;

use App\Models\caja_chica;
use App\Models\forma_pago;
use App\Models\gastos;
use App\Models\image_pago;
use App\Models\pagos_ventas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class gastos_controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        $fecha_actual = Carbon::now();
        if (request()->ajax()) {
            return DataTables::of(
                gastos::with(["gastos_tipo"])->orderBy('created_at', 'asc')
                    ->get(),
            )
                ->addColumn('action', static function ($Data) {
                    $gastos_id = encrypt_id($Data->gastos_id);
                    return view('buttons.gastos', ['gastos_id' => $gastos_id]);
                })
                ->addColumn('total', static function ($Data) {
                    if ($Data->pagos) {
                        return $Data->pagos->sum("monto"); 
                    } 
                }) 
                ->addColumn('fecha_creacion', static function ($Data) {
                    return Carbon::parse($Data->created_at)->format('d/m/Y');
                })
                ->toJson();
        }

        $html = $builder
            ->columns([
                Column::make('gastos_nombre')->title('Nombre del gastos'), 
                Column::make('total')->title('Total del gasto'), 
                Column::make('fecha_creacion')->title('Fecha creacion'),
                Column::make('action') 
                    ->exportable(false)
                    ->printable(false)
            ])
            ->parameters([
                'dom' => 'Bfrtip',
                'buttons' => [
                    [
                        'text' => '<i class="fa fa-bars"></i> columnas visibles',
                        'extend' => 'colvis',
                    ],
                    [
                        'text' => '<i class="fa fa-copy"></i> Copiar',
                        'extend' => 'copy',
                        'title' => 'tabla_cliente_fecha_' . $fecha_actual,
                    ],
                    [
                        'text' => '<i class="fa fa-file-csv"></i> Csv',
                        'extend' => 'csvHtml5',
                        'title' => 'tabla_cliente_fecha_' . $fecha_actual,
                    ],
                    [
                        'text' => '<i class="fa fa-file-excel"></i> Excel',
                        'extend' => 'excelHtml5',
                        'title' => 'tabla_cliente_fecha_' . $fecha_actual,
                    ],
                    [
                        'text' => '<i class="fa fa-file-pdf"></i> Pdf',
                        'extend' => 'pdfHtml5',
                        'title' => 'tabla_cliente_fecha_' . $fecha_actual,
                    ],
                    [
                        'text' => '<i class="fa fa-print"></i> Imprimir',
                        'extend' => 'print',
                        'title' => 'tabla_cliente_fecha_' . $fecha_actual,
                    ],
                ],
                'language' => [
                    'url' => url('//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'),
                ],
                'processing' => false,
                'serverSide' => true,
                'responsive' => true,
                'autoWidth' => false,
            ]);
        //php artisan vendor:publish --tag=datatables-buttons

        return view('modules.gastos.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $forma_pago = forma_pago::where('estado', 'A')->get();
         return view('modules.gastos.create',["forma_pago"=>$forma_pago]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $delete = gastos::find(decrypt_id($id));
 
            if ($delete->delete()) { 

                pagos_ventas::where('gastos_id',decrypt_id($id))->delete();

                session()->flash('success', 'se elimino correctamente el gasto');
                return redirect()->route('gastos.index');
            } else {
                session()->flash('success', 'error al eliminar el gasto');
                return redirect()->route('gastos.index');
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'error al eliminar este registro');
            return redirect()->route('gastos.index');
        }
    }

    public function crear_gasto(Request $request){
        try {
            $datax = $request->all();
            $validate = $request->validate([
                'gastos_nombre' => 'required|string|max:200',
            ]);

            $validate['user_id'] = Auth::user()->id;
             
            $caja_chica = caja_chica::where("user_id", auth()->user()->id)->where("is_abierto","Y")->first()->caja_chica_id;
            $validate['caja_chica_id'] = $caja_chica;
            $unique_marca_nombre = gastos::where('gastos_nombre', $datax['gastos_nombre'])->first();

            if ($unique_marca_nombre) {
                return response()->json([
                    'message' => 'Este gasto ya existe',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
            } else {
                $create = gastos::create($validate);
                if ($create) {

                    foreach ($datax['pagos'] as $pago) {
                        if($pago['monto'] != 0){
                            if ($pago['url'] != false) {
                                $pagosVentas = new pagos_ventas();
                                $pagosVentas->gastos_id = $create->gastos_id;
                                $pagosVentas->fecha_pago = Carbon::now();
                                $pagosVentas->monto = $pago['monto'];
                                $pagosVentas->forma_pago_id = $pago['forma_pago_id'];
                                $pagosVentas->referencia = $pago['referencia'];
                                $pagosVentas->imagen = 'Y';
                                $pagosVentas->tipo = 'G';
                                $pagosVentas->caja_chica_id = $caja_chica;
                                $pagosVentas->user_id = Auth::id();
                                $pagosVentas->save();
    
                                /* ******** insertar imagen al pago ************* */
                                $base64Data = $pago['url'];
                                $decodedData = base64_decode($base64Data);
                                $filename = Carbon::now()->format('Ymdhis') . '.jpg'; // Set the desired filename here
                                $path = 'fotos_pagos/' . $filename;
                                $add = Storage::disk('local')->put('public/' . $path, $decodedData);
    
                                if ($add) {
                                    $imagePago = new image_pago();
                                    $imagePago->url = $path;
                                    $imagePago->pagos_ventas_id = $pagosVentas->pagos_ventas_id;
                                    $imagePago->save();
                                }
                                /* *********************** */
                            } else {
                                $pagosVentas = new pagos_ventas();
                                $pagosVentas->gastos_id =  $create->gastos_id;
                                $pagosVentas->fecha_pago = Carbon::now();
                                $pagosVentas->monto = $pago['monto'];
                                $pagosVentas->forma_pago_id = $pago['forma_pago_id'];
                                $pagosVentas->referencia = $pago['referencia'];
                                $pagosVentas->imagen = 'N';
                                $pagosVentas->tipo = 'G';
                                $pagosVentas->caja_chica_id = $caja_chica;
                                $pagosVentas->user_id = Auth::id();
                                $pagosVentas->save();
                            }
                        }  
                    } 
                    return response()->json([
                        'message' => 'se creo correctamente un gasto',
                        'error' => '',
                        'success' => true,
                        'data' => "",
                    ]);
                } else {
                    Log::error('no se pudo registrar el gasto');
                    return response()->json([
                        'message' => 'no se pudo registrar el gasto',
                        'error' => '',
                        'success' => false,
                        'data' => '',
                    ]);
                }
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'message' => 'error del servidor',
                'error' => $th,
                'success' => false,
                'data' => '',
            ]);
        }
    }
}
