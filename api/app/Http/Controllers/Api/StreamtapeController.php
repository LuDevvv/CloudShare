<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\StreamtapeService;
use Illuminate\Http\Request;

class StreamtapeController extends Controller
{
    protected $streamtapeService;

    public function __construct(StreamtapeService $streamtapeService)
    {
        $this->streamtapeService = $streamtapeService;
    }

    public function upload(Request $request)
    {
        $url = $request->input('url');
        $result = $this->streamtapeService->uploadVideo($url);

        return response()->json($result);
    }
}