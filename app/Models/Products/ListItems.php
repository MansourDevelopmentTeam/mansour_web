<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class ListItems extends Model
{

    protected $fillable = ["list_id", "item_id"];
    public static $validation = [
        "list_id" => "required|integer|exists:lists,id",
        "item_id" => "required|integer",
    ];

}
