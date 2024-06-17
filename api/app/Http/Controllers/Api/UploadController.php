<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Upload;
use App\Services\DoodstreamService;
use App\Services\StreamtapeService;

class UploadController extends Controller
{
    protected $doodstreamService;
    protected $streamtapeService;

    public function __construct(DoodstreamService $doodstreamService, StreamtapeService $streamtapeService)
    {
        $this->doodstreamService = $doodstreamService;
        $this->streamtapeService = $streamtapeService;
    }

    public function index()
    {
        $uploads = Upload::all();
        return response()->json(['data' => $uploads]);
    }

    public function show($id)
    {
        $upload = Upload::find($id);
        if (!$upload) {
            return response()->json(['error' => 'Upload not found'], 404);
        }
        return response()->json(['data' => $upload]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'url' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $fileUrl = $request->input('url');

        // Here you can implement logic for different upload services based on your requirements
        // For example, using services like DoodstreamService or StreamtapeService

        // Example logic with DoodstreamService
        $fileCode = $this->doodstreamService->uploadByUrl($fileUrl);
        $fileUrl = $this->doodstreamService->getVideoUrl($fileCode);

        // Save the upload record to the database
        $upload = new Upload();
        $upload->title = $request->input('title');
        $upload->file_url = $fileUrl;
        $upload->save();

        return response()->json(['message' => 'Upload created successfully', 'data' => $upload], 201);
    }

    public function update(Request $request, $id)
    {
        $upload = Upload::find($id);
        if (!$upload) {
            return response()->json(['error' => 'Upload not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'file_url' => 'sometimes|string|max:255',
            // Add more validation rules as needed
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->has('file_url')) {
            $upload->file_url = $request->input('file_url');
        }

        // Update other fields if necessary

        $upload->save();

        return response()->json(['message' => 'Upload updated successfully', 'data' => $upload], 200);
    }

    public function destroy($id)
    {
        $upload = Upload::find($id);
        if (!$upload) {
            return response()->json(['error' => 'Upload not found'], 404);
        }

        $upload->delete();
        return response()->json(['message' => 'Upload deleted successfully'], 200);
    }
}
