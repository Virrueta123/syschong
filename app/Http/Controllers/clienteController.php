<?php

namespace App\Http\Controllers;

use App\Models\cliente;
use App\Models\modelo;
use App\Models\motos;
use Carbon\Carbon;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class clienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
            $cliente = cliente::with(["tipo_cliente"])->orderBy('created_at', 'desc')->get();
            return DataTables::of($cliente)
                ->addIndexColumn()
                ->addColumn('nombres', function ($Data) {
                    return $Data->cli_nombre . ' ' . $Data->cli_apellido;
                })
                ->addColumn('action', static function ($Data) {
                    $cli_id = encrypt_id($Data->cli_id);
                    return view('buttons.cliente_buttons', ['cli_id' => $cli_id]);
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('modules.clientes.index', ['fecha_actual' => $fecha_actual]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modules.clientes.create');
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
                'cli_nombre' => 'required|string|max:255',
                'cli_apellido' => 'required|string|max:255',
                'cli_dni' => 'required|numeric',
                'cli_direccion' => 'required|string|max:255',
                'cli_provincia' => 'required|string|max:255',
                'cli_distrito' => 'required|string|max:255',
                'cli_departamento' => 'required|string|max:255',
                'cli_telefono' => 'required|string|max:11',
                'cli_correo' => 'nullable|string|max:255|email',
            ]);

            $validate['cli_telefono'] = str_replace('-', '', $validate['cli_telefono']);
            $validate['cli_correo'] = is_null($validate['cli_correo']) ? 'N' : $validate['cli_correo'];
            $validate['cli_ruc'] = is_null($datax['cli_ruc']) ? 'N' : $datax['cli_ruc'];
            $validate['cli_razon_social'] = is_null($datax['cli_razon_social']) ? 'N' : $datax['cli_razon_social'];
            $validate['cli_direccion_ruc'] = is_null($datax['cli_direccion_ruc']) ? 'N' : $datax['cli_direccion_ruc'];
            $validate['cli_provincia_ruc'] = is_null($datax['cli_provincia_ruc']) ? 'N' : $datax['cli_provincia_ruc'];
            $validate['cli_departamento_ruc'] = is_null($datax['cli_departamento_ruc']) ? 'N' : $datax['cli_departamento_ruc'];
            $validate['cli_distrito_ruc'] = is_null($datax['cli_distrito_ruc']) ? 'N' : $datax['cli_distrito_ruc'];
            $validate['user_id'] = Auth::user()->id;

            $create = cliente::create($validate);

            if ($create) {
                 
                    session()->flash('success', 'Registro creado correctamente');
                    return redirect()->route('cliente.index');
                
            } else {
                Log::error('no se pudo registrar el cliente');
                session()->flash('error', 'error al registrar en la base de datos');
                return redirect()->route('cliente.index');
            }
         
    }

    public function store_vue_cliente_ruc(Request $request)
    {
        try {
            $datax = $request->all();

            $validate = $request->validate([
                'cli_ruc' => 'required|string|max:255',
                'cli_razon_social' => 'required|string|max:255',
                'cli_direccion_ruc' => 'required|string',
            ]);

            $validate['cli_telefono'] = str_replace('-', '', $datax['cli_telefono']);
            $datax['cli_correo'] = is_null($datax['cli_correo']) ? 'N' : $datax['cli_correo'];
            $validate['cli_ruc'] = is_null($datax['cli_ruc']) ? 'N' : $datax['cli_ruc'];
            $validate['cli_razon_social'] = is_null($datax['cli_razon_social']) ? 'N' : $datax['cli_razon_social'];
            $validate['cli_direccion_ruc'] = is_null($datax['cli_direccion_ruc']) ? 'N' : $datax['cli_direccion_ruc'];
            $validate['cli_provincia_ruc'] = is_null($datax['cli_provincia_ruc']) ? 'N' : $datax['cli_provincia_ruc'];
            $validate['cli_departamento_ruc'] = is_null($datax['cli_departamento_ruc']) ? 'N' : $datax['cli_departamento_ruc'];
            $validate['cli_distrito_ruc'] = is_null($datax['cli_distrito_ruc']) ? 'N' : $datax['cli_distrito_ruc'];
            $validate['user_id'] = Auth::user()->id;

            $create = cliente::create($validate);

            if ($create) {
                return response()->json(
                    [
                        'message' => 'se creo correctamente un cliente',
                        'error' => '',
                        'success' => true,
                        'data' => ['value' => $create->cli_id, 'title' => $create->cli_razon_social . ' - ' . $create->cli_ruc],
                    ],
                    200,
                );
            } else {
                Log::error('no se pudo registrar el cliente');
                return response()->json(
                    [
                        'message' => 'no se pudo registrar el cliente',
                        'error' => '',
                        'success' => false,
                        'data' => '',
                    ],
                    500,
                );
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(
                [
                    'message' => 'error del servidor' . $th,
                    'error' => $th,
                    'success' => false,
                    'data' => '',
                ],
                500,
            );
        }
    }

    public function store_vue(Request $request)
    {
        try {
            $datax = $request->all();
            $validate = $request->validate([
                'cli_nombre' => 'required|string|max:255',
                'cli_apellido' => 'required|string|max:255',
                'cli_dni' => 'required|numeric',
                'cli_telefono' => 'nullable|string|max:11',
                'cli_correo' => 'nullable|string|max:255|email',
            ]);

            $validate['cli_telefono'] = str_replace('-', '', $validate['cli_telefono']);
            $validate['cli_correo'] = is_null($validate['cli_correo']) ? 'no tiene' : $validate['cli_correo'];
            $validate['cli_ruc'] = is_null($datax['cli_ruc']) ? 'no tiene' : $datax['cli_ruc'];
            $validate['cli_razon_social'] = is_null($datax['cli_razon_social']) ? 'no tiene' : $datax['cli_razon_social'];
            $validate['cli_direccion_ruc'] = is_null($datax['cli_direccion_ruc']) ? 'no tiene' : $datax['cli_direccion_ruc'];
            $validate['cli_provincia_ruc'] = is_null($datax['cli_provincia_ruc']) ? 'no tiene' : $datax['cli_provincia_ruc'];
            $validate['cli_departamento_ruc'] = is_null($datax['cli_departamento_ruc']) ? 'no tiene' : $datax['cli_departamento_ruc'];
            $validate['cli_distrito_ruc'] = is_null($datax['cli_distrito_ruc']) ? 'no tiene' : $datax['cli_distrito_ruc'];
            $validate['user_id'] = Auth::user()->id;

            $create = cliente::create($validate);

            if ($create) {
                return response()->json(
                    [
                        'message' => 'se creo correctamente un cliente',
                        'error' => '',
                        'success' => true,
                        'data' => ['value' => $create->cli_id, 'title' => $create->cli_nombre . ' ' . $create->cli_apellido . ' - ' . $create->cli_dni],
                    ],
                    200,
                );
            } else {
                Log::error('no se pudo registrar el cliente');
                return response()->json(
                    [
                        'message' => 'no se pudo registrar el cliente',
                        'error' => '',
                        'success' => false,
                        'data' => '',
                    ],
                    500,
                );
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(
                [
                    'message' => 'error del servidor' . $th,
                    'error' => $th,
                    'success' => false,
                    'data' => '',
                ],
                500,
            );
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
            $show = Cliente::where('cli_id', decrypt_id($id))->first();

            if ($show) {
                return view('modules.clientes.edit', ['show' => $show, 'id' => $id]);
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
            $update = Cliente::where('cli_id', decrypt_id($id));
            $datax = $request->all();
            $validate = $request->validate([
                'cli_nombre' => 'required|string|max:255',
                'cli_apellido' => 'required|string|max:255',
                'cli_dni' => 'required|numeric',
                'cli_direccion' => 'required|string|max:255',
                'cli_provincia' => 'required|string|max:255',
                'cli_distrito' => 'required|string|max:255',
                'cli_departamento' => 'required|string|max:255',
                'cli_telefono' => 'required|string|max:11',
                'cli_correo' => 'nullable|string|max:255|email',
            ]);

            $validate['cli_telefono'] = str_replace('-', '', $validate['cli_telefono']);
            $validate['cli_correo'] = is_null($validate['cli_correo']) ? '' : $validate['cli_correo'];
            $validate['cli_ruc'] = is_null($datax['cli_ruc']) ? 'no tiene' : $datax['cli_ruc'];
            $validate['cli_razon_social'] = is_null($datax['cli_razon_social']) ? 'no tiene' : $datax['cli_razon_social'];
            $validate['cli_direccion_ruc'] = is_null($datax['cli_direccion_ruc']) ? 'no tiene' : $datax['cli_direccion_ruc'];
            $validate['cli_provincia_ruc'] = is_null($datax['cli_provincia_ruc']) ? '' : $datax['cli_provincia_ruc'];
            $validate['cli_departamento_ruc'] = is_null($datax['cli_departamento_ruc']) ? '' : $datax['cli_departamento_ruc'];
            $validate['cli_distrito_ruc'] = is_null($datax['cli_distrito_ruc']) ? '' : $datax['cli_distrito_ruc'];

            $update = $update->update($validate);

            if ($update) {
                session()->flash('success', 'Registro editado correctamente');
                return redirect()->route('cliente.index');
            } else {
                Log::error('no se pudo registrar el cliente');
                session()->flash('error', 'error al editar en la base de datos');
                return redirect()->route('cliente.index');
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'error al editar');
            return redirect()->route('cliente.index');
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
            $destroy = Cliente::where('cli_id', decrypt_id($id));
            $destroy->delete();

            if ($destroy) {
                session()->flash('success', 'Registro eliminado correctamente');
                return redirect()->route('cliente.index');
            } else {
                Log::error('no se pudo eliminar el cliente');
                session()->flash('error', 'error al eliminar en la base de datos');
                return redirect()->route('cliente.index');
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'error al eliminar');
            return redirect()->route('cliente.index');
        }
    }

    /* ******** mas funciones ************* */

    /* ******** funciones para consumir en vue ************* */
    function cliente_search(Request $req)
    {
        $cliente = cliente::select(DB::raw('cli_id AS id'), DB::raw("CONCAT(cli_nombre,' ', cli_apellido,'-',cli_dni) AS name"))
            ->where('cli_nombre', 'like', '%' . $req->all()['search'] . '%')
            ->orWhere('cli_apellido', 'like', '%' . $req->all()['search'] . '%')
            ->orWhere('cli_dni', 'like', '%' . $req->all()['search'] . '%')
            ->limit(7)
            ->get();
        echo json_encode($cliente);
    }

    function cliente_search_pos(Request $req)
    {
        $cliente = cliente::select(DB::raw('cli_id AS id'), DB::raw("CONCAT(cli_razon_social,'-',cli_ruc) AS name"))
            ->where('cli_razon_social', 'like', '%' . $req->all()['search'] . '%')
            ->orWhere('cli_ruc', 'like', '%' . $req->all()['search'] . '%')
            ->limit(7)
            ->get();
        echo json_encode($cliente);
    }
    /* *********************** */

    /* ******** actualizar ruc ************* */
    function editar_ruc(Request $req)
    {
        try {
            $datax = $req->all();

            $cliente = cliente::find($datax['cli_id']);
            $cliente->cli_ruc = $datax['cli_form'][0]['value'];
            $cliente->cli_razon_social = $datax['cli_form'][1]['value'];
            $cliente->cli_departamento_ruc = $datax['cli_form'][3]['value'];
            $cliente->cli_provincia_ruc = $datax['cli_form'][4]['value'];
            $cliente->cli_distrito_ruc = $datax['cli_form'][5]['value'];
            $cliente->cli_direccion_ruc = $datax['cli_form'][2]['value'];

            /*
            $update = cliente::update([
                'cli_ruc' => $datax["cli_ruc"],
                'cli_razon_social' => $datax["cli_razon_social"],
                'cli_departamento_ruc' => $datax["cli_departamento_ruc"],
                'cli_provincia_ruc' => $datax["cli_provincia_ruc"],
                'cli_distrito_ruc' => $datax["cli_distrito_ruc"],
                'cli_direccion_ruc' => $datax["cli_direccion_ruc"],
            ], [$datax["cli_id"]]); */

            if ($cliente->update()) {
                return response()->json([
                    'message' => 'se actualizo correctamente el ruc',
                    'error' => '',
                    'success' => true,
                    'data' => '',
                ]);
            } else {
                Log::error('error al actualizar el ruc');
                return response()->json([
                    'message' => 'error al actualizar el ruc',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                'message' => 'error al actualizar el ruc',
                'error' => $th->getMessage(),
                'success' => false,
                'data' => '',
            ]);
        }
    }
    /* *********************** */
    function update_vue_cliente(Request $req)
    {
        try {
            $datax = $req->all();

            $cliente = new cliente();
            $cliente->cli_nombre = is_null($datax['cli_nombre']) ? 'no tiene' :$datax['cli_nombre'] ;
            $cliente->cli_apellido = $datax['cli_apellido'];
            $cliente->cli_dni = $datax['cli_dni'];
            $cliente->cli_direccion = $datax['cli_direccion'];
            $cliente->cli_provincia = $datax['cli_provincia'];
            $cliente->cli_distrito = $datax['cli_distrito'];
            $cliente->cli_departamento = $datax['cli_departamento'];
            $cliente->cli_telefono = str_replace('-', '', $datax['cli_telefono']);
            $cliente->cli_correo = $datax['cli_correo'];
            $cliente->cli_ruc =  is_null($datax['cli_ruc'])  ? 'no tiene' :$datax['cli_ruc'] ;
            $cliente->cli_razon_social =is_null( $datax['cli_razon_social'])  ? 'no tiene' :$datax['cli_razon_social'] ;
            $cliente->cli_direccion_ruc =is_null( $datax['cli_direccion_ruc'])  ? 'no tiene' :$datax['cli_direccion_ruc'] ;
            $cliente->cli_provincia_ruc = $datax['cli_provincia_ruc'];
            $cliente->cli_departamento_ruc = $datax['cli_departamento_ruc'];
            $cliente->cli_distrito_ruc = $datax['cli_distrito_ruc'];
 
            $cliente->save();
            $cli_id = $cliente->cli_id;

          
            $moto = motos::find($datax['mtx_id']);

            $moto->cli_id = $cli_id;

            

            if ($moto->update()) {
                return response()->json([
                    'message' => 'se actualizo correctamente el  cliente',
                    'error' => '',
                    'success' => true,
                    'data' => $cliente,
                ]);
            } else {
                Log::error('error al actualizar el cliente');
                return response()->json([
                    'message' => 'error al actualizar el cliente',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                'message' => 'error al actualizar el cliente',
                'error' => $th->getMessage(),
                'success' => false,
                'data' => '',
            ]);
        }
    }

    function asignar_cliente_moto(Request $req){
        try {
            $datax = $req->all();
 
            $cli_id = $datax["cli_id"];

            $cliente = cliente::find($datax["cli_id"]);

        

            $moto = motos::find($datax['mtx_id']);

            $moto->cli_id = $cli_id;

            if ($moto->update()) {
                return response()->json([
                    'message' => 'se actualizo correctamente el  cliente',
                    'error' => '',
                    'success' => true,
                    'data' => $cliente,
                ]);
            } else {
                Log::error('error al actualizar el cliente');
                return response()->json([
                    'message' => 'error al actualizar el cliente',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                'message' => 'error al actualizar el cliente',
                'error' => $th->getMessage(),
                'success' => false,
                'data' => '',
            ]);
        }
    }

    function update_vue_cli(Request $req)
    {
        try {
            $datax = $req->all();
 
            $cliente = cliente::find($datax['cli_id']);
            $cliente->cli_nombre = $datax['cli_nombre'];
            $cliente->cli_apellido = $datax['cli_apellido'];
            $cliente->cli_dni = $datax['cli_dni'];
            $cliente->cli_direccion = $datax['cli_direccion'];
            $cliente->cli_provincia = $datax['cli_provincia'];
            $cliente->cli_distrito = $datax['cli_distrito'];
            $cliente->cli_departamento = $datax['cli_departamento'];
            $cliente->cli_telefono = str_replace('-', '', $datax['cli_telefono']);
            $cliente->cli_correo = $datax['cli_correo'];
            $cliente->cli_ruc = $datax['cli_ruc'];
            $cliente->cli_razon_social = $datax['cli_razon_social'];
            $cliente->cli_direccion_ruc = $datax['cli_direccion_ruc'];
            $cliente->cli_provincia_ruc = $datax['cli_provincia_ruc'];
            $cliente->cli_departamento_ruc = $datax['cli_departamento_ruc'];
            $cliente->cli_distrito_ruc = $datax['cli_distrito_ruc'];
          
            if ($cliente->update()) {
                return response()->json([
                    'message' => 'se actualizo correctamente el cliente',
                    'error' => '',
                    'success' => true,
                    'data' => '',
                ]);
            } else {
                Log::error('error al actualizar el cliente');
                return response()->json([
                    'message' => 'error al actualizar el cliente',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                'message' => 'error al actualizar el cliente',
                'error' => $th->getMessage(),
                'success' => false,
                'data' => '',
            ]);
        }
    }

    /* *********************** */
    function editar_celular(Request $req)
    {
        try {
            $datax = $req->all();
        
            $cliente = cliente::find($datax['cli_id']);
        
            $cliente->cli_telefono =  $req->all()['cli_telefono']; 

            if ($cliente->update()) {
                return response()->json([
                    'message' => 'se actualizo correctamente el  cliente',
                    'error' => '',
                    'success' => true,
                    'data' => $datax['cli_telefono'],
                ]);
            } else {
                Log::error('error al actualizar el cliente');
                return response()->json([
                    'message' => 'error al actualizar el cliente',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                'message' => 'error al actualizar el cliente',
                'error' => $th->getMessage(),
                'success' => false,
                'data' => '',
            ]);
        }
    }
}
