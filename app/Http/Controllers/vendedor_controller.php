<?php

namespace App\Http\Controllers;

use App\Models\vendedor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class vendedor_controller extends Controller
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
                vendedor::where("active","A")
                    ->orderBy('created_at', 'asc')
                    ->get(),
            )
                ->addColumn('action', static function ($Data) {
                    $modelo_id = encrypt_id($Data->modelo_id);
                    return view('buttons.modelo', ['modelo_id' => $modelo_id]);
                }) 
                ->addColumn('estado', static function ($Data) {
                    $estado  = $Data->active;
                    return view('complementos.active', ['estado' => $estado]);
                })
                ->addColumn('fecha_creacion', static function ($Data) {
                    return Carbon::parse($Data->created_at)->format("d/m/Y");
                })
                ->toJson();
        }

        $html = $builder
            ->columns([
                Column::make('vendedor_nombres')->title('Nombre Vendedor'),
                Column::make('estado')->title('Estado'),
                Column::make('fecha_creacion')->title('Fecha Creacion'), 
                Column::make('action')
                    ->title('Opcion')
                    ->exportable(false)
                    ->printable(false),
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

        return view('modules.vendedor.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 
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
        //
    }

    public function search_vendedor(Request $req)
    {
        
        $vendedor = vendedor::select(DB::raw('vendedor_id AS id'), 'vendedor_nombres as name')
            ->where('vendedor_nombres', 'like', '%' . $req->all()['search'] . '%')
            ->where('tienda_id', $req->all()['tienda_id'])
            ->limit(9)
            ->get();
        echo json_encode($vendedor);
    }

        public function crear_vendedor(Request $request)
    {
        
        try {
            
            $datax = $request->all();
            $validate = $request->validate([
                'vendedor_nombres' => 'required|string|max:250',
                "tienda_id"=>'required',
            ]); 

            $unique_vendedor = vendedor::where('vendedor_nombres', $datax['vendedor_nombres'])->where("tienda_id",$datax['tienda_id'])->first();

            if ($unique_vendedor) {
                return response()->json([
                    'message' => 'Este vendedor ya existe en esta tienda',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
            } else {
                $create = vendedor::create($validate);
                if ($create) {
                    return response()->json([
                        'message' => 'se creo correctamente un vendedor',
                        'error' => '',
                        'success' => true,
                        'data' => ['value' => $create->vendedor_id, 'title' => $create->vendedor_nombres],
                    ]);
                } else {
                    Log::error('no se pudo registrar el vendedor');
                    return response()->json([
                        'message' => 'no se pudo registrar el vendedor',
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
