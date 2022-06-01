<?php

namespace App\Models\Repositories;

use App\Models\ACL\Role;
use App\Models\Users\User;

/**
*
*/
class CustomerRepository
{

	public function getAllCustomers()
	{
		return User::where("type", 1)->with('cart.cartItems.product')->get();
	}

	public function getAllCustomersPaginated(           )
	{
		return User::where("type", 1)->where("id", "!=", 999999)->orderBy("created_at", "DESC")->paginate(20)->items();
	}

    public function searchCustomers($data,$query)
    {
        $query->when(isset($data["q"]) && !empty($data["q"]), function ($q) use ($data) {
            $q->where(function ($q) use ($data) {
                $q->where("name", "LIKE", "%{$data["q"]}%")
                ->orWhere("email", "LIKE", "%{$data["q"]}%")
                ->orWhere("id", "LIKE", "%{$data["q"]}%")
                ->orWhere("phone", "LIKE", "%{$data["q"]}%")
                ->orWhereHas("addresses.area", function($q2) use ($q,$data) {
                    $q2->where("name", "LIKE", "%{$data["q"]}%");
                });
            });
        });
        // Filter By ID
        $query->when(isset($data["ids"]) && !empty($data["ids"]), function ($q) use ($data) {
            $q->whereIn("id", $data["ids"]);
        });
        // Filter By  Name
        $query->when(isset($data["name"]) && !empty($data["name"]), function ($q) use ($data) {
            $q->where('name', "LIKE", "%{$data["name"]}%");
        });
        // Filter By  Email
        $query->when(isset($data["email"]) && !empty($data["email"]), function ($q) use ($data) {
            $q->where('email', "LIKE", "%{$data["email"]}%");
        });
        // Filter By  Phone
        $query->when(isset($data["phone"]) && !empty($data["phone"]), function ($q) use ($data) {
            $q->where('phone', "LIKE", "%{$data["phone"]}%");
        });
        // Filter By Customer address area name
        $query->when(isset($data["area_name"]) && !empty($data["area_name"]), function ($q) use ($data) {
            $q->whereHas('addresses.area', function ($q) use ($data) {
                $q->where('name', "LIKE", "%{$data["area_name"]}%");
                $q->orWhere('name_ar', "LIKE", "%{$data["area_name"]}%");
            });
        });
        // Filter By Customer address area id
        $query->when(isset($data["area_ids"]) && !empty($data["area_ids"]), function ($q) use ($data) {
            $q->whereHas('addresses.area', function ($q) use ($data) {
                $q->whereIn('id', $data["area_ids"]);
            });
        });
        $query->when(isset($data["area_id"]) && !empty($data["area_id"]), function ($q) use ($data) {
            $q->whereHas('addresses', function ($q) use ($data) {
                $q->where('area_id', $data["area_id"]);
            });
        });
        // Filter By Customer address city name
        $query->when(isset($data["city_name"]) && !empty($data["city_name"]), function ($q) use ($data) {
            $q->whereHas('addresses.city', function ($q) use ($data) {
                $q->where('name', "LIKE", "%{$data["city_name"]}%");
                $q->orWhere('name_ar', "LIKE", "%{$data["city_name"]}%");
            });
        });
        // Filter By Customer address city id
        $query->when(isset($data["city_ids"]) && !empty($data["city_ids"]), function ($q) use ($data) {
            $q->whereHas('addresses.city', function ($q) use ($data) {
                $q->whereIn('id', $data["city_ids"]);
            });
        });
        $query->when(isset($data["city_id"]) && !empty($data["city_id"]), function ($q) use ($data) {
            $q->whereHas('addresses', function ($q) use ($data) {
                $q->where('city_id', $data["city_id"]);
            });
        });
        // Filter By Customer active
        $query->when(isset($data["active"]) && !empty($data["active"]), function ($q) use ($data) {
            $q->where('active', $data["active"]);
        });
        // Filter By Customer birthdate
        $query->when(isset($data["birthdate"]) && !empty($data["birthdate"]), function ($q) use ($data) {
            $date = strtotime($data["birthdate"]);
            $q->whereDate("birthdate", "=", date("Y-m-d", $date));
        });
        // Filter By date From
        $query->when(isset($data["date_from"]) && !empty($data["date_from"]), function ($q) use ($data) {
            $date = strtotime($data["date_from"]);
            $q->whereDate("created_at", ">=", date("Y-m-d", $date));
        });
        // Filter By date To
        $query->when(isset($data["date_to"]) && !empty($data["date_to"]), function ($q) use ($data) {
            $date = strtotime($data["date_to"]);
            $q->whereDate("created_at", "<=", date("Y-m-d", $date));
        });

        // Filter By number of orders
        $query->when(isset($data["no_orders"]) && !empty($data["no_orders"]), function ($q) use ($data) {
            $q->withCount('orders')->has('orders', "=", $data["no_orders"]);
        });
        // Filter By number of orders from
        $query->when(isset($data["no_orders_from"]) && !empty($data["no_orders_from"]), function ($q) use ($data) {
            $q->withCount('orders')->has('orders', ">=", $data["no_orders_from"]);
        });
        // Filter By number of orders to
        $query->when(isset($data["no_orders_to"]) && !empty($data["no_orders_to"]), function ($q) use ($data) {
            $q->withCount('orders')->has('orders', "<=", $data["no_orders_to"]);
        });
        return $query->latest();
    }

	public function getCustomerById($id)
	{
		return User::where("type", 1)->where("id", $id)->firstOrFail();
	}

	public function customerCount()
	{
		return $this->getAllCustomers()->count();
	}
}
