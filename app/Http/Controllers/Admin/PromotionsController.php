<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PromotionRequest;
use App\Models\Payment\Promotion\PromotionConditions;
use App\Models\Payment\Promotion\PromotionTargets;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Payment\Promotion\Promotion;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use phpDocumentor\Reflection\Types\This;

class PromotionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $promotions = Promotion::where('category', Promotion::B2C_CATEGORY)->orderBy("created_at", "DESC")->get();

        return $this->jsonResponse("Success", $promotions->load('conditions', 'targets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PromotionRequest $request)
    {
        $request->merge(['category' => Promotion::B2C_CATEGORY]);

        $promotion = Promotion::firstOrCreate($request->only([
            "name",
            "name_ar",
            "start_date",
            "expiration_date",
            "discount",
            "discount_qty",
            "different_brands",
            "different_categories",
            "different_products",
            "override_discount",
            "priority",
            "times",
            "active",
            "type",
            "gift_ar",
            "gift_en",
            "check_all_conditions",
            "boost",
            "category",
            "exclusive",
            "periodic",
            "group_id",
            'instant',
            'incentive_id',
            'description',
            'description_ar'
        ]));

        if (isset($request->targets)) {
            foreach ($request->targets as $target) {
                $promotion->targets()->create($target);
            }
        }

        if (isset($request->conditions)) {
            foreach ($request->conditions as $condition) {

                if ($condition['item_type'] == PromotionConditions::ITEM_TYPES['products']) {
                    $list = $condition['custom_list'];
                    unset($condition['custom_list']);
                    $condition = $promotion->conditions()->create($condition);

                    foreach ($list as $item) {
                        $condition->customLists()->create([
                            'item_id' => $item
                        ]);
                    }
                } else {
                    unset($condition['custom_list']);
                    $promotion->conditions()->create($condition);
                }
            }
        }

        $promotion->refresh();

        return $this->jsonResponse("Success", $promotion->load("targets", "conditions"));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $promotion = Promotion::with("targets", "conditions")->findOrFail($id);

        return $this->jsonResponse("Success", $promotion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PromotionRequest $request, $id)
    {
        $promotion = Promotion::with("targets", "conditions")->findOrFail($id);

        $promotion->update($request->only([
            "name",
            "name_ar",
            "start_date",
            "expiration_date",
            "discount",
            "discount_qty",
            "different_brands",
            "different_categories",
            "different_products",
            "override_discount",
            "priority",
            "times",
            "active",
            "type",
            "gift_ar",
            "gift_en",
            "check_all_conditions",
            "boost",
            "exclusive",
            "periodic",
            "group_id",
            'instant',
            'incentive_id',
            'description',
            'description_ar'
        ]));

        if (isset($request->targets)) {
            $promotion->targets()->delete();

            foreach ($request->targets as $target) {
                $promotion->targets()->create($target);
            }
        }

        if (isset($request->conditions)) {
            $promotion->conditions()->delete();

            foreach ($request->conditions as $condition) {

                if ($condition['item_type'] == PromotionConditions::ITEM_TYPES['products']) {
                    $list = $condition['custom_list'];
                    unset($condition['custom_list']);
                    $condition = $promotion->conditions()->create($condition);

                    $condition->customLists()->delete();

                    foreach ($list as $item) {
                        $condition->customLists()->create([
                            'item_id' => $item
                        ]);
                    }
                } else {
                    $promotion->conditions()->create($condition);
                }
            }
        }

        $promotion->refresh();

        return $this->jsonResponse("Success", $promotion);
    }

    public function activate($id)
    {
        $promotion = Promotion::findOrFail($id);

        $promotion->active = 1;
        $promotion->deactivation_notes = null;
        $promotion->save();

        return $this->jsonResponse("Success");
    }

    public function deactivate(Request $request, $id)
    {
        // validate request
        $this->validate($request, ["deactivation_notes" => "required"]);

        $promotion = Promotion::findOrFail($id);

        $promotion->active = 0;
        $promotion->deactivation_notes = $request->deactivation_notes;
        $promotion->save();

        return $this->jsonResponse("Success");
    }

    public function destroy($id)
    {
        Promotion::findOrFail($id)->delete();

        return $this->jsonResponse("Success");
    }

    public function getGroups()
    {
        $groupList = \DB::table('promotion_groups')->get();

        return $this->jsonResponse("Success", $groupList);
    }

}
