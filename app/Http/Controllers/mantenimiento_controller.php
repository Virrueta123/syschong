<?php

namespace App\Http\Controllers;

use App\Models\accesorios;
use App\Models\accesorios_inventario_detalle;
use App\Models\activaciones;
use App\Models\autorizaciones;
use App\Models\cortesias_activacion;
use App\Models\cotizacion;
use App\Models\cotizacioncotizacion_detalle;
use App\Models\inventario_autorizaciones;
use App\Models\inventario_moto;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class mantenimiento_controller extends Controller
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
        //$whatsapp = new whatsapp_api();
        //$whatsapp->sendMessage();

        //dd($whatsapp);

        $fecha_actual = Carbon::now();
        if (request()->ajax()) {
            return DataTables::of(
                activaciones::with([
                    'moto' => function ($query) {
                        $query->with(['modelo', 'cliente']);
                    },
                    'cortesias',
                ])->where('activado_taller', 'N'),
            )
                ->addColumn('action', static function ($Data) {
                    $activaciones_id = encrypt_id($Data->activaciones_id);
                    return view('buttons.mantenimiento', ['activaciones_id' => $activaciones_id]);
                })
                ->addColumn('cliente', function ($Data) {
                    if ($Data->moto->cliente->cli_ruc != 'no tiene') {
                        return $Data->moto->cliente->cli_razon_social;
                    } else {
                        return $Data->moto->cliente->cli_nombre . ' ' . $Data->moto->cliente->cli_apellido;
                    }
                })
                ->addColumn('dnioruc', function ($Data) {
                    if ($Data->moto->cliente->cli_ruc != 'no tiene') {
                        return $Data->moto->cliente->cli_ruc;
                    } else {
                        return $Data->moto->cliente->cli_dni;
                    }
                })
                ->addColumn('marca', function ($Data) {
                    return $Data->moto->modelo->marca->marca_nombre;
                })
                ->addColumn('modelo', function ($Data) {
                    return $Data->moto->modelo->modelo_nombre;
                })
                ->addColumn('motor', function ($Data) {
                    return $Data->moto->mtx_motor;
                })
                ->addColumn('vin', function ($Data) {
                    return $Data->moto->mtx_vin;
                })
                ->addColumn('mantenimiento', function ($Data) {
                    return count($Data->cortesias);
                })
                ->toJson();
        }

        $html = $builder
            ->columns([
                Column::computed('cliente')->title('Cliente / razon social'),
                Column::computed('dnioruc')->title('Dni / Ruc'),
                Column::computed('marca')->title('Marca'),
                Column::computed('modelo')->title('modelo'),
                Column::computed('motor')->title('Motor'),
                Column::computed('vin')->title('Vin'),
                Column::computed('mantenimiento')->title('N de mantenimientos'),
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
        return view('modules.mantenimiento.index', compact('html'));
    }

    public function sub_mantenimiento($id){
        dd($id);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accesorios = accesorios::all();
        $autorizaciones = autorizaciones::all();
        return view('modules.mantenimiento.create', compact('accesorios', 'autorizaciones'));
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
    public function show($id, Builder $builder)
    {
        $activaciones_id = decrypt_id($id);

        $get = activaciones::with([
            'moto' => function ($query) {
                return $query->with([
                    'cliente',
                    'modelo' => function ($query) {
                        return $query->with(['marca']);
                    },
                ]);
            },
            'cortesias',
            'vendedor',
            'tienda',
        ])->find($activaciones_id);

        $fecha_actual = Carbon::now();
        if (request()->ajax()) {
            return DataTables::of(
                cortesias_activacion::with(['cotizacion', 'mecanico'])
                    ->where('activaciones_id', $activaciones_id)
                    ->where('tipo', 'M')
                    ->orderBy('created_at', 'desc'),
            )
                ->addColumn('action', static function ($Data) {
                    $cortesias_activacion_id = encrypt_id($Data->cortesias_activacion_id);
                    return view('buttons.mantenimientos', ['cortesias_activacion_id' => $cortesias_activacion_id]);
                })
                ->addColumn('cotizacion', function ($Data) {
                    if ($Data->cotizacion == '') {
                        return 'no hay cotizacion';
                    } else {
                        return $Data->cotizacion->total_descuento;
                    }
                })
                ->addColumn('mecanico', function ($Data) {
                    return $Data->mecanico->name . ' ' . $Data->mecanico->lastname;
                })
                ->addColumn('km', function ($Data) {
                    return $Data->km . ' KM';
                })
                ->addColumn('Isxz', function ($Data) {
                    return $Data->km . ' KM';
                })
                ->toJson();
        }

        $html = $builder
            ->columns([
                Column::computed('mecanico')->title('mecanico'),
                Column::computed('cotizacion')->title('cotizacion'),
                Column::computed('km')->title('Kilometraje'),
                Column::make('numero_corterisa')->title('Numero de Mantenimiento'),
                Column::make('numero_corterisa')->title('Numero de Mantenimiento'),
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

        return view('modules.mantenimiento.show', ['get' => $get, 'id' => $id, 'html' => $html]);
    }

    function view_mantenimiento($id)
    {
        $cortesia = cortesias_activacion::with(['cotizacion', 'mecanico', 'usuario'])->find(decrypt_id($id));

        $inventario = inventario_moto::with([
            'moto' => function ($query) {
                $query->with('cliente');
            },
        ])->find($cortesia->inventario_moto_id);

     

        $inventario_moto_id = encrypt_id($inventario->inventario_moto_id);

        $accesorios = accesorios_inventario_detalle::with('accesorios')
            ->where('inventario_moto_id', $inventario->inventario_moto_id)
            ->get();

        $autorizaciones = inventario_autorizaciones::with('autorizaciones')
            ->where('inventario_moto_id', $inventario->inventario_moto_id)
            ->get();

        return view('modules.mantenimiento.show_mantenimiento', compact('cortesia', 'inventario', 'inventario_moto_id', 'accesorios', 'autorizaciones'));
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

    /* ******** vista para crear la cotiazacion del mantenimiento ************* */

    public function cotizacion_mantenimiento($id)
    {
        $cortesia = cortesias_activacion::with([
            'activaciones' => function ($query) {
                return $query->with([
                    'moto' => function ($query) {
                        return $query->with('cliente');
                    },
                ]);
            },
            'cotizacion',
            'mecanico',
            'usuario',
        ])->find(decrypt_id($id));

       

        $inventario = inventario_moto::with([
            'moto' => function ($query) {
                $query->with('cliente');
            },
        ])->find($cortesia->inventario_moto_id);

        $inventario_moto_id = encrypt_id($inventario->inventario_moto_id);

        $accesorios = accesorios_inventario_detalle::with('accesorios')
            ->where('inventario_moto_id', $inventario->inventario_moto_id)
            ->get();

        $autorizaciones = inventario_autorizaciones::with('autorizaciones')
            ->where('inventario_moto_id', $inventario->inventario_moto_id)
            ->get();

        $mecanicos = $mecanicos = User::where('roles_id', 2)->get();

        return view('modules.mantenimiento.cotizacion_mantenimiento', compact('cortesia', 'mecanicos', 'inventario', 'inventario_moto_id', 'accesorios', 'autorizaciones'));
    }

    /* *********************** */

    /* crear una cotizacion para un mantenimiento */

    public function cotizacion_mantenimiento_store($id, Request $request)
    {
        $Datax = $request->all();

        // Crear una nueva instancia del modelo
        $cotizacion = new cotizacion();

        $correlativo = cotizacion::max('cotizacion_correlativo');
        if (is_null($correlativo)) {
            $correlativo = 1;
        } else {
            $correlativo++;
        }

        $cortesias = cortesias_activacion::with([
            'activaciones' => function ($query) {
                return $query->with([
                    'moto' => function ($query) {
                        return $query->with('cliente');
                    },
                ]);
            },
            'cotizacion',
            'mecanico',
            'usuario',
        ])->find(decrypt_id($id));

        // Asignar valores a los campos
        $cotizacion->inventario_moto_id = $cortesias->inventario_moto_id;
        $cotizacion->observacion_sta = $Datax['observacion_sta'];
        $cotizacion->total = $Datax['total'];
        $cotizacion->cotizacion_correlativo = $correlativo;
        $cotizacion->total_descuento = $Datax['total_descuento'];
        $cotizacion->user_id = Auth::id(); // ID del usuario relacionado
        $cotizacion->mecanico_id = $Datax['mecanico_id']; // ID del mecánico relacionado
        $cotizacion->trabajo_realizar = $Datax['trabajo_realizar'];

        if ($cotizacion->save()) {
            foreach ($Datax['cotizacion'] as $ps) {
                // Crear una nueva instancia del modelo
                $cotizaion_detalle = new cotizacioncotizacion_detalle();

                // Asignar valores a los campos
                $cotizaion_detalle->cotizacion_id =  $cotizacion->cotizacion_id ; // ID de la cotización relacionada
                $cotizaion_detalle->prod_id = $ps['prod_id']; // ID del producto relacionado
                $cotizaion_detalle->servicios_id = $ps['servicios_id']; // ID del servicio relacionado
                $cotizaion_detalle->tipo = $ps['tipo']; // 'P' para producto, 'S' para servicio, ajusta según sea necesario
                $cotizaion_detalle->Precio = $ps['Precio'];
                $cotizaion_detalle->Importe = $ps['Importe'];
                $cotizaion_detalle->ImporteDescuento = $ps['ImporteDescuento'];
                $cotizaion_detalle->Descuento = $ps['Descuento'];
                $cotizaion_detalle->Descripcion = $ps['Descripcion'];
                $cotizaion_detalle->Codigo = $ps['Codigo'];
                $cotizaion_detalle->Cantidad = $ps['Cantidad'];
                $cotizaion_detalle->ValorDescuento = $ps['ValorDescuento'];
                $cotizaion_detalle->Detalle = $ps['Detalle'];

                // Guardar el registro en la base de datos
                $cotizaion_detalle->save();
            }

            // Encontrar el registro por su ID
            $cortesias_activacion = cortesias_activacion::findOrFail(decrypt_id($id));

            // Actualizar el registro con los nuevos datos
            $cortesias_activacion->update(['cotizacion_id' => $cotizacion->cotizacion_id]);

            session()->flash('success', 'Registro creado correctamente');
            return redirect()->route('cotizaciones.show',  encrypt_id($cotizacion->cotizacion_id ));
        } else {
           
            Log::error('no se pudo registrar la cotizacion');
            session()->flash('error', 'error al registrar en la base de datos');
            return redirect()->route('cotizacion.create', $Datax['id']);
        }
    }

    /* ******** axios vue ************* */

    public function create_vue_mantenimiento(Request $request)
    {
        $ultimo_registro = inventario_moto::max('inventario_numero');

        if ($ultimo_registro) {
            $ultimo_registro++;
        } else {
            $ultimo_registro = 1;
        }

        $datax = $request->all();

        $select_acesorios = json_decode($datax['select_acesorios']);
        $select_autorizacion = json_decode($datax['select_autorizacion']);

        $validate = $request->validate([
            'inventario_moto_obs_cliente' => 'required',
            'inventario_moto_nivel_gasolina' => 'required',
        ]);

        $validate['inventario_numero'] = $ultimo_registro;
        $validate['inventario_moto_kilometraje'] = $datax['km'];
        $validate['mtx_id'] = $datax['mtx_id'];

        $create = inventario_moto::create($validate);

        if ($create) {
            // Crear una nueva instancia del modelo
            $activaciones = new activaciones();
            // Establecer los valores de los campos
            $activaciones->moto_id = $datax['mtx_id'];
            $activaciones->activado_taller = 'N';
            $activaciones->precio = $datax['precio'];
            $activaciones->user_id = auth()->user()->id;
            $activaciones->start_cortesia = 1;
            $activaciones->tienda_cobrar = 0;
            $activaciones->save();

            $numero_corterisa = cortesias_activacion::where('activaciones_id', $activaciones->activaciones_id)
                ->select('numero_corterisa')
                ->max('numero_corterisa');
            if (is_null($numero_corterisa)) {
                $numero_corterisa = 1;
            } else {
                $numero_corterisa++;
            }

            $cortesias_activacion = new cortesias_activacion();
            $cortesias_activacion->activaciones_id = $activaciones->activaciones_id; // Reemplaza con el valor deseado
            $cortesias_activacion->km = $datax['km']; // Reemplaza con el valor deseado
            $cortesias_activacion->user_id = auth()->user()->id; // Reemplaza con el valor deseado
            $cortesias_activacion->precio = $datax['precio']; // Reemplaza con el valor deseado
            $cortesias_activacion->tipo = 'M'; // Si no deseas eliminar lógicamente el registro
            $cortesias_activacion->numero_corterisa = $numero_corterisa; // Reemplaza con el valor deseado
            $cortesias_activacion->inventario_moto_id = $create->inventario_moto_id; // Reemplaza con el valor deseado
            $cortesias_activacion->mecanico_id = $datax['mecanico_id']; // Reemplaza con el valor deseado
            $cortesias_activacion->mtx_id = $datax['mtx_id']; // Reemplaza con el valor deseado
            $cortesias_activacion->is_aviso = $request->all()['is_aviso'] == 'true' ? 'S' : 'A';
            $cortesias_activacion->dias = $datax['dias'];
            $cortesias_activacion->date_aviso = Carbon::now()->addDays($datax['dias']);
            $cortesias_activacion->aceite_id = $datax['aceite_id'];
            $cortesias_activacion->save();

            foreach ($select_autorizacion as $autorizacion) {
                $create_autorizaciones = new inventario_autorizaciones();
                $create_autorizaciones->inventario_moto_id = $create->inventario_moto_id;
                $create_autorizaciones->aut_id = $autorizacion->identificador;
                $create_autorizaciones->save();
            }
            foreach ($select_acesorios as $accesorio) {
                $accesorios_inventario_detalle = new accesorios_inventario_detalle();
                $accesorios_inventario_detalle->inventario_moto_id = $create->inventario_moto_id;
                $accesorios_inventario_detalle->accesorios_inventario_id = $accesorio->identificador;
                $accesorios_inventario_detalle->estado = $accesorio->estado;
                $accesorios_inventario_detalle->save();
            }

            session()->flash('success', 'Mantenimiento | Registro creado correctamente');

            return response()->json([
                'message' => 'se creo correctamente el mantenimiento',
                'error' => '',
                'success' => true,
                'data' => route('mantenimiento.show', encrypt_id($activaciones->activaciones_id)),
            ]);
        } else {
            Log::error('no se pudo registrar el inventario de la moto');
            session()->flash('error', 'error al registrar en la base de datos');
            dd('error');
            return redirect()->route('inventario_moto.index');
        }
    }

    /* *********************** */
}
