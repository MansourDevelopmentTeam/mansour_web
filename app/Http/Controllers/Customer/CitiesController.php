<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Customer\CityResource;
use App\Mail\NewRegistration;
use App\Mail\ResetPassword;
use App\Models\Locations\Area;
use App\Models\Locations\City;
use App\Models\Locations\District;
use App\Models\Repositories\SocialRepository;
use App\Models\Transformers\CustomerTransformer;
use App\Models\Users\ContactUs;
use App\Models\Users\PasswordReset;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Newsletter\NewsletterFacade;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class CitiesController extends Controller
{

    public function index(Request $request)
    {
        $cities = City::where('active',1)
                ->with(["areas" => function ($q) {
                    $q->with(['districts' => function ($q) {
                        $q->where('active', 1)
                            ->orderBy((request()->header("lang") == 2 ? "name_ar" : "name"), "ASC");
                    }]);
                    if (config('constants.delivery_method') == 'aramex') {
                        $q->where(function ($query){
                            $query->whereNotNull('aramex_area_name')
                                ->where('aramex_area_name', '!=', ' ');
                        });
                    }
                    $q->where('active', 1)->orderBy((request()->header("lang") == 2 ? "name_ar" : "name"), "ASC");
                }])->whereHas('areas', function($q){
                    $q->where('active', 1);
                });
        if ($request->header("lang") == 2) {
            $cities->orderBy("name_ar", "ASC");
        } else {
            $cities->orderBy("name", "ASC");
        }

        $cities = $cities->get();

        return $this->jsonResponse("Success", CityResource::collection($cities));
    }

    public function getCities()
    {
        return $this->jsonResponse("Success", City::orderBy("name", "ASC")->get(["id", "name"]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate request
        $this->validate($request, [
            "name" => "required",
            "name_ar" => "required",
            "delivery_fees" => "required"
        ]);

        $request->merge(["active" => 1]);
        $city = City::create($request->only(["name", "name_ar", "city_id", "delivery_fees", "active"]));
        $city->refresh();

        return $this->jsonResponse("Success", $city->load("areas"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $city = City::findOrFail($id);

        return $this->jsonResponse("Success", $city->load("areas"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);

        // validate request
        $this->validate($request, [
            "name" => "required",
            "name_ar" => "required",
            "delivery_fees" =>  "required"
        ]);

        $city->update($request->only(["name", "name_ar", "delivery_fees"]));

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
            Excel::load($request->file, function ($reader) {

                $results = $reader->all();

                foreach ($results as $key => $record) {

                    $city = City::firstOrCreate(["name" => $record->city_name], ["name_ar" => $record->city_name_ar, "delivery_fees" => $record->city_fees]);

                    if ($record->area_name) {
                        $area = Area::firstOrCreate(["city_id" => $city->id, "name" => $record->area_name], ["name_ar" => $record->area_name_ar, "delivery_fees" => $record->area_fees, "city_id" => $city->id]);

                        if ($record->district_name) {
                            $district = District::firstOrCreate(["name" => $record->district_name], ["name_ar" => $record->district_name_ar, "delivery_fees" => $record->district_fees, "area_id" => $area->id]);
                        }
                    }
                }
            });
        } catch (\Exception $e) {
            Log::error("ImportFactory File Error: " . $e->getMessage());
            return $this->errorResponse($e->getMessage(), "Invalid data", [], 422);
        }


        // return response
        return $this->jsonResponse("Success");
    }
}
