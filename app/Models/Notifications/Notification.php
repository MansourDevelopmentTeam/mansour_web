<?php

namespace App\Models\Notifications;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    
    protected $fillable = ["title", "body","title_ar", "body_ar", "user_id", "type", "item_id", "image","details", "item_link"];

    const ORDERTYPE = 1;

    const TYPE_GENERAL = 1;
    const TYPE_PRODUCT = 2;
    const TYPE_BRAND = 3;
    const TYPE_CATEGORY = 4;
    const TYPE_ORDER = 5;
    const TYPE_SUBCATEGORY = 6;
    const TYPE_LIST = 7;

    public function getDetailsAttribute($value) {
        $attribute = $value ;
        if ($this->type == 10){
            $attribute = json_decode($value);
        }elseif ($this->type == 11){
            $attribute =["link"=>$value];
        }
        return $attribute;
    }
}
