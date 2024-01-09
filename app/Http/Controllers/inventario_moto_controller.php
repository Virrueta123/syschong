<?php

namespace App\Http\Controllers;

use App\Models\accesorios;
use App\Models\accesorios_inventario_detalle;
use App\Models\autorizaciones;
use App\Models\inventario_autorizaciones;
use App\Models\inventario_moto;
use App\Providers\EmpresaServiceProvider;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class inventario_moto_controller extends Controller
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
    public function index(Request $request)
    {
        $fecha_actual = Carbon::now();
        if ($request->ajax()) {
            $inventario_moto = inventario_moto::with([
                'moto' => function ($query) {
                    $query->with('cliente');
                },
            ])
                ->orderBy('created_at', 'desc')
                ->get();

            return DataTables::of($inventario_moto)
                ->addIndexColumn()
                ->addColumn('fecha_creacion', function ($Data) {
                    return Carbon::parse($Data->created_at)->format('d/m/Y');
                })
                ->addColumn('cliente', function ($Data) {
                    return $Data->moto->cliente->cli_nombre . ' ' . $Data->moto->cliente->cli_apellido;
                })
                ->addColumn('moto_placa', function ($Data) {
                    return $Data->moto->mtx_placa;
                })
                ->addColumn('moto_vin', function ($Data) {
                    return $Data->moto->mtx_vin;
                })
                ->addColumn('action', static function ($Data) {
                    $inventario_moto_id = encrypt_id($Data->inventario_moto_id);
                    return view('buttons.inventario_moto', ['inventario_moto_id' => $inventario_moto_id]);
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('modules.inventario_moto.index', ['fecha_actual' => $fecha_actual]);
        }
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
        return view('modules.inventario_moto.create', ['accesorios' => $accesorios, 'autorizaciones' => $autorizaciones]);
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
            /* ******** obteniendo el ultimo registro ultimo registro ************* */
            $ultimo_registro = inventario_moto::max('inventario_numero');

            if ($ultimo_registro) {
                $ultimo_registro++;
            } else {
                $ultimo_registro = 1;
            }

            /* *********************** */

            $datax = $request->all();

            $autorizaciones = json_decode($datax['autorizaciones']);
            $seleccionados_accesorios = json_decode($datax['seleccionados_accesorios']);

            $validate = $request->validate([
                'mtx_id' => 'required',
                'inventario_moto_kilometraje' => 'required',
                'inventario_moto_obs_cliente' => 'required',
                'inventario_moto_nivel_gasolina' => 'required',
            ]);

            $validate['inventario_numero'] = $ultimo_registro;

            $create = inventario_moto::create($validate);

            if ($create) {
                foreach ($autorizaciones as $autorizacion) {
                    $create_autorizaciones = new inventario_autorizaciones();
                    $create_autorizaciones->inventario_moto_id = $create->inventario_moto_id;
                    $create_autorizaciones->aut_id = $autorizacion->identificador;
                    $create_autorizaciones->save();
                }
                foreach ($seleccionados_accesorios as $accesorio) {
                    $accesorios_inventario_detalle = new accesorios_inventario_detalle();
                    $accesorios_inventario_detalle->inventario_moto_id = $create->inventario_moto_id;
                    $accesorios_inventario_detalle->accesorios_inventario_id = $accesorio->identificador;
                    $accesorios_inventario_detalle->estado = $accesorio->estado;
                    $accesorios_inventario_detalle->save();
                }

                session()->flash('success', 'Inventario de la moto | Registro creado correctamente');
                return redirect()->route('inventario_moto.index');
            } else {
                Log::error('no se pudo registrar el inventario de la moto');
                session()->flash('error', 'error al registrar en la base de datos');
                dd('error');
                return redirect()->route('inventario_moto.index');
            }
        } catch (\Throwable $th) {
            Log::error(json_encode($th->getMessage(), true));
            dd('error grave');
            session()->flash('error', 'error al registrar');
            return redirect()->back();
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
        try {
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
                return view('modules.inventario_moto.show', ['get' => $get, 'accesorios' => $accesorios, 'autorizaciones' => $autorizaciones, 'id' => $id]);
            } else {
                return view('errors.404');
            }
        } catch (\Throwable $th) {
            Log::error(json_encode($th->getMessage(), true));
            dd('error grave');
            session()->flash('error', 'error al entrar a esta ruta');
            return redirect()->back();
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
        return view('modules.inventario_moto.edit');
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
            $destroy = inventario_moto::find(decrypt_id($id));
            $destroy->delete();

            if ($destroy) {
                session()->flash('success', 'Registro eliminado correctamente');
                return redirect()->route('inventario_moto.index');
            } else {
                Log::error('no se pudo eliminar');
                session()->flash('error', 'error al eliminar en la base de datos');
                return redirect()->route('inventario_moto.index');
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'error al eliminar');
            return redirect()->route('inventario_moto.index');
        }
    }

    /* ******** imprimir inventario moto ************* */

    public function imprimir_inventario_moto($id)
    {
        $get = inventario_moto::with([
            'cotizacion' => function ($query) {
                $query->with('detalle');
            },
            'cortesia' => function ($query) {
                $query->with([
                    'moto' => function ($query) {
                        $query->with([
                            'cliente',
                            'modelo' => function ($query) {
                                return $query->with(['marca']);
                            },
                        ]);
                    },
                    'activaciones' => function ($query) {
                        $query->with([
                            'moto' => function ($query) {
                                $query->with([
                                    'cliente',
                                    'modelo' => function ($query) {
                                        return $query->with(['marca']);
                                    },
                                ]);
                            },
                        ]);
                    },
                ]);
            },
            'moto' => function ($query) {
                $query->with('cliente');
            },
            'accesorios_inventario',
        ])->find(decrypt_id($id));

        if ($get) {
            $accesorios = accesorios::all();

            $autorizaciones = inventario_autorizaciones::with('autorizaciones')->get();

            $accesorios_selected = [];

            foreach ($accesorios as $cc) {
                foreach ($get->accesorios_inventario as $a_i) {
                    if ($a_i->accesorios_inventario_id == $cc->accesorios_id) {
                        switch ($a_i->estado) {
                            case 'b':
                                $estado = 'Bueno';
                                break;

                            case 'r':
                                $estado = 'Regular';
                                break;

                            case 'm':
                                $estado = 'Malo';
                                break;
                        }
                        array_push($accesorios_selected, ['item' => $cc->accesorios_nombre, 'check' => 'y', 'estado' => $estado]);
                    } else {
                    }
                }

                array_push($accesorios_selected, ['item' => $cc->accesorios_nombre, 'check' => 'n']);
            }

            return view('pdf.orden_servicio', ['accesorios_selected' => json_encode($accesorios_selected), 'get' => $get, 'accesorios' => $accesorios, 'autorizaciones' => $autorizaciones, 'id' => $id]);
        } else {
            return view('errors.404');
        }
    }

    /* *********************** */
}
