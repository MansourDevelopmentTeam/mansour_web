<?php

namespace App\Models\Orders;

use App\Models\Payment\Invoice;
use App\Models\Products\Product;
use App\Models\Orders\OrderSchedule;
use App\Models\Shipping\OrderPickup;
use App\Models\Users\Address;
use App\Models\Users\Affiliates\WalletHistory;
use App\Models\Users\Deliverer;
use App\Models\Users\User;
use App\Models\Users\Wallet;
use Illuminate\Database\Eloquent\Model;
use App\Models\Payment\PaymentInstallment;

class Order extends Model
{
    const DELIVERY_FEES = 15;

    const DEVICE_TYPE_WEB = 1;
    const DEVICE_TYPE_ANDROID = 2;
    const DEVICE_TYPE_IOS = 3;

    protected $appends = ["payment_method_name"];
    protected $fillable = ["user_id", "payment_method", "address_id", "state_id", "cancellation_id", "cancellation_text", "notes", "scheduled_at", "admin_notes", "transaction_id", "source", "phone", "admin_id", "user_agent", "user_ip", "payment_installment_id", "affiliate_id", "promotion_discount", 'wallet_redeem',
        'cashback_amount'
    ];

    public function affiliate()
    {
        return $this->belongsTo(User::class, "affiliate_id");
    }
    public function byAffiliate()
    {
        $attribute = false;
        if (!is_null($this->user_id) && !is_null($this->affiliate_id)){
            if ($this->user_id === $this->affiliate_id){
                $attribute = true;
            }
        }
        return $attribute;
    }
    public function wallet_record()
    {
        return $this->hasOne(WalletHistory::class, "order_id");
    }
    public function affiliateTotalAmount()
    {
        return $this->items()->sum('affiliate_commission');
    }
    public function state()
    {
        return $this->belongsTo(OrderState::class, "state_id");
    }
    public function order_pickup()
    {
        return $this->hasOne(OrderPickup::class, "order_id")->orderBy("created_at", "DESC");
    }

    /**
     * Get the paymentInstallment that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paymentInstallment()
    {
        return $this->belongsTo(PaymentInstallment::class);
    }
    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'id', "transaction_id");
    }

    public function order_pickups()
    {
        return $this->hasMany(OrderPickup::class, "order_id");
    }

    public function sub_state()
    {
        return $this->belongsTo(OrderState::class, "sub_state_id");
    }

    public function CancellationReason()
    {
        return $this->belongsTo(OrderCancellationReason::class, "cancellation_id");
    }

    public function customer()
    {
        return $this->belongsTo(User::class, "user_id");
    }
    public function admin()
    {
        return $this->belongsTo(User::class, "admin_id");
    }

    public function deliverer()
    {
        return $this->belongsTo(Deliverer::class, "deliverer_id");
    }

    public function items()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, "order_products", "order_id", "product_id")->withTrashed();
    }

    public function history()
    {
        return $this->hasMany(OrderHistory::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class, "address_id")->withTrashed();
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, "order_id");
    }

    public function schedule()
    {
        return $this->hasOne(OrderSchedule::class);
    }

    public function reorders()
    {
        return $this->hasMany(self::class, "parent_id");
    }

    public function parentOrder()
    {
        return $this->belongsTo(self::class, "parent_id");
    }

    public function isActive()
    {
        return !in_array($this->state_id, [4, 6, 7, 9]);
    }

    public function getTotal()
    {
        $items = $this->items()->with("product", "price")->where("missing", "!=", 1)->get();

        return $items->reduce(function ($carry, $item) {
            if (!is_null($item->discount_price)) {
                return $carry + ($item->discount_price);
            }

            return $carry + ($item->price);
        });
    }

    public function getOrderWightAttribute()
    {
        $attributes = 0;
        $orderItems =  $this->items;
        foreach ($orderItems as $item) {
            $product = $item->product;
            $attributes += $product->weight * $item->amount;
        }
        return $attributes;
    }
    public function getOrderNumberOfPiscesAttribute()
    {
        return $this->items->reduce(function ($carry, $item) {
            return $carry + $item->amount;
        });
    }
    /**
     * Set the user order agent.
     *
     * @param  string  $value
     * @return void
     */
    public function setUserAgentAttribute($value)
    {
        switch ($value) {
            case Order::DEVICE_TYPE_WEB:
                $agent = 'web';
                break;
            case Order::DEVICE_TYPE_ANDROID:
                $agent = 'android';
                break;
            case Order::DEVICE_TYPE_IOS:
                $agent = 'ios';
                break;
        }
        if(is_string($value)){
            $agent = $value;
        }
        if(is_null($value)){
            $agent = getDevice();
        }
        $this->attributes['user_agent'] = $agent;
    }
    public function getStates($lang = 1)
    {
        $processingLabel = 0;
        $deliveringLabel = 0;
        $deliveredLabel = 0;
        $preparedLabel = 0;

        if ($this->state_id == OrderState::DELIVERED) {
            $processingLabel = 1;
            $deliveringLabel = 1;
            $deliveredLabel = 1;
            $preparedLabel = 1;
        } elseif ($this->state_id == OrderState::ONDELIVERY) {
            $processingLabel = 1;
            $deliveringLabel = 1;
            $preparedLabel = 1;
        } elseif ($this->state_id == OrderState::PREPARED) {
            $processingLabel = 1;
            $preparedLabel = 1;
        } elseif ($this->state_id == OrderState::PROCESSING) {
            $processingLabel = 1;
        }

        $created_state = OrderState::find(OrderState::CREATED);
        $prepared_state = OrderState::find(OrderState::PREPARED);
        $processing_state = OrderState::find(OrderState::PROCESSING);
        $delivering_state = OrderState::find(OrderState::ONDELIVERY);
        $delivered_state = OrderState::find(OrderState::DELIVERED);

        return [
            [
                "id" => 1,
                // "name" => $created_state->getName($lang),
                "name" => $created_state->name,
                "name_ar" => $created_state->name_ar
            ],
            [
                "id" => $processingLabel,
                // "name" => $processing_state->getName($lang)
                "name" => $processing_state->name,
                "name_ar" => $processing_state->name_ar
            ],
            [
                "id" => $preparedLabel,
                // "name" => $prepared_state->getName($lang)
                "name" => $prepared_state->name,
                "name_ar" => $prepared_state->name_ar
            ],
            [
                "id" => $deliveringLabel,
                // "name" => $delivering_state->getName($lang)
                "name" => $delivering_state->name,
                "name_ar" => $delivering_state->name_ar
            ],
            [
                "id" => $deliveredLabel,
                // "name" => $delivered_state->getName($lang)
                "name" => $delivered_state->name,
                "name_ar" => $delivered_state->name_ar
            ]
        ];
    }

    public function getArea()
    {
        return $this->address->area;
    }

    public function createSchdule($scheduleData)
    {
        $schedule = $this->schedule()->create([
            "interval" => $scheduleData["interval"],
            "time" => $scheduleData["time"]
        ]);

        if ($scheduleData["interval"] == OrderSchedule::WEEKLY || $scheduleData["interval"] == OrderSchedule::MONTHLY) {
            foreach ($scheduleData["days"] as $day) {
                $schedule->days()->create(["day" => $day]);
            }
        }
    }
    public function getPaymentMethodNameAttribute()
    {
        return config("payment.stores.{$this->payment_method}.name_en");
    }

    public function getUrlAttribute()
    {
        return config('app.website_url') . "/account/order-history/" . $this->id;
    }

    public function totalCashBack()
    {
        return $this->hasMany(Wallet::class,  'order_id', 'id');
    }
}
