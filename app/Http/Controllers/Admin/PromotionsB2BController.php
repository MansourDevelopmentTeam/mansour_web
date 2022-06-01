<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PromotionB2BRequest;
use App\Models\Payment\Promotion\Promotion;
use App\Models\Payment\Promotion\PromotionConditions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PromotionsB2BController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private $Model = Promotion::class;

    public function index()
    {
        $promotions = $this->Model::where('category', Promotion::B2B_CATEGORY)
            ->orderBy("created_at", "DESC")->get();

        return $this->jsonResponse("Success", $promotions->load('conditions', 'segments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PromotionB2BRequest $request)
    {
        $request->merge(['category' => Promotion::B2B_CATEGORY]);

        $promotion = $this->Model::firstOrCreate($request->only([
            'name',
            'name_ar',
            "active",
            'type',
            'priority',
//            'times',
            "start_date",
            "expiration_date",
            'category',
            "periodic",
            'instant',
            'incentive_id',
            'description',
            'description_ar'
        ]));

        if (isset($request->conditions)) {
            foreach ($request->conditions as $condition) {
                $promotion->conditions()->firstOrCreate($condition);
            }
        }

        if (isset($request->segments)) {
            foreach ($request->segments as $segment) {
                $promotion->segments()->firstOrCreate($segment);
            }
        }

        $promotion->refresh();

        return $this->jsonResponse("Success", $promotion->load("segments", "conditions"));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $promotion = $this->Model::with("segments", "conditions")
            ->where('category', Promotion::B2B_CATEGORY)->findOrFail($id);

        return $this->jsonResponse("Success", $promotion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PromotionB2BRequest $request, $id)
    {
        $promotion = $this->Model::with("segments", "conditions")
            ->where('category', Promotion::B2B_CATEGORY)
            ->findOrFail($id);

        $promotion->update($request->only([
            'name',
            'name_ar',
            "active",
            'type',
            'priority',
            'times',
            "start_date",
            "expiration_date",
            "periodic",
            'instant',
            'incentive_id',
            'description',
            'description_ar'
        ]));

        if (isset($request->segments)) {
            $promotion->segments()->delete();

            foreach ($request->segments as $segment) {
                $promotion->segments()->firstOrCreate($segment);
            }
        }

        if (isset($request->conditions)) {
            $promotion->conditions()->delete();

            foreach ($request->conditions as $condition) {
                $promotion->conditions()->firstOrCreate($condition);
            }
        }

        $promotion->refresh();

        return $this->jsonResponse("Success", $promotion);
    }

    public function activate($id)
    {
        $promotion = $this->Model::where('category', Promotion::B2B_CATEGORY)->findOrFail($id);

        $promotion->active = 1;
        $promotion->deactivation_notes = null;
        $promotion->save();

        return $this->jsonResponse("Success");
    }

    public function deactivate(Request $request, $id)
    {
        // validate request
        $this->validate($request, ["deactivation_notes" => "required"]);

        $promotion = $this->Model::where('category', Promotion::B2B_CATEGORY)->findOrFail($id);

        $promotion->active = 0;
        $promotion->deactivation_notes = $request->deactivation_notes;
        $promotion->save();

        return $this->jsonResponse("Success");
    }

    public function destroy($id)
    {
        $this->Model::where('category', Promotion::B2B_CATEGORY)->findOrFail($id)->delete();

        return $this->jsonResponse("Success");
    }
}
