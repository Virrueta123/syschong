<?php

namespace App\Http\Controllers;

use App\Models\autorizaciones;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class autorizaciones_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fecha_actual = Carbon::now();
        if ($request->ajax()) {
            $cliente = autorizaciones::orderBy('created_at', 'desc')->get();
            return DataTables::of($cliente)
                ->addIndexColumn()
                ->addColumn('fecha_creacion', function ($Data) {
                    return Carbon::parse($Data->created_at)->format('d/m/Y');
                })
                ->addColumn('action', static function ($Data) {
                    $aut_id = encrypt_id($Data->aut_id);
                    return view('buttons.autorizaciones', ['aut_id' => $aut_id]);
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('modules.autorizaciones.index', ['fecha_actual' => $fecha_actual]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modules.autorizaciones.create');
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
                'aut_nombre' => 'required|string|max:255',
            ]);

            $validate['user_id'] = Auth::user()->id;

            $create = autorizaciones::create($validate);

            if ($create) {
                session()->flash('success', 'Registro creado correctamente');
                return redirect()->route('autorizaciones.index');
            } else {
                Log::error('no se pudo registrar');
                session()->flash('error', 'error al registrar en la base de datos');
                return redirect()->route('autorizaciones.index');
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'error al registrar');
            return redirect()->route('autorizaciones.index');
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
        $id = decrypt_id($id);
        $edit = autorizaciones::find($id);
        return view('modules.autorizaciones.edit', ['edit' => $edit]);
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
            $validate = $request->validate([
                'aut_nombre' => 'required|string|max:255',
            ]);

            // Obtén el ID del usuario autenticado
            $validate['user_id'] = Auth::user()->id;

            // Busca el registro existente por su ID
            $registro = autorizaciones::findOrFail($id);

            // Actualiza los atributos del registro
            $update = $registro->update($validate);

            if ($update) {
                session()->flash('success', 'Registro actualizado correctamente');
                return redirect()->route('autorizaciones.index');
            } else {
                Log::error('No se pudo actualizar el registro');
                session()->flash('error', 'Error al actualizar en la base de datos');
                return redirect()->route('autorizaciones.index');
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'Error al actualizar');
            return redirect()->route('autorizaciones.index');
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
            $id = decrypt_id($id);
            $delete = autorizaciones::destroy($id);
            if ($delete) {
                session()->flash('success', 'Registro eliminado correctamente');
                return redirect()->route('autorizaciones.index');
            } else {
                Log::error('No se pudo actualizar el registro');
                session()->flash('error', 'Error al eliminar el registro en la base de datos');
                return redirect()->route('autorizaciones.index');
            }
        } catch (\Throwable $th) {
            Log::error($th);
            session()->flash('error', 'Error al actualizar');
            return redirect()->route('autorizaciones.index');
        }
    }
}
