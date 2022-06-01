<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Group extends Model
{
    protected $hidden =['pivot'];
    protected $appends = ['link'];
    protected $fillable = ["name_en", "name_ar", "image", "description_en", "description_ar", "active","slug","order"];
    protected $casts = [
        'active' => 'integer',
    ];
    public static $validation = [
        "name_en" => "required|string",
        "name_ar" => "required|string",
        "description_en" => "required|string",
        "description_ar" => "required|string",
        "slug" => "sometimes|nullable|string",
        "image" => "sometimes|nullable|string",
        "active" => "sometimes|nullable|boolean",
        "order" => "sometimes|nullable|integer",

    ];

    public function getName($lang = 1)
    {
        if ($lang == 2) {
            return $this->name_ar ?: $this->name_en;
        }
        return $this->name_en;
    }

    public function getDescription($lang = 1)
    {
        if ($lang == 2) {
            return $this->description_ar ?: $this->description_en;
        }

        return $this->description_en;
    }

    public function sub_categories()
    {
        return $this->belongsToMany(Category::class, SubCategoryGroup::class, 'group_id', 'sub_category_id')->with('parent');
    }
    public function active_sub_categories()
    {
        return $this->belongsToMany(Category::class, SubCategoryGroup::class, 'group_id', 'sub_category_id')->where('active',1)->with('parent');
    }

    public function category()
    {
        return $this->belongsToMany(Category::class, SubCategoryGroup::class, 'group_id', 'category_id')->where('active',1);
    }

    public function subcategories()
    {
        return $this->belongsToMany(Category::class, 'sub_category_groups', 'group_id', 'sub_category_id');
    }

    public function getLinkAttribute()
    {
        return '/products?group_id=' . $this->id;
    }
}
