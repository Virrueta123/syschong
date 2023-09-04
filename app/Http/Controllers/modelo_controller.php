<?php

namespace App\Http\Controllers;

use App\Models\modelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class modelo_controller extends Controller
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

    /* ******** vue api ************* */

    public function search_modelo(Request $request)
    {
        $search = $request->input('search');
  
        $modelo = modelo::select('modelo.modelo_id as id', DB::raw("CONCAT(marca.marca_nombre, '-', modelo.modelo_nombre, '-', modelo.cilindraje) as name"))
        ->join('marca', 'modelo.marca_id', '=', 'marca.marca_id')
        ->where(function ($query) use ($search) {
            $query->where('modelo.modelo_nombre', 'like', '%' . $search . '%')
                ->orWhere('marca.marca_nombre', 'like', '%' . $search . '%');
        })
        ->get(15);

        echo json_encode($modelo);
    }

    /* *********************** */
}
