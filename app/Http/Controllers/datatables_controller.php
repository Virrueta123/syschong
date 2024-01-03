<?php

namespace App\Http\Controllers;

use App\Models\activaciones;
use App\Models\caja_chica;
use App\Models\compras;
use App\Models\cortesias_activacion;
use App\Models\cotizacion;
use App\Models\producto;
use App\Models\servicios;
use App\Models\tienda_facturas;
use App\Models\ventas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class datatables_controller extends Controller
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
    public function tablas_activaciones_anterior_por_tienda($id)
    {
        $activaciones = activaciones::with([
            'moto' => function ($query) {
                return $query->with([
                    'cliente',
                    'modelo' => function ($query) {
                        return $query->with(['marca']);
                    },
                ]);
            },
            'vendedor',
            'tienda',
        ])

            ->where('is_cobro', 'Y')
            ->where('activado_taller', 'Y')
            ->where('tienda_id', decrypt_id($id))
            ->orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($activaciones)
            ->addIndexColumn()
            ->addColumn('cliente', function ($Data) {
                if (is_null($Data->activaciones->moto->cliente)) {
                    return 'sin cliente';
                } else {
                    if ($Data->activaciones->moto->cliente->cli_ruc != 'no tiene') {
                        return $Data->activaciones->moto->cliente->cli_razon_social;
                    } else {
                        return $Data->activaciones->moto->cliente->cli_nombre . ' ' . $Data->activaciones->moto->cliente->cli_apellido;
                    }
                }
            })
            ->addColumn('dnioruc', function ($Data) {
                if (is_null($Data->activaciones->moto->cliente)) {
                    return 'sin cliente';
                } else {
                    if ($Data->activaciones->moto->cliente->cli_ruc != 'no tiene') {
                        return $Data->activaciones->moto->cliente->cli_ruc;
                    } else {
                        return $Data->activaciones->moto->cliente->cli_dni;
                    }
                }
            })
            ->addColumn('vendedor', function ($Data) {
                return $Data->vendedor->vendedor_nombres;
            })
            ->addColumn('marca', function ($Data) {
                return $Data->moto->modelo->marca->marca_nombre;
            })
            ->addColumn('modelo', function ($Data) {
                return $Data->moto->modelo->modelo_nombre;
            })
            ->addColumn('tienda', function ($Data) {
                return $Data->tienda->tienda_nombre;
            })
            ->addColumn('motor', function ($Data) {
                return $Data->moto->mtx_motor;
            })

            ->addColumn('fecha_creacion', function ($Data) {
                return Carbon::parse($Data->created_at)->format('d/m/Y');
            })
            ->addColumn('action', static function ($Data) {
                $activaciones_id = encrypt_id($Data->activaciones_id);
                return view('buttons.activaciones', ['activaciones_id' => $activaciones_id]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /* ******** tabla cotizacion para compras ************* */
    public function cotizacion_by_compra()
    {
        try {
            $cotizacion = cotizacion::select(DB::raw('*'))
                ->with([
                    'mecanico',
                    'inventario' => function ($query) {
                        $query->with([
                            'cortesia',
                            'moto' => function ($query) {
                                $query->with(['cliente']);
                            },
                        ]);
                    },
                ])
                ->get();

            $data = DataTables::of($cotizacion)
                ->addColumn('cliente', function ($Data) {
                    if (is_null($Data->inventario->moto->cliente)) {
                        return 'Sin Cliente';
                    } else {
                        if ($Data->inventario->moto->cliente->cli_ruc != 'no tiene') {
                            return $Data->inventario->moto->cliente->cli_razon_social;
                        } else {
                            if (is_null($Data->inventario->moto->cliente->cli_ruc)) {
                                return $Data->inventario->moto->cliente->cli_nombre . ' ' . $Data->inventario->moto->cliente->cli_apellido;
                            } else {
                                return $Data->inventario->moto->cliente->cli_razon_social;
                            }
                        }
                    }
                })
                ->addColumn('dnioruc', function ($Data) {
                    if (is_null($Data->inventario->moto->cliente)) {
                        return 'Sin Cliente';
                    } else {
                        if ($Data->inventario->moto->cliente->cli_ruc != 'no tiene') {
                            return $Data->inventario->moto->cliente->cli_ruc;
                        } else {
                            if (is_null($Data->inventario->moto->cliente->cli_ruc)) {
                                return $Data->inventario->moto->cliente->cli_dni;
                            } else {
                                return $Data->inventario->moto->cliente->cli_ruc;
                            }
                        }
                    }
                })
                ->addColumn('mecanico', function ($Data) {
                    if (is_null($Data->mecanico)) {
                        return 'Sin Mecanico';
                    } else {
                        return $Data->mecanico->name . ' ' . $Data->mecanico->last_name;
                    }
                })
                ->addColumn('marca', function ($Data) {
                    return $Data->inventario->moto->modelo->marca->marca_nombre;
                })
                ->addColumn('modelo', function ($Data) {
                    return $Data->inventario->moto->modelo->modelo_nombre;
                })
                ->addColumn('motor', function ($Data) {
                    return $Data->inventario->moto->mtx_motor;
                })
                ->addColumn('vin', function ($Data) {
                    return $Data->inventario->moto->mtx_vin;
                })
                ->addColumn('fecha', function ($Data) {
                    return Carbon::parse($Data->created_at)->format('d/m/Y');
                })
                ->toJson();

            return response()->json([
                'message' => 'Trabajo finalizado',
                'error' => '',
                'success' => true,
                'data' => $data,
            ]);
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
    public function data_compras($id)
    {
        return DataTables::of(
            compras::with(['usuario', 'proveedor'])
                ->where('caja_chica_id', decrypt_id($id))
                ->orderBy('created_at', 'asc')
                ->get(),
        )
            ->addColumn('action', static function ($Data) {
                $compra_id = encrypt_id($Data->compra_id);
                return view('buttons.compras', ['compra_id' => $compra_id]);
            })
            ->addColumn('proveedor', static function ($Data) {
                return $Data->proveedor->proveedor_razon_social . ' - ' . $Data->proveedor->proveedor_ruc;
            })
            ->addColumn('created_at', static function ($Data) {
                return Carbon::parse($Data->created_at)->format('Y-m-d');
            })
            ->addColumn('fecha_emision', static function ($Data) {
                return Carbon::parse($Data->fecha_emision)->format('Y-m-d');
            })
            ->addColumn('forma_pago', static function ($Data) {
                switch ($Data->forma_pago) {
                    case 'CO':
                        return 'Contado';
                        break;
                    case 'CR':
                        return 'Credito';
                        break;
                }
            })
            ->addColumn('is_pago', static function ($Data) {
                switch ($Data->is_pago) {
                    case 'Y':
                        return 'Si hay pagos';
                        break;
                    case 'N':
                        return 'no hay pagos';
                        break;
                }
                return Carbon::parse($Data->created_at)->format('Y-m-d');
            })
            ->addColumn('tipo_comprobante', static function ($Data) {
                switch ($Data->t_comprobante) {
                    case 'F':
                        return 'FACTURA';
                        break;
                    case 'B':
                        return 'FACTURA';
                        break;
                    case 'N':
                        return 'FACTURA';
                        break;
                }
                return Carbon::parse($Data->created_at)->format('Y-m-d');
            })
            ->addColumn('documento', static function ($Data) {
                return $Data->compra_correlativo . ' - ' . $Data->compra_serie;
            })
            ->make(true);
    }

    public function data_ventas($id)
    {
        $activaciones = ventas::where('caja_chica_id', decrypt_id($id))
            ->orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($activaciones)
            ->addIndexColumn()
            ->addColumn('action', static function ($Data) {
                $venta_id = encrypt_id($Data->venta_id);
                return view('buttons.venta', ['venta_id' => $venta_id]);
            })
            ->addColumn('tipo_venta', static function ($Data) {
                switch ($Data->tipo_venta) {
                    case 'FM':
                        return 'Factura Mantenimiento';
                        break;

                    case 'BM':
                        return 'Boleta Mantenimiento';
                        break;

                    case 'FV':
                        return 'Factura';
                        break;

                    case 'BV':
                        return 'Boleta';
                        break;

                    case 'FT':
                        return 'Factura por tienda comercial';
                        break;
                }
            })
            ->addColumn('numero', static function ($Data) {
                return $Data->venta_serie . '-' . $Data->venta_correlativo;
            })
            ->addColumn('venta_estado', static function ($Data) {
                switch ($Data->venta_estado) {
                    case 'A':
                        return 'Aceptado';
                        break;

                    case 'R':
                        return 'Rechazado';
                        break;
                }
            })
            ->addColumn('cliente', static function ($Data) {
                if ($Data->tipo_comprobante == 'B') {
                    return $Data->Nombre . ' ' . $Data->Apellido;
                } else {
                    return $Data->razon_social;
                }
            })
            ->addColumn('documento', static function ($Data) {
                if ($Data->tipo_comprobante == 'B') {
                    return $Data->Dni;
                } else {
                    return $Data->ruc;
                }
            })
            ->addColumn('venta_total', static function ($Data) {
                return 'S/. ' . number_format($Data->venta_total, 2);
            })
            ->addColumn('MtoOperGravadas', static function ($Data) {
                return 'S/. ' . number_format($Data->MtoOperGravadas, 2);
            })
            ->addColumn('SubTotal', static function ($Data) {
                return 'S/. ' . number_format($Data->SubTotal, 2);
            })
            ->addColumn('forma_pago', static function ($Data) {
                switch ($Data->forma_pago) {
                    case 'CO':
                        return 'Contado';
                        break;

                    case 'CR':
                        return 'Credito';
                        break;
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tablas_activaciones_actual_por_tienda($id)
    {
        $activaciones = activaciones::with([
            'moto' => function ($query) {
                return $query->with([
                    'cliente',
                    'modelo' => function ($query) {
                        return $query->with(['marca']);
                    },
                ]);
            },
            'vendedor',
            'tienda',
        ])

            ->where('is_cobro', 'N')
            ->where('activado_taller', 'A')
            ->where('tienda_id', decrypt_id($id))
            ->orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($activaciones)
            ->addIndexColumn()
            ->addColumn('cliente', function ($Data) {
                if (is_null($Data->moto->cliente)) {
                    return 'sin cliente';
                } else {
                    if (is_null($Data->moto->cliente->cli_ruc)) {
                        return 'sin cliente';
                    } else {
                        if ($Data->moto->cliente->cli_ruc != 'no tiene') {
                            return $Data->moto->cliente->cli_razon_social;
                        } else {
                            return $Data->moto->cliente->cli_nombre . ' ' . $Data->moto->cliente->cli_apellido;
                        }
                    }
                }
            })
            ->addColumn('dnioruc', function ($Data) {
                if (is_null($Data->moto->cliente)) {
                    return 'sin cliente';
                } else {
                    if (is_null($Data->moto->cliente->cli_ruc)) {
                        return 'sin cliente';
                    } else {
                        if ($Data->moto->cliente->cli_ruc != 'no tiene') {
                            return $Data->moto->cliente->cli_ruc;
                        } else {
                            return $Data->moto->cliente->cli_dni;
                        }
                    }
                }
            })
            ->addColumn('vendedor', function ($Data) {
                return $Data->vendedor->vendedor_nombres;
            })
            ->addColumn('marca', function ($Data) {
                return $Data->moto->modelo->marca->marca_nombre;
            })
            ->addColumn('modelo', function ($Data) {
                return $Data->moto->modelo->modelo_nombre;
            })
            ->addColumn('tienda', function ($Data) {
                return $Data->tienda->tienda_nombre;
            })
            ->addColumn('motor', function ($Data) {
                return $Data->moto->mtx_motor;
            })

            ->addColumn('fecha_creacion', function ($Data) {
                return Carbon::parse($Data->created_at)->format('d/m/Y');
            })
            ->addColumn('action', static function ($Data) {
                $activaciones_id = encrypt_id($Data->activaciones_id);
                return view('buttons.activaciones', ['activaciones_id' => $activaciones_id]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    //tabla activacion filtrar por parametros
    public function tablas_activaciones_actual_por_tienda_by_factura(Request $request)
    {
        $datax = $request->all();

        if (isset($datax['marca'])) {
            if (isset($datax['select_monto'])) {
                $activaciones = activaciones::with([
                    'moto' => function ($query) {
                        return $query->with([
                            'cliente',
                            'modelo' => function ($query) {
                                return $query->with(['marca']);
                            },
                        ]);
                    },
                    'vendedor',
                    'tienda',
                ])
                    ->where('is_cobro', 'N')
                    ->where('activado_taller', 'A')
                    ->whereHas('moto.modelo.marca', function ($query) use ($datax) {
                        $query->whereIn('marca_id', $datax['marca']);
                    })
                    ->where('tienda_id', decrypt_id($datax['tienda_id']))
                    ->whereIn('total', $datax['select_monto'])
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                $activaciones = activaciones::with([
                    'moto' => function ($query) {
                        return $query->with([
                            'cliente',
                            'modelo' => function ($query) {
                                return $query->with(['marca']);
                            },
                        ]);
                    },
                    'vendedor',
                    'tienda',
                ])
                    ->where('is_cobro', 'N')
                    ->where('activado_taller', 'A')
                    ->whereHas('moto.modelo.marca', function ($query) use ($datax) {
                        $query->whereIn('marca_id', $datax['marca']);
                    })
                    ->where('tienda_id', decrypt_id($datax['tienda_id']))
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        } else {
            if (isset($datax['select_monto'])) {
                $activaciones = activaciones::with([
                    'moto' => function ($query) {
                        return $query->with([
                            'cliente',
                            'modelo' => function ($query) {
                                return $query->with(['marca']);
                            },
                        ]);
                    },
                    'vendedor',
                    'tienda',
                ])
                    ->where('is_cobro', 'N')
                    ->where('activado_taller', 'A')
                    ->where('tienda_id', decrypt_id($datax['tienda_id']))
                    ->whereIn('total', $datax['select_monto'])
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                $activaciones = activaciones::with([
                    'moto' => function ($query) {
                        return $query->with([
                            'cliente',
                            'modelo' => function ($query) {
                                return $query->with(['marca']);
                            },
                        ]);
                    },
                    'vendedor',
                    'tienda',
                ])
                    ->where('is_cobro', 'N')
                    ->where('activado_taller', 'A')
                    ->where('tienda_id', decrypt_id($datax['tienda_id']))
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        }

        return DataTables::of($activaciones)
            ->addIndexColumn()
            ->addColumn('cliente', function ($Data) {
                if (is_null($Data->moto->cliente)) {
                    return 'sin cliente';
                } else {
                    if (is_null($Data->moto->cliente->cli_ruc)) {
                        return 'sin cliente';
                    } else {
                        if ($Data->moto->cliente->cli_ruc != 'no tiene') {
                            return $Data->moto->cliente->cli_razon_social;
                        } else {
                            return $Data->moto->cliente->cli_nombre . ' ' . $Data->moto->cliente->cli_apellido;
                        }
                    }
                }
            })

            ->addColumn('dnioruc', function ($Data) {
                if (is_null($Data->moto->cliente)) {
                    return 'sin cliente';
                } else {
                    if (is_null($Data->moto->cliente->cli_ruc)) {
                        return 'sin cliente';
                    } else {
                        if ($Data->moto->cliente->cli_ruc != 'no tiene') {
                            return $Data->moto->cliente->cli_ruc;
                        } else {
                            return $Data->moto->cliente->cli_dni;
                        }
                    }
                }
            })
            ->addColumn('vendedor', function ($Data) {
                return $Data->vendedor->vendedor_nombres;
            })
            ->addColumn('marca', function ($Data) {
                return $Data->moto->modelo->marca->marca_nombre;
            })
            ->addColumn('modelo', function ($Data) {
                return $Data->moto->modelo->modelo_nombre;
            })
            ->addColumn('tienda', function ($Data) {
                return $Data->tienda->tienda_nombre;
            })
            ->addColumn('motor', function ($Data) {
                return $Data->moto->mtx_motor;
            })

            ->addColumn('fecha_creacion', function ($Data) {
                return Carbon::parse($Data->created_at)->format('d/m/Y');
            })
            ->addColumn('action', static function ($Data) {
                $activaciones_id = encrypt_id($Data->activaciones_id);
                return view('buttons.activaciones', ['activaciones_id' => $activaciones_id]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    //tabla cortesias filtrar por parametros

    public function tablas_cortesias_actual_por_tienda_by_factura(Request $request)
    {
        $datax = $request->all();

        if (isset($datax['select_cortesia'])) {
            $cortesias = cortesias_activacion::with([
                'activaciones' => function ($query) {
                    return $query->with([
                        'tienda',
                        'moto' => function ($query) {
                            return $query->with([
                                'cliente',
                                'modelo' => function ($query) {
                                    return $query->with(['marca']);
                                },
                            ]);
                        },
                    ]);
                },
            ])

                ->where('is_cobro', 'N')
                ->where('tienda_cobrar', decrypt_id($datax['tienda_id']))
                ->where('tipo', 'C')
                ->whereIn('numero_corterisa', $datax['select_cortesia'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $cortesias = cortesias_activacion::with([
                'activaciones' => function ($query) {
                    return $query->with([
                        'tienda',
                        'moto' => function ($query) {
                            return $query->with([
                                'cliente',
                                'modelo' => function ($query) {
                                    return $query->with(['marca']);
                                },
                            ]);
                        },
                    ]);
                },
            ])

                ->where('is_cobro', 'N')
                ->where('tienda_cobrar', decrypt_id($datax['tienda_id']))
                ->where('tipo', 'C')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return DataTables::of($cortesias)
            ->addIndexColumn()
            ->addColumn('cliente', function ($Data) {
                if (is_null($Data->activaciones->moto->cliente)) {
                    return 'sin cliente';
                } else {
                    if ($Data->activaciones->moto->cliente->cli_ruc != 'no tiene') {
                        return $Data->activaciones->moto->cliente->cli_razon_social;
                    } else {
                        return $Data->activaciones->moto->cliente->cli_nombre . ' ' . $Data->activaciones->moto->cliente->cli_apellido;
                    }
                }
            })
            ->addColumn('dnioruc', function ($Data) {
                if (is_null($Data->activaciones->moto->cliente)) {
                    return 'sin cliente';
                } else {
                    if ($Data->activaciones->moto->cliente->cli_ruc != 'no tiene') {
                        return $Data->activaciones->moto->cliente->cli_ruc;
                    } else {
                        return $Data->activaciones->moto->cliente->cli_dni;
                    }
                }
            })
            ->addColumn('marca', function ($Data) {
                return $Data->activaciones->moto->modelo->marca->marca_nombre;
            })
            ->addColumn('modelo', function ($Data) {
                return $Data->activaciones->moto->modelo->modelo_nombre;
            })
            ->addColumn('motor', function ($Data) {
                return $Data->activaciones->moto->mtx_motor;
            })
            ->addColumn('numero_cortesia_letra', function ($Data) {
                switch ($Data->numero_corterisa) {
                    case 1:
                        return 'PRIMER SERVICIO DE CORTESIA';
                        break;
                    case 2:
                        return 'SEGUNDO SERVICIO DE CORTESIA';
                        break;
                    case 3:
                        return 'TERCER SERVICIO DE CORTESIA';
                        break;
                    case 4:
                        return 'CUARTO SERVICIO DE CORTESIA';
                        break;
                    case 5:
                        return 'QUINTO SERVICIO DE CORTESIA';
                        break;
                    case 6:
                        return 'SEXTO SERVICIO DE CORTESIA';
                        break;
                }
            })

            ->addColumn('fecha_creacion', function ($Data) {
                return Carbon::parse($Data->created_at)->format('d/m/Y');
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function tablas_ventas(Request $request)
    {
        try {
            $data = DataTables::of(
                ventas::whereNotIn('tipo_comprobante', ['N'])
                    ->orderBy('created_at', 'asc')
                    ->get(),
            )
                ->addColumn('action', static function ($Data) {
                    $venta_id = encrypt_id($Data->venta_id);
                    return view('buttons.venta', ['venta_id' => $venta_id]);
                })
                ->addColumn('tipo_venta', static function ($Data) {
                    switch ($Data->tipo_venta) {
                        case 'FM':
                            return 'Factura Mantenimiento';
                            break;
    
                        case 'BM':
                            return 'Boleta Mantenimiento';
                            break;
    
                        case 'FV':
                            return 'Factura';
                            break;
    
                        case 'BV':
                            return 'Boleta';
                            break;
    
                        case 'FT':
                            return 'Factura casa comercial';
                            break;
                    }
                })
                ->addColumn('numero', static function ($Data) {
                    return $Data->venta_serie . '-' . $Data->venta_correlativo;
                })
                ->addColumn('venta_estado', static function ($Data) {
                    switch ($Data->venta_estado) {
                        case 'A':
                            return 'Aceptado';
                            break;
    
                        case 'R':
                            return 'Rechazado';
                            break;
                    }
                })
                ->addColumn('cliente', static function ($Data) {
                    if ($Data->tipo_comprobante == 'B') {
                        return $Data->Nombre . ' ' . $Data->Apellido;
                    } else {
                        return $Data->razon_social;
                    }
                })
                ->addColumn('documento', static function ($Data) {
                    if ($Data->tipo_comprobante == 'B') {
                        return $Data->Dni;
                    } else {
                        return $Data->ruc;
                    }
                })
                
            ->addColumn('id', static function ($Data) {
                $venta_id = encrypt_id($Data->venta_id);
                return $venta_id;
            })
                ->addColumn('forma_pago', static function ($Data) {
                    switch ($Data->forma_pago) {
                        case 'CO':
                            return 'Contado';
                            break;
    
                        case 'CR':
                            return 'Credito';
                            break;
                    }
                })
                ->toJson();

            return response()->json([
                'message' => 'ventas cargados correctamente',
                'error' => '',
                'success' => true,
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                'message' => 'error del servidor',
                'error' => $th->getMessage(),
                'success' => false,
                'data' => '',
            ]);
        }

       

        /*
        $html = $builder
            ->columns([
                Column::make('fecha_creacion')->title('Emision'),
                Column::make('tipo_venta')->title('Tipo Comprobante'),
                Column::make('cliente')
                    ->title('Cliente')
                    ->searchable(true)
                    ->orderable(true)
                    ->exportable(false)
                    ->printable(false),
                Column::make('documento')->title('Documento'),
                Column::make('numero')->title('numero'),
                Column::make('venta_estado')->title('Estado'),
                Column::make('venta_total')->title('Venta Total'),
                Column::make('MtoOperGravadas')->title('MtoOperGravadas'),
                Column::make('SubTotal')->title('SubTotal'),
                Column::make('forma_pago')->title('forma pago'),
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
            ]);*/
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function tablas_cortesias_actual_por_tienda($id)
    {
        $cortesias = cortesias_activacion::with([
            'activaciones' => function ($query) use ($id) {
                return $query->with([
                    'tienda',
                    'moto' => function ($query) {
                        return $query->with([
                            'cliente',
                            'modelo' => function ($query) {
                                return $query->with(['marca']);
                            },
                        ]);
                    },
                ]);
            },
        ])

            ->where('is_cobro', 'N')
            ->where('tienda_cobrar', decrypt_id($id))
            ->where('tipo', 'C')
            ->orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($cortesias)
            ->addIndexColumn()
            ->addColumn('cliente', function ($Data) {
                if (is_null($Data->activaciones->moto->cliente)) {
                    return 'sin cliente';
                } else {
                    if ($Data->activaciones->moto->cliente->cli_ruc != 'no tiene') {
                        return $Data->activaciones->moto->cliente->cli_razon_social;
                    } else {
                        return $Data->activaciones->moto->cliente->cli_nombre . ' ' . $Data->activaciones->moto->cliente->cli_apellido;
                    }
                }
            })
            ->addColumn('dnioruc', function ($Data) {
                if (is_null($Data->activaciones->moto->cliente)) {
                    return 'sin cliente';
                } else {
                    if ($Data->activaciones->moto->cliente->cli_ruc != 'no tiene') {
                        return $Data->activaciones->moto->cliente->cli_ruc;
                    } else {
                        return $Data->activaciones->moto->cliente->cli_dni;
                    }
                }
            })
            ->addColumn('marca', function ($Data) {
                return $Data->activaciones->moto->modelo->marca->marca_nombre;
            })
            ->addColumn('modelo', function ($Data) {
                return $Data->activaciones->moto->modelo->modelo_nombre;
            })
            ->addColumn('motor', function ($Data) {
                return $Data->activaciones->moto->mtx_motor;
            })
            ->addColumn('numero_cortesia_letra', function ($Data) {
                switch ($Data->numero_corterisa) {
                    case 1:
                        return 'PRIMER SERVICIO DE CORTESIA';
                        break;
                    case 2:
                        return 'SEGUNDO SERVICIO DE CORTESIA';
                        break;
                    case 3:
                        return 'TERCER SERVICIO DE CORTESIA';
                        break;
                    case 4:
                        return 'CUARTO SERVICIO DE CORTESIA';
                        break;
                    case 5:
                        return 'QUINTO SERVICIO DE CORTESIA';
                        break;
                    case 6:
                        return 'SEXTO SERVICIO DE CORTESIA';
                        break;
                }
            })

            ->addColumn('fecha_creacion', function ($Data) {
                return Carbon::parse($Data->created_at)->format('d/m/Y');
            })
            ->addColumn('action', static function ($Data) {
                $activaciones_id = encrypt_id($Data->activaciones_id);
                return view('buttons.activaciones', ['activaciones_id' => $activaciones_id]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function factura_tienda_table($id)
    {
        $facturas = tienda_facturas::with(['venta'])
            ->where('tienda_id', decrypt_id($id))
            ->orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($facturas)
            ->addIndexColumn()
            ->addColumn('fecha_creacion', function ($Data) {
                return Carbon::parse($Data->created_at)->format('d/m/Y');
            })
            ->addColumn('action', static function ($Data) {
                $venta_id = encrypt_id($Data->venta->venta_id);
                $estado = $Data->venta->venta_estado;

                return view('buttons.factura_tienda', ['venta_id' => $venta_id, 'estado' => $estado, 'tienda_facturas_id' => encrypt_id($Data->tienda_facturas_id)]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function tablle_cotizacion_para_compra()
    {
        $facturas = cotizacion::with(['venta'])
            ->whereNotIn('progreso', [3, 4, 5, 6])
            ->orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($facturas)
            ->addIndexColumn()
            ->addColumn('fecha_creacion', function ($Data) {
                return Carbon::parse($Data->created_at)->format('d/m/Y');
            })
            ->addColumn('action', static function ($Data) {
                $venta_id = encrypt_id($Data->venta->venta_id);
                $estado = $Data->venta->venta_estado;

                return view('buttons.cotizacion', ['venta_id' => $venta_id, 'estado' => $estado, 'tienda_facturas_id' => encrypt_id($Data->tienda_facturas_id)]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function servicios_seleccionados_table()
    {
        $servicios = servicios::where('estado', 'A')
            ->orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($servicios)
            ->addIndexColumn()

            ->addColumn('fecha_creacion', function ($Data) {
                return Carbon::parse($Data->created_at)->format('d/m/Y');
            })

            ->rawColumns(['action'])
            ->make(true);
    }

    public function productos_seleccionados_table()
    {
        $productos = producto::orderBy('created_at', 'desc')->get();

        return DataTables::of($productos)
            ->addIndexColumn()

            ->addColumn('fecha_creacion', function ($Data) {
                return Carbon::parse($Data->created_at)->format('d/m/Y');
            })

            ->rawColumns(['action'])
            ->make(true);
    }

    /* ******** datatable para activacion y cortesias para avisar ************* */
    //activaciones
    public function tablas_activaciones_de_hoy()
    {
        $activaciones = activaciones::select('*', DB::raw('DATE(DATE_ADD(created_at, INTERVAL dias DAY))'))
            ->with([
                'moto' => function ($query) {
                    return $query->with([
                        'cliente',
                        'modelo' => function ($query) {
                            return $query->with(['marca']);
                        },
                    ]);
                },
                'vendedor',
                'cortesias',
                'tienda',
            ])
            ->where('activado_taller', 'A')
            ->where('is_aviso', 'S')
            ->whereDate(DB::raw('DATE(DATE_ADD(created_at, INTERVAL dias DAY))'), '=', Carbon::now()->format('Y-m-d'))
            ->whereDoesntHave('cortesias')
            ->orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($activaciones)
            ->addIndexColumn()
            ->addColumn('cliente', function ($Data) {
                if (is_null($Data->moto->cliente)) {
                    return 'sin cliente';
                } else {
                    if ($Data->moto->cliente->cli_ruc != 'no tiene') {
                        return $Data->moto->cliente->cli_razon_social;
                    } else {
                        return $Data->moto->cliente->cli_nombre . ' ' . $Data->moto->cliente->cli_apellido;
                    }
                }
            })
            ->addColumn('dnioruc', function ($Data) {
                if (is_null($Data->moto->cliente)) {
                    return 'sin cliente';
                } else {
                    if ($Data->moto->cliente->cli_ruc != 'no tiene') {
                        return $Data->moto->cliente->cli_ruc;
                    } else {
                        return $Data->moto->cliente->cli_dni;
                    }
                }
            })
            ->addColumn('vendedor', function ($Data) {
                return $Data->vendedor->vendedor_nombres;
            })
            ->addColumn('marca', function ($Data) {
                return $Data->moto->modelo->marca->marca_nombre;
            })
            ->addColumn('modelo', function ($Data) {
                return $Data->moto->modelo->modelo_nombre;
            })
            ->addColumn('tienda', function ($Data) {
                return $Data->tienda->tienda_nombre;
            })
            ->addColumn('motor', function ($Data) {
                return $Data->moto->mtx_motor;
            })
            ->addColumn('fecha_creacion', function ($Data) {
                return Carbon::parse($Data->created_at)->format('d/m/Y');
            })
            ->addColumn('action', static function ($Data) {
                $activaciones_id = encrypt_id($Data->activaciones_id);
                return view('buttons.activaciones', ['activaciones_id' => $activaciones_id]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function tablas_activaciones_pendiente()
    {
        $activaciones = activaciones::select('*', DB::raw('DATE(DATE_ADD(created_at, INTERVAL dias DAY))'))
            ->with([
                'moto' => function ($query) {
                    return $query->with([
                        'cliente',
                        'modelo' => function ($query) {
                            return $query->with(['marca']);
                        },
                    ]);
                },
                'vendedor',
                'cortesias',
                'tienda',
            ])
            ->where('activado_taller', 'A')
            ->where('is_aviso', 'S')
            ->whereDate(DB::raw('DATE(DATE_ADD(created_at, INTERVAL dias DAY))'), '>', Carbon::now()->format('Y-m-d'))
            ->whereDoesntHave('cortesias')
            ->orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($activaciones)
            ->addIndexColumn()
            ->addColumn('cliente', function ($Data) {
                if (is_null($Data->moto->cliente)) {
                    return 'sin cliente';
                } else {
                    if ($Data->moto->cliente->cli_ruc != 'no tiene') {
                        return $Data->moto->cliente->cli_razon_social;
                    } else {
                        return $Data->moto->cliente->cli_nombre . ' ' . $Data->moto->cliente->cli_apellido;
                    }
                }
            })
            ->addColumn('dnioruc', function ($Data) {
                if (is_null($Data->moto->cliente)) {
                    return 'sin cliente';
                } else {
                    if ($Data->moto->cliente->cli_ruc != 'no tiene') {
                        return $Data->moto->cliente->cli_ruc;
                    } else {
                        return $Data->moto->cliente->cli_dni;
                    }
                }
            })
            ->addColumn('vendedor', function ($Data) {
                return $Data->vendedor->vendedor_nombres;
            })
            ->addColumn('fecha_aviso', function ($Data) {
                return Carbon::parse($Data->created_at)
                    ->addDays($Data->dias)
                    ->format('d/m/Y');
            })
            ->addColumn('marca', function ($Data) {
                return $Data->moto->modelo->marca->marca_nombre;
            })
            ->addColumn('modelo', function ($Data) {
                return $Data->moto->modelo->modelo_nombre;
            })
            ->addColumn('tienda', function ($Data) {
                return $Data->tienda->tienda_nombre;
            })
            ->addColumn('motor', function ($Data) {
                return $Data->moto->mtx_motor;
            })

            ->addColumn('fecha_creacion', function ($Data) {
                return Carbon::parse($Data->created_at)->format('d/m/Y');
            })
            ->addColumn('action', static function ($Data) {
                $activaciones_id = encrypt_id($Data->activaciones_id);
                return view('buttons.activaciones', ['activaciones_id' => $activaciones_id]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    //cotesias
    public function tablas_cortesias_de_hoy()
    {
        $cortesias = cortesias_activacion::select('*')
            ->with([
                'activaciones' => function ($query) {
                    return $query->with([
                        'moto' => function ($query) {
                            return $query->with([
                                'cliente',
                                'modelo' => function ($query) {
                                    return $query->with(['marca']);
                                },
                            ]);
                        },
                    ]);
                },
            ])
            ->where('is_aviso', 'S')
            ->where('cortesia_pasada', 'N')
            ->whereDate(DB::raw('DATE(DATE_ADD(created_at, INTERVAL dias DAY))'), '=', Carbon::now()->format('Y-m-d'))
            ->orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($cortesias)
            ->addIndexColumn()
            ->addColumn('cliente', function ($Data) {
                if (is_null($Data->activaciones->moto->cliente)) {
                    return 'sin cliente';
                } else {
                    if ($Data->activaciones->moto->cliente->cli_ruc != 'no tiene') {
                        return $Data->activaciones->moto->cliente->cli_razon_social;
                    } else {
                        return $Data->activaciones->moto->cliente->cli_nombre . ' ' . $Data->activaciones->moto->cliente->cli_apellido;
                    }
                }
            })
            ->addColumn('dnioruc', function ($Data) {
                if (is_null($Data->activaciones->moto->cliente)) {
                    return 'sin cliente';
                } else {
                    if ($Data->activaciones->moto->cliente->cli_ruc != 'no tiene') {
                        return $Data->activaciones->moto->cliente->cli_ruc;
                    } else {
                        return $Data->activaciones->moto->cliente->cli_dni;
                    }
                }
            })
            ->addColumn('marca', function ($Data) {
                return $Data->activaciones->moto->modelo->marca->marca_nombre;
            })
            ->addColumn('modelo', function ($Data) {
                return $Data->activaciones->moto->modelo->modelo_nombre;
            })
            ->addColumn('motor', function ($Data) {
                return $Data->activaciones->moto->mtx_motor;
            })
            ->addColumn('fecha_aviso', function ($Data) {
                return Carbon::parse($Data->created_at)
                    ->addDays($Data->dias)
                    ->format('d/m/Y');
            })
            ->addColumn('fecha_creacion', function ($Data) {
                return Carbon::parse($Data->created_at)->format('d/m/Y');
            })
            ->addColumn('action', static function ($Data) {
                return 'config';
                $activaciones_id = encrypt_id($Data->activaciones_id);
                return view('buttons.activaciones', ['activaciones_id' => $activaciones_id]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function tablas_cortesias_pendiente()
    {
        $cortesias = cortesias_activacion::select('*')
            ->with([
                'activaciones' => function ($query) {
                    return $query->with([
                        'moto' => function ($query) {
                            return $query->with([
                                'cliente',
                                'modelo' => function ($query) {
                                    return $query->with(['marca']);
                                },
                            ]);
                        },
                    ]);
                },
            ])
            ->where('is_aviso', 'S')
            ->where('cortesia_pasada', 'N')
            ->whereDate(DB::raw('DATE(DATE_ADD(created_at, INTERVAL dias DAY))'), '>', Carbon::now()->format('Y-m-d'))
            ->orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($cortesias)
            ->addIndexColumn()
            ->addColumn('cliente', function ($Data) {
                if (is_null($Data->activaciones->moto->cliente)) {
                    return 'sin cliente';
                } else {
                    if ($Data->activaciones->moto->cliente->cli_ruc != 'no tiene') {
                        return $Data->activaciones->moto->cliente->cli_razon_social;
                    } else {
                        return $Data->activaciones->moto->cliente->cli_nombre . ' ' . $Data->activaciones->moto->cliente->cli_apellido;
                    }
                }
            })
            ->addColumn('dnioruc', function ($Data) {
                if (is_null($Data->activaciones->moto->cliente)) {
                    return 'sin cliente';
                } else {
                    if ($Data->activaciones->moto->cliente->cli_ruc != 'no tiene') {
                        return $Data->activaciones->moto->cliente->cli_ruc;
                    } else {
                        return $Data->activaciones->moto->cliente->cli_dni;
                    }
                }
            })
            ->addColumn('marca', function ($Data) {
                return $Data->activaciones->moto->modelo->marca->marca_nombre;
            })
            ->addColumn('modelo', function ($Data) {
                return $Data->activaciones->moto->modelo->modelo_nombre;
            })
            ->addColumn('motor', function ($Data) {
                return $Data->activaciones->moto->mtx_motor;
            })
            ->addColumn('fecha_aviso', function ($Data) {
                return Carbon::parse($Data->created_at)
                    ->addDays($Data->dias)
                    ->format('d/m/Y');
            })
            ->addColumn('fecha_creacion', function ($Data) {
                return Carbon::parse($Data->created_at)->format('d/m/Y');
            })
            ->addColumn('action', static function ($Data) {
                return 'config';
                $activaciones_id = encrypt_id($Data->activaciones_id);
                return view('buttons.activaciones', ['activaciones_id' => $activaciones_id]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /* *********************** */
}
