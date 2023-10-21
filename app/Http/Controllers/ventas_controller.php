<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ventas_controller extends Controller
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

    /* ******** registrar la venta con vue ************* */ 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_vue(Request $request)
    {
        try {
            
            $cotizacion_id = $request->all()['cotizacion_id'];
            $detalle = $request->all()['detalle'];
            $contador = 0;
            
            foreach ($detalle as $dt) {
                $contador++;
                $updated = cotizacioncotizacion_detalle::find($dt['cotizacion_detalle_id']);
                $updated->aprobar = $dt['aprobar'];
                $updated->save();
            }

            if (count($detalle) == $contador) {
                $cotizacion_id = $request->all()['cotizacion_id'];
                $update = cotizacion::find($cotizacion_id);
                $update->progreso = 2;
                $update->save();
                return response()->json([
                    'message' => 'se actualizo la cotizacion a aprobada',
                    'error' => '',
                    'success' => true,
                    'data' => '',
                ]);
            } else {
                Log::error('no se puedo actualizar la cotizacion a aprobada');
                return response()->json([
                    'message' => 'no se puedo actualizar la cotizacion a aprobada',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                'message' => 'error del servidor',
                'error' => $th->getMessage(),
                'success' => false,
                'data' => '',
            ]);
        }
    }
    /* *********************** */
}
