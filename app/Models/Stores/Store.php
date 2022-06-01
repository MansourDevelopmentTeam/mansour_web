<?php

namespace App\Models\Stores;

use App\Trolley\Products\Lists;
use App\Trolley\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use App\Trolley\Transformers\ProductFullTransformer;

class Store extends Model
{
    protected $fillable = [
        "phone",
        "name_en",
        "name_ar",
        "description_ar",
        "description_en",
        "image_en",
        "image_ar",
        "address",
        "lat",
        "long",
        "type",
        "active",
    ];
    public static $validation = [
        "phone" => "sometimes|nullable",
        "type" => "sometimes|nullable|string",
        "active" => "sometimes|nullable|in:0,1",
        "name_en" => "required|string",
        "name_ar" => "required|string",
        "description_ar" => "required|string",
        "description_en" => "required|string",
        "image_en" => "sometimes|nullable|string",
        "image_ar" => "sometimes|nullable|string",
        'address' => 'required|string',
        'lat' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
        'long' => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
    ];
    protected $casts = [
        'active' => 'integer',
    ];

    public function getName()
    {
        if (request()->header('lang') == 2) {
            return $this->name_ar ?: $this->name_en;
        }
        return $this->name_en;
    }
    public function getDescription()
    {
        if (request()->header('lang') == 2) {
            return $this->description_ar ?: $this->description_en;
        }
        return $this->description_en;
    }
    public function getImage()
    {
        if (request()->header('lang') == 2) {
            return $this->image_ar ?: $this->image_en;
        }
        return $this->image_en;
    }
}
