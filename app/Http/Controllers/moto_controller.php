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
            $cliente = motos::with('marca')
                ->orderBy('created_at', 'desc')
                ->get();
            return DataTables::of($cliente)
                ->addIndexColumn()
                ->addColumn('marca', function ($Data) {
                    return $Data->marca->marca_nombre;
                })
                ->addColumn('cliente', function ($Data) {
                    return $Data->cliente->cli_nombre . '-' . $Data->cliente->cli_apellido;
                })
                ->addColumn('fecha_creacion', function ($Data) {
                    return Carbon::parse($Data->created_at)->format('d/m/Y');
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

                'marca_id' => 'required',

                'mtx_motor' => 'required',

                'mtx_fabricacion' => 'required|date',

                'mtx_estado' => 'required|max:1',

                'mtx_chasis' => 'required|max:200',

                'mtx_color' => 'required|string|max:200',

                'mtx_cilindraje' => 'required|string|max:200',

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

    /* ******** api ************* */

    public function moto_search(Request $req)
    {
        $moto = motos::select(DB::raw('mtx_id AS id'), DB::raw("CONCAT(mtx_placa,' ', mtx_vin,' ',mtx_motor) AS name"))
            ->where('mtx_placa', 'like', '%' . $req->all()['search'] . '%')
            ->orWhere('mtx_vin', 'like', '%' . $req->all()['search'] . '%') 
            ->limit(7)
            ->get();
        echo json_encode($moto);
    }

    public function get_moto(Request $req){
        
        try {
            $show = motos::with('cliente')->find(($req->all()['id'])); 
   
            if ($show) {
                return response()->json([
                    'message' => 'todo ok',
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

    /* *********************** */
}
