<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class whatsapp_api extends Controller
{
    public $nombre_cliente;
    public $saludo;
    public $numero_cotizacion;
    public $link_pdf;
    public $link_aprobacion;

    public function sendMessage()
    {
        $client = new Client();

        $url = 'https://graph.facebook.com/v17.0/139753709218160/messages';

        $headers = [
            'Authorization' => 'Bearer ' . app('empresa')->token_whatsapps_api(),
            'Content-Type' => 'application/json',
        ];

        $data = [
            'messaging_product' => 'whatsapp',
            'to' => '51900968831',
            'type' => 'template',
            'template' => [
                'name' => 'send_cotizacion',
                'language' => [
                    'code' => 'es_ES',
                    "policy"=>"deterministic"
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
                    ] ,
                    [
                        'type' => 'button',
                        'sub_type'=> 'url',
                        "index" => "0",
                        'parameters' => [
                            [
                                'type' => 'text',
                                'text' => $this->link_aprobacion,
                            ],
                        ],
                    ]     
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
