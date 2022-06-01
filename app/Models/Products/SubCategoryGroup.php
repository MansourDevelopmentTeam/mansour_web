<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class SubCategoryGroup extends Model
{

    protected $fillable = ["group_id","category_id", "sub_category_id"];
    public static $validation = [
        "group_id" => "required|exist:groups,id",
        "category_id" => "required|exist:categories,id",
        "sub_category_id" => "required|exist:categories,id,parent_id,null",
    ];





}
