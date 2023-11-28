<?php

namespace App\Http\Controllers;

use App\Imports\ActivacionesImport;
use App\Models\accesorios;
use App\Models\accesorios_inventario_detalle;
use App\Models\activaciones;
use App\Models\autorizaciones;
use App\Models\cortesias_activacion;
use App\Models\cotizacion;
use App\Models\cotizacioncotizacion_detalle;
use App\Models\inventario_autorizaciones;
use App\Models\inventario_moto;
use App\Models\motos;
use App\Models\tiendas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class activaciones_controller extends Controller
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
            $tiendas = activaciones::with([
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
                ->where('activado_taller', 'A')
                ->orderBy('created_at', 'desc')
                ->get();

            return DataTables::of($tiendas)
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
        } else {
            return view('modules.activaciones.index', ['fecha_actual' => $fecha_actual]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modules.activaciones.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datax = $request->all();
        // Crear una nueva instancia del modelo
        $activaciones = new activaciones();

        //crear la moto
        $moto = new motos();
        $moto->mtx_vin = $datax['mtx_vin'];
        $moto->mtx_motor = $datax['mtx_motor'];
        $moto->mtx_color = $datax['mtx_color'];
        $moto->modelo_id = $datax['modelo_id'];
        $moto->mtx_fabricacion = $datax['mtx_fabricacion'];
        $moto->mtx_chasis = $datax['mtx_chasis'];
        $created = $moto->save();

        if ($created) {
            // Establecer los valores de los campos
            $activaciones->tienda_id = $datax['tienda_id'];
            $activaciones->vendedor_id = $datax['vendedor_id'];
            $activaciones->moto_id = $moto->mtx_id;
            $activaciones->precio = $datax['precio'];
            $activaciones->precio_gasolina = $datax['precio_gasolina'];
            $activaciones->total = $datax['precio_gasolina'] + $datax['precio'];
            $activaciones->user_id = auth()->user()->id;
        }

        // Guardar el registro en la base de datos

        if ($activaciones->save()) {
            session()->flash('success', 'Se creo correctamente la activacion');
            return redirect()->route('activaciones.show', encrypt_id($activaciones->activaciones_id));
        } else {
            Log::error('no se pudo registrar la activacion');
            session()->flash('error', 'error al registrar en la base de datos');
            return redirect()->route('activaciones.create');
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
        $get = activaciones::with([
            'moto' => function ($query) {
                return $query->with([
                    'cliente',
                    'modelo' => function ($query) {
                        return $query->with(['marca']);
                    },
                ]);
            },
            'cortesias' => function ($query) {
                return $query->with(['tcobrar']);
            },
            'vendedor',
        ])->find(decrypt_id($id));

        return view('modules.activaciones.show', ['get' => $get, 'id' => $id]);
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

    public function cortesia_destroy($id)
    {
        try {
            $cortesia = cortesias_activacion::find($id);
            $activaciones_id = $cortesia->activaciones_id;
           
            $delete = $cortesia->delete();
            if ($delete) {
                $cotizacion = cotizacion::find($cortesia->cotizacion_id);
                if ($cotizacion) {
                    $delete = $cotizacion->delete();

                if ($delete) {
                    session()->flash('success', 'se elimino correctamente la cortesia');
                     
                    return redirect()->route('activaciones.show',encrypt_id($activaciones_id) );
                } else {
                    session()->flash('success', 'error al eliminar la cortesia');
                    return redirect()->route('activaciones.show',encrypt_id($activaciones_id) );
                }
                } else {
                    session()->flash('success', 'se elimino correctamente la cortesia');
                     
                    return redirect()->route('activaciones.show',encrypt_id($activaciones_id) );
                }
                
               
            } else {
                session()->flash('success', 'error al eliminar la cortesia');
                return redirect()->route('activaciones.index',encrypt_id($activaciones_id) );
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'no se creo correctamente la cortesia');
            return redirect()->route('activaciones.show',encrypt_id($activaciones_id) );
        }
    }

    /* ******** importar excel para crear activaciones ************* */

    public function importar()
    {
        return view('modules.activaciones.importar');
    }

    /* ******** agregar cortesias ************* */

    public function cortesia($id)
    {
        $accesorios = accesorios::all();
        $autorizaciones = autorizaciones::all();

        $activacion = activaciones::with([
            'moto' => function ($query) {
                $query->with([
                    'cliente',
                    'modelo' => function ($query) {
                        $query->with(['marca']);
                    },
                ]);
            },
        ])->find(decrypt_id($id));

        return view('modules.cortesia.create', compact('id', 'accesorios', 'autorizaciones', 'activacion'));
    }

    public function cortesia_store($id, Request $request)
    {
        $datax = $request->all();

        $cortesia = new cortesias_activacion();
        $cortesia->km = $datax['km'];
        $cortesia->precio = $datax['precio'];
        $cortesia->activaciones_id = decrypt_id($id);
        $cortesia->user_id = auth()->user()->id;
        $cortesia->is_aviso = $request->all()['is_aviso'] == 'true' ? 'S' : 'A';
        $cortesia->dias = $datax['dias'];
        $cortesia->date_aviso = Carbon::now()->addDays($datax['dias']);
        $cortesia->tienda_cobrar = $datax['tienda_cobrar'];

        $numero_corterisa = cortesias_activacion::where('activaciones_id', decrypt_id($id))
            ->select('numero_corterisa')
            ->max('numero_corterisa');
        if (is_null($numero_corterisa)) {
            $numero_corterisa = 1;
        } else {
            $numero_corterisa++;
        }

        $cortesia->numero_corterisa = $numero_corterisa;
        // Guardar el registro en la base de datos

        if ($cortesia->save()) {
            session()->flash('success', 'Se creo correctamente la cortesia');
            return redirect()->route('activaciones.show', $id);
        } else {
            Log::error('no se pudo registrar la activacion');
            session()->flash('error', 'error al registrar en la base de datos');
            return redirect()->route('activaciones.show', $id);
        }
    }

    public function create_vue_cortesia(Request $request)
    {
        $ultimo_registro = inventario_moto::max('inventario_numero');

        if ($ultimo_registro) {
            $ultimo_registro++;
        } else {
            $ultimo_registro = 1;
        }

        $datax = $request->all();
        $activaciones = json_decode($datax['activaciones']);

        $select_acesorios = json_decode($datax['select_acesorios']);
        $select_autorizacion = json_decode($datax['select_autorizacion']);

        $validate = $request->validate([
            'inventario_moto_obs_cliente' => 'required',
            'inventario_moto_nivel_gasolina' => 'required',
        ]);

        $validate['inventario_numero'] = $ultimo_registro;
        $validate['inventario_moto_kilometraje'] = $datax['km'];
        $validate['mtx_id'] = $activaciones->moto->mtx_id;

        $create = inventario_moto::create($validate);

        if ($create) {
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
            // Reemplaza con el valor deseado
            $cortesias_activacion->tipo = 'C'; // Si no deseas eliminar lógicamente el registro
            $cortesias_activacion->numero_corterisa = $numero_corterisa; // Reemplaza con el valor deseado
            $cortesias_activacion->inventario_moto_id = $create->inventario_moto_id; // Reemplaza con el valor deseado
            $cortesias_activacion->mecanico_id = 0; // Reemplaza con el valor deseado
            $cortesias_activacion->mtx_id = $activaciones->moto->mtx_id; // Reemplaza con el valor deseado
            $cortesias_activacion->is_aviso = $request->all()['is_aviso'] == 'true' ? 'S' : 'A';
            $cortesias_activacion->dias = $datax['dias'];
            $cortesias_activacion->date_aviso = Carbon::now()->addDays($datax['dias']);
            $cortesias_activacion->aceite_id = 0;
            $cortesias_activacion->tienda_cobrar = $datax['tienda_cobrar'];
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
            // Crear una nueva instancia del modelo
            $cotizacion = new cotizacion();

            $correlativo = cotizacion::max('cotizacion_correlativo');
            if (is_null($correlativo)) {
                $correlativo = 1;
            } else {
                $correlativo++;
            }

            $cotizacion->inventario_moto_id = $cortesias_activacion->inventario_moto_id;
            $cotizacion->observacion_sta = $datax['observacion_sta'];
            $cotizacion->total = $datax['total'];
            $cotizacion->cotizacion_correlativo = $correlativo;
            $cotizacion->total_descuento = 0;
            $cotizacion->user_id = Auth::id(); // ID del usuario relacionado
            $cotizacion->mecanico_id = 0; // ID del mecánico relacionado
            $cotizacion->trabajo_realizar = $datax['trabajo_realizar'];

            if ($cotizacion->save()) {
                foreach ($datax['cotizacion'] as $ps) {
                    // Crear una nueva instancia del modelo
                    $cotizaion_detalle = new cotizacioncotizacion_detalle();

                    // Asignar valores a los campos
                    $cotizaion_detalle->cotizacion_id = $cotizacion->cotizacion_id; // ID de la cotización relacionada
                    $cotizaion_detalle->prod_id = $ps['prod_id']; // ID del producto relacionado
                    $cotizaion_detalle->servicios_id = $ps['servicios_id']; // ID del servicio relacionado
                    $cotizaion_detalle->tipo = $ps['tipo']; // 'P' para producto, 'S' para servicio, ajusta según sea necesario
                    $cotizaion_detalle->Precio = $ps['Precio'];
                    $cotizaion_detalle->Importe = $ps['Importe'];
                    $cotizaion_detalle->ImporteDescuento = 0;
                    $cotizaion_detalle->Descuento = 0;
                    $cotizaion_detalle->Descripcion = $ps['Descripcion'];
                    $cotizaion_detalle->Codigo = $ps['Codigo'];
                    $cotizaion_detalle->Cantidad = $ps['Cantidad'];
                    $cotizaion_detalle->ValorDescuento = 0;
                    $cotizaion_detalle->Detalle = $ps['Detalle'];

                    // Guardar el registro en la base de datos
                    $cotizaion_detalle->save();
                }

                // Encontrar el registro por su ID
                $cortesias_activacion = cortesias_activacion::findOrFail($cortesias_activacion->cortesias_activacion_id);

                // Actualizar el registro con los nuevos datos
                $cortesias_activacion->update(['cotizacion_id' => $cotizacion->cotizacion_id]);
            }

            session()->flash('success', 'Cortesia | Registro creado correctamente');

            return response()->json([
                'message' => 'se creo correctamente la cortesia',
                'error' => '',
                'success' => true,
                'data' => route('activaciones.show', encrypt_id($activaciones->activaciones_id)),
            ]);
        } else {
            Log::error('no se pudo registrar el inventario de la moto');
            session()->flash('error', 'error al registrar en la base de datos');
            dd('error');
            return redirect()->route('inventario_moto.index');
        }
    }

    /* *********************** */

    public function importar_activaciones(Request $request)
    {
        Excel::import(new ActivacionesImport(), $request->file('file'));
    }
    /* *********************** */
}
