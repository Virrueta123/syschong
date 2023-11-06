<?php

namespace App\Http\Controllers;

use App\Models\caja_chica;
use App\Models\forma_pago;
use App\Models\pagos_ventas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class caja_chica_controller extends Controller
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
            return DataTables::of(caja_chica::with(['usuario'])->orderBy('created_at', 'asc'))
                ->addColumn('action', static function ($Data) {
                    $caja_chica_id = encrypt_id($Data->caja_chica_id);
                    return view('buttons.caja', ['caja_chica_id' => $caja_chica_id]);
                })
                ->addColumn('fecha_cierra', static function ($Data) {
                    if (is_null($Data->fecha_cierra)) {
                        return 'Caja Abierto';
                    } else {
                        return Carbon::parse($Data->fecha_cierra)->format('Y-m-d');
                    }
                })
                ->addColumn('created_at', static function ($Data) {
                    return Carbon::parse($Data->created_at)->format('Y-m-d');
                })
                ->addColumn('estado', static function ($Data) {
                    switch ($Data->is_abierto) {
                        case 'Y':
                            return 'Abierto';
                            break;

                        case 'C':
                            return 'Cerrado';
                            break;
                    }
                })
                ->toJson();
        }

        $html = $builder
            ->columns([
                Column::make('referencia')->title('Referencia'),
                Column::make('usuario.name')->title('Nombre'),
                Column::make('created_at')->title('Fecha apertura'),
                Column::make('saldo_inicial')->title('Saldo inicial'),
                Column::make('fecha_cierra')->title('Fecha Cierre'),
                Column::make('saldo_final')->title('Saldo cierre'),
                Column::make('estado')->title('Estado'),
                Column::computed('action')
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

        return view('modules.caja.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
        $apertura_caja = caja_chica::where('is_abierto', 'Y')->where("user_id",Auth::id())->first();
        if(is_null($apertura_caja)){
            return view('modules.caja.create');
        }else{
            session()->flash('error', 'ya esta creada una caja con este usuario');
            return redirect()->route('caja.index');
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $datax = $request->all();

            $validate = $request->validate([
                'referencia' => 'required',
                'saldo_inicial' => 'required',
            ]);

            $validate['user_id'] = Auth::user()->id;

            $create = caja_chica::create($validate);

            if ($create) {
                session()->flash('success', 'se creo correctamente la caja');
                return redirect()->route('caja.index');
            } else {
                Log::error('no se creo correctamente la caja');
                session()->flash('error', 'no se creo correctamente la caja');
                return redirect()->route('caja.index');
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'no se creo correctamente la caja');
            return redirect()->route('caja.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        
        $show = caja_chica::find(decrypt_id($id));
        return view("modules.caja.show",compact("show","id")); 
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

            $caja = caja_chica::findOrFail(decrypt_id($id));
          

            if ($caja->pagos()->exists()) {
                session()->flash('warning', 'No se puede eliminar esta caja por que ya tiene compras o ventas');
                return redirect()->route('caja.index');
            } else {
                $delete = $caja->delete(); 
                if ($delete) {
                    session()->flash('success', 'se elimino correctamente la caja');
                    return redirect()->route('caja.index');
                } else {
                    session()->flash('success', 'error al eliminar la caja');
                    return redirect()->route('caja.index');
                }
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'no se creo correctamente la caja');
            return redirect()->route('caja.index');
        }
    }
}
