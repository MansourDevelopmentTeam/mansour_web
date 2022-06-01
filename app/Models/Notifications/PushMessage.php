<?php

namespace App\Models\Notifications;

use App\Models\Products\Product;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class PushMessage extends Model
{
    
    protected $fillable = ["creator_id", "title", "body", "image", "product_id"];

    public function creator()
    {
        return $this->belongsTo(User::class, "creator_id");
    }

    public function product()
    {
        return $this->belongsTo(Product::class, "product_id");
    }

    public function getImageAttribute()
    {
        if (isset($this->attributes["image"])) {
            $image = explode("/", $this->attributes["image"]);
            $name = array_pop($image);
            $image = implode("/", $image) . "/" . rawurlencode($name);

            if (preg_match("/https?:\/\//", $this->attributes["image"])) {
                return $image;
            }

            return URL::to('') . "/" . $image;
        }
    }
}
