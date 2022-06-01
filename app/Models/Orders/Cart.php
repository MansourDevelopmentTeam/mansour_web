<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id'];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
