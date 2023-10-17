<?php

namespace App\Http\Controllers;

use App\Models\empresa;
use App\Models\forma_pago;
use App\Models\ventas;
use Illuminate\Http\Request;

class pos_controller extends Controller
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
        $correlativo_factura = ventas::where("tipo_comprobante","F")->max("venta_correlativo");
    
        if (is_null($correlativo_factura)) {
            $correlativo_factura = 1;
        } else {
            $correlativo_factura++;
        }

        $correlativo_boleta = ventas::where("tipo_comprobante","B")->max("venta_correlativo");
    
        if (is_null($correlativo_boleta)) {
            $correlativo_boleta = 1;
        } else {
            $correlativo_boleta++;
        }

        $forma_pago = forma_pago::where("estado","A")->get();
 
        $empresa = empresa::select("ruc","celular","razon_social","direccion","ruc")->first(); 
        
        return view('modules.pos.create',["empresa"=>$empresa,"correlativo_factura"=>$correlativo_factura,"correlativo_boleta"=>$correlativo_boleta,"forma_pago"=>$forma_pago]);
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
