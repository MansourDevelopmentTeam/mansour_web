<?php

namespace App\Models\Orders\Validation\Rules;

use App\Models\Orders\Validation\ValidationError;
use App\Models\Users\Address;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Lang;

class RequiredFields implements RulesInterface
{
    public $order_data;
    public function __construct($order_data)
    {
        $this->order_data = $order_data;
    }

    public function validate()
    {
        $fields = [
            //'device_type'
        ];
        foreach ($fields as $field) {
            if(!array_key_exists($field, $this->order_data)) {
                return new ValidationError("{$field} field is required", 423);
            }
        }
    }
}
