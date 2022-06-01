<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use App\Models\Products\Option;

class OptionValue extends Model
{
//    protected $appends =['option'];
    protected $hidden =['pivot'];
    protected $fillable = ["name_en", "name_ar", "image","color_code", "option_id", "active","created_by"];
    protected $casts = [
        'active' => 'integer',
    ];
    public static $validation = [
        "name_en" => "required|string",
        "name_ar" => "required|string",
        "image" => "sometimes|nullable|string",
        "color_code" => "sometimes|nullable|string",
        "active" => "sometimes|nullable|in:0,1",
    ];

    public function option(){
      return  $this->belongsTo(Option::class,'option_id','id');
    }
    public function getName($lang = 1)
    {
        if ($lang == 2) {
            return $this->name_ar ?: $this->name_en;
        }
        return $this->name_en;
    }
}
