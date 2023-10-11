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
                            $cod_marca = substr(str_replace(' ', '', $valores[3]), 0, 3);
                        } else {
                            $valor_marca = $marca->marca_prod_id;
                            $cod_marca = substr(str_replace(' ', '',$marca->marca_prod_nombre), 0, 3);
                        }

                        $categoria = categoria_producto::where('categoria_nombre', $valores[2])->first();

                        if (!$categoria) {
                            $categoria_producto = new categoria_producto();
                            $categoria_producto->categoria_nombre = $valores[2];
                            $categoria_producto->save();
                            $valor_categoria = $categoria_producto->categoria_id;
                            $cod_categoria = substr(str_replace(' ', '',$valores[2]), 0, 3);
                        } else {
                            $valor_categoria = $categoria->categoria_id;
                            $cod_categoria = substr(str_replace(' ', '',$categoria->categoria_nombre), 0, 3);
                        }
                        
                        if (is_null($valores[1]) == true || $valores[1] == "") {

                            $codigo = substr(str_replace(' ', '',$valores[0]), 0, 3) . '' . $cod_marca . '' . $cod_categoria;
                           
                        } else {
                            
                            $codigo = $valores[1];
                            
                        } 
                        $productos = producto::create([
                            'prod_nombre' => $valores[0],
                            'prod_codigo' => $codigo,
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

    function existeCodigoEnLaBaseDeDatos($codigo)
    {
        $producto = producto::where('prod_codigo', $codigo)->first();

        if ($producto) {
            return true;
        } else {
            return false;
        }
    }
}
