<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Products\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads = Ad::with("product.category.parent", "sub_category.parent")->orderBy("order")->get();

        // $ads->each->setAppends([]);

        return $this->jsonResponse("Success", $ads);
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
        $validator = Validator::make($request->all(), Ad::$validations);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        $data = $validator->valid();
        $ad = Ad::create($data);
        $ad->refresh();
        Cache::forget('ads');
        return $this->jsonResponse("Success", $ad);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ad = Ad::findOrFail($id);

        return $this->jsonResponse("Success", $ad);
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
        $ad = Ad::findOrFail($id);
        // validate request
        $validator = Validator::make($request->all(), Ad::$validations);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        $data = $validator->valid();
        $ad->update($data);
        Cache::forget('ads');
        return $this->jsonResponse("Success", $ad);
    }

    public function activate($id)
    {
        $ad = Ad::findOrFail($id);

        $ad->active = 1;
        $ad->deactivation_notes = null;
        $ad->save();
        Cache::forget('ads');
        return $this->jsonResponse("Success");
    }

    public function deactivate(Request $request, $id)
    {
        // validate request
        $validator = Validator::make($request->all(), ["deactivation_notes" => "required"]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }

        $ad = Ad::findOrFail($id);

        $ad->active = 0;
        $ad->deactivation_notes = $request->deactivation_notes;
        $ad->save();
        Cache::forget('ads');
        return $this->jsonResponse("Success");
    }
    public function destroy($id)
    {
        $ad = Ad::findOrFail($id);

        $ad->delete();
        return $this->jsonResponse("Success");
    }
}
