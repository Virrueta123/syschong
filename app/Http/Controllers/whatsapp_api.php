<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class whatsapp_api extends Controller
{
    public $nombre_cliente;
    public $celular_cliente;
    public $saludo;
    public $numero_cotizacion;
    public $link_pdf;
    public $link_aprobacion;

    public function sendMessage()
    {
        $client = new Client();

        $url = 'https://graph.facebook.com/v17.0/' . app('empresa')->codigo_telefono() . '/messages';

        $headers = [
            'Authorization' => 'Bearer ' . app('empresa')->token_whatsapps_api(),
            'Content-Type' => 'application/json',
        ];

        $data = [
            'messaging_product' => 'whatsapp',
            'to' => "51{$this->celular_cliente}",
            'type' => 'template',
            'template' => [
                'name' => 'send_coti',
                'language' => [
                    'code' => 'es_ES',
                    'policy' => 'deterministic',
                ],
                'components' => [
                    [
                        'type' => 'header',
                        'parameters' => [
                            [
                                'type' => 'DOCUMENT',
                                'document' => [
                                    'link' => $this->link_pdf,
                                ],
                            ],
                        ],
                    ],

                    [
                        'type' => 'body',
                        'parameters' => [
                            [
                                'type' => 'text',
                                'text' => $this->numero_cotizacion,
                            ],
                            [
                                'type' => 'text',
                                'text' => $this->nombre_cliente,
                            ],
                            [
                                'type' => 'text',
                                'text' => $this->saludo,
                            ],
                        ],
                    ],
                    [
                        'type' => 'button',
                        'sub_type' => 'url',
                        'index' => '0',
                        'parameters' => [
                            [
                                'type' => 'text',
                                'text' => $this->link_aprobacion,
                            ],
                        ],
                    ],
                ],
            ],
        ];

        try {
            $response = $client->post($url, [
                'headers' => $headers,
                'json' => $data,
            ]);

            $statusCode = $response->getStatusCode();
            $responseBody = $response->getBody();

            // Puedes manejar la respuesta aquí
            return response()->json(['statusCode' => $statusCode, 'response' => json_decode($responseBody)]);
        } catch (\Exception $e) {
            // Maneja cualquier error aquí
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request)
    {
        try {
            $verifyToken = "1321658136546965426935dsadsads";
            $query = $request->query();

            $mode = $query['hub.mode'];
            $token = $query['hub.verify_token'];
            $challenge = $query['hub.challenge'];

            if($mode && $token){
                if($mode == "subscribe" && $token == $verifyToken){
                    return response($challenge,200)->header('Content-Type','text/plain');
                } 
            }

            throw new Exception("invalid request");
            
            //code...
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
}
