<?php

namespace App\Http\Controllers\Customer;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Facades\App\Models\Services\UploadService;

class UploadsController extends Controller
{

    public function upload(Request $request)
    {
        try {
            $data = UploadService::upload($request);

            return $this->jsonResponse("Success", $data);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), "Invalid data");
        }
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
