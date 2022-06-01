<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Tag extends Model
{
    protected $hidden =['pivot'];
    protected $fillable = ["name_en", "name_ar","image","description_en","description_ar","status"];
    protected $casts = [
        'status' => 'integer',
    ];
    public static $validation = [
        "name_en" => "required|string",
        "name_ar" => "required|string",
        "description_en" => "required|string",
        "description_ar" => "required|string",
        "status" => "sometimes|nullable|in:0,1",
    ];

}
