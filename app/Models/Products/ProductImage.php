<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class ProductImage extends Model
{

	protected $fillable = ["url"];
    protected $appends = ['thumbnail'];
	protected $hidden = ["created_at", "updated_at"];


    public function getUrlAttribute()
    {
        if(isset($this->attributes["url"])){
            $image = explode("/", $this->attributes["url"]);
            $name = array_pop($image);
            $image = implode("/", $image) . "/" . rawurlencode($name);

            if(preg_match("/https?:\/\//", $this->attributes["url"])) {
                return $image;
            }

            return URL::to('') . "/" . $image;
        }
    }

    public function getThumbnailAttribute()
    {
        $imgArr = explode('/', $this->attributes["url"]);
        $last = end($imgArr);
        array_pop($imgArr);
        $imgArr[] = 'thumbnails';
        $imgArr[] = $last;
        if(Storage::disk('public')->exists("uploads/thumbnails/{$last}")) {
            return implode('/', $imgArr);
        }
        return $this->attributes["url"];
    }
}
