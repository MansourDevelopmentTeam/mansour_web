<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class ProductVariant extends Model
{
    protected $hidden =['pivot'];
    protected $fillable = ["sku", "price", "quantity", "default", "option_id","product_id","created_by"];
    public static $validation = [
        "sku" => "required|string",
        "price" => "required|integer",
        "quantity" => "required|integer",
        "default" => "required|in:0,1",

        "option_id" => "required|exists:options,id",
        "value_id" => "required|exists:option_values,id",
        "product_id" => "required|exists:products,id",
        "created_by" => "required|exists:users,id"
    ];
    public function product_variant_values(){
        return $this->hasMany(ProductVariantValue::class,'product_variant_id','id');
    }
    public function images(){
        return $this->hasMany(ProductVariantImage::class,'product_variant_id','id');
    }

    public function options()
    {
        return $this->belongsToMany(Option::class, ProductVariantValue::class, 'product_variant_id', 'option_id');
    }

    public function values()
    {
        return $this->belongsToMany(OptionValue::class, ProductVariantValue::class, 'product_variant_id', 'value_id');
    }

    public function joinValues()
    {
      return  $this->leftjoin('product_variant_values', 'product_variant_values.product_variant_id', '=', 'product_variants.id')
          ->join('options', 'options.id', '=', 'product_variant_values.option_id')
          ->join('option_values', 'option_values.id', '=', 'product_variant_values.value_id')
          ->select('options.*')
          ->select('option_values.*')
          ->distinct()
          ->get();
    }

    public function optionsWithValues()
    {
//        $options = $this->optionValues;
        $optionValues = $this->values;
        $Mainarray = [];
        foreach ($optionValues as $optionValue) {
            $option =  Option::where('id',$optionValue->option_id)->first();
            $optionObject = app()->make('stdClass');
            $optionObject->option = $option;
            $optionObject->value = $optionValue;
            array_push($Mainarray,$optionObject);
        }
        return $Mainarray;
    }


    public function test(){

    }







}
