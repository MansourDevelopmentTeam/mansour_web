<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Products\Ad;
use App\Models\Products\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagsController extends Controller
{

    public function index()
    {
        $tags = Tag::all();

        return $this->jsonResponse("Success", $tags);
    }

    public function store(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), Tag::$validation);
        
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        $data = $validator->valid();
        $data['status'] == "true" ?  $data['status'] = '1' : $data['status'] ='0';
        $tag = Tag::create($data);
        return $this->jsonResponse("Success", $tag);
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);
        // validate request
        $validator = Validator::make($request->all(), Tag::$validation);
        
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        $data = $validator->valid();
        $data['status'] == "true" ?  $data['status'] = '1' : $data['status'] ='0';
        $tag->update($data);

        return $this->jsonResponse("Success", $tag);
    }

    public function activate($id)
    {
        $ad = Ad::findOrFail($id);

        $ad->active = 1;
        $ad->deactivation_notes = null;
        $ad->save();

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

        return $this->jsonResponse("Success");
    }
}