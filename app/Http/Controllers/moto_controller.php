<?php

namespace App\Http\Controllers;

use App\Models\accesorios_inventario_detalle;
use App\Models\cliente;
use App\Models\cortesias_activacion;
use App\Models\cotizacion;
use App\Models\cotizacioncotizacion_detalle;
use App\Models\inventario_autorizaciones;
use App\Models\inventario_moto;
use App\Models\motos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class moto_controller extends Controller
{
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
            $cliente = motos::with([
                'modelo' => function ($query) {
                    $query->with(['marca']);
                },
            ])
                ->orderBy('created_at', 'desc')
                ->get();
            return DataTables::of($cliente)
                ->addIndexColumn()
                ->addColumn('marca', function ($Data) {
                    return $Data->modelo->marca->marca_nombre;
                })
                ->addColumn('modelo', function ($Data) {
                    return $Data->modelo->modelo_nombre;
                })
                ->addColumn('cliente', function ($Data) {
                    if(is_null($Data->cliente)){
                        return "sin cliente";
                    }else{
                        if ($Data->cliente->cli_ruc != 'no tiene') {
                            return $Data->cliente->cli_razon_social;
                        } else {
                            return $Data->cliente->cli_nombre . '-' . $Data->cliente->cli_apellido;
                        }
                    } 
                })
                ->addColumn('fecha_creacion', function ($Data) {
                    return Carbon::parse($Data->created_at)->format('Y-m-d');
                })
                ->addColumn('estado', static function ($Data) {
                    $estado  = $Data->mtx_estado;
                    return view('complementos.estado_moto', ['estado' => $estado]);
                })
                ->addColumn('action', static function ($Data) {
                    $mtx_id = encrypt_id($Data->mtx_id);
                    return view('buttons.moto_buttons', ['mtx_id' => $mtx_id]);
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('modules.moto.index', ['fecha_actual' => $fecha_actual]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fecha = Carbon::now()->format("Y");
        return view('modules.moto.create',compact("fecha"));
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

             
            $validate = $request->validate([
                'mtx_placa' => 'required|string|max:50',

                'mtx_vin' => 'required|max:200',

                'modelo_id' => 'required',

                'mtx_motor' => 'required',

                'mtx_fabricacion' => 'required',

                'mtx_estado' => 'required|max:1', 

                'mtx_color' => 'required|string|max:200', 

                'cli_id' => 'required',
            ]);

            $validate['user_id'] = Auth::user()->id;
           
             
            $create = motos::create($validate);

            if ($create) {
                session()->flash('success', 'se creo correctamente una nueva moto');
                return redirect()->route('moto.index');
            } else {
                Log::error('no se pudo registrar la nueva moto');
                session()->flash('error', 'error al registrar en la base de datos');
                return redirect()->route('moto.index');
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $show = motos::
            with(['cliente',
            'modelo' => function ($query) {
                return $query->with(['marca']);
            } 
            ])
            ->where('mtx_id', decrypt_id($id))->first();

            $fecha = $show->mtx_fabricacion;

            if ($show) {
                return view('modules.moto.editar', ['show' => $show, 'id' => $id,'fecha' => $fecha]);
            } else {
                return view('errors.404');
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'error al eliminar');
            return redirect()->route('cliente.index');
        }
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
        try {
            $update = motos::where('mtx_id', decrypt_id($id));
            $datax = $request->all(); 
            $validate = $request->validate([
                'mtx_placa' => 'string|max:50',

                'mtx_vin' => 'required|max:200',

                'modelo_id' => 'required',

                'mtx_motor' => 'required', 

                'mtx_estado' => 'required|max:1',

                'mtx_chasis' => 'max:200',

                'mtx_color' => 'required|string|max:200', 

                'cli_id' => '',
            ]);

            if(!is_null($datax["mtx_fabricacion"])){
                $validate['mtx_fabricacion'] = $datax["mtx_fabricacion"];
            }

            $validate['user_id'] = Auth::user()->id;

            $update = $update->update($validate);

            if ($update) {
                session()->flash('success', 'Registro editado correctamente');
                return redirect()->route('moto.index');
            } else {
                Log::error('no se pudo editar la moto');
                session()->flash('error', 'error al editar en la base de datos');
                return redirect()->route('moto.index');
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'error al editar');
            return redirect()->route('moto.index');
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
            $destroy = motos::where('mtx_id', decrypt_id($id));
            $destroy->delete();

            if ($destroy) {
                session()->flash('success', 'Registro eliminado correctamente');
                return redirect()->route('moto.index');
            } else {
                Log::error('no se pudo eliminar la moto');
                session()->flash('error', 'error al eliminar en la base de datos');
                return redirect()->route('moto.index');
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'error al eliminar');
            return redirect()->route('moto.index');
        }
    }

    /* ******** api ************* */

    public function search_moto_modelo(Request $req)
    {
        $search = $req->all()['search'];
        $moto = motos::select('motos.mtx_id as id', DB::raw("CONCAT('Cliente : ',cliente.cli_nombre, ' ', cliente.cli_apellido, ' | Moto : ', marca.marca_nombre,' modelo: ' , modelo.modelo_nombre, ' Clindraje: ', modelo.cilindraje,' Motor:',motos.mtx_motor) as name"))
            ->join('cliente', 'cliente.cli_id', '=', 'motos.cli_id')
            ->join('modelo', 'modelo.modelo_id', '=', 'motos.modelo_id')
            ->join('marca', 'marca.marca_id', '=', 'modelo.marca_id')
            ->where(function ($query) use ($search) {
                $query
                    ->whereRaw('CONCAT(cliente.cli_nombre," ",cliente.cli_apellido) LIKE ?', '%' . $search . '%')
                    ->orWhere('cliente.cli_apellido', 'like', '%' . $search . '%')
                    ->orWhere('marca.marca_nombre', 'like', '%' . $search . '%')
                    ->orWhere('modelo.modelo_nombre', 'like', '%' . $search . '%')
                    ->orWhere('motos.mtx_motor', 'like', '%' . $search . '%')
                    ->orWhere('cliente.deleted_at', '=', null);
            })
            ->limit(15) 
            ->get();

        echo json_encode($moto);
    }

    public function moto_search(Request $req)
    {
        $moto = motos::select(DB::raw('mtx_id AS id'), DB::raw("CONCAT(mtx_placa,' ', mtx_vin,' ',mtx_motor) AS name"))
            ->with("modelo")
            ->where('mtx_placa', 'like', '%' . $req->all()['search'] . '%')
            ->orWhere('mtx_vin', 'like', '%' . $req->all()['search'] . '%')
            ->orWhere('modelo.modelo_nombre', 'like', '%' . $req->all()['search'] . '%')
            ->limit(15)
            ->get();

        echo json_encode($moto);
    }

    public function get_moto(Request $req)
    {
        try {
            $show = motos::with(["cliente",'modelo' => function ($query) {
                $query->with(['marca']);
            }])->find($req->all()['id']);

       
            if ($show) {
                return response()->json([
                    'message' => 'datos cargados correctamente',
                    'error' => '',
                    'success' => true,
                    'data' => $show,
                ]);
            } else {
                Log::error('error al mostrar los datos');
                return response()->json([
                    'message' => 'no se pudo registrar el cliente',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'message' => 'error al mostrar los datos, cargue el navegador nuevamente',
                'error' => $th,
                'success' => false,
                'data' => '',
            ]);
        }
    }

    public function store_moto_vue(Request $req){
        
        try {
           

            $validate = $req->validate([
                'mtx_placa' => 'required|string|max:50',

                'mtx_vin' => 'required|max:200',

                'modelo_id' => 'required', 

                'mtx_fabricacion' => 'required',

                'mtx_estado' => 'required|max:1', 

                'mtx_color' => 'required|string|max:200', 

                'mtx_motor' => 'required|string|max:200', 

                'cli_id' => 'required',
            ]);

            

            $validate['user_id'] = Auth::user()->id;

            $create = motos::create($validate);

        

            if ($create) {
                $moto = motos::with(["cliente",'modelo' => function ($query) {
                    $query->with(['marca']);
                }])->find($create->mtx_id);

                $moto_array = $moto->toArray();
  
                $moto_array["value"] = $create->mtx_id;
                $moto_array["title"] = 'Cliente : '.$moto->cliente->cli_nombre.' '. $moto->cliente->cli_apellido. ' | Moto : '.  $moto->modelo->marca->marca_nombre.' modelo: ' .$moto->modelo->modelo_nombre.' Clindraje: '. $moto->modelo->cilindraje.' Motor:'.$moto->mtx_motor;
                
                return response()->json(
                    [
                        'message' => 'se creo correctamente la moto',
                        'error' => '',
                        'success' => true,
                        'data' => $moto_array
                    ] 
                );
                dd($validate);
                
            } else {
                Log::error('no se pudo registrar el cliente');
                return response()->json(
                    [
                        'message' => 'no se pudo registrar la moto',
                        'error' => '',
                        'success' => false,
                        'data' => '',
                    ], 
                );
            }
 
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'message' => 'error al mostrar los datos, cargue el navegador nuevamente',
                'error' => $th,
                'success' => false,
                'data' => '',
            ]);
        }
    }

    /* *********************** */

    public function create_vue_garantia_orden(Request $request){
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
            'inventario_moto_obs_cliente' => 'nullable',
            'inventario_moto_nivel_gasolina' => 'nullable',
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
            $cortesias_activacion->is_garantia = "Y";
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
            $cotizacion->total = $datax['sumar_total'];
            $cotizacion->cotizacion_correlativo = $correlativo;
            $cotizacion->total_descuento = 0;
            $cotizacion->user_id = Auth::id(); // ID del usuario relacionado
            $cotizacion->mecanico_id = 0; // ID del mecánico relacionado
            $cotizacion->trabajo_realizar = $datax['trabajo_realizar'];
            $cotizacion->tipo_cotizacion = "C";
            $cotizacion->total_garantia = $datax['sumar_total_garanria'];

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
                    $cotizaion_detalle->garantia = $ps['garantia'];

                    // Guardar el registro en la base de datos
                    $cotizaion_detalle->save();
                }

                // Encontrar el registro por su ID
                $cortesias_activacion = cortesias_activacion::findOrFail($cortesias_activacion->cortesias_activacion_id);

                // Actualizar el registro con los nuevos datos
                $cortesias_activacion->update(['cotizacion_id' => $cotizacion->cotizacion_id]);
            }

            session()->flash('success', 'Garantia | Registro creado correctamente');

            return response()->json([
                'message' => 'se creo correctamente la garantia',
                'error' => '',
                'success' => true,
                'data' => route('cotizaciones.show', encrypt_id($cotizacion->cotizacion_id)),
            ]);
        } else {
            Log::error('no se pudo registrar el inventario de la moto');
            return response()->json([
                'message' => 'error al crear al crear la garantia',
                'error' => '',
                'success' => false,
                'data' => "",
            ]);
        }
    }
}
