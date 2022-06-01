<?php

namespace App\Models\Orders\Validation\Rules;

use Carbon\Carbon;
use App\Models\Orders\Order;
use App\Models\Products\Product;
use App\Models\Orders\OrderState;
use Illuminate\Support\Facades\DB;
use App\Models\Orders\OrderProduct;
use App\Models\Orders\Validation\ValidationError;
use Facades\App\Models\Repositories\CartRepository;

class MaxPerOrder implements RulesInterface
{
    public $name = "schedule_date";
    private $order_data;
    private $user;
    private $lang;

    public function __construct($order_data, $user, $lang = 1)
    {
        $this->order_data = $order_data;
        $this->user = $user;
        $this->lang = $lang;
    }

    public function validate()
    {
        try {
            $items = CartRepository::getUserCartItems();
        } catch (\Exception $e) {
            return new ValidationError(trans('mobile.errorItemsNotExists'), 422);
        }
        foreach ($items as $item) {
            $product = Product::findOrFail($item["id"]);
            if ($product) {
                $user = $this->user;
                // $order_item = OrderProduct::with("order", "product")->select("*", DB::raw("SUM(amount) as sale_count"))->whereHas("order", function ($q) use ($user) {
                //     $q->whereNotIn("state_id", [OrderState::CANCELLED, OrderState::INCOMPLETED])->where("user_id", $user->id);
                // })->where("product_id", $item["id"])->where("created_at", ">", now()->subDays($product->min_days))->groupby("product_id")->first();

                if ($user) {
                    $orders = Order::with(['items' => function ($query) use ($product) {
                        $query->where('product_id', $product->id);
                    }]);
                    if ($product->min_days) {
                        $orders->where('created_at', '>', Carbon::now()->subDays($product->min_days));
                    }

                    $orders = $orders->whereHas('items', function ($query) use ($product) {
                        $query->where('product_id', $product->id);
                    })
                        ->whereNotIn("state_id", [OrderState::CANCELLED, OrderState::INCOMPLETED])
                        ->where('user_id', $user->id)
                        ->get();

                    $amount = $orders->pluck('items')->sum(function ($product) {
                        return $product->first()->amount;
                    });
                } else {
                    $amount = 0;
                }


                $total_qty = $item["amount"] + $amount;

                if ($total_qty > $product->parent->max_per_order && $product->parent->max_per_order != null) {
                    return new ValidationError(trans("mobile.errorMaxProduct", ["product" => $product->getName($this->lang), "quantity" => $product->parent->max_per_order]), 423);
                }

            }
        }
    }
}
