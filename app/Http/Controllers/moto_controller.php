<?php

namespace App\Http\Controllers;

use App\Models\cliente;
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
                    return Carbon::parse($Data->created_at)->format('d/m/Y');
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
        return view('modules.moto.create');
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
                'mtx_placa' => 'required|string|max:50',

                'mtx_vin' => 'required|max:200',

                'modelo_id' => 'required',

                'mtx_motor' => 'required',

                'mtx_fabricacion' => 'required|date',

                'mtx_estado' => 'required|max:1',

                'mtx_chasis' => 'required|max:200',

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
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'error al registrar');
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

            if ($show) {
                return view('modules.moto.editar', ['show' => $show, 'id' => $id]);
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
                'mtx_placa' => 'required|string|max:50',

                'mtx_vin' => 'required|max:200',

                'modelo_id' => 'required',

                'mtx_motor' => 'required', 

                'mtx_estado' => 'required|max:1',

                'mtx_chasis' => 'required|max:200',

                'mtx_color' => 'required|string|max:200', 

                'cli_id' => 'required',
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
                    ->orWhere('motos.mtx_motor', 'like', '%' . $search . '%');
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

                'mtx_fabricacion' => 'required|date',

                'mtx_estado' => 'required|max:1',

                'mtx_chasis' => 'required|max:200',

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
}
