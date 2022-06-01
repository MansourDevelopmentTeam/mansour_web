<?php

namespace App\Http\Controllers\Admin;

use App\Sheets\Export\Brands\BrandsExport;
use App\Sheets\Import\Brands\BrandsImport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Products\Brand;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class BrandsController extends Controller
{

    public function index()
    {
        return $this->jsonResponse("Success", Brand::all());
    }

    public function show($id)
    {
        $brand = Brand::find($id);
        return $this->jsonResponse("Success", $brand);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "name_ar" => "required",
            "image" => "required",
            "status" => 'sometimes|nullable'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        $data = $validator->valid();
        $brand = Brand::create($data);
        Cache::forget('brands');
        return $this->jsonResponse("Success", $brand);
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $validator = Validator::make($request->all(), [
            "name" => "required",
            "name_ar" => "required",
            "image" => "required",
            "status" => 'sometimes|nullable'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        $data = $validator->valid();
        $brand->update($data);
        Cache::forget('brands');
        return $this->jsonResponse("Success", $brand);
    }

    /**
     * Import brands api
     *
     * @deprecated v1.0.0
     *
     * @param Request $request
     * @return void
     */

    public function import(Request $request)
    {
        $this->validate($request, ["file" => "required"]);
        try {
            $file = $request->file('file');
            $fileName = "Brands_" . date("Y_m_d H_i_s") . '.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('public/imports/brands', $fileName);
            $pathUrl = Str::replaceFirst('public/', 'storage/', $path);
            Log::channel('imports')->info('Action: import brands, File link: ' . url($pathUrl) . ' Admin name: ' . auth()->user()->name . ' Date: ' . now());
            Excel::import(new BrandsImport(), $path);
        } catch(\Exception $e) {
            Log::error("Import File Error: " . $e->getMessage());
            return $this->errorResponse($e->getMessage(), "Invalid data", [], 422);
        }
        // return response
        return $this->jsonResponse("Success");
    }
    public function export()
    {
        return  Excel::download( new BrandsExport() , 'Brands_' . date("Ymd").'.xlsx');
    }
}
