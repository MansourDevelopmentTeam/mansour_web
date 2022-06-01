<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AreaResource;
use App\Models\Locations\Area;
use App\Models\Locations\City;
use App\Models\Locations\District;
use App\Models\Shipping\DeliveryFees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AreasController extends Controller
{
    public function index(Request $request, $city_id)
    {
        $tableSortCols = ['created_at'];
        $limit = abs(intval($request->limit));
        $sortCol = $request->header('lang') == 2 ? 'name_ar' : 'name';
        $sortDir = in_array($request->sort_dir, ['desc']) ? $request->sort_dir : 'asc';
        
        if (in_array($request->sort_col, $tableSortCols)) {
            $sortCol = $request->sort_col;
        }
        
        $areas = Area::with("city", "districts")->where("city_id", $city_id);
        
        if ($request->q) {
            $areas = $areas->where('name', 'LIKE', "%{$request->q}%")
                ->orWhere('name_ar', 'LIKE', "%{$request->q}%");
        }

        $areas = $areas->orderBy($sortCol, $sortDir);

        if ($limit) {
            $areas = $areas->paginate($limit);
        } else {
            $areas = $areas->get();
        }
        return $this->jsonResourceResponse("Success", AreaResource::collection($areas));
    }

    public function store(Request $request, $city_id)
    {
        // validate request
        $this->validate($request, [
            "name" => "required",
            "name_ar" => "required",
            "delivery_fees" => "sometimes|nullable",
            "fees_type" => "required|in:1,2",
        ], ["name.unique" => "An area already exist with the same name"]);

        $city = City::findOrFail($city_id);
 
        $requestData = [
            "name" => $request->name,
            "aramex_area_name" => $request->aramex_area_name,
            "name_ar" => $request->name_ar,
            "city_id" => $request->city_id,
            "active" => 1,
            "delivery_fees_type" => $request->fees_type,
            "delivery_fees" => $request->fees_type === 1 ? $request->delivery_fees : 0,
        ];

        $area = $city->areas()->create($requestData);
        $area->refresh();

        if($request->fees_type == 2) {
            DeliveryFees::setFees('area', $area->id, $request->delivery_fees, $request);
        }

        $area->fees_type = $area->delivery_fees_type;
        $area->fees_range = DeliveryFees::getFeesData('area', $area->id);

        return $this->jsonResponse("Success", $area->load("city", "districts"));
    }

    public function show($city_id, $id)
    {
        $area = Area::findOrFail($id);

        $area->fees_type = $area->delivery_fees_type;
        $area->fees_range = DeliveryFees::getFeesData('area', $area->id);
        
        return $this->jsonResponse("Success", $area->load("city", "districts"));
    }

    public function update(Request $request, $city_id, $id)
    {
        $area = Area::findOrFail($id);

        // validate request
        $this->validate($request, [
            "name" => "required",
            "name_ar" => "required",
            "fees_type" => "required|in:1,2",
        ], ["name.unique" => "An area already exist with the same name"]);

        $requestData = [
            "name" => $request->name,
            "name_ar" => $request->name_ar,
            "aramex_area_name" => $request->aramex_area_name,
            "delivery_fees_type" => $request->fees_type,
            "delivery_fees" => $request->fees_type === 1 ? $request->delivery_fees : 0,
        ];

        $area->update($requestData);

        DeliveryFees::setFees('area', $area->id, $request->delivery_fees, $request);

        $area->fees_type = $area->delivery_fees_type;
        $area->fees_range = DeliveryFees::getFeesData('area', $area->id);

        return $this->jsonResponse("Success", $area->load("city", "districts"));
    }

    public function activate($city_id, $id)
    {
        $area = Area::findOrFail($id);

        $area->active = 1;
        $area->deactivation_notes = null;
        $area->save();

        return $this->jsonResponse("Success");
    }

    public function deactivate(Request $request, $city_id, $id)
    {
        // validate request
        $this->validate($request, ["deactivation_notes" => "required"]);

        $area = Area::findOrFail($id);

        $area->active = 0;
        $area->deactivation_notes = $request->deactivation_notes;
        $area->save();

        return $this->jsonResponse("Success");
    }

    public function updateDeliveryFees(Request $request)
    {
        $this->validate($request, [
            "area_ids" => "required|array",
            "delivery_fees" => "required"
        ]);

        Area::whereIn("id", $request->area_ids)->update(["delivery_fees" => $request->delivery_fees]);

        if ($request->cascade) {
            District::whereIn("area_id", $request->area_ids)->update(["delivery_fees" => $request->delivery_fees]);
        }

        return $this->jsonResponse("Success");
    }

    public function destroy($id)
    {
        $area = Area::findOrFail($id);

        $area->delete();

        return $this->jsonResponse("Success");
    }
}
