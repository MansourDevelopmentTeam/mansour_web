<?php

namespace App\Http\Controllers\Admin;

use App\Models\Products\Ad;
use App\Models\Products\CustomAd;
use App\Models\Transformers\CustomAdsTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
class CustomAdsController extends Controller
{
    private $adsTransformer;

    public function __construct(CustomAdsTransformer $adsTransformer)
    {
        $this->adsTransformer = $adsTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads = CustomAd::get();
        return $this->jsonResponse("Success", $this->adsTransformer->transformCollection($ads));
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
        $validator = Validator::make($request->all(), CustomAd::$validations);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        $data = $validator->valid();
        $ad = CustomAd::create($data);
        Cache::forget('customAd');
        return $this->jsonResponse("Success", $this->adsTransformer->transform($ad));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ad = CustomAd::findOrFail($id);

        return $this->jsonResponse("Success",  $this->adsTransformer->transform($ad));
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
        $ad = CustomAd::findOrFail($id);
        if (!$ad){
            $message = 'ad Not Found';
            return $this->errorResponse($message, "Invalid data", 422);
        }

        // validate request
        $validator = Validator::make($request->all(), CustomAd::$validations);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        $data = $validator->valid();
        $ad->update($data);
        Cache::forget('customAd');
        return $this->jsonResponse("Success",  $this->adsTransformer->transform($ad));
    }

    public function activate($id)
    {
        $ad = CustomAd::findOrFail($id);
        $ad->active = 1;
        $ad->deactivation_notes = null;
        $ad->save();
        Cache::forget('customAd');
        return $this->jsonResponse("Success");
    }

    public function deactivate(Request $request, $id)
    {
        // validate request
        $validator = Validator::make($request->all(), ["deactivation_notes" => "required"]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }

        $ad = CustomAd::findOrFail($id);

        $ad->active = 0;
        $ad->deactivation_notes = $request->deactivation_notes;
        $ad->save();
        Cache::forget('customAd');

        return $this->jsonResponse("Success");
    }
}
