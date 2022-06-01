<?php

namespace App\Http\Controllers\Admin;

use App\Models\Locations\Area;
use App\Models\Locations\District;
use App\Models\Shipping\DeliveryFees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\DistrictResource;

class DistrictsController extends Controller
{
    public function index(Request $request, $area_id)
    {
        $tableSortCols = ['created_at'];
        $limit = abs(intval($request->limit));
        $sortCol = $request->header('lang') == 2 ? 'name_ar' : 'name';
        $sortDir = in_array($request->sort_dir, ['desc']) ? $request->sort_dir : 'asc';
        
        if (in_array($request->sort_col, $tableSortCols)) {
            $sortCol = $request->sort_col;
        }
        
        $districts = Area::findOrFail($area_id)->districts()->with("area");
        
        if ($request->q) {
            $districts = $districts->where('name', 'LIKE', "%{$request->q}%")
                ->orWhere('name_ar', 'LIKE', "%{$request->q}%");
        }
        
        $districts = $districts->orderBy($sortCol, $sortDir);

        if ($limit) {
            $districts = $districts->paginate($limit);
        } else {
            $districts = $districts->get();
        }

        return $this->jsonResourceResponse("Success", DistrictResource::collection($districts));
    }

    public function store(Request $request, $area_id)
    {
        // validate request
        $this->validate($request, [
            "name" => "required",
            "name_ar" => "required",
            "fees_type" => "required|in:1,2",
        ]);

        $area = Area::findOrFail($area_id);
    
        $requestData = [
            "name" => $request->name,
            "name_ar" => $request->name_ar,
            "area_id" => $request->area_id,
            "active" => 1,
            "delivery_fees_type" => $request->fees_type,
            "delivery_fees" => $request->fees_type === 1 ? $request->delivery_fees : 0,
        ];

        $district = $area->districts()->create($requestData);
        $district->refresh();

        if($request->fees_type == 2) {
            DeliveryFees::setFees('district', $district->id, $request->delivery_fees, $request);
        }
        
        $district->fees_type = $district->delivery_fees_type;
        $district->fees_range = DeliveryFees::getFeesData('district', $district->id);

        return $this->jsonResponse("Success", $district->load("area"));
    }

    public function show($area_id, $id)
    {
        $district = District::findOrFail($id);

        $district->fees_type = $district->delivery_fees_type;
        $district->fees_range = DeliveryFees::getFeesData('district', $district->id);
        
        return $this->jsonResponse("Success", $district->load("area"));
    }

    public function update(Request $request, $area_id, $id)
    {
        $district = District::findOrFail($id);

        // validate request
        $this->validate($request, [
            "name" => "required",
            "fees_type" => "required|in:1,2",
        ]);

        $requestData = [
            "name" => $request->name,
            "name_ar" => $request->name_ar,
            "delivery_fees_type" => $request->fees_type,
            "delivery_fees" => $request->fees_type === 1 ? $request->delivery_fees : 0,
        ];

        $district->update($requestData);

        DeliveryFees::setFees('district', $district->id, $request->delivery_fees, $request);

        $district->fees_type = $district->delivery_fees_type;
        $district->fees_range = DeliveryFees::getFeesData('district', $district->id);

        return $this->jsonResponse("Success", $district->load("area"));
    }

    public function updateDeliveryFees(Request $request)
    {
        $this->validate($request, [
            "district_ids" => "required|array",
            "delivery_fees" => "required"
        ]);

        District::whereIn("id", $request->district_ids)->update(["delivery_fees" => $request->delivery_fees]);

        return $this->jsonResponse("Success");
    }

    public function activate($area_id, $id)
    {
        $district = District::findOrFail($id);

        $district->active = 1;
        $district->deactivation_notes = null;
        $district->save();

        return $this->jsonResponse("Success");
    }

    public function deactivate(Request $request, $area_id, $id)
    {
        // validate request
        $this->validate($request, ["deactivation_notes" => "required"]);

        $district = District::findOrFail($id);

        $district->active = 0;
        $district->deactivation_notes = $request->deactivation_notes;
        $district->save();

        return $this->jsonResponse("Success");
    }
}
