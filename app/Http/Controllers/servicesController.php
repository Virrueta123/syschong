<?php

namespace App\Http\Controllers;

use App\Models\ubigeo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class servicesController extends Controller
{
    protected $key = 'a5d01a0250c0819ade1a30b51998444db70e10746c7e9c61a12b82d3368cdb72';
    protected function consulta_dni($dni)
    {
        try {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://apiperu.dev/api/dni/{$dni}?api_token={$this->key}",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_SSL_VERIFYPEER => false,
            ]);
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                return response()->json(
                    [
                        'message' => 'error al cargar los datos, porfavor ingrese los datos manualmente',
                        'error' => 'cURL Error #:' . $err,
                        'success' => false,
                        'data' => '',
                    ],
                    500,
                );
            } else {
                echo $response;
            }
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'message' => 'error al cargar los datos, porfavor ingrese los datos manualmente',
                    'error' => 'error Throwable',
                    'success' => false,
                    'data' => '',
                ],
                500,
            );
        }
    }

    protected function consulta_dni_retorno($dni)
    {
        try {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://apiperu.dev/api/dni/{$dni}?api_token={$this->key}",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_SSL_VERIFYPEER => false,
            ]);
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                return response()->json(
                    [
                        'message' => 'error al cargar los datos, porfavor ingrese los datos manualmente',
                        'error' => 'cURL Error #:' . $err,
                        'success' => false,
                        'data' => '',
                    ], 
                );
            } else {
                return json_decode($response);
            }
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'message' => 'error al cargar los datos, porfavor ingrese los datos manualmente',
                    'error' => 'error Throwable',
                    'success' => false,
                    'data' => '',
                ], 
            );
        }
    }
    protected function consulta_ruc($ruc)
    {
        try {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://apiperu.dev/api/ruc/{$ruc}?api_token={$this->key}",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_SSL_VERIFYPEER => false,
            ]);
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                return response()->json(
                    [
                        'message' => 'error al cargar los datos, porfavor ingrese los datos manualmente',
                        'error' => 'cURL Error #:' . $err,
                        'success' => false,
                        'data' => '',
                    ],
                    500,
                );
            } else {
                echo $response;
            }
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'message' => 'error al cargar los datos, porfavor ingrese los datos manualmente',
                    'error' => 'error Throwable',
                    'success' => false,
                    'data' => '',
                ],
                500,
            );
        }
    }

    protected function consulta_ruc_retorno($ruc)
    {
        try {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://apiperu.dev/api/ruc/{$ruc}?api_token={$this->key}",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_SSL_VERIFYPEER => false,
            ]);
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                return response()->json(
                    [
                        'message' => 'error al cargar los datos, porfavor ingrese los datos manualmente',
                        'error' => 'cURL Error #:' . $err,
                        'success' => false,
                        'data' => '',
                    ],
                    500,
                );
            } else {
                return json_decode($response);
            }
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'message' => 'error al cargar los datos, porfavor ingrese los datos manualmente',
                    'error' => 'error Throwable',
                    'success' => false,
                    'data' => '',
                ],
                500,
            );
        }
    }

    public function consulta_dni_view($dni)
    {
        return $this->consulta_dni_retorno($dni);
    }
    public function consulta_ruc_view($dni)
    {
        return $this->consulta_ruc_retorno($dni);
    }
    public function consulta_dni_api(Request $request)
    {
        return $this->consulta_dni($request->all()['dni']);
    }

    public function consulta_ruc_api(Request $request)
    {
        return $this->consulta_ruc($request->all()['ruc']);
    }

    public function ubigeo_search(Request $request){
        $ubigeo = ubigeo::select(DB::raw('ubigeo_id AS id'), DB::raw("CONCAT(Ubigeo,' / ', Departamento,' / ',Provincia,' / ',Distrito) AS name"))
         
            ->where('Ubigeo', 'like', '%' . $request->all()['search'] . '%')
            ->orWhere('Departamento', 'like', '%' . $request->all()['search'] . '%')
            ->orWhere('Provincia', 'like', '%' . $request->all()['search'] . '%')
            ->orWhere('Distrito', 'like', '%' . $request->all()['search'] . '%')
            ->limit(25)
            ->get();

        echo json_encode($ubigeo);
    }
}
