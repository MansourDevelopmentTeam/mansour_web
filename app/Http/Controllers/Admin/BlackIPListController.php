<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Orders\BlackIPList;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class BlackIPListController extends Controller
{

    public function index()
    {
        $list = BlackIPList::all();

        return $this->jsonResponse("Success", $list);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ["ip" => "required|ip"]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data",
                $validator->errors(), 422);
        }

        $item = BlackIPList::firstOrCreate($request->all());

        return $this->jsonResponse("Success", $item);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), ["ip" => "required|ip"]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data",
                $validator->errors(), 422);
        }

        $item = BlackIPList::whereId($id)->first();

        if (isset($item))
            $item->update($request->all());

        return $this->jsonResponse("Success", $item);
    }


    public function destroy($id)
    {
       $category = BlackIPList::findOrFail($id);

       $category->delete();

       return $this->jsonResponse("Success");
    }

}
