<?php

namespace App\Imports;

use App\Models\categoria_producto;
use App\Models\marca_producto;
use App\Models\producto;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductoImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        try {
            foreach ($rows as $row => $valores) {
                if ($row != 0) {
                    if ($valores[2] != 'SERVICIOS') {
                        $marca = marca_producto::where('marca_prod_nombre', $valores[3])->first();

                        if (!$marca) {
                            $marca_producto = new marca_producto();
                            $marca_producto->marca_prod_nombre = $valores[3];
                            $marca_producto->save();
                            $valor_marca = $marca_producto->marca_prod_id;
                        } else {
                            $valor_marca = $marca->marca_prod_id;
                        }

                        $categoria = categoria_producto::where('categoria_nombre', $valores[2])->first();

                        if (!$categoria) {
                            $categoria_producto = new categoria_producto();
                            $categoria_producto->categoria_nombre = $valores[2];
                            $categoria_producto->save();
                            $valor_categoria = $categoria_producto->categoria_id;
                        } else {
                            $valor_categoria = $categoria->categoria_id;
                        }
                        if (is_null($valores[1])) {
                            
                            do {
                                
                                $codigo = rand(1000000000,999999999);  
                       
                            } while (self::existeCodigoEnLaBaseDeDatos($valores[1]));
                            
                        } else {
                            $codigo = $valores[1];
                        }
 
                        $productos = producto::create([
                            'prod_nombre' => $valores[0],
                            'prod_codigo' =>  $codigo,
                            'categoria_id' => $valor_categoria,
                            'marca_id' => $valor_marca,
                            'prod_precio_venta' => $valores[4],
                            'prod_stock_inicial' => $valores[7],
                            'unidades_id' => 1,
                            'zona_id' => 1,
                        ]);
                         
                    }
                }
            }

            return response()->json([
                'message' => 'se importo correctamente los datos del archivo excel',
                'error' => '',
                'success' => true,
                'data' => '',
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'message' => 'error al importar verifique los datos en el archivo excel',
                'error' => $th,
                'success' => false,
                'data' => '',
            ]);
        }
    }

    function existeCodigoEnLaBaseDeDatos($codigo){
        $producto = producto::where('prod_codigo', $codigo)->first();
 
        if($producto){
            return true;
        }else{
            return false;
        }
    }

}
