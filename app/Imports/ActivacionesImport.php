<?php

namespace App\Imports;

use App\Http\Controllers\servicesController;
use App\Models\activacion_precio;
use App\Models\activaciones;
use App\Models\cliente;
use App\Models\cortesias_activacion;
use App\Models\marca;
use App\Models\modelo;
use App\Models\motos;
use App\Models\tiendas;
use App\Models\vendedor;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ActivacionesImport implements ToCollection
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row => $valores) {
            if ($row != 0 && $row != 1) {
                /* ******** buscando tienda si encuentra seleciona si no crea tienda ************* */
                if (!is_null($valores[7])) {
                    if (is_null($valores[2])) {
                        $valor_tienda = 1;
                        if (is_null($valores[5])) {
                            $valor_modelo = 1;
                        } else {
                            /* ******** crear modelo si exite ************* */

                            $modelo = modelo::where('modelo_nombre', $valores[5])->first();

                            if (!$modelo) {
                                $marca = marca::where('marca_nombre', $valores[3])->first();

                                $create_modelo = new modelo();
                                $create_modelo->marca_id = $marca->marca_id;
                                $create_modelo->tipo_vehiculo_id = 1;
                                $create_modelo->modelo_nombre = $valores[5];
                                $create_modelo->save();
                                $valor_modelo = $create_modelo->modelo_id;
                            } else {
                                $valor_modelo = $modelo->modelo_id;
                            }
                        }
                        $is_precio_modelo = activacion_precio::where('modelo_id', $valor_modelo)
                            ->where('tienda_id', $valor_tienda)
                            ->first();

                        if (!$is_precio_modelo) {
                            $activacion_precio = new activacion_precio();
                            $activacion_precio->tienda_id = $valor_tienda;
                            $activacion_precio->modelo_id = $valor_modelo;
                            $activacion_precio->precio_activacion = is_null($valores[8]) ? 30 : $valores[8];
                            $activacion_precio->precio_cortesia = 25;
                            $activacion_precio->save();
                        }
                    } else {
                        $tienda = tiendas::where('tienda_nombre', $valores[2])->first();

                        if (!$tienda) {
                            $tiendas = new tiendas();
                            $tiendas->tienda_nombre = $valores[2];
                            $tiendas->save();
                            $valor_tienda = $tiendas->tienda_id;

                            if (is_null($valores[5])) {
                                $valor_modelo = 1;
                            } else {
                                /* ******** crear modelo si exite ************* */

                                $modelo = modelo::where('modelo_nombre', $valores[5])->first();

                                if (!$modelo) {
                                    $marca = marca::where('marca_nombre', $valores[3])->first();

                                    $create_modelo = new modelo();
                                    $create_modelo->marca_id = $marca->marca_id;
                                    $create_modelo->tipo_vehiculo_id = 1;
                                    $create_modelo->modelo_nombre = $valores[5];
                                    $create_modelo->save();
                                    $valor_modelo = $create_modelo->modelo_id;
                                } else {
                                    $valor_modelo = $modelo->modelo_id;
                                }
                            }
                            $is_precio_modelo = activacion_precio::where('modelo_id', $valor_modelo)
                                ->where('tienda_id', $valor_tienda)
                                ->first();

                            if (!$is_precio_modelo) {
                                $activacion_precio = new activacion_precio();
                                $activacion_precio->tienda_id = $valor_tienda;
                                $activacion_precio->modelo_id = $valor_modelo;
                                $activacion_precio->precio_activacion = is_null($valores[8]) ? 30 : $valores[8];
                                $activacion_precio->precio_cortesia = 25;
                                $activacion_precio->save();
                            }

                            /* *********************** */
                        } else {
                            $valor_tienda = $tienda->tienda_id;

                            /* ******** crear modelo si exite ************* */

                            if (is_null($valores[5])) {
                                $valor_modelo = 1;
                            } else {
                                $modelo = modelo::where('modelo_nombre', $valores[5])->first();

                                if (!$modelo) {
                                    $marca = marca::where('marca_nombre', $valores[3])->first();

                                    $create_modelo = new modelo();
                                    $create_modelo->marca_id = $marca->marca_id;
                                    $create_modelo->tipo_vehiculo_id = 1;
                                    $create_modelo->modelo_nombre = $valores[5];
                                    $create_modelo->save();
                                    $valor_modelo = $create_modelo->modelo_id;
                                } else {
                                    $valor_modelo = $modelo->modelo_id;
                                }
                            }

                            $is_precio_modelo = activacion_precio::where('modelo_id', $valor_modelo)
                                ->where('tienda_id', $valor_tienda)
                                ->first();

                            if (!$is_precio_modelo) {
                                $activacion_precio = new activacion_precio();
                                $activacion_precio->tienda_id = $valor_tienda;
                                $activacion_precio->modelo_id = $valor_modelo;
                                $activacion_precio->precio_activacion = is_null($valores[8]) ? 30 : $valores[8];
                                $activacion_precio->precio_cortesia = 25;
                                $activacion_precio->save();
                            }
                        }
                    }

                    /* *********************** */

                    /* ******** buscando tienda si encuentra seleciona si no crea vendedor check ************* */
                    if (!is_null($valores[4])) {
                        $vendedor = vendedor::where('vendedor_nombres', $valores[4])->first();

                        if (!$vendedor) {
                            $vendedores = new vendedor();
                            $vendedores->vendedor_nombres = $valores[4];
                            $vendedores->save();
                            $valor_vendedor = $vendedores->vendedor_id;
                        } else {
                            $valor_vendedor = $vendedor->vendedor_id;
                        }
                    } else {
                        $valor_vendedor = 1;
                    }

                    /* *********************** */

                    /* ******** buscando tienda si encuentra seleciona si no crea motor ************* */

                    $motos = motos::where('mtx_motor', $valores[7])->first();

                    if (!$motos) {
                        if (!is_null($valores[10])) {
                            if (strlen($valores[10]) > 8) {
                                $cliente = cliente::where('cli_ruc', $valores[10])->first();
                                if (!$cliente) {
                                    $servicesController = new servicesController();
                                    $consulta_ruc = $servicesController->consulta_ruc_view($valores[10]);

                                    try {
                                        if ($consulta_ruc->success == true) {
                                            $crear_cliente = new cliente();
                                            $crear_cliente->cli_ruc = $valores[10];
                                            $crear_cliente->cli_razon_social = $consulta_ruc->data->nombre_o_razon_social;
                                            $crear_cliente->cli_direccion_ruc = $consulta_ruc->data->direccion;
                                            $crear_cliente->cli_provincia_ruc = $consulta_ruc->data->provincia;
                                            $crear_cliente->cli_distrito_ruc = $consulta_ruc->data->distrito;
                                            $crear_cliente->cli_departamento_ruc = $consulta_ruc->data->departamento;
                                            $crear_cliente->cli_telefono = $valores[12];
                                            $crear_cliente->save();
                                            $valor_cliente = $crear_cliente->cli_id;
                                        } else {
                                            $crear_cliente = new cliente();
                                            $crear_cliente->cli_ruc = is_null($valores[10]) ? '88888888' : $valores[10];
                                            $crear_cliente->cli_razon_social = $valores[11];
                                            $crear_cliente->cli_telefono = is_null($valores[12]) ? '999999999' : $valores[12];
                                            $crear_cliente->save();
                                            $valor_cliente = $crear_cliente->cli_id;
                                        }
                                    } catch (\Throwable $th) {
                                        dd($consulta_ruc);
                                    }
                                   
                                } else {
                                    $valor_cliente = $cliente->cli_id;
                                }
                            } else {
                                $cliente = cliente::where('cli_dni', $valores[10])->first();

                                if (!$cliente) {
                                    $servicesController = new servicesController();
                                    $consulta_dni = $servicesController->consulta_dni_view($valores[10]);

                                    try {

                                    if ($consulta_dni->success == true) {
                                        $crear_cliente = new cliente();
                                        $crear_cliente->cli_dni = $valores[10];
                                        $crear_cliente->cli_nombre = $consulta_dni->data->nombres;
                                        $crear_cliente->cli_apellido = $consulta_dni->data->apellido_paterno . ' ' . $consulta_dni->data->apellido_materno;
                                        $crear_cliente->cli_direccion = $consulta_dni->data->direccion;
                                        $crear_cliente->cli_provincia = $consulta_dni->data->provincia;
                                        $crear_cliente->cli_distrito = $consulta_dni->data->distrito;
                                        $crear_cliente->cli_departamento = $consulta_dni->data->departamento;
                                        $crear_cliente->cli_telefono = $valores[12];
                                        $crear_cliente->save();
                                        $valor_cliente = $crear_cliente->cli_id;
                                    } else {
                                        $crear_cliente = new cliente();
                                        $crear_cliente->cli_dni = is_null($valores[10]) ? '88888888' : $valores[10];
                                        $crear_cliente->cli_nombre = $valores[11];
                                        $crear_cliente->cli_telefono = is_null($valores[12]) ? '999999999' : $valores[12];
                                        $crear_cliente->save();
                                        $valor_cliente = $crear_cliente->cli_id;
                                    }
                                } catch (\Throwable $th) {
                                    dd($consulta_dni);
                                }
                                } else {
                                    $valor_cliente = $cliente->cli_id;
                                }
                            }
                        } else {
                            if (is_null($valores[11])) {
                                $valor_cliente = 1;
                            } else {
                                $cliente = cliente::where('cli_nombre', $valores[11])->first();
                                if (!$cliente) {
                                    $crear_cliente = new cliente();
                                    $crear_cliente->cli_dni = $valores[10];
                                    $crear_cliente->cli_nombre = $valores[11];
                                    $crear_cliente->save();
                                    $valor_cliente = $crear_cliente->cli_id;
                                } else {
                                    $valor_cliente = $cliente->cli_id;
                                }
                            }
                        }

                        $create_motos = new motos();
                        $create_motos->mtx_motor = $valores[7];
                        $create_motos->mtx_vin = $valores[6];
                        $create_motos->cli_id = $valor_cliente;
                        $create_motos->tienda_id = $valor_tienda;
                        $create_motos->modelo_id = $valor_modelo;
                        $create_motos->user_id = Auth::id();
                        $create_motos->save();
                        $valor_moto = $create_motos->mtx_id;
                    } else {
                        $valor_moto = $motos->mtx_id;
                    }

                    /* *********************** */

                    $activaciones = new activaciones();

                    $activaciones->tienda_id = $valor_tienda;
                    $activaciones->vendedor_id = $valor_vendedor;
                    $activaciones->moto_id = $valor_moto;
                    $activaciones->precio = is_null($valores[8]) ? 30 : $valores[8];
                    $activaciones->user_id = Auth::id();
                    $activaciones->created_at = is_null($valores[0]) ? Carbon::now() : self::convertir_fecha($valores[0]);
                    $activaciones->save();

                    if (!is_null($valores[15])) {
                        // Crear un nuevo registro
                        $registro = new cortesias_activacion();
                        $registro->activaciones_id = $activaciones->activaciones_id;
                        $registro->km = $valores[16];
                        $registro->user_id = Auth::id();
                        $registro->created_at = is_null($valores[15]) && $valores[15] != '' ? Carbon::now() : self::convertir_fecha($valores[15]);
                        $registro->numero_corterisa = 1;
                        $registro->save();
                    }

                    if (!is_null($valores[18])) {
                        // Crear un nuevo registro
                        $registro = new cortesias_activacion();
                        $registro->activaciones_id = $activaciones->activaciones_id;
                        $registro->km = $valores[19];
                        $registro->user_id = Auth::id();
                        $registro->created_at = is_null($valores[18]) && $valores[18] != '' ? Carbon::now() : self::convertir_fecha($valores[18]);
                        $registro->numero_corterisa = 2;
                        $registro->save();
                    }

                    if (!is_null($valores[21])) {
                        // Crear un nuevo registro
                        $registro = new cortesias_activacion();
                        $registro->activaciones_id = $activaciones->activaciones_id;
                        $registro->km = $valores[22];
                        $registro->user_id = Auth::id();
                        $registro->created_at = is_null($valores[21]) && $valores[21] != '' ? Carbon::now() : self::convertir_fecha($valores[21]);
                        $registro->numero_corterisa = 3;
                        $registro->save();
                    }

                    if (!is_null($valores[24])) {
                        // Crear un nuevo registro
                        $registro = new cortesias_activacion();
                        $registro->activaciones_id = $activaciones->activaciones_id;
                        $registro->km = $valores[25];
                        $registro->user_id = Auth::id();
                        $registro->created_at = is_null($valores[24]) && $valores[24] != '' ? Carbon::now() : self::convertir_fecha($valores[24]);
                        $registro->numero_corterisa = 4;
                        $registro->save();
                    }

                    if (!is_null($valores[27])) {
                        // Crear un nuevo registro
                        $registro = new cortesias_activacion();
                        $registro->activaciones_id = $activaciones->activaciones_id;
                        $registro->km = $valores[28];
                        $registro->user_id = Auth::id();
                        $registro->created_at = is_null($valores[27]) && $valores[27] != '' ? Carbon::now() : self::convertir_fecha($valores[27]);
                        $registro->numero_corterisa = 5;
                        $registro->save();
                    }
                }
            }
        }
    }

    public function convertir_fecha($digito)
    {
        $numero_serie_excel = $digito; // El número de serie de Excel que deseas convertir

        $fechaExcel = Carbon::createFromTimestamp(($numero_serie_excel - 25569) * 86400); // 25569 es el número de serie de Excel para el 1 de enero de 1970

        return $fechaExcel->format('Y-m-d');
    }
}
