<?php

namespace App\Models\Products;

use App\Models\Products\Option;
use Illuminate\Support\Facades\URL;
use App\Models\Products\OptionValue;
use Illuminate\Database\Eloquent\Model;

class ProductOptionValues extends Model
{

    protected $fillable = ["product_id", "option_id","value_id","image","input_en","input_ar","type"];
    public static $validation = [
        "product_id" => "required|integer",
        "option_id" => "required|integer",
        "value_id" => "required|integer",
        "image" => "sometimes|nullable|string",
        "type" => "sometimes|nullable|in:0,1",
        "input_en" => "sometimes|nullable|string",
        "input_ar" => "sometimes|nullable|string",
    ];
    public function getInput($lang = 1)
    {
        if ($lang == 2) {
            return $this->input_ar ?: $this->input_en;
        }
        return $this->input_en;
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function value()
    {
        return $this->belongsTo(OptionValue::class);
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
