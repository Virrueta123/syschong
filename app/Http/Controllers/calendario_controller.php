<?php

namespace App\Http\Controllers;

use App\Models\activaciones;
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
        $eventos = [];

        $activaciones = activaciones::with([
            'moto' => function ($query) {
                return $query->with([
                    'cliente',
                    'modelo' => function ($query) {
                        return $query->with(['marca']);
                    },
                ]);
            },
            'vendedor',
            'tienda',
            'cortesias',
        ])
            ->where('activado_taller', 'Y')
            ->get();

        foreach ($activaciones as $ac) {
            if ($ac->cortesias->count() > 0) {
                $id = $ac->activaciones_id;

                $cortesias_activacion = cortesias_activacion::with([
                    'activaciones' => function ($query) use ($id) {
                        $query->with([
                            'moto' => function ($query) {
                                $query->with(['modelo', 'cliente']);
                            },
                        ]);
                    },
                ])
                    ->where('activaciones_id', $id)
                    ->where('tipo', 'C')
                    ->where('is_aviso', 'S')
                    ->orderBy('numero_corterisa', 'desc')
                    ->first();

                if ($cortesias_activacion) {
                    $evento_cortesias_activacion = [
                        'title' => $cortesias_activacion->activaciones->moto->cliente->cli_nombre . '-' . $cortesias_activacion->activaciones->moto->cliente->cli_apellido, // Título del evento (reemplaza 'nombre_campo' con el nombre real)
                        'start' => Carbon::parse($cortesias_activacion->created_at)
                            ->addDays($cortesias_activacion->dias)
                            ->format('Y-m-d'), // Fecha de inicio del evento, // Fecha de inicio del evento
                        'end' => Carbon::parse($cortesias_activacion->created_at)
                            ->addDays($cortesias_activacion->dias)
                            ->format('Y-m-d'),
                        'color' => 'red', // Fecha de fin del evento (calculada agregando 'dias')
                    ];
                    array_push($eventos, $evento_cortesias_activacion);
                }
            } else {
                $evento = [
                    'title' => $ac->moto->cliente->cli_nombre . '-' . $ac->moto->cliente->cli_apellido, // Título del evento (reemplaza 'nombre_campo' con el nombre real)
                    'start' => Carbon::parse($ac->created_at)
                        ->addDays($ac->dias)
                        ->format('Y-m-d'), // Fecha de inicio del evento, // Fecha de inicio del evento
                    'end' => Carbon::parse($ac->created_at)
                        ->addDays($ac->dias)
                        ->format('Y-m-d'),
                    'color' => 'blue', // Fecha de fin del evento (calculada agregando 'dias')
                ];
                array_push($eventos, $evento);
            }
        }

        /* ******** mantenimiento ************* */
        $activaciones_mantenimiento = activaciones::with([
            'moto' => function ($query) {
                return $query->with([
                    'cliente',
                    'modelo' => function ($query) {
                        return $query->with(['marca']);
                    },
                ]);
            },
            'vendedor',
            'tienda',
            'cortesias',
        ])
            ->where('activado_taller', 'N')
            ->get();

        foreach ($activaciones_mantenimiento as $ac) {
            if ($ac->cortesias->count() > 0) {
                $id = $ac->activaciones_id;

                $cortesias_activacion = cortesias_activacion::with([
                    'activaciones' => function ($query) use ($id) {
                        $query->with([
                            'moto' => function ($query) {
                                $query->with(['modelo', 'cliente']);
                            },
                        ]);
                    },
                ])
                    ->where('activaciones_id', $id)
                    ->where('tipo', 'M')
                    ->where('is_aviso', 'S')
                    ->orderBy('numero_corterisa', 'desc')
                    ->first();

                if ($cortesias_activacion) {
                    $evento_cortesias_activacion = [
                        'title' => $cortesias_activacion->activaciones->moto->cliente->cli_nombre . '-' . $cortesias_activacion->activaciones->moto->cliente->cli_apellido, // Título del evento (reemplaza 'nombre_campo' con el nombre real)
                        'start' => Carbon::parse($cortesias_activacion->created_at)
                            ->addDays($cortesias_activacion->dias)
                            ->format('Y-m-d'), // Fecha de inicio del evento, // Fecha de inicio del evento
                        'end' => Carbon::parse($cortesias_activacion->created_at)
                            ->addDays($cortesias_activacion->dias)
                            ->format('Y-m-d'),
                        'color' => 'green', // Fecha de fin del evento (calculada agregando 'dias')
                    ];
                    array_push($eventos, $evento_cortesias_activacion);
                }
            } else {
                $evento = [
                    'title' => $ac->moto->cliente->cli_nombre . '-' . $ac->moto->cliente->cli_apellido, // Título del evento (reemplaza 'nombre_campo' con el nombre real)
                    'start' => Carbon::parse($ac->created_at)
                        ->addDays($ac->dias)
                        ->format('Y-m-d'), // Fecha de inicio del evento, // Fecha de inicio del evento
                    'end' => Carbon::parse($ac->created_at)
                        ->addDays($ac->dias)
                        ->format('Y-m-d'),
                    'color' => 'black', // Fecha de fin del evento (calculada agregando 'dias')
                ];
                array_push($eventos, $evento);
            }
        }
        /* *********************** */
        return $eventos;
    }
    /* *********************** */
}
