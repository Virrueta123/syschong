<?php

namespace App\Http\Controllers;

use App\Imports\ServiciosImport;
use App\Models\servicios;
use App\Models\servicios_defecto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class servicios_controller extends Controller
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
    public function index(Request $request)
    {
        $fecha_actual = Carbon::now();
        if ($request->ajax()) {
            $tiendas = servicios::orderBy('created_at', 'desc')->get();

            return DataTables::of($tiendas)
                ->addIndexColumn()

                ->addColumn('fecha_creacion', function ($Data) {
                    return Carbon::parse($Data->created_at)->format('d/m/Y');
                })
                ->addColumn('action', static function ($Data) {
                    $servicios_id = encrypt_id($Data->servicios_id);
                    return view('buttons.servicios', ['servicios_id' => $servicios_id]);
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('modules.servicios.index', ['fecha_actual' => $fecha_actual]);
        }
    }

    public function servicios_seleccionados(Request $request)
    {
        $servicios = servicios::where('estado', 'A')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('modules.servicios.servicios_seleccionados', ['servicios' => $servicios]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modules.servicios.create');
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
            'servicios_nombre' => 'required|string|max:249|unique:servicios,servicios_nombre',
            'servicios_descripcion' => 'required|string|max:249',
            'servicios_precio' => 'required|string',
        ]);

        $codigo = servicios::max('servicios_codigo');
        if (is_null($codigo)) {
            $codigo = 1;
        } else {
            $codigo++;
        }

        $validate['servicios_codigo'] = $codigo;

        $validate['servicios_precio'] = str_replace(',', '', $validate['servicios_precio']);

        $validate['user_id'] = Auth::user()->id;

        $create = servicios::create($validate);

        if ($create) {
            session()->flash('success', 'se creo correctamente una nueo servicio');
            return redirect()->route('servicios.index');
        } else {
            Log::error('no se pudo registrar el servicio');
            session()->flash('error', 'error al registrar en la base de datos');
            return redirect()->route('servicios.index');
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
        try {
            $get = servicios::find(decrypt_id($id));

            if ($get) {
                return view('modules.servicios.edit', ['get' => $get, 'id' => $id]);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = servicios::where('servicios_id', decrypt_id($id));
        $datax = $request->all();

        $validate = $request->validate([
            'servicios_nombre' => 'required|string|max:249',
            'servicios_descripcion' => 'required|string|max:249',
            'servicios_precio' => 'required|string',
        ]);

        $validate['user_id'] = Auth::user()->id;

        $validate['servicios_precio'] = str_replace(',', '', $validate['servicios_precio']);

        $update = $update->update($validate);

        if ($update) {
            session()->flash('success', 'Registro editado correctamente');
            return redirect()->route('servicios.index');
        } else {
            Log::error('no se pudo registrar el servicio');
            session()->flash('error', 'error al editar en la base de datos');
            return redirect()->route('servicios.index');
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
            $destroy = servicios::where('servicios_id', decrypt_id($id));
            $destroy->delete();

            if ($destroy) {
                session()->flash('success', 'Registro eliminado correctamente');
                return redirect()->route('servicios.index');
            } else {
                Log::error('no se pudo eliminar el servicio');
                session()->flash('error', 'error al eliminar en la base de datos');
                return redirect()->route('servicios.index');
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'error al eliminar');
            return redirect()->route('servicios.index');
        }
    }

    public function estado($id)
    {
        try {
            $update = servicios::find(decrypt_id($id));
            $servicios = servicios::find(decrypt_id($id));

            if ($servicios->estado == 'A') {
                $estado = 'D';
            } else {
                $estado = 'A';
            }

            $update = $update->update(['estado' => $estado]);

            if ($update) {
                session()->flash('success', 'estado actualizado correctamente');
                return redirect()->route('servicios.index');
            } else {
                Log::error('falla al cambiar estado');
                session()->flash('error', 'error al editar en la base de datos');
                return redirect()->route('servicios.index');
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'error al editar');
            return redirect()->route('servicios.index');
        }
    }

    public function importar()
    {
        return view('modules.servicios.importar');
    }

    public function importar_servicioss(Request $request)
    {
        Excel::import(new ServiciosImport(), $request->file('file'));
    }
    /* ******** buscando servicios peticion via ajax ************* */

    public function search_servicios(Request $request)
    {
        try {
            $servicios = servicios::select(DB::raw('*'))
                ->where('servicios_nombre', 'like', '%' . $request->all()['search'] . '%')
                ->orWhere('servicios_codigo', 'like', '%' . $request->all()['search'] . '%')
                ->limit(7)
                ->get();

            if ($servicios) {
                return response()->json([
                    'message' => 'datos encontrados',
                    'error' => '',
                    'success' => true,
                    'data' => json_encode($servicios),
                ]);
            } else {
                Log::error('error al buscar los datos');
                return response()->json([
                    'message' => 'error al buscar los datos',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'message' => 'error al buscar los datos',
                'error' => $th,
                'success' => false,
                'data' => '',
            ]);
        }
    }

    //actualizar los servicios por defecto
    public function servicios_defecto(Request $request)
    {
        try {
            $datax = $request->all();

            $servicio_defecto = servicios_defecto::orderBy('created_at', 'desc')->get();

            if (count($servicio_defecto) != 0) {
                foreach ($servicio_defecto as $servicio) {
                    $servicio->delete();
                }
            }

            //insertando los servicios por defecto en la tabla servicios_defecto
            foreach ($datax['seleccionados'] as $seleccionado) {
                $create = servicios_defecto::create([
                    'servicios_id' => $seleccionado['servicios_id'],
                ]);
            }

            session()->flash('success', 'registro creado correctamente');
            return response()->json([
                'message' => 'datos registrados correctamente',
                'error' => '',
                'success' => true,
                'data' => route("servicios.index")
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'message' => 'error aal registrar los datos',
                'error' => $th->getMessage(),
                'success' => false,
                'data' => '',
            ]);
        }
    }
}
