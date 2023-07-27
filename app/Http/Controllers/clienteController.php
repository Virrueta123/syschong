<?php

namespace App\Http\Controllers;

use App\Models\cliente;
use Illuminate\Http\Request;
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
        if ($request->ajax()) {
            $cliente = cliente::where("active", "A")
                ->get();

            return DataTables::of($cliente)
                ->addIndexColumn()
                ->addColumn('nombres', function ($Data) {
                    return $Data->cli_nombre . " " . $Data->cli_apellido;
                })
                ->addColumn('action', static function ($Data) {
                    //return view("modules.options.historial", ["tx" => $Data]);
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('modules.clientes.index');
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

        try {
            $validate = $request->validate([
                'cli_nombre' => 'required|string|max:255',
                'cli_apellido' => 'required|string|max:255',
                'cli_dni' => 'required|numeric',
                'cli_ruc' => 'nullable|numeric|max:11|min:11',
                'cli_razon_social' => 'nullable|string|max:255',
                'cli_direccion_ruc' => 'nullable|string|max:255',
                'cli_provincia_ruc' => 'nullable|string|max:255',
                'cli_departamento_ruc' => 'nullable|string|max:255',
                'cli_distrito_ruc' => 'nullable|string|max:255',
                'cli_direccion' => 'required|string|max:255',
                'cli_provincia' => 'required|string|max:255',
                'cli_distrito' => 'required|string|max:255',
                'cli_departamento' => 'required|string|max:255',
                'cli_telefono' => 'required|string|max:11',
                'cli_correo' => 'nullable|string|max:255|email',
            ]);

            $validate['cli_telefono'] = str_replace('-', '',  $validate['cli_telefono']);
            $validate['cli_correo'] = is_null($validate['cli_correo']) ? 'N'  : $validate['cli_correo'];
            $validate['cli_ruc'] = is_null($validate['cli_ruc']) ? 'N'  : $validate['cli_ruc'];
            $validate['cli_razon_social'] = is_null($validate['cli_razon_social']) ? 'N'  : $validate['cli_razon_social'];
            $validate['cli_direccion_ruc'] = is_null($validate['cli_direccion_ruc']) ? 'N'  : $validate['cli_direccion_ruc'];
            $validate['cli_provincia_ruc'] = is_null($validate['cli_provincia_ruc']) ? 'N'  : $validate['cli_provincia_ruc'];
            $validate['cli_departamento_ruc'] = is_null($validate['cli_departamento_ruc']) ? 'N'  : $validate['cli_departamento_ruc'];
            $validate['cli_distrito_ruc'] = is_null($validate['cli_distrito_ruc']) ? 'N'  : $validate['cli_distrito_ruc'];

            $create = cliente::create($validate);

            if ($create) {
                session()->flash('success', 'Registro creado correctamente');
                return redirect()->route("cliente.index");
            } else {
                session()->flash('error', 'error al registrar');
                return redirect()->route("cliente.index");
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'error al registrar');
            return redirect()->route("cliente.index");
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
}
