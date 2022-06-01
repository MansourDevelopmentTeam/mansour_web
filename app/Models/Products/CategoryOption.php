<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class CategoryOption extends Model
{

    protected $fillable = ["sub_category_id", "option_id","created_by"];
    public static $validation = [
        "sub_category_id" => "required|integer",
        "option_id" => "required|integer",
    ];

    public function option()
    {
        $data = $this->belongsTo(Option::class, 'option_id', 'id')->getChild('values');
// $data->with('values');
        return $data;
    }



}
