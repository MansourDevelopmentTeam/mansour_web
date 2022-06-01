<?php

namespace App\Models\Products;

use App\Http\Resources\Customer\CategoryResource;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;

class Category extends Model
{
    // use SoftDeletes;
    protected $hidden = ['pivot'];
    protected $appends = ['link'];
    protected $fillable = ["name", "name_ar", "parent_id", "description", "description_ar", "image", "active", "order", "created_by", "slug", 'ex_rate_pts', 'ex_rate_egp', 'payment_target', 'family_id'];

    public static $validation = [
        "sub_categories" => "required|array"
    ];

    public function subCategories()
    {
        return $this->hasMany(self::class, "parent_id")->with('options');
    }

    public function activeSubCategories()
    {
        return $this->hasMany(self::class, "parent_id")->with('options')->where('active', 1);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, "parent_id");
    }

    public function group()
    {
        return $this->belongsToMany(Group::class, SubCategoryGroup::class, 'sub_category_id', 'group_id');
    }

    public function groupSubCategory()
    {
        return $this->hasMany(SubCategoryGroup::class);
    }

    public function getGroupNameAttribute()
    {
        $attribute = '';
        if ($this->group) {
            $attribute = $this->group()[0]->name_en;
        }
        return $attribute;
    }

    public function mainCategoryGroups()
    {
        return $this->belongsToMany(Group::class, "sub_category_groups", 'category_id', 'group_id');
    }

    public function activeMainCategoryGroups()
    {
        return $this->belongsToMany(Group::class, "sub_category_groups", 'category_id', 'group_id')->where('active', 1);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function options()
    {
        return $this->belongsToMany(Option::class, CategoryOption::class, 'sub_category_id', 'option_id')->with('values');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, "created_by");
    }

    public function getName($lang = 1)
    {
        if ($lang == 2) {
            return $this->name_ar ?: $this->name;
        }
        return $this->name;
    }

    public function getDescription($lang = 1)
    {
        if ($lang == 2) {
            return $this->description_ar ?: $this->description;
        }

        return $this->description;
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

    public function getProductCount()
    {
        return $this->subCategories->reduce(function ($carry, $item) {
            return $carry + $item->products->count();
        });
    }

    public function homeGroups($lang = 1)
    {
        $array = [];
        $subCatIds = [];
        $createdGroupsIDS = [];
        $activeMainCategoryGroups = $this->activeMainCategoryGroups()->orderBy("order", "DESC")->get();
        foreach ($activeMainCategoryGroups as $group) {
            if (!in_array($group->id, $createdGroupsIDS)) {
                $group = [
                    'id' => $group->id,
                    'name' => $group->name_en, //$group->getName($lang),
                    'name_en' => $group->name_en, //$group->getName($lang),
                    'name_ar' => $group->name_ar, //$group->getName($lang),
                    'description_en' => $group->description_en,
                    'description_ar' => $group->description_ar,
                    'name' => $group->name_en, //$group->getName($lang),
                    'description' => $group->getDescription($lang),
                    'image' => $group->image,
                    'order' => $group->order,
                    'sub_categories' => CategoryResource::collection($group->active_sub_categories()->orderBy("order", "ASC")->get()),
                ];
                $array[] = $group;
                $createdGroupsIDS[] = $group["id"];
            }
        }

        $subCategories = $this->activeSubCategories()->with("subCategories")->whereDoesntHave("group")->orderBy("order", "ASC")->get();
        if (count($subCategories) > 0) {
            $group = [
                "id" => $this->id,
                "name" => "General",
                "description" => "General",
                "image" => $this->image,
                "sub_categories" => CategoryResource::collection($subCategories)
            ];
            $array[] = $group;
        }
        return array_reverse($array);
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeSubCategories($query)
    {
        return $query->whereNotNull('parent_id');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'sub_category_groups', 'category_id', 'group_id')->distinct();
    }

    public function getLinkAttribute()
    {
        if($this->parent_id) {
            return '/products?category_id=' . $this->parent_id . "&sub_category_id=" . $this->id;
        } else {
            return '/products?category_id=' . $this->id;
        }
    }
}
