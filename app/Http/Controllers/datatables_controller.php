<?php

namespace App\Http\Controllers;

use App\Models\activaciones;
use App\Models\cortesias_activacion;
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

            ->whereMonth('created_at', '!=', Carbon::now())
            ->where('activaciones.tienda_id', decrypt_id($id))
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
            'tienda' => function ($query) use ($id) {
                return $query->where('tienda_id', decrypt_id($id));
            },
        ])

            ->whereMonth('created_at', now()->month)
            ->where('activaciones.tienda_id', decrypt_id($id))
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
                        return $query->with(['cliente',"modelo" => function ($query){
                            return $query->with(['marca']);
                        }]);
                    },
                ]);
            },
        ])

            ->whereMonth('created_at', now()->month)
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
                return $Data->activacione->moto->modelo->marca->marca_nombre;
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
