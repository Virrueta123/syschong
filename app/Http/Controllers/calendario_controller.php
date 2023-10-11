<?php

namespace App\Http\Controllers;

use App\Models\cortesias_activacion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class calendario_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          
        return view('modules.calendar.calendar_view');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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

    /* ******** calendario_cortesisas ************* */
    public function calendario_cortesisas()
    {
        $registros = cortesias_activacion::with(["activaciones"=>function($query){
            $query->with(['moto' => function ($query) {
                $query->with(['modelo', 'cliente']);
            }]);
        }]) ->get();

        $eventos = [];

        foreach ($registros as $registro) {
            $evento = [
                'title' => $registro->activaciones->moto->cliente->cli_nombre."-".$registro->activaciones->moto->cliente->cli_apellido, // Título del evento (reemplaza 'nombre_campo' con el nombre real)
                'start' => Carbon::parse($registro->created_at)->addDays($registro->dias)->format('Y-m-d'), // Fecha de inicio del evento, // Fecha de inicio del evento
                'end' => Carbon::parse($registro->created_at)->addDays($registro->dias)->format('Y-m-d'),
                "color" => "red",  // Fecha de fin del evento (calculada agregando 'dias')
            ];

            $eventos[] = $evento;
        }
        return $eventos;
    }
    /* *********************** */
}
