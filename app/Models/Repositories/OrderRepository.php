<?php

namespace App\Models\Repositories;

use App\Models\Orders\Order;
use App\Models\Orders\OrderState;
use Carbon\Carbon;

/**
*
*/
class OrderRepository
{

    public function getAllOrders()
    {
        return Order::orderBy("created_at", "DESC")->get();
    }

    public function getUnassignedOrders()
    {
        return Order::with("customer", "address")->whereNull("scheduled_at")->where("state_id", OrderState::CREATED)->orderBy("created_at", "DESC")->get();
    }

    public function getAllOrdersPaginated()
    {
        return Order::with("customer", "invoice")->whereNull("scheduled_at")->orderBy("created_at", "DESC")->paginate(20)->items();
    }

    public function getOrderById($id)
    {
        return Order::with('customer.addresses')->findOrFail($id);
    }

    public function filterOrders($data ,$query)
    {
        // Filter By Order ID
        $query->when(isset($data["ids"]) && !empty($data["ids"]), function ($q) use ($data) {
            $q->whereIn("id", $data["ids"]);
        });
        // Filter By Customer ID
        $query->when(isset($data["customer_ids"]) && !empty($data["customer_ids"]), function ($q) use ($data) {
            $q->whereHas('customer', function ($q) use ($data) {
                $q->whereIn('id', $data["customer_ids"]);
            });
        });
        // Filter By Customer Name
        $query->when(isset($data["customer_name"]) && !empty($data["customer_name"]), function ($q) use ($data) {
            $q->whereHas('customer', function ($q) use ($data) {
                $q->where('name', "LIKE", "%{$data["customer_name"]}%");
            });
        });
        // Filter By Customer Email
        $query->when(isset($data["customer_email"]) && !empty($data["customer_email"]), function ($q) use ($data) {
            $q->whereHas('customer', function ($q) use ($data) {
                $q->where('email', "LIKE", "%{$data["customer_email"]}%");
            });
        });

        $query->when(isset($data["shipping_id"]) && !empty($data["shipping_id"]), function ($q) use ($data) {
            $q->whereHas('order_pickups', function ($q) use ($data) {
                $q->where('shipping_id', "LIKE", "%{$data["shipping_id"]}%");
            });
        });

        // Filter By Customer Phone
        $query->when(isset($data["customer_phone"]) && !empty($data["customer_phone"]), function ($q) use ($data) {
            $q->whereHas('customer', function ($q) use ($data) {
                $q->where('phone', "LIKE", "%{$data["customer_phone"]}%");
            });
        });
        // Filter By Customer address area name
        $query->when(isset($data["customer_area_name"]) && !empty($data["customer_area_name"]), function ($q) use ($data) {
            $q->whereHas('address.area', function ($q) use ($data) {
                $q->where('name', "LIKE", "%{$data["customer_area_name"]}%");
                $q->orWhere('name_ar', "LIKE", "%{$data["customer_area_name"]}%");
            });
        });
        // Filter By Customer address area id
        $query->when(isset($data["customer_area_ids"]) && !empty($data["customer_area_ids"]), function ($q) use ($data) {
            $q->whereHas('address.area', function ($q) use ($data) {
                $q->whereIn('id', $data["customer_area_ids"]);
            });
        });
        // Filter By Customer address city name
        $query->when(isset($data["customer_city_name"]) && !empty($data["customer_city_name"]), function ($q) use ($data) {
            $q->whereHas('address.city', function ($q) use ($data) {
                $q->where('name', "LIKE", "%{$data["customer_city_name"]}%");
                $q->orWhere('name_ar', "LIKE", "%{$data["customer_city_name"]}%");
            });
        });
        // Filter By Customer address city id
        $query->when(isset($data["customer_city_ids"]) && !empty($data["customer_city_ids"]), function ($q) use ($data) {
            $q->whereHas('address.city', function ($q) use ($data) {
                $q->whereIn('id', $data["customer_city_ids"]);
            });
        });
        // Filter By items  id
        $query->when(isset($data["items_ids"]) && !empty($data["items_ids"]), function ($q) use ($data) {
            $q->whereHas('items', function ($q) use ($data) {
                $q->whereIn('id', $data["items_ids"]);
            });
        });
        // Filter By items  name
        $query->when(isset($data["items_name"]) && !empty($data["items_name"]), function ($q) use ($data) {
            $q->whereHas('items.product', function ($q) use ($data) {
                $q->where('name', "LIKE", "%{$data["items_name"]}%");
                $q->orWhere('name_ar', "LIKE", "%{$data["items_name"]}%");
            });
        });
        // Filter By items  categories ids
        $query->when(isset($data["items_categories_ids"]) && !empty($data["items_categories_ids"]), function ($q) use ($data) {
            $q->whereHas('items.product.category.parent', function ($q) use ($data) {
                $q->whereIn('id', $data["items_categories_ids"]);
            });
        });
        // Filter By items  categories name
        $query->when(isset($data["items_categories_name"]) && !empty($data["items_categories_name"]), function ($q) use ($data) {
            $q->whereHas('items.product.category.parent', function ($q) use ($data) {
                $q->where('name', "LIKE", "%{$data["items_categories_name"]}%");
                $q->orWhere('name_ar', "LIKE", "%{$data["items_categories_name"]}%");
            });
        });
        // Filter By items sub categories ids
        $query->when(isset($data["items_sub_categories_ids"]) && !empty($data["items_sub_categories_ids"]), function ($q) use ($data) {
            $q->whereHas('items.product.category', function ($q) use ($data) {
                $q->whereIn('id', $data["items_sub_categories_ids"]);
            });
        });
        // Filter By items sub categories name
        $query->when(isset($data["items_sub_categories_name"]) && !empty($data["items_sub_categories_name"]), function ($q) use ($data) {
            $q->whereHas('items.product.category', function ($q) use ($data) {
                $q->where('name', "LIKE", "%{$data["items_sub_categories_name"]}%");
                $q->orWhere('name_ar', "LIKE", "%{$data["items_sub_categories_name"]}%");
            });
        });
        // Filter By items brand ids
        $query->when(isset($data["items_brand_ids"]) && !empty($data["items_brand_ids"]), function ($q) use ($data) {
            $q->whereHas('items.product.brand', function ($q) use ($data) {
                $q->whereIn('id', $data["items_brand_ids"]);
            });
        });
        // Filter By items brand name
        $query->when(isset($data["items_brand_name"]) && !empty($data["items_brand_name"]), function ($q) use ($data) {
            $q->whereHas('items.product.brand', function ($q) use ($data) {
                $q->where('name', "LIKE", "%{$data["items_brand_name"]}%");
                $q->orWhere('name_ar', "LIKE", "%{$data["items_brand_name"]}%");
            });
        });
        // Filter By items  price From
        $query->when(isset($data["items_price_from"]) && !empty($data["items_price_from"]), function ($q) use ($data) {
            $q->whereHas('items.product', function ($q) use ($data) {
                $q->where('price', ">=", $data["items_price_from"]);
                $q->orWhere('discount_price', ">=", $data["items_price_from"]);

            });
        });
        // Filter By items  price To
        $query->when(isset($data["items_price_to"]) && !empty($data["items_price_to"]), function ($q) use ($data) {
            $q->whereHas('items.price', function ($q) use ($data) {
                $q->where('price', "<=", $data["items_price_to"]);
                $q->orWhere('discount_price', "<=", $data["items_price_to"]);
            });
        });
        // Filter By State ID
        $query->when(isset($data["state_id"]) && !empty($data["state_id"]), function ($q) use ($data) {
            $q->where("state_id", $data["state_id"]);
        });
        // Filter By subState ID
        $query->when(isset($data["sub_state_id"]) && !empty($data["sub_state_id"]), function ($q) use ($data) {
            $q->where("sub_state_id", $data["sub_state_id"]);
        });
        // Hide scheduled Orders
        $query->when(isset($data["hide_scheduled"]) && $data["hide_scheduled"] != "false", function ($q) use ($data) {
            $q->where(function ($q) use ($data) {
                $q->whereNull("scheduled_at")->orWhere("scheduled_at", "<", Carbon::tomorrow());
            });
        });
        // Filter By amount  price From
        $query->when(isset($data["amount_price_from"]) && !empty($data["amount_price_from"]), function ($q) use ($data) {
            $q->whereHas('invoice', function ($q) use ($data) {
                $q->where('discount', ">=", $data["amount_price_from"]);
                $q->orWhere('total_amount', ">=", $data["amount_price_from"]);
            });
        });
        // Filter By amount  price To
        $query->when(isset($data["amount_price_to"]) && !empty($data["amount_price_to"]), function ($q) use ($data) {
            $q->whereHas('invoice', function ($q) use ($data) {
                $q->where('discount', "<=", $data["amount_price_to"]);
                $q->orWhere('total_amount', "<=", $data["amount_price_to"]);
            });
        });
        // Filter By paid amount  price From
        $query->when(isset($data["paid_amount_price_from"]) && !empty($data["paid_amount_price_from"]), function ($q) use ($data) {
            $q->whereHas('invoice', function ($q) use ($data) {
                $q->where('paid_amount', ">=", $data["paid_amount_price_from"]);
            });
        });
        // Filter By paid amount  price To
        $query->when(isset($data["paid_amount_price_to"]) && !empty($data["paid_amount_price_to"]), function ($q) use ($data) {
            $q->whereHas('invoice', function ($q) use ($data) {
                $q->where('paid_amount', "<=", $data["paid_amount_price_to"]);
            });
        });
        // Filter By delivery fees  price From
        $query->when(isset($data["delivery_fees_price_from"]) && !empty($data["delivery_fees_price_from"]), function ($q) use ($data) {
            $q->whereHas('invoice', function ($q) use ($data) {
                $q->where('delivery_fees', ">=", $data["delivery_fees_price_from"]);
            });
        });
        // Filter By delivery fees  price To
        $query->when(isset($data["delivery_fees_price_to"]) && !empty($data["delivery_fees_price_to"]), function ($q) use ($data) {
            $q->whereHas('invoice', function ($q) use ($data) {
                $q->where('delivery_fees', "<=", $data["delivery_fees_price_to"]);
            });
        });
        // Filter By payment method To
        $query->when(isset($data["payment_method"]) && !empty($data["payment_method"]), function ($q) use ($data) {
            $q->where("payment_method", $data["payment_method"]);
        });
        // Filter By remaining  price From
        $query->when(isset($data["remaining_price_from"]) && !empty($data["remaining_price_from"]), function ($q) use ($data) {
            $q->whereHas('invoice', function ($q) use ($data) {
                $q->where('remaining', ">=", $data["remaining_price_from"]);
            });
        });
        // Filter By remaining  price To
        $query->when(isset($data["remaining_price_to"]) && !empty($data["remaining_price_to"]), function ($q) use ($data) {
            $q->whereHas('invoice', function ($q) use ($data) {
                $q->where('remaining', "<=", $data["remaining_price_to"]);
            });
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
        // Filter By date From
        $query->when(isset($data["scheduled_date_from"]) && !empty($data["scheduled_date_from"]), function ($q) use ($data) {
            $date = strtotime($data["scheduled_date_from"]);
            $q->whereDate("scheduled_at", ">=", date("Y-m-d", $date));
        });
        // Filter By date To
        $query->when(isset($data["scheduled_date_to"]) && !empty($data["scheduled_date_to"]), function ($q) use ($data) {
            $date = strtotime($data["scheduled_date_to"]);
            $q->whereDate("scheduled_at", "<=", date("Y-m-d", $date));
        });
        // Filter By Delivery Man  id
        $query->when(isset($data["delivery_man_ids"]) && !empty($data["delivery_man_ids"]), function ($q) use ($data) {
            $q->whereHas('deliverer', function ($q) use ($data) {
                $q->whereIn('id', $data["delivery_man_ids"]);
            });
        });
        // Filter By Delivery Man  name
        $query->when(isset($data["delivery_man_name"]) && !empty($data["delivery_man_name"]), function ($q) use ($data) {
            $q->whereHas('deliverer', function ($q) use ($data) {
                $q->where('name', "LIKE", "%{$data["delivery_man_name"]}%");
            });
        });
        // Filter By Delivery Man  number
        $query->when(isset($data["delivery_man_number"]) && !empty($data["delivery_man_number"]), function ($q) use ($data) {
            $q->whereHas('deliverer', function ($q) use ($data) {
                $q->where('phone', "LIKE", "%{$data["delivery_man_number"]}%");
            });
        });
        // Filter By Promo  id
        $query->when(isset($data["promo_ids"]) && !empty($data["promo_ids"]), function ($q) use ($data) {
            $q->whereHas('invoice.promo', function ($q) use ($data) {
                $q->whereIn('id', $data["promo_ids"]);
            });
        });
        // Filter By Promo  type
        $query->when(isset($data["promo_type"]) && !empty($data["promo_type"]), function ($q) use ($data) {
            $q->whereHas('invoice.promo', function ($q) use ($data) {
                $q->where('type', $data["promo_type"]);
            });
        });
        // Filter By Promo  type
        $query->when(isset($data["promo_name"]) && !empty($data["promo_name"]), function ($q) use ($data) {
            $q->whereHas('invoice.promo', function ($q) use ($data) {
                $q->where('name', "LIKE", "%{$data["promo_name"]}%");
            });
        });
        // Filter By promo amount  From
        $query->when(isset($data["promo_amount_from"]) && !empty($data["promo_amount_from"]), function ($q) use ($data) {
            $q->whereHas('invoice.promo', function ($q) use ($data) {
                $q->where('amount', ">=", $data["promo_amount_from"]);
            });
        });
        // Filter By promo amount To
        $query->when(isset($data["promo_amount_to"]) && !empty($data["promo_amount_to"]), function ($q) use ($data) {
            $q->whereHas('invoice.promo', function ($q) use ($data) {
                $q->where('amount', "<=", $data["promo_amount_to"]);
            });
        });
        // Filter By promo max amount  From
        $query->when(isset($data["promo_max_amount_from"]) && !empty($data["promo_max_amount_from"]), function ($q) use ($data) {
            $q->whereHas('invoice.promo', function ($q) use ($data) {
                $q->where('max_amount', ">=", $data["promo_max_amount_from"]);
            });
        });
        // Filter By promo max amount To
        $query->when(isset($data["promo_max_amount_to"]) && !empty($data["promo_max_amount_to"]), function ($q) use ($data) {
            $q->whereHas('invoice.promo', function ($q) use ($data) {
                $q->where('max_amount', "<=", $data["promo_max_amount_to"]);
            });
        });
        // Filter By promo max amount  From
        $query->when(isset($data["promo_min_amount_from"]) && !empty($data["promo_min_amount_from"]), function ($q) use ($data) {
            $q->whereHas('invoice.promo', function ($q) use ($data) {
                $q->where('minimum_amount', ">=", $data["promo_min_amount_from"]);
            });
        });
        // Filter By promo max amount To
        $query->when(isset($data["promo_min_amount_to"]) && !empty($data["promo_min_amount_to"]), function ($q) use ($data) {
            $q->whereHas('invoice.promo', function ($q) use ($data) {
                $q->where('minimum_amount', "<=", $data["promo_min_amount_to"]);
            });
        });

        $query->when(isset($data["user_agent"]) && !empty($data["user_agent"]), function ($q) use ($data) {
            $q->where('user_agent', $data["user_agent"]);
        });
        // sort Desc By creation date To
        $query->orderBy("created_at", "DESC");
        return $query;

    }

    public function getDelivererOrders($deliverer)
    {
        return Order::where("deliverer_id", $deliverer->id)->get();
    }

    public function getDelivererActiveOrders($deliverer)
    {
        return Order::where("deliverer_id", $deliverer->id)->whereIn("state_id", OrderState::getDelivererActiveStates())->orderBy("created_at", "DESC")->get();
    }

    public function getDelivererOrdersHistory($deliverer)
    {
        return Order::where("deliverer_id", $deliverer->id)->where("state_id", OrderState::DELIVERED)->orderBy("created_at", "DESC")->get();
    }

    public function getDelivererPreparedOrders($deliverer)
    {
        return Order::where("deliverer_id", $deliverer->id)->where("state_id", OrderState::PREPARED)->orderBy("created_at", "DESC")->get();
    }

    public function getCustomerOrders($customer)
    {
        return Order::where("user_id", $customer->id)->orderBy("created_at", "DESC")->get();
    }

    public function getTotalOrders()
    {
        return Order::count();
    }
}
