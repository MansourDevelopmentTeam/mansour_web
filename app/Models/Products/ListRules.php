<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class ListRules extends Model
{

    protected $fillable = ["field", "condition","value","type","item_id","list_id"];
    public static $validation = [
        "field" => "sometimes|nullable|string",
        "condition" => "sometimes|nullable|integer|in:1,2,3,4,5,6",
        "value" => "sometimes|nullable|string",
        "type" => "sometimes|nullable|in:1,2,3,4,5|integer",
        "lists_id" => "required|integer|exists:lists,id",
        "item_id" => "required|integer|exists:products,id",
    ];

}
