<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DoodstreamService
{
    protected $apiUrl = 'https://doodstream.com/api/';

    public function uploadByUrl($url)
    {
        // Obtén la clave de API desde el archivo .env
        $apiKey = env('DOODSTREAM_API_KEY');

        if (!$apiKey) {
            throw new \Exception('API key not set');
        }

        // Realiza la solicitud a la API de Doodstream
        $response = Http::post($this->apiUrl . 'upload/url', [
            'url' => $url,
            'api_key' => $apiKey
        ]);

        // Verifica si la respuesta es exitosa
        if ($response->successful()) {
            $data = $response->json();

            // Verifica si el array tiene la clave 'result'
            if (isset($data['result'])) {
                return $data['result'];
            } else {
                // Maneja el caso donde la clave 'result' no está presente
                throw new \Exception('Invalid response format: ' . json_encode($data));
            }
        } else {
            // Maneja el caso donde la solicitud falla
            throw new \Exception('Failed to upload URL: ' . $response->body());
        }
    }

    public function getVideoUrl($fileCode)
    {
        return 'https://doodstream.com/e/' . $fileCode;
    }
}
