<?php

namespace App\Http\Controllers\Admin;

use App\Models\Users\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ErpController extends Controller
{
    
    public function getCustomersWithoutID()
    {
        $users = User::where('type', 1)->whereNull("erp_id")->get();

        return $this->jsonResponse("Success", $users);
    }

    public function setCustomersID(Request $request)
    {
        $errors = [];
        foreach ($request->customers as $key => $customer) {
            
            if (!isset($customer["erp_id"]) || $customer["erp_id"] == null) {
                $errors[] = [
                    "code" => "001",
                    "index" => $key,
                    "message" => "Missing erp id."
                ];
                continue;
            }
            
            if (!isset($customer["id"]) || $customer["id"] == null) {
                $errors[] = [
                    "code" => "002",
                    "index" => $key,
                    "message" => "Missing El-Dokan id."
                ];
                continue;
            }
            
            $user = User::find($customer["id"]);

            if (!$user) {
                $errors[] = [
                    "code" => "003",
                    "index" => $key,
                    "message" => "El-Dokan id {$customer['id']} not found."
                ];
                continue;
            }

            $existingUser = User::where('erp_id', $customer["erp_id"])->where("id", "!=", $user->id)->first();
            if ($existingUser) {
                $existingUser->update(['erp_id' => null]);
            }

            $user->update(["erp_id" => $customer["erp_id"]]);
        }

        if (count($errors)) {
            return $this->errorResponse("Invalid Customers", "", $errors, 400);
        }

        return $this->jsonResponse("Success");
    }

    public function getTotalNew()
    {
        $usersCount = User::where('type', 1)->whereNull("erp_id")->count();

        return $this->jsonResponse("Success", [
            "customers" => $usersCount,
            "orders" => 10,
            // "customers" => 10,
        ]);
    }
}
