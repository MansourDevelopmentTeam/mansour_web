<?php

namespace App\Http\Controllers;



use App\Models\Stores\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class StoresController extends Controller
{

    public function index()
    {
        $page = Store::get();
        return $this->jsonResponse("Success", $page);
    }

    public function store(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), Store::$validation);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        $data = $validator->valid();
        $store = Store::create($data);
        return $this->jsonResponse("Success", $store);
    }

    public function update(Request $request, $id)
    {
        $store = Store::find($id);
        if (!$store){
            $message = 'Store Not Found';
            return $this->errorResponse($message, "Invalid data", 422);
        }
        // validate request
        $validator = Validator::make($request->all(), Store::$validation);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        $data = $validator->valid();
        $store->update($data);
        return $this->jsonResponse("Success", $store);
    }

    public function activate($id)
    {
        $store = Store::find($id);
        if (!$store) {
            $message = 'This store Not Found';
            return $this->jsonResponse($message, $store);
        }
        $data = ['active' => '1'];
        $store->update($data);
        return $this->jsonResponse("Success");
    }

    public function deactivate($id)
    {
        $store = Store::find($id);
        if (!$store) {
            $message = 'This store Not Found';
            return $this->jsonResponse($message, $store);
        }
        $data = ['active' => '0'];
        $store->update($data);
        return $this->jsonResponse("Success");
    }
}
