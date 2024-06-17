<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ImgBBService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.imgbb.api_key');
    }

    public function upload($image)
    {
        $response = Http::asForm()->post('https://api.imgbb.com/1/upload', [
            'key' => $this->apiKey,
            'image' => base64_encode(file_get_contents($image)),
        ]);

        if ($response->successful()) {
            return $response->json()['data']['url'];
        }

        return null;
    }
}
