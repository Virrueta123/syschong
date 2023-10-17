<?php

namespace App\Http\Controllers;

use App\Models\accesorios_inventario_detalle;
use App\Models\cotizacion;
use App\Models\cotizacioncotizacion_detalle;
use App\Models\cuentas;
use App\Models\empresa;
use App\Models\forma_pago;
use App\Models\inventario_autorizaciones;
use App\Models\inventario_moto;
use App\Models\User;
use App\Models\ventas;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use LengthException;
use Yajra\DataTables\Facades\DataTables;

class cotizacion_controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware("auth")->except([
            'cotizacion_show_cliente',
            "cotizacion_aprobada"
            // Adicione aqui o nome das rotas que você deseja excluir do middleware "auth"
        ]); 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fecha_actual = Carbon::now();
        if ($request->ajax()) {
            $cotizacion = cotizacion::with([
                'inventario' => function ($query) {
                    $query->with([
                        'moto' => function ($query) {
                            $query->with(['cliente']);
                        },
                    ]);
                },
            ])
                ->orderBy('created_at', 'desc')
                ->get();

            return DataTables::of($cotizacion)
                ->addIndexColumn()
                ->addColumn('cliente', function ($Data) {
                    return $Data->inventario->moto->cliente->cli_nombre . ' ' . $Data->inventario->moto->cliente->cli_apellido;
                })
                ->addColumn('moto_placa', function ($Data) {
                    return $Data->inventario->moto->mtx_placa;
                })
                ->addColumn('fecha_creacion', function ($Data) {
                    return Carbon::parse($Data->created_at)->format('d-m-Y');
                })
                ->addColumn('action', static function ($Data) {
                    $cotizacion_id = encrypt_id($Data->cotizacion_id);
                    return view('buttons.cotizacion', ['cotizacion_id' => $cotizacion_id]);
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('modules.cotizacion.index', ['fecha_actual' => $fecha_actual]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        try {
            $mecanicos = User::where('roles_id', 2)->get();
            $get = inventario_moto::with([
                'moto' => function ($query) {
                    $query->with('cliente');
                },
            ])->find(decrypt_id($id));

            if ($get) {
                $accesorios = accesorios_inventario_detalle::with('accesorios')
                    ->where('inventario_moto_id', decrypt_id($id))
                    ->get();
                $autorizaciones = inventario_autorizaciones::with('autorizaciones')
                    ->where('inventario_moto_id', decrypt_id($id))
                    ->get();
                return view('modules.cotizacion.create', ['get' => $get, 'accesorios' => $accesorios, 'autorizaciones' => $autorizaciones, 'id' => $id, 'mecanicos' => $mecanicos]);
            } else {
                return view('errors.404');
            }
        } catch (\Throwable $th) {
            Log::error(json_encode($th->getMessage(), true));

            session()->flash('error', 'error al entrar a esta ruta');
            return redirect()->back();
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
        /*try {*/
        $Datax = $request->all();

        // Crear una nueva instancia del modelo
        $cotizacion = new cotizacion();

        $correlativo = cotizacion::max('cotizacion_correlativo');
        if (is_null($correlativo)) {
            $correlativo = 1;
        } else {
            $correlativo++;
        }

        // Asignar valores a los campos
        $cotizacion->inventario_moto_id = decrypt_id($Datax['id']);
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
                $cotizaion_detalle->cotizacion_id = $cotizacion->cotizacion_id; // ID de la cotización relacionada
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

            session()->flash('success', 'Registro creado correctamente');
            return redirect()->route('cotizaciones.show', encrypt_id($cotizacion->cotizacion_id));
        } else {
            Log::error('no se pudo registrar la cotizacion');
            session()->flash('error', 'error al registrar en la base de datos');
            return redirect()->route('cotizacion.create', $Datax['id']);
        }
        /*
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            session()->flash('error', 'error al registrar');
            return redirect()->route('cotizacion.create',$Datax['id']);
        }*/
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $get = cotizacion::with([
            'inventario' => function ($query) {
                $query->with([
                    'moto' => function ($query) {
                        $query->with(['cliente', 'marca']);
                    },
                ]);
            },
            'mecanico',
            'detalle' => function ($query) {
                $query->with([
                    'servicio',
                    'producto' => function ($query) {
                        $query->with(['unidad']);
                    },
                ]);
            },
        ])->find(decrypt_id($id));

        $correlativo_factura = ventas::where('tipo_comprobante', 'F')->max('venta_correlativo');

        if (is_null($correlativo_factura)) {
            $correlativo_factura = 1;
        } else {
            $correlativo_factura++;
        }

        $correlativo_boleta = ventas::where('tipo_comprobante', 'B')->max('venta_correlativo');

        if (is_null($correlativo_boleta)) {
            $correlativo_boleta = 1;
        } else {
            $correlativo_boleta++;
        }

        $forma_pago = forma_pago::where('estado', 'A')->get();

        $empresa = empresa::select('ruc', 'celular', 'razon_social', 'direccion', 'ruc')->first();

        if ($get) {
            return view('modules.cotizacion.show', ['get' => $get, 'id' => $id, 'empresa' => $empresa, 'correlativo_factura' => $correlativo_factura, 'correlativo_boleta' => $correlativo_boleta, 'forma_pago' => $forma_pago]);
        } else {
            return view('errors.404');
        }
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

    // crear factura

    public function emitir_factura_cotizacion(Request $request)
    {
        $Datax = $request->all();
        dd($Datax);

        $detalle = cotizacioncotizacion_detalle::with([
            'inventario' => function ($query) {
                $query->with([
                    'moto' => function ($query) {
                        $query->with(['cliente', 'marca']);
                    },
                ]);
            },
            'mecanico',
            'detalle' => function ($query) {
                $query->with([
                    'servicio',
                    'producto' => function ($query) {
                        $query->with(['unidad']);
                    },
                ]);
            },
        ])
            ->where('cotizacion_id', $Datax['cotizacion_id'])
            ->first();

        try {
            $Datax = $request->all();
            if (true) {
                return response()->json([
                    'message' => '',
                    'error' => '',
                    'success' => true,
                    'data' => '',
                ]);
            } else {
                Log::error('no se pudo registrar la marca de producto');
                return response()->json([
                    'message' => 'no se puedo actualizar la cotizacion a enviada',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                'message' => 'error del servidor',
                'error' => $th->getMessage(),
                'success' => false,
                'data' => '',
            ]);
        }
    }

    public function pdf($id)
    {
        $cuentas = cuentas::where('estado', 'A')->get();
        $get = cotizacion::with([
            'inventario' => function ($query) {
                $query->with([
                    'moto' => function ($query) {
                        $query->with(['cliente', 'marca']);
                    },
                ]);
            },
            'mecanico',
            'detalle' => function ($query) {
                $query->with([
                    'servicio',
                    'producto' => function ($query) {
                        $query->with(['unidad']);
                    },
                ]);
            },
        ])->find(decrypt_id($id));

        if ($get) {
            $pdf = Pdf::loadView('pdf.cotizacion', ['get' => $get, 'id' => $id, 'cuentas' => $cuentas]);

            return $pdf->stream();
        } else {
            return view('errors.404');
        }
    }

    public function cotizacion_show_cliente($id)
    {
        $get = cotizacion::with([
            'inventario' => function ($query) {
                $query->with([
                    'moto' => function ($query) {
                        $query->with(['cliente', 'marca']);
                    },
                ]);
            },
            'mecanico',
            'detalle' => function ($query) {
                $query->with([
                    'servicio',
                    'producto' => function ($query) {
                        $query->with(['unidad']);
                    },
                ]);
            },
        ])->find(decrypt_id($id));
        return view('modules.cotizacion.show_cliente', ['get' => $get]);
    }
    /* ******** cotizacion aprobada whatsapp ************* */
    public function cotizacion_enviada_whatsapp(Request $request)
    {
        try {
            $now = Carbon::now();
            $saludo = 'Buenos días';

            $cotizacion_id = $request->all()['cotizacion_id'];

            $cotizacion = cotizacion::with([
                'inventario' => function ($query) {
                    $query->with([
                        'moto' => function ($query) {
                            $query->with(['cliente']);
                        },
                    ]);
                },
            ])->find($cotizacion_id);

            $update = cotizacion::find($cotizacion_id);

            $update->progreso = 1;
            if ($update->save()) {
                $whatsapp = new whatsapp_api();
                $whatsapp->nombre_cliente = $cotizacion->inventario->moto->cliente->cli_nombre;
                $whatsapp->saludo = $saludo;
                $whatsapp->celular_cliente = $cotizacion->inventario->moto->cliente->cli_telefono;
                $whatsapp->numero_cotizacion = 'C' . $cotizacion->cotizacion_serie . '-' . $cotizacion->cotizacion_correlativo;
                $whatsapp->link_pdf = 'https://ocw.uca.es/pluginfile.php/1491/mod_resource/content/1/El_principe_Maquiavelo.pdf';
                $whatsapp->link_aprobacion = 'cotizacion/' . encrypt_id($cotizacion_id) . '/cliente';

                return response()->json([
                    'message' => $whatsapp->sendMessage(),
                    'error' => '',
                    'success' => true,
                    'data' => '',
                ]);
            } else {
                Log::error('no se pudo registrar la marca de producto');
                return response()->json([
                    'message' => 'no se puedo actualizar la cotizacion a enviada',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                'message' => 'error del servidor',
                'error' => $th->getMessage(),
                'success' => false,
                'data' => '',
            ]);
        }
    }
    /* *********************** */
    /* ******** cambiar estado de cotizacion ************* */

    public function cotizacion_enviada(Request $request)
    {
        try {
            $cotizacion_id = $request->all()['cotizacion_id'];

            
            $update = cotizacion::find($cotizacion_id);

            $update->progreso = 1;
            if ($update->save()) {
                return response()->json([
                    'message' => 'actualizacion exitosa',
                    'error' => '',
                    'success' => true,
                    'data' => '',
                ]);
            } else {
                Log::error('no se pudo registrar la marca de producto');
                return response()->json([
                    'message' => 'no se puedo actualizar la cotizacion a enviada',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                'message' => 'error del servidor',
                'error' => $th->getMessage(),
                'success' => false,
                'data' => '',
            ]);
        }
    }

    public function cotizacion_aprobada(Request $request)
    {
        try {
            $cotizacion_id = $request->all()['cotizacion_id'];
            $detalle = $request->all()['detalle'];
            $contador = 0;
            foreach ($detalle as $dt) {
                $contador++;
                $updated = cotizacioncotizacion_detalle::find($dt['cotizacion_detalle_id']);
                $updated->aprobar = $dt['aprobar'];
                $updated->save();
            }

            if (count($detalle) == $contador) {
                $cotizacion_id = $request->all()['cotizacion_id'];
                $update = cotizacion::find($cotizacion_id);
                $update->progreso = 2;
                $update->save();
                return response()->json([
                    'message' => 'se actualizo la cotizacion a aprobada',
                    'error' => '',
                    'success' => true,
                    'data' => '',
                ]);
            } else {
                Log::error('no se puedo actualizar la cotizacion a aprobada');
                return response()->json([
                    'message' => 'no se puedo actualizar la cotizacion a aprobada',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                'message' => 'error del servidor',
                'error' => $th->getMessage(),
                'success' => false,
                'data' => '',
            ]);
        }
    }
    /* *********************** */

    /* ******** trabajo realizado ************* */

    public function moto_aprobada(Request $request)
    {
        try {
            $cotizacion_id = $request->all()['cotizacion_id'];
            $update = cotizacion::find($cotizacion_id);
            $update->progreso = 3;
            if ($update->save()) {
                return response()->json([
                    'message' => 'Trabajo finalizado',
                    'error' => '',
                    'success' => true,
                    'data' => '',
                ]);
            } else {
                Log::error('no se pudo registrar Trabajo finalizado');
                return response()->json([
                    'message' => 'no se pudo terminar el trabajo',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                'message' => 'error del servidor',
                'error' => $th->getMessage(),
                'success' => false,
                'data' => '',
            ]);
        }
    }

    /* *********************** */

    /* ******** cotizacion datatables by progreso ************* */
    public function cotizacion_table_vue($progreso)
    {
        $cotizacion = cotizacion::select(DB::raw('*'))
            ->with([
                'inventario' => function ($query) {
                    $query->with([
                        'moto' => function ($query) {
                            $query->with(['cliente']);
                        },
                    ]);
                },
            ])
            ->where('progreso', $progreso)
            ->get();

        return response()->json(['data' => $cotizacion]);
    }
    /* *********************** */

    /* ******** badge ************* */
    public function badge()
    {
        $emitidos = cotizacion::where('progreso', 0)
            ->get()
            ->count();
        $enviados = cotizacion::where('progreso', 1)
            ->get()
            ->count();
        $aprobados = cotizacion::where('progreso', 2)
            ->get()
            ->count();
        $trabajo_terminado = cotizacion::where('progreso', 3)
            ->get()
            ->count();
        $finalizados = cotizacion::where('progreso', 4)
            ->get()
            ->count();

        $responseData = [
            'emitidos' => $emitidos,
            'enviados' => $enviados,
            'aprobados' => $aprobados,
            'trabajo_terminado' => $trabajo_terminado,
            'finalizados' => $finalizados,
        ];

        return response()->json($responseData);
    }
    /* *********************** */
}
