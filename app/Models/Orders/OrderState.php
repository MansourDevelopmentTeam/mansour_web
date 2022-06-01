<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;

class OrderState extends Model
{
    protected $fillable = ["name", "name_ar", "parent_id"];

    const CREATED = 1;
    const PROCESSING = 2; // assigned
    const ONDELIVERY = 3;
    const DELIVERED = 4;
    const INVESTIGATION = 5;
    const CANCELLED = 6;
    const RETURNED = 7;
    const PREPARED = 8;
    const INCOMPLETED = 9;
    const PARTIAL_RETURNED = 10;
    const PENDING_PAYMENT = 11;
    const PAYMENT_EXPIRED = 12;
    const DELIVERY_FAILED = 14;

    public function getName($lang = 1)
    {
        if ($lang == 2) {
            return $this->name_ar ?: $this->name;
        }

        return $this->name;
    }

    public function sub_states()
    {
        return $this->hasMany(self::class, "parent_id");
    }

    public static function getDelivererActiveStates()
    {
    	return [
    		self::PROCESSING,
    		self::ONDELIVERY,
    		self::INVESTIGATION,
    		self::PREPARED,
    	];
    }
}
