<?php 
namespace App\Http\Services;
use GuzzleHttp\Client;

class WhatsappServices 
{
    public function sendMessage( )
    {
        $client = new Client();

        $url = 'https://graph.facebook.com/v17.0/139753709218160/messages';

        $headers = [
            'Authorization' => 'Bearer EAAUlLkvngA0BOzZC8HuPsn8yK0uzatZBrVPIg4G2BYXdyt8BLh1JeCtZBCAIkdm3eARt85rmTxuQhZACGY6WUtKgFVdGFZAqr59TYGkPn729vtrZBTdCdFHwRiSSUxPFfapNywohioebyexCUVwBUfXqWvIYVOREnzkZCuKWNn5XTCgXyUSuNeRabgXIOLJVk60zB60L5bbLTBZCgAUD',
            'Content-Type' => 'application/json',
        ];

        $data = [
            'messaging_product' => 'whatsapp',
            'to' => '51900968831',
            'type' => 'template',
            'template' => [
                'name' => 'hello_world',
                'language' => [
                    'code' => 'en_US',
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
}