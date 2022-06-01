<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Loyality\Reward;
use App\Models\Loyality\UserRedeem;
use App\Http\Controllers\Controller;

class RewardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rewards = Reward::orderBy("created_at", "DESC")->get();

        return $this->jsonResponse("Success", $rewards);
    }

    public function getGiftRequests()
    {
        $requests = UserRedeem::whereHas("reward", function ($q) {
            $q->where("type", 2);
        })->orderBy("created_at", "DESC")->get();

        return $this->jsonResponse("Success", $requests->load("reward", "user"));
    }

    public function changeGiftRequestStatus(Request $request, $id)
    {
        $giftRequest = UserRedeem::findOrFail($id);

        $giftRequest->status = $request->status;
        $giftRequest->save();

        return $this->jsonResponse("Success");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "name" => "required",
            "name_ar" => "required",
            "description" => "required",
            "description_ar" => "required",
            "type" => "required|in:1,2",
            "image" => "required_if:type,2",
            "amount_type" => "required_if:type,1",
            "amount" => "required_if:type,1",
            "max_amount" => "required_if:amount_type,2",
            "point_cost" => "required",
        ]);
        is_null($request->is_gold) ? $request->merge(['is_gold'=>0]) : '';
        $reward = Reward::create($request->all());
        $reward->refresh();

        return $this->jsonResponse("Success", $reward);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reward = Reward::findOrFail($id);

        return $this->jsonResponse("Success", $reward);
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
        $reward = Reward::findOrFail($id);

        $this->validate($request, [
            "name" => "required",
            "name_ar" => "required",
            "description" => "required",
            "description_ar" => "required",
            "type" => "required|in:1,2",
            "image" => "required_if:type,2",
            "amount_type" => "required_if:type,1",
            "amount" => "required_if:type,1",
            "max_amount" => "required_if:amount_type,2",
            "point_cost" => "required",
        ]);

        $reward->update($request->all());
        $reward->refresh();
        
        return $this->jsonResponse("Success", $reward);
    }

    public function activate($id)
    {
        $reward = Reward::findOrFail($id);

        $reward->active = 1;
        $reward->deactivation_notes = null;
        $reward->save();

        return $this->jsonResponse("Success");
    }

    public function deactivate(Request $request, $id)
    {
        // validate request
        $this->validate($request, ["deactivation_notes" => "required"]);

        $reward = Reward::findOrFail($id);

        $reward->active = 0;
        $reward->deactivation_notes = $request->deactivation_notes;
        $reward->save();

        return $this->jsonResponse("Success");
    }
}
