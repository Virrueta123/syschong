<?php

namespace App\Http\Controllers;

use App\Models\empresa;
use Illuminate\Http\Request;

class empresa_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit( )
    {
        $empresa = empresa::first();
        return view('modules.empresa.edit', compact('empresa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request )
    {
        $data = $request->validate([
            'ruc' => 'required|string|max:12',
            'celular' => 'required|string',
            'razon_social' => 'required|string|max:250',
            'direccion' => 'required|string|max:250', 
            'declaracion' => 'required|string|max:255',
            'token_whatsapps_api' => 'required|string|max:255',
            'codigo_telefono' => 'required|string|max:155',
            'activacion' => 'required|string|max:155',
            'cortesia' => 'required|string|max:155',
        ]);

        $empresa = empresa::find(1);
        $empresa->update($data);

        return redirect()->route('home')->with('success', 'Empresa actualizada correctamente');
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
