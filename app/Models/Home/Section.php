<?php

namespace App\Models\Home;

use App\Models\Products\Lists;
use App\Models\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use App\Models\Transformers\ProductFullTransformer;

class Section extends Model
{
    const CUSTOM_LIST_TYPE = 0;
    const MOST_RECENT_TYPE = 1;
    const MOST_BOUGHT_TYPE = 2;
    const DISCOUNT_TYPE = 3;

    const IMAGE_TYPE_NO_IMAGE = 1;
    const IMAGE_TYPE_SINGLE = 2;
    const IMAGE_TYPE_MULTIPLE = 3;
    const IMAGE_TYPE_WIDE = 4;

    // protected $appends =['items'];
    protected $fillable = [
        "list_id",
        "active",
        "order",
        "name_en",
        "name_ar",
        "image_en",
        "image_ar",
        "description_ar",
        "description_en",
        "type",
        "image_type"
    ];
    public static $validation = [
        "list_id" => "required_if:type,0|integer|exists:lists,id",
        // "active" => "required|in:0,1",
        "order" => "required|integer",
        "name_en" => "required|string",
        "name_ar" => "required|string",
        "description_ar" => "required|string",
        "description_en" => "required|string",
        "images" => "required_unless:image_type,1|array",
        "type" => "required|integer|in:0,1,2,3",
        "image_type" => "required|integer|in:1,2,3",
    ];
    // type 0 =  to select from lists
    // type 1 =  MostRecent
    // type 2 =  MostBought
    // type 3 =  Discounted(

    protected $casts = [
        'active' => 'integer',
    ];

    public function list()
    {
        return $this->belongsTo(Lists::class);
    }

    /**
     * Get all of the images for the Section
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(SectionImage::class);
    }

    public function products()
    {
        if ($this->type == 0) {
            $products = $this->list->products;
        }
        // elseif ($this->type == 1) {
        //     $products = $productRepo->getMostRecent();
        // } elseif ($this->type == 2) {
        //     $products = $productRepo->getMostBought();
        // } elseif ($this->type == 3) {
        //     $products = $productRepo->getDiscounted();
        // }
        return $products;
    }
    /**
     * Get ten products variant
     *
     * @return void
     */
    public function TenProductsVariant()
    {
        $products = $this->list->availableProducts()
                ->with(["productVariants" => function ($query) {
                    $query->with('images')->active();
                }])
                ->active()
                ->orderBy("order", "ASC")
                ->take(10)
                ->get();

        $products = $products->map(function ($item) {
            return ($item->parent_id ? $item : $item->productVariants()->orderBy("stock", "DESC")->first());
        });

        return $products;
    }

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
