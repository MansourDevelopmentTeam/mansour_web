<?php

namespace App\Http\Controllers\Admin;

use App\Models\Orders\OrderState;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class OrderStatesController extends Controller
{
    
    public function index()
    {
    	$order_states = OrderState::with("sub_states")->whereNull("parent_id")->get();

    	return $this->jsonResponse("Success", $order_states);
    }

    public function getEditableStates()
    {
        $order_states = OrderState::with("sub_states")->whereNull("parent_id")->where("editable", 1)->get();

        return $this->jsonResponse("Success", $order_states);
    }

    public function update(Request $request, $id)
    {
    	$state = OrderState::findOrFail($id);
    	$this->validate($request, [
    		"name" => "required",
    		"name_ar" => "required",
    	]);

    	$state->update($request->only(["name", "name_ar"]));

        if ($request->sub_states) {
        	foreach ($request->sub_states as $sub_state) {
        		if (isset($sub_state["id"])) {
        			$sub_state = OrderState::find($sub_state["id"]);
        			$sub_state->update(["name" => $sub_state["name"]]);
        		} else {
        			$sub_state = $state->sub_states()->create(["name" => $sub_state["name"]]);
        		}
        	}
        }

    	return $this->jsonResponse("Success", $state->load("sub_states"));
    }

    public function activate(Request $request, $id)
    {
    	$state = OrderState::findOrFail($id);

        $state->active = 1;
        $state->deactivation_notes = null;
        $state->save();

        return $this->jsonResponse("Success");

    }

    public function deactivate(Request $request, $id)
    {
        $state = OrderState::findOrFail($id);

        $state->active = 0;
        $state->deactivation_notes = $request->deactivation_notes;
        $state->save();

        return $this->jsonResponse("Success");
    }
}
