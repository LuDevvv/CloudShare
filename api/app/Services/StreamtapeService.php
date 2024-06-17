<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class StreamtapeService
{
    protected $apiLogin;
    protected $apiKey;

    public function __construct()
    {
        $this->apiLogin = config('services.streamtape.api_login');
        $this->apiKey = config('services.streamtape.api_key');
    }

    public function uploadByUrl($url)
    {

        // return response()->json()->$url;

        try {
            $response = Http::post('https://api.streamtape.com/remotedl/add', [
                'login' => $this->apiLogin,
                'key' => $this->apiKey,
                'url' => $url,
            ]);
    
            // Check if the request was successful (status code 2xx)
            $response->throw();
    
            $jsonResponse = $response->json();
    
            // Check if the response contains the 'result' field and 'url' subfield
            if (!isset($jsonResponse['result']) || !isset($jsonResponse['result']['url'])) {
                throw new Exception("Invalid response from Streamtape: " . json_encode($jsonResponse));
            }
    
            return $jsonResponse['result']['url'];
        } catch (\Throwable $e) {
            // Log the error
            Log::error("Streamtape upload failed - Error", [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
    
            // Throw a general exception
            throw new Exception("Error occurred while uploading to Streamtape: " . $e->getMessage());
        }
    }
    
    public function getVideoUrl($fileCode)
    {
        return "https://streamtape.com/v/$fileCode";
    }
}
