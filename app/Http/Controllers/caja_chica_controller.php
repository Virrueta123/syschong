<?php

namespace App\Http\Controllers;

use App\Models\caja_chica;
use App\Models\compras;
use App\Models\forma_pago;
use App\Models\pagos_ventas;
use App\Models\ventas;
use Barryvdh\DomPDF\Facade\Pdf;
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
            return DataTables::of(
                caja_chica::with(['usuario'])
                    ->orderBy('created_at', 'asc')
                    ->get(),
            )
                ->addColumn('action', static function ($Data) {
                    $caja_chica_id = encrypt_id($Data->caja_chica_id);
                    return view('buttons.caja', ['caja_chica_id' => $caja_chica_id, 'is_abierto' => $Data->is_abierto]);
                })
                ->addColumn('fecha_cierra', static function ($Data) {
                    if ($Data->is_abierto == 'C') {
                        return Carbon::parse($Data->fecha_cierra)->format('Y-m-d');
                    } else {
                        return 'Caja Abierta';
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
        $apertura_caja = caja_chica::where('is_abierto', 'Y')
            ->where('user_id', Auth::id())
            ->first();
        if (is_null($apertura_caja)) {
            return view('modules.caja.create');
        } else {
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
        return view('modules.caja.show', compact('show', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $get = caja_chica::find(decrypt_id($id));
        return view('modules.caja.edit', compact('get', 'id'));
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
        $datax = $request->all();

        $validate = $request->validate([
            'referencia' => 'required',
            'saldo_inicial' => 'required',
        ]);

        $validate['user_id'] = Auth::user()->id;

        $caja_chica = caja_chica::findOrFail(decrypt_id($id));
        $caja_chica->referencia = $validate['referencia'];
        $caja_chica->saldo_inicial = $validate['saldo_inicial'];

        if ($caja_chica->update()) {
            session()->flash('success', 'se edito correctamente la caja');
            return redirect()->route('caja.index');
        } else {
            Log::error('no se edito correctamente la caja');
            session()->flash('error', 'no se edito correctamente la caja');
            return redirect()->route('caja.index');
        }
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

    public function cerrar($id)
    {
        $caja = caja_chica::with(['pagos'])->find(decrypt_id($id));

        if (count($caja->pagos) != 0) {
            $caja->is_abierto = 'C';

            $compras = $caja->pagos->where('tipo', 'C')->sum('monto');
            $ventas = $caja->pagos->where('tipo', 'V')->sum('monto');
            $caja->saldo_final = $caja->saldo_inicial + $ventas - $compras;
            $caja->fecha_cierre = Carbon::now();
            $caja->cierre = Carbon::now();
            $caja->update();
            session()->flash('success', 'se cerró correctamente la caja');
            return redirect()->route('caja.index');
        } else {
            session()->flash('error', 'no se pudo cerrar la caja por que no tiene pagos ni ventas');
            return redirect()->route('caja.index');
        }
    }

    public function reporte($id)
    {
         
        $get = caja_chica::with([
             "usuario","pagos"
             ,"ventas" => function ($query) {
                $query->with(["pagos"=> function ($query) {
                    $query->with(["forma_pago"]);
                 }]);
             },
             "compras" => function ($query) {
                $query->with(["pagos"=> function ($query) {
                    $query->with(["forma_pago"]);
                 }]);
             },
             "gastos" => function ($query) {
                $query->with(["pagos"=> function ($query) {
                    $query->with(["forma_pago"]);
                 }]);
             }
        ])->find(decrypt_id($id));
 
        $calcular_ingresos =  ventas::whereIn("tipo_comprobante",["N","F", "B"])->where("caja_chica_id",decrypt_id($id))->whereIn("estado",["A","R"])->sum("SubTotal");

        $calcular_gastos =  pagos_ventas::where("tipo","G")->where("caja_chica_id",decrypt_id($id))->sum("monto");

        $calcular_compras = pagos_ventas::where("tipo","C")->where("caja_chica_id",decrypt_id($id))->sum("monto");
             
        if ($get) {
            $pdf = Pdf::loadView('pdf.caja_chica', ['get' => $get, 'id' => $id,'calcular_ingresos' => $calcular_ingresos,'calcular_gastos' => $calcular_gastos,'calcular_compras' => $calcular_compras]);

            return $pdf->stream();
        } else {
            return view('errors.404');
        }
    }
}
 