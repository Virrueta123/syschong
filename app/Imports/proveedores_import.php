<?php

namespace App\Imports;

use App\Http\Controllers\servicesController;
use App\Models\proveedores;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;

class proveedores_import implements ToCollection
{
    public function collection(Collection $rows)
    {
        try {
            DB::beginTransaction();
            $contador = 0;
            foreach ($rows as $row => $valores) {
                if ($row != 0) {
                    $proveedor = new proveedores();
                    $proveedor->proveedor_dni = $valores[0] == 'D.N.I' ? $valores[1] : 'no tiene'; // Replace with the desired DNI value
                    $proveedor->proveedor_nombre = $valores[0] == 'D.N.I' ? $valores[2] : 'no tiene'; // Replace with other field values
                    $proveedor->proveedor_nombre_comercial = is_null($valores[3]) ? 'no tiene' : $valores[3];
                    $proveedor->proveedor_razon_social = $valores[0] == 'R.U.C' ? $valores[2] : 'no tiene';
                    $proveedor->proveedor_ruc = $valores[0] == 'R.U.C' ? $valores[1] : 'no tiene';
                    $proveedor->proveedor_contacto1 = is_null($valores[5]) ? 'no tiene' : $valores[5];
                    $proveedor->proveedor_contacto2 = is_null($valores[6]) ? 'no tiene' : $valores[6];
                    $proveedor->proveedor_direccion = is_null($valores[4]) ? 'no tiene' : $valores[4];
                    $proveedor->proveedor_departamento = 'no tiene';
                    $proveedor->proveedor_provincia = 'no tiene';
                    $proveedor->proveedor_distrito = 'no tiene';
                    $proveedor->proveedor_email = is_null($valores[7]) ? 'no tiene' : $valores[7];
                    $proveedor->user_id = 1; // Replace with the user_id value

                    

                    // Save the new Proveedor record to the database
                    //$proveedor = proveedores::create($proveedor->toArray());

                    $proveedores = proveedores::create([
                        'proveedor_dni' => $proveedor->proveedor_dni, // Reemplaza con el valor de D.N.I. deseado
                        'proveedor_nombre' => $proveedor->proveedor_nombre, // Reemplaza con otros valores de campos
                        'proveedor_nombre_comercial' => $proveedor->proveedor_nombre_comercial,
                        'proveedor_razon_social' => $proveedor->proveedor_razon_social,
                        'proveedor_ruc' => $proveedor->proveedor_ruc,
                        'proveedor_contacto1' => $proveedor->proveedor_contacto1,
                        'proveedor_contacto2' => $proveedor->proveedor_contacto2,
                        'proveedor_direccion' => $proveedor->proveedor_direccion,
                        'proveedor_departamento' => $proveedor->proveedor_departamento,
                        'proveedor_provincia' => $proveedor->proveedor_provincia,
                        'proveedor_distrito' => $proveedor->proveedor_distrito,
                        'proveedor_email' => $proveedor->proveedor_email,
                        'user_id' => 1, // Reemplaza con el user_id deseado
                    ]);

                    if ($proveedores) {
                        $contador++;
                    }
                }
            }
            DB::commit();
             
            return response()->json([
                'message' => 'se importo correctamente los datos del archivo excel',
                'error' => '',
                'success' => true,
                'data' => $contador,
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                'message' => 'error al importar verifique los datos en el archivo excel',
                'error' => $th,
                'success' => false,
                'data' => '',
            ]);
        }
    }
}
