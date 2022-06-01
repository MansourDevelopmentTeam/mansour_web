<?php

namespace App\Models\Orders\Validation\Rules;

use Illuminate\Support\Facades\Auth;
use App\Exceptions\CartEmptyException;
use App\Models\Orders\Validation\ValidationError;
use Facades\App\Models\Repositories\CartRepository;

class ItemsExists implements RulesInterface
{

    public function validate()
    {
        try {
            $items = CartRepository::getUserCartItems();
        } catch (\Exception $e) {
    		return new ValidationError(trans('mobile.errorItemsNotExists'), 422);
        }
    }
}
