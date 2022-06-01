<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class ProductVariantValue extends Model
{

    protected $fillable = ["option_id", "value_id", "product_id", "product_variant_id","created_by"];
    public static $validation = [

        "option_id" => "required|exists:options,id",
        "value_id" => "required|exists:option_values,id",
        "product_id" => "required|exists:products,id",
        "product_variant_id" => "required|exists:product_variants,id",
        "created_by" => "required|exists:users,id"
    ];




//    public function optionValues()
//    {
//        return $this->belongsToMany(OptionValue::class, ProductVariantValue::class, 'product_variant_id', 'value_id');
//    }
//    public function optionsWithVlues()
//    {
////        $options = $this->optionValues;
//        $optionValues = $this->optionValues;
//        $Mainarray = [];
//        foreach ($optionValues as $optionValue) {
//            $option =  Option::where('id',$optionValue->option_id)->first();
//            $optionObject = app()->make('stdClass');
//            $optionObject->option = $option;
//            $optionObject->value = $optionValue;
//            array_push($Mainarray,$optionObject);
//        }
//        return $Mainarray;
//    }

}
