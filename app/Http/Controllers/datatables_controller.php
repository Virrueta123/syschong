<?php

namespace App\Http\Controllers;

use App\Models\activaciones;
use App\Models\caja_chica;
use App\Models\compras;
use App\Models\cortesias_activacion;
use App\Models\ventas;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
            ->where("tienda_cobrar",decrypt_id($id))
            ->orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($activaciones)
            ->addIndexColumn()
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

    public function data_compras($id)
    {
        return DataTables::of(
            compras::with(['usuario', 'proveedor'])
                ->where('caja_chica_id', decrypt_id($id))
                ->orderBy('created_at', 'asc')
                ->get(),
        )
            ->addColumn('action', static function ($Data) {
                $caja_chica_id = encrypt_id($Data->caja_chica_id);
                return view('buttons.caja', ['caja_chica_id' => $caja_chica_id]);
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
            'tienda' 
        ])

            ->where('is_cobro', 'N')
            ->where('activado_taller', 'Y')
            ->where("tienda_cobrar",decrypt_id($id)) 
            ->orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($activaciones)
            ->addIndexColumn()
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
                    'tienda' => function ($query) use ($id) {
                        return $query->where('tienda_id', decrypt_id($id));
                    },
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
            ->where('tipo', 'C')
            ->orderBy('created_at', 'desc')
            ->get(); 
        $cortesias = cortesias_activacion::with([
            'activaciones' => function ($query) use ($id) {
                return $query->with([
                    'tienda' ,
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
            ->where("tienda_cobrar",decrypt_id($id))
            ->where('tipo', 'C')
            ->orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($cortesias)
            ->addIndexColumn()
            ->addColumn('cliente', function ($Data) {
       
                if ($Data->activaciones->moto->cliente->cli_ruc != 'no tiene') {
                    return $Data->activaciones->moto->cliente->cli_razon_social;
                } else {
                    return $Data->activaciones->moto->cliente->cli_nombre . ' ' . $Data->activaciones->moto->cliente->cli_apellido;
                }
            })
            ->addColumn('dnioruc', function ($Data) {
                 
                if ($Data->activaciones->moto->cliente->cli_ruc != 'no tiene') {
                    return $Data->activaciones->moto->cliente->cli_ruc;
                } else {
                    return $Data->activaciones->moto->cliente->cli_dni;
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
}
