<?php

namespace App\Http\Controllers;

use App\Imports\ServiciosImport;
use App\Models\servicios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class servicios_controller extends Controller
{
    public function importar()
    {
        return view('modules.servicios.importar');
    }

    public function importar_servicioss(Request $request)
    {
        Excel::import(new ServiciosImport(), $request->file('file'));
    }
    /* ******** buscando servicios peticion via ajax ************* */

    public function search_servicios(Request $request)
    {
        try {
            $servicios = servicios::select(DB::raw('*')) 
                ->where('servicios_nombre', 'like', '%' . $request->all()['search'] . '%') 
                ->orWhere('servicios_codigo', 'like', '%' . $request->all()['search'] . '%')
                ->limit(7)
                ->get();

            if ($servicios) {
                return response()->json([
                    'message' => 'datos encontrados',
                    'error' => '',
                    'success' => true,
                    'data' => json_encode($servicios),
                ]);
            } else {
                Log::error('error al buscar los datos');
                return response()->json([
                    'message' => 'error al buscar los datos',
                    'error' => '',
                    'success' => false,
                    'data' => '',
                ]);
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'message' => 'error al buscar los datos',
                'error' => $th,
                'success' => false,
                'data' => '',
            ]);
        }
    }
}
