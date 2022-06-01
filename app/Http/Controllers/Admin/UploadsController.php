<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Facades\App\Models\Services\UploadService;
use Illuminate\Http\Request;

class UploadsController extends Controller
{

    public function upload(Request $request)
    {
        $data = UploadService::upload($request);
        return $this->jsonResponse("Success", $data);
    }

    public function uploadCkEditor(Request $request)
    {
        $data = UploadService::upload($request);
        return ['imageUrl' => $data['filePath']];
    }

    public function uploadFiles(Request $request)
    {
        $files = UploadService::uploadFiles($request);
        return $this->jsonResponse("Success", $files);
    }

    public function getUploads(Request $request)
    {
        $paginated = UploadService::getUploads($request);
        return $this->jsonResponse("Success", $paginated);
    }
}
