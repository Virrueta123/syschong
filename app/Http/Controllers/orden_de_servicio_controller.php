<?php

namespace App\Http\Controllers;

use App\Models\accesorios;
use App\Models\autorizaciones;
use App\Models\empresa;
use App\Models\producto;
use App\Models\productos_defecto;
use App\Models\servicios_defecto;
use Illuminate\Http\Request;

class orden_de_servicio_controller extends Controller
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
    public function index()
    {
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

        $servicios_defecto = servicios_defecto::with(['servicio'])
            ->orderBy('created_at')
            ->get();


        //agregar aceite 
        $productos_defecto = producto::with(['producto_modelo', "unidad"])
            ->where('unidades_id', 65)
            ->orderBy('created_at', 'desc')
            ->get();


        $empresa = empresa::first();
 

        return view('modules.order_de_servicio.create', compact('accesorios', 'autorizaciones', "servicios_defecto", "productos_defecto", "empresa"));
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
