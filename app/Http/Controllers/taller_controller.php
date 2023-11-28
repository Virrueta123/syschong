<?php

namespace App\Http\Controllers;

use App\Models\cotizacion;
use Illuminate\Http\Request;

class taller_controller extends Controller
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
        return view('modules.taller.index');
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

    public function taller_data(Request $req)
    {
         $coti1 = count(cotizacion::where("progreso",0)->where("estado","A")->get());
         $coti2 = count(cotizacion::where("progreso",1)->where("estado","A")->get());
         $coti3 = count(cotizacion::where("progreso",2)->where("estado","A")->get());
         $coti4 = count(cotizacion::where("progreso",3)->where("estado","A")->get());
         $coti5 = count(cotizacion::where("progreso",4)->where("estado","A")->get());
         $coti6 = count(cotizacion::where("progreso",5)->where("estado","A")->get());
         $coti7 = count(cotizacion::where("progreso",6)->where("estado","A")->get());
         
         $data = array("coti1"=>$coti1,"coti2"=>$coti2,"coti3"=>$coti3,"coti4"=>$coti4,"coti5"=>$coti5,"coti6"=>$coti6,"coti7"=>$coti7);

         return response()->json([
            'message' => 'datos cargados',
            'error' => '',
            'success' => true,
            'data' => $data,
        ]); 
         
    }
}
