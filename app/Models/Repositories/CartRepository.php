<?php

namespace App\Models\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Exceptions\CartEmptyException;
use Illuminate\Validation\ValidationException;

/**
 * Cart Repository
 * @author Esmail Shabayek <esmail.shabayek@gmail.com>
 * @package App\Models\Repositories\CartRepository
 */
class CartRepository
{
    public $cartItems = [];

    public function getUserCartItems($user = null)
    {
        if ($this->cartItems) {
            return $this->cartItems;
        }

        $user = Auth::user() ?? $user;

        if ((auth()->check() && auth()->user()->type == 2) || $user == null || $user->id == 999999) {
            $items = collect(request()->get('items'));
        } else {
            $carts = $user->cart()->with('cartItems')->get();

            $items = optional($carts->pluck('cartItems')->first())->map(function ($item) {
                return [
                    'id' => $item->product_id,
                    'amount' => $item->amount,
                ];
            });
        }

        if ($items == null || empty($items)) {
            throw new CartEmptyException('Cart is empty');
        }

        return $items;
    }
}
