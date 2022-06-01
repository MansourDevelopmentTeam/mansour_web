<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shipping\DeliveryFees;
use App\Sheets\Export\Cities\CitiesExport;
use App\Sheets\Import\Cities\CitiesImport;
use App\Sheets\Import\Cities\CitiesImportV2;
use Illuminate\Http\Request;
use App\Models\Locations\Area;
use App\Models\Locations\City;
use App\Models\Locations\District;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\Admin\CityResource;

class CitiesController extends Controller
{

    public function index(Request $request)
    {
        $tableSortCols = ['created_at'];
        $limit = abs(intval($request->limit));
        $sortCol = $request->header('lang') == 2 ? 'name_ar' : 'name';
        $sortDir = in_array($request->sort_dir, ['desc']) ? $request->sort_dir : 'asc';
        
        if (in_array($request->sort_col, $tableSortCols)) {
            $sortCol = $request->sort_col;
        }
        
        $cities = City::with(["areas" => function ($q) use ($request) {
            $q->orderBy(($request->header("lang") == 2 ? "name_ar" : "name"), "ASC");
        }, "areas.districts" => function ($q) use ($request) {
            $q->orderBy(($request->header("lang") == 2 ? "name_ar" : "name"), "ASC");
        }]);
        
        if ($request->q) {
            $cities = $cities->where('name', 'LIKE', "%{$request->q}%")
                ->orWhere('name_ar', 'LIKE', "%{$request->q}%");
        }

        $cities = $cities->orderBy($sortCol, $sortDir);
        
        if ($limit) {
            $cities = $cities->paginate($limit);
        } else {
            $cities = $cities->get();
        }

        return $this->jsonResourceResponse("Success", CityResource::collection($cities));
    }

    public function getCities()
    {
        return $this->jsonResponse("Success", City::orderBy("name", "ASC")->get(["id", "name"]));
    }

    public function store(Request $request)
    {
        // validate request
        $this->validate($request, [
            "name" => "required",
            "name_ar" => "required",
            "fees_type" => "required|in:1,2",
        ]);

        $requestData = [
            "name" => $request->name,
            "name_ar" => $request->name_ar,
            "active" => 1,
            "delivery_fees_type" => $request->fees_type,
            "delivery_fees" => $request->delivery_fees,
        ];

        $city = City::create($requestData);
        $city->refresh();

        if($request->fees_type == 2) {
            DeliveryFees::setFees('city', $city->id, $request->delivery_fees, $request);
        }

        $city->fees_type = $city->delivery_fees_type;
        $city->fees_range = DeliveryFees::getFeesData('city', $city->id);

        return $this->jsonResponse("Success", $city->load("areas"));
    }

    public function show($id)
    {
        $city = City::findOrFail($id);

        $city->fees_type = $city->delivery_fees_type;
        $city->fees_range = DeliveryFees::getFeesData('city', $city->id);

        return $this->jsonResponse("Success", $city->load("areas"));
    }

    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);

        // validate request
        $this->validate($request, [
            "name" => "required",
            "name_ar" => "required",
            "fees_type" => "required|in:1,2",
        ]);

        $requestData = [
            "name" => $request->name,
            "name_ar" => $request->name_ar,
            "delivery_fees_type" => $request->fees_type,
            "delivery_fees" => $request->fees_type == 1 ? $request->delivery_fees : 0,
        ];

        $city->update($requestData);

        DeliveryFees::setFees('city', $city->id, $request->delivery_fees, $request);

        $city->fees_type = $city->delivery_fees_type;
        $city->fees_range = DeliveryFees::getFeesData('city', $city->id);

        return $this->jsonResponse("Success", $city->load("areas"));
    }

    public function activate($id)
    {
        $city = City::findOrFail($id);

        $city->active = 1;
        $city->deactivation_notes = null;
        $city->save();

        return $this->jsonResponse("Success");
    }

    public function deactivate(Request $request, $id)
    {
        // validate request
        $this->validate($request, ["deactivation_notes" => "required"]);

        $city = City::findOrFail($id);

        $city->active = 0;
        $city->deactivation_notes = $request->deactivation_notes;
        $city->save();

        return $this->jsonResponse("Success");
    }

    public function updateDeliveryFees(Request $request)
    {
        $this->validate($request, [
            "city_ids" => "required|array",
            "delivery_fees" => "required"
        ]);

        City::whereIn("id", $request->city_ids)->update(["delivery_fees" => $request->delivery_fees]);

        if ($request->cascade) {
            $areas = Area::whereIn("city_id", $request->city_ids)->update(["delivery_fees" => $request->delivery_fees]);

            District::whereHas('area', function ($q) use ($request) {
                $q->whereIn('city_id', $request->city_ids);
            })->update(["delivery_fees" => $request->delivery_fees]);
        }

        return $this->jsonResponse("Success");
    }

    public function import(Request $request)
    {
        $this->validate($request, ["file" => "required"]);
        try {
            $file = $request->file('file');
            $fileName = "Cities_" . date("Y_m_d H_i_s") . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/imports/cities', $fileName);
            $history_id = 1;
            Excel::import(new CitiesImportV2($history_id), $path);
        } catch (\Exception $e) {
            Log::error("Import File Error: " . $e->getMessage());
            return $this->errorResponse($e->getMessage(), "Invalid data", [], 422);
        }
        // return response
        return $this->jsonResponse("Success");
    }

    public function export()
    {
        return Excel::download(new CitiesExport(), 'Cities_' . date("Ymd") . '.xlsx');
    }
}
