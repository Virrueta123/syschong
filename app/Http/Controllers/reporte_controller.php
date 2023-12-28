<?php

namespace App\Http\Controllers;

use App\Models\ventas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class reporte_controller extends Controller
{
    public function load_numero_comprobante()
    {
        try {
         
            $monto_total_comprobantes = ventas::whereIn("tipo_comprobante",["F", "B"])->where("estado","A")->count();

            $monto_total_notas_ventas = ventas::where("tipo_comprobante",["N"])->where("estado","A")->count();

            $monto_total_general = "S/. ".moneyformat(ventas::whereIn("tipo_comprobante",["N","F", "B"])->where("estado","A")->sum("SubTotal"));

            $utilidad_neta = 10;

            return response()->json([
                'message' => 'datos encontrados',
                'error' => '',
                'success' => true,
                'data' => [
                    'monto_total_comprobantes' => $monto_total_comprobantes,
                    'monto_total_notas_ventas' => $monto_total_notas_ventas,
                    'monto_total_general' => $monto_total_general,
                    'utilidad_neta' => $utilidad_neta,
                ],
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'message' => 'error al buscar los datos',
                'error' => $th->getMessage(),
                'success' => false,
                'data' => '',
            ]);
        }
    }

    
}


