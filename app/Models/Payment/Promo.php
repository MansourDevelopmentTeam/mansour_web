<?php

namespace App\Models\Payment;

use App\Models\Users\User;
use App\Models\Products\Lists;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{

    // Target type
    const TARGET_TYPE_SELECTED_CUSTOMER = 1;
    const TARGET_TYPE_UPLOAD_CUSTOMER = 2;
    // Type
    const AMOUNT = 1;
    const PERCENT = 2;
    const FREE_DELIVERY = 3;

    protected $fillable = [
        "name",
        "type",
        "amount",
        "max_amount",
        "expiration_date",
        "description",
        "first_order",
        "minimum_amount",
        "target_type",
        'incentive_id'
    ];

    // public $active;

    public static $validation = [
    	"type" => "required|in:1,2,3",
    	"amount" => "nullable|numeric",
    	"expiration_date" => "required|date",
    	"description" => "required",
        'incentive_id' => 'integer'
    ];


    protected $appends = ["use_number"];

    protected $hidden = ["invoices"];

    protected $casts = [
        "amount" => "double"
    ];

    // public function getAmountAttribute()
    // {
    //     if(isset($this->attributes["type"]) && $this->attributes["type"] == 1) {
    //         return $this->attributes["amount"] / 100;
    //     }else {
    //         return $this->attributes["amount"];
    //     }
    // }

    public function getMaxAmountAttribute()
    {
        return $this->attributes["max_amount"] / 100;
    }

    public function invoices()
    {
    	return $this->hasMany(Invoice::class, "promo_id");
    }

    public function uses()
    {
        return $this->belongsToMany(User::class, "user_promo", "promo_id", "user_id");
    }

    public function paymentMethods()
    {
        return $this->belongsToMany(PaymentMethod::class, "promo_payment_method", "promo_id", "payment_method_id");
    }

    public function targets()
    {
        return $this->belongsToMany(User::class, "promo_targets", "promo_id", "user_id");
    }

    public function phone_targets()
    {
        return $this->belongsToMany(User::class, "promo_targets", "promo_id", "phone", null, "phone");
    }

    public function target_lists()
    {
        return $this->hasMany(PromoTarget::class);
    }

    public function list()
    {
        return $this->belongsTo(Lists::class, "list_id");
    }

    public function getUseNumberAttribute()
    {
    	return $this->invoices->count();
    }

    public function scopeActive($query)
    {
        return $query->where("active", 1);
    }

    /**
     * Scope a query active now.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActiveNow($query)
    {
        return $query->where("active", 1)->whereDate('expiration_date', '>=', now());
    }
}
