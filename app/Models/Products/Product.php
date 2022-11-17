<?php

namespace App\Models\Products;

use App\Models\Payment\Promotion\Promotion;
use App\Models\Payment\Promotion\PromotionConditions;
use App\Models\Payment\Promotion\PromotionTargets;
use App\Models\Users\User;
use TeamTNT\TNTSearch\TNTSearch;
use Illuminate\Support\Facades\DB;
use App\Models\Orders\OrderProduct;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment\PaymentMethod;
use App\Models\Products\ProductPrice;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Products\SearchableTrait as Searchable;

class Product extends Model
{
    use SoftDeletes, Searchable;

    const REGULAR = 1;
    const TYPE_BUNDLE = 2;

    protected $hidden = ['pivot'];
    protected $appends = ['variants_stock_count'];

    protected $fillable = ["name", "name_ar", "description", "meta_title", "meta_description", "meta_title_ar", "meta_description_ar", "keywords", "description_ar", "image", "brand_id", "price","price_ws","category_id", "optional_sub_category_id", "discount_price", "discount_start_date", "discount_end_date", "creator_id", "sku", "stock", "stock_alert", "rate", "long_description_ar", "long_description_en", "active","default_variant","parent_id", "max_per_order", "min_days","order", "barcode", "subtract_stock", "option_default_id", "weight", "preorder", "preorder_start_date", "preorder_end_date", "preorder_price", "type","video","available_soon","last_editor","bundle_checkout", "has_stock", "downloadable_url", "downloadable_label", "affiliate_commission", "free_delivery", 'prod_id',
        'tax_percentage',
        'fix_tax'
    ];
    // protected $appends = ["price"];

    protected $casts = [
        'free_delivery' => 'boolean',
    ];

    public static $mainProductValidation = [
        "category_id" => "required|exists:categories,id",
        "optional_sub_category_id" => "sometimes|nullable|exists:categories,id",
        "brand_id" => "sometimes|nullable|exists:brands,id",
        "order" => "sometimes|nullable|integer",
        "active" => "sometimes|nullable",
        "video" => "sometimes|nullable",
        "available_soon" => "sometimes|nullable",
        "downloadable_url" => "sometimes|nullable",
        "downloadable_label" => "sometimes|nullable",
        "preorder" => "sometimes|boolean",
        "preorder_start_date" => "sometimes",
        "preorder_end_date" => "sometimes",
        "max_per_order" => "sometimes|nullable",
        "min_days" => "sometimes|nullable",
        "stock_alert" => "sometimes|nullable|integer",
        "name" => "required",
        "name_ar" => "required",
        "type" => "required",
        "has_stock" => "sometimes|nullable",
        "bundle_checkout" => "sometimes|nullable",
        "affiliate_commission" => "sometimes|nullable",
    ];

    public static $validation = [
        "category_id" => "required|exists:categories,id",
        "optional_sub_category_id" => "exists:categories,id",
        "brand_id" => "sometimes|nullable|exists:brands,id",
        "order" => "sometimes|nullable|integer",
        "active" => "sometimes|nullable",
        "video" => "sometimes|nullable",
        "available_soon" => "sometimes|nullable",
        "meta_title" => "sometimes|nullable",
        "meta_title_ar" => "sometimes|nullable",
        "meta_description" => "sometimes|nullable",
        "meta_description_ar" => "sometimes|nullable",
        "bundle_checkout" => "sometimes|nullable|in:0,1",
        "preorder" => "sometimes|boolean",
        "preorder_start_date" => "sometimes|nullable",
        "preorder_end_date" => "sometimes|nullable",
        "max_per_order" => "sometimes|nullable",
        "min_days" => "sometimes|nullable",
        "name" => "required",
        "name_ar" => "required",

        "description" => "required",
        "description_ar" => "required",
        "long_description_en" => "required",
        "long_description_ar" => "required",
        "image" => "required",
        "images" => "required|array",
        "tags.*" => "required|exists:product_tags,id",
        "price" => "sometimes|nullable|integer",
        "affiliate_commission" => "sometimes|nullable",
        "preorder_price" => "sometimes|integer",
        "stock" => "required|numeric",
        "stock_alert" => "sometimes|nullable|integer",
        "type" => "sometimes|nullable|in:1,2",
        "bundle_products_ids" => "required_if:type,2|array|filled",
        "weight" => "sometimes|nullable",
        "barcode" => "sometimes|nullable|string",
        "subtract_stock" => "sometimes|nullable|boolean",
        "discount_price" => "sometimes|nullable|integer",


        "option_default_id" => "required|exists:options,id",


        "product_variants" => "sometimes|nullable|array",

        "option_values.*.option_id" => "sometimes|nullable|integer|exists:options,id",
        "option_values.*.option_value.*.id" => "sometimes|nullable|integer",

        "product_variants.*.price" => "sometimes|nullable|integer",
        "product_variants.*.discount_price" => "sometimes|nullable|integer",
        "product_variants.*.stock" => "sometimes|nullable|numeric",
        "product_variants.*.stock_alert" => "sometimes|nullable|integer",
        "product_variants.*.default_variant" => "sometimes|nullable|boolean",
        "product_variants.*.image" => "sometimes|nullable|string",
        "product_variants.*.variant_image" => "sometimes|nullable|string",
        "product_variants.*.images" => "sometimes|nullable|array",
        "product_variants.*.options.*.option_id" => "sometimes|nullable|integer|exists:options,id",
        "product_variants.*.options.*.option_value_id" => "sometimes|nullable|integer|exists:option_values,id",

    ];

    protected $searchable = [
        'name',
        'name_ar',
        // 'description',
        // 'description_ar'
    ];

    public $tntSearchable = ['id', 'name', 'name_ar'];

    protected static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            self::tnt()->getIndex()->insert($model->only($model->tntSearchable));
        });
        static::updated(function ($model) {
            self::tnt()->getIndex()->update($model->id, $model->only($model->tntSearchable));
        });
    }

    public function pivotOptions()
    {
        return $this->hasMany(ProductOptionValues::class);
    }

    public function bundleProduct()
    {
        return $this->belongsToMany(Product::class, ProductBundles::class, 'bundle_id', 'product_id');
    }

    public function paymentMethods()
    {
        return $this->belongsToMany(PaymentMethod::class);
    }


    public function getPaymentMethodsDiscountNameEnAttribute($value)
    {
        if($this->paymentMethods->isNotEmpty() && !is_null($this->discount_price)){
            return 'Discount applicable on payment methods ' . $this->paymentMethods->implode('name', ', ');
        }
        return null;
    }
    public function getIsActiveAttribute($value)
    {
        $active = false;

        if($this->active && $this->parent->active){
            if($this->active){
                $active = true;
            }
        }
        return $active;
    }

    public function getPaymentMethodsDiscountNameArAttribute($value)
    {
        if($this->paymentMethods->isNotEmpty() && !is_null($this->discount_price)){
            return 'هذا الخصم يطبق فقط على ' . $this->paymentMethods->implode('name_ar', ', ');
        }
        return null;
    }

    public static function tnt()
    {
        $tnt = new TNTSearch;
        $tnt->loadConfig(config('tnt'));

        $tnt->selectIndex("product.index");
        return $tnt;
    }

    public function getVariantsStockCountAttribute()
    {
        $attribute = 0;

        $variants = $this->availableProductVariants;
        if ($this->parent_id == null){
            $attribute = $variants->sum('stock');
        }else{
            $attribute = $this->stock;
        }

        return $attribute;
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function relatedSkus()
    {
        return $this->hasMany(ProductSku::class);
    }

    public function relatedProducts()
    {
        return $this->belongsToMany(Product::class, "product_skus", "product_id", "sku", "id", "sku");
    }

    public function allRates()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function approvedRates()
    {
        return $this->hasMany(ProductReview::class)->where('status','1');
    }

    public function ratesApprovedAvg()
    {
        $approvedRates = $this->approvedRates->avg('rate');
        return round($approvedRates);
    }

    public function productVariants()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function availableProductVariants()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')->where('stock','>',0);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function lists()
    {
        return $this->belongsToMany(Lists::class, ListItems::class, 'item_id', 'list_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, ProductTag::class, 'product_id', 'tag_id');
    }

    public function allOptions()
    {
        return $this->belongsToMany(Option::class, ProductOptionValues::class, 'product_id', 'option_id');
    }

    public function allOptionValues()
    {
        return $this->belongsToMany(OptionValue::class, ProductOptionValues::class, 'product_id', 'value_id');
    }

    public function ProductOptionValues()
    {
        return $this->belongsToMany(OptionValue::class, ProductOptionValues::class, 'product_id', 'value_id')->where('product_option_values.type', '0');
    }

    public function productOptionValuesForFilter()
    {
        return $this->belongsToMany(OptionValue::class, ProductOptionValues::class, 'product_id', 'value_id')->where('product_option_values.value_id', '!=', null);
    }

    public function productOptions()
    {
        return $this->belongsToMany(Option::class, ProductOptionValues::class, 'product_id', 'option_id')->where('product_option_values.type', '0');
    }

    public function productVariantOptions()
    {
        return $this->belongsToMany(Option::class, ProductOptionValues::class, 'product_id', 'option_id')->where('product_option_values.type', '1');
    }

    public function productVariantValues()
    {
        return $this->belongsToMany(OptionValue::class, ProductOptionValues::class, 'product_id', 'value_id')->where('product_option_values.type', '1');
    }

    public function defaultOptionValue()
    {
        return $this->hasOne(ProductOptionValues::class)->where("option_id", $this->option_default_id);
    }

    public function optionValues()
    {
        return $this->hasMany(ProductOptionValues::class);
    }

    public function variantOptions()
    {
        return $this->hasManyThrough(ProductOptionValues::class, Product::class, "parent_id", "product_id");
    }

    public function customerAttributesWithVlues($brand = null)
    {
        $options = $this->productOptions->sortBy('order')->filter(function ($option) {
            return $option->appear_on_product_details != 0;
        });
        $Mainarray = [];
        foreach ($options as $option) {
            if($option->active == 1) {
                if ($option->type == 5){
                    $productOptionValues = ProductOptionValues::where('product_id',$this->id)->where('option_id',$option->id)->first();
                    $Mainarray[] = [
                        "option" => $option->getName(request()->header('lang')),
                        "option_order" => $option->order,
                        "value" => !empty($productOptionValues->getInput(request()->header('lang'))) ?  $productOptionValues->getInput(request()->header('lang')) : null
                    ];
                }else{
                    $optionValues = $this->ProductOptionValues()->where('option_values.option_id',$option->id)->get();
                    foreach ($optionValues as $optionValue){
                        $Mainarray[] = [
                            "option" => $option->getName(request()->header('lang')),
                            "value" => !empty($optionValue->getName(request()->header('lang'))) ? $optionValue->getName(request()->header('lang')) : null
                        ];
                    }
                }
            }
        }
        return collect($Mainarray)->reject(function ($attr) {
            return $attr['value'] == null;
        })->values()->toArray();
    }

    public function adminAttributesWithVlues()
    {
        $options = $this->productOptions;
        $Mainarray = [];
        foreach ($options as $option) {
            if ($option->type == 5){
                $productOptionValues = ProductOptionValues::where('product_id',$this->id)->where('option_id',$option->id)->first();
                $Mainarray[] = [
                    "option" => $option,
                    "value" => [
                        "id" => null,
                        "input_ar" => $productOptionValues->input_ar,
                        "input_en" => $productOptionValues->input_en
                    ],
                ];
            }else{
                $optionValues = $this->ProductOptionValues()->where('option_values.option_id',$option->id)->get();
                foreach ($optionValues as $optionValue){
                    $Mainarray[] = [
                        "option" => $option,
                        "value" => $optionValue
                    ];
                }
            }
        }
        return $Mainarray;
    }

    public function fullVariantOptionsLists()
    {

        $mainArray = [];
        $options = $this->productVariantOptions->unique();
        $valuesIDS = $this->productVariantValues->pluck('id')->unique();
        foreach ($options as $option) {
            $data = [];
            $values = [];
            if ($this->parent_id != null) {
                $parent = Product::find($this->parent_id);
                $option->default = $parent->option_default_id == $option->id ? true : false;
            } else {
                $option->default = $this->option_default_id == $option->id ? true : false;
            }
            $data['option'] = $option;

            $optionValues = OptionValue::whereIn('id', $valuesIDS)->where('option_id', $option->id)->get();
            if (count($optionValues) > 0){
                foreach ($optionValues as $optionValue) {
                    if ($option->type == 4) {
                        $variantOptionValues = ProductOptionValues::where('product_id', $this->id)->where('type', '1')->where('option_id', $option->id)->where('value_id', $optionValue->id)->first();
                        $optionValue->image = $variantOptionValues->image;
                    } elseif ($option->type == 5) {
                        $variantOptionValues = ProductOptionValues::where('product_id', $this->id)->where('type', '1')->where('option_id', $option->id)->where('value_id', $optionValue->id)->first();
                        $optionValue->input_en = $variantOptionValues->input_en;
                        $optionValue->input_ar = $variantOptionValues->input_ar;
                    }
                    $values[] = $optionValue;
                }
            }else{
                $optionValue = new \stdClass();
                if ($option->type == 5) {
                    $variantOptionValues = ProductOptionValues::where('product_id', $this->id)->where('type', '1')->where('option_id', $option->id)->first();
                    $optionValue->input_en = $variantOptionValues->input_en;
                    $optionValue->input_ar = $variantOptionValues->input_ar;
                    $values[] = $optionValue;
                }

            }

            $data['values'] = $values;

            $mainArray[] = $data;
        }
        return $mainArray;
    }

    public function getDecodedImages()
    {
         $cacheKey = "product_images_{$this->id}";
         if (Cache::has($cacheKey)) {
            $images = Cache::get($cacheKey);
         } else {
            $images = $this->images->toArray();
            Cache::put($cacheKey, $images, 3600);
         }

        return $images;
    }

    public function getThumbnailAttribute()
    {
        if(isset($this->attributes["image"])) {
            $imgArr = explode('/', $this->attributes["image"]);
            $last = end($imgArr);
            array_pop($imgArr);
            $imgArr[] = 'thumbnails';
            $imgArr[] = $last;
            if(Storage::disk('public')->exists("uploads/thumbnails/{$last}")) {
                return implode('/', $imgArr);
            }
        }
        return $this->image;
    }

    public function getAdminVariantOptionsList($variants)
    {

        $optionsLists = [];
        foreach ($variants as $variant) {

            $optionValues = $variant->fullVariantOptionsLists();

            foreach ($optionValues as $optionValue) {

                $result = array_filter($optionsLists, function ($item) use ($optionValue) {
                    return $item["option"]["name_en"] == $optionValue["option"]["name_en"];
                });
                if (count($result)) {
                    // option exist
                    foreach ($optionsLists as $key => $optionsList) {

                        if ($optionsList["name"] == $optionValue["option"]["name"]) {

                            $result = array_filter($optionsLists[$key]["values"], function ($item) use ($optionValue) {

                                return $item["name_en"] == $optionValue["values"][0]["name_en"];
                            });
                            if (count($result) == 0) {

//                                dd($optionsLists[$key]["values"],$optionValue["values"][0]);
//                                dd($optionsLists[$key]['values'][]);
                                $optionsLists[$key]["values"] = $optionValue["values"][0];
                            }
                        }
                    }

                } else {
                    $value = $optionValue['values'];
                    unset($optionValue['values']);
                    $optionValue['option']['values'] = $value;
                    // option does not exist
                    $optionsLists[] = $optionValue['option'];

                }
            }
        }
        return $optionsLists;
    }

    public function getVariantOptionsList($variants)
    {

        $optionsLists = [];
        foreach ($variants as $variant) {
            $optionValues = $variant->customerVariantOptionsLists(request()->header('lang'));

            $optionValues = array_filter($optionValues, function ($item) {
                return count($item["values"]);
            });


            foreach ($optionValues as $optionValue) {
                $result = array_filter($optionsLists, function ($item) use ($optionValue) {
                    return $item["option"]["name"] == $optionValue["option"]["name"];
                });
                if (count($result)) {
                    // option exist
                    foreach ($optionsLists as $key => $optionsList) {
                        if ($optionsList["option"]["name"] == $optionValue["option"]["name"]) {
                            $result = array_filter($optionsLists[$key]["values"], function ($item) use ($optionValue) {
                                return $item["name"] == $optionValue["values"][0]["name"];
                            });
                            if (count($result) == 0) {
                                if (!isset( $optionsLists[$key]["values"][0]['product_ids'])) {
                                    $optionsLists[$key]["values"][0]['product_ids'] = [];
                                }
                                array_push($optionsLists[$key]['values'][0]['product_ids'],$variant->id);
                                $optionsLists[$key]["values"][] = $optionValue["values"][0];
                            }else{
                                if (!isset($optionsLists[$key]["values"][0]['product_ids'])) {
                                    $optionsLists[$key]["values"][0]['product_ids'] = [];
                                }
                                array_push($optionsLists[$key]["values"][0]['product_ids'],$variant->id);
                            }
                        }
                    }
                } else {
                    // option does not exist
                    if (!isset($optionValue['values'][0]['product_ids'])) {
                        $optionValue['values'][0]['product_ids'] = [];
                    }
                    array_push($optionValue['values'][0]['product_ids'],$variant->id);
                    $optionsLists[] = $optionValue;
                }
            }
        }
        return collect($optionsLists)->sortBy('option.order')->values()->toArray();
    }

    public function customerVariantOptionsLists($lang = 1)
    {
        $mainArray = [];
       $cacheKey = 'product_' . $this->id . '_' . $lang . '_options';
       if (Cache::has($cacheKey)) {
        //    Log::info("CACHE HIT");
           $mainArray = Cache::get($cacheKey);
       } else {
        //    Log::info("CACHE MISS: " . $cacheKey);
            $options = $this->productVariantOptions->unique();
            $valuesIDS = $this->productVariantValues->pluck('id')->unique();
            foreach ($options as $option) {
                $data = [];
                $values = [];
                // if ($this->parent_id != null) {
                //     $parent = Product::find($this->parent_id);
                //     $default = $parent->option_default_id == $option->id ? true : false;
                // } else {
                //     $default = $this->option_default_id == $option->id ? true : false;
                // }
                $default = $this->option_default_id == $option->id ? true : false;
                $data['option'] = [
                    'id' => $option->id,
                    'name' => $option->getName($lang),
                    'description' => $option->getDescription($lang),
                    'type' => $option->type,
                    'default' => $default,
                    'order' => $option->order
                ];
                $optionValues = OptionValue::whereIn('id', $valuesIDS)->where('option_id', $option->id)->get();
                foreach ($optionValues as $optionValue) {
                    $image = null;
                    if ($option->type == 4) {
                        $variantOptionValues = ProductOptionValues::where('product_id', $this->id)->where('type', '1')->where('option_id', $option->id)->where('value_id', $optionValue->id)->first();
                        $image = $variantOptionValues->image;
                    } elseif ($option->type == 5) {
                        $variantOptionValues = ProductOptionValues::where('product_id', $this->id)->where('type', '1')->where('option_id', $option->id)->where('value_id', $optionValue->id)->first();
                        $input = $variantOptionValues->getInput($lang);
                    }
                    $values[] = [
                        'id' => $optionValue->id,
                        'name' => $optionValue->getName($lang),
                        'image' => $image,
                        'color_code' => ($option->type == 2 || $option->type == 4)  ? $optionValue->color_code : null,
                    ];
                    isset($values['input']) ? $values['input'] = $input : '';
                }

                $data['values'] = $values;

                $mainArray[] = $data;
            }
        //    Log::info("ADDING TO CACHE");
           Cache::put($cacheKey, $mainArray, 3600);
       }

        usort($mainArray, function ($item, $compare) {
            return $item['option']['default'] <= $compare['option']['default'];
        });
        return $mainArray;
    }

    public function optionsWithVlues()
    {
        // $options = $this->optionValues;
        $optionValues = $this->ProductOptionValues;
        $Mainarray = [];
        foreach ($optionValues as $optionValue) {
            $option = Option::where('id', $optionValue->option_id)->first();
            $optionObject = app()->make('stdClass');
            $optionObject->option = $option;
            $optionObject->value = $optionValue;
            array_push($Mainarray, $optionObject);
        }

        return $Mainarray;
    }

    public function getOptionsWithValues($lang = 1)
    {
        $optionsWithVlues = $this->ProductOptionValues();
        $finalData = [];
        foreach ($optionsWithVlues as $optionsWithVlue) {
            if ($optionsWithVlue->option->type == 5) {
                $optionValue = ProductOptionValues::where('option_id', $optionsWithVlue->option->id)->where('value_id', $optionsWithVlue->value->id)->where('product_id', $this->id)->where('type', '0')->first();
                $finalData[] = [
                    'option' => $optionsWithVlue->option->getName($lang),
                    'value' => $optionValue->getInput($lang)
                ];
            } else {
                $finalData[] = [
                    'option' => $optionsWithVlue->option->getName($lang),
                    'value' => $optionsWithVlue->value->getName($lang)
                ];
            }
        }
        return $finalData;
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function optionalSubCategory()
    {
        return $this->belongsTo(Category::class, 'optional_sub_category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, "creator_id");
    }
    public function updator()
    {
        return $this->belongsTo(User::class, "last_editor");
    }

    public function usersFavourite()
    {
        return $this->belongsToMany(User::class, "user_favourites", "product_id", "user_id");
    }

    public function usersCompare()
    {
        return $this->belongsToMany(User::class, "compare_products", "product_id", "user_id");
    }

    public function comparisons()
    {
        return $this->belongsToMany(User::class, "compare_products", "product_id", "user_id");
    }

    public function items()
    {
        return $this->hasMany(OrderProduct::class, "product_id");
    }

    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function stock_notifiers()
    {
        return $this->belongsToMany(User::class, "stock_notifications", "product_id", "user_id");
    }

    public function getName($lang = 1)
    {
        if ($lang == 2) {
            return $this->name_ar ?: $this->name;
        }

        return $this->name;
    }

    public function getMetaTitle($lang = 1)
    {
        if ($lang == 2) {
            return $this->meta_title_ar ?: $this->meta_title;
        }

        return $this->meta_title;
    }

    public function getSlug($lang = 1)
    {
        if ($lang == 2) {
            return $this->slug_ar ?: $this->slug;
        }

        return $this->slug;
    }

    public function getDescription($lang = 1)
    {
        if ($lang == 2) {
            return $this->description_ar ?: $this->description;
        }

        return $this->description;
    }

    public function getLongDescription($lang = 1)
    {
        if ($lang == 2) {
            return $this->long_description_ar ?: $this->long_description_en;
        }

        return $this->long_description_en;
    }

    public function getImageAttribute($value)
    {
        if ($value) {
            $image = explode("/", $this->attributes["image"]);
            $name = array_pop($image);
            $image = implode("/", $image) . "/" . $name;

            if (preg_match("/https?:\/\//", $this->attributes["image"])) {
                return $image;
            }

            return URL::to('') . "/" . $image;
        }
        return null;
    }

    public function getPriceAttribute()
    {
        if (isset($this->attributes["price"]) && !is_null($this->attributes["price"]) ) {
            return $this->attributes["price"] / 100;
        }
    }

    public function setPriceAttribute($value)
    {
        if (!is_null($value)) {
            $this->attributes["price"] = $value * 100;
        }else {
            $this->attributes["price"] = null;
        }
    }

    public function getDiscountPriceAttribute()
    {
        if (isset($this->attributes["discount_price"]) && !is_null($this->attributes["discount_price"])) {
            return $this->attributes["discount_price"] / 100;
        }
    }

    public function setDiscountPriceAttribute($value)
    {
        if (!is_null($value)) {
            $this->attributes["discount_price"] = $value * 100;
        } else {
            $this->attributes["discount_price"] = null;
        }
    }

    public function resetProductVariants()
    {
        $variantOptions = [];
        $mainProductOptions = [];
        $mainProduct = $this->parent;
        $productVariants = $mainProduct->productVariants()->pluck('id');
        if (count($productVariants) > 0) {
            foreach ($productVariants as $productVariant) {
                $optionValues = ProductOptionValues::where('product_id', $productVariant)->where('type', '1')->get();
                if (count($optionValues) > 0) {
                    foreach ($optionValues as $optionValue) {
                        $variantOptions[] = [
                            'option_id' => $optionValue->option_id,
                            'value_id' => $optionValue->value_id,
                            'image' => $optionValue->image,
                            'input_en' => $optionValue->input_en,
                            'input_ar' => $optionValue->input_ar,
                            'type' => '1',
                        ];
                    }
                }
            }
        }
        $mainProductVariants = ProductOptionValues::where('product_id', $mainProduct->id)->where('type', '1')->get();
        if (count($mainProductVariants) > 0) {
            foreach ($mainProductVariants as $mainProductVariant) {
                $mainProductOptions[] = [
                    'product_id' => $mainProduct->id,
                    'option_id' => $mainProductVariant->option_id,
                    'value_id' => $mainProductVariant->value_id,
                    'image' => $mainProductVariant->image,
                    'input_en' => $mainProductVariant->input_en,
                    'input_ar' => $mainProductVariant->input_ar,
                    'type' => '1',
                ];
            }
        }
        ProductOptionValues::where('product_id', $mainProduct->id)->where('type', '1')->delete();
        foreach ($variantOptions as $variantOption) {
            $variantOption['product_id'] = $mainProduct->id;
            ProductOptionValues::updateOrCreate($variantOption);
        }
        foreach ($mainProductOptions as $mainProductOption) {
            $productOption = ProductOptionValues::where('option_id', $mainProductOption['option_id'])->where('value_id', $mainProductOption['value_id'])->where('product_id', $mainProduct->id)->where('type', '1')->first();
            if ($productOption) {
                $productOption->update($mainProductOption);
            }
        }
    }

    public function isUserFavourite($user)
    {
        if(!Auth::check() || Auth::id() == 999999)
            return false;

        return (bool)$this->usersFavourite()->find($user->id);
    }

    public function getIsFavouriteAttribute()
    {
        if(!Auth::check() || Auth::id() == 999999)
            return false;

        return (bool) $this->usersFavourite->find(Auth::user());
    }

    public function getIsCompareAttribute()
    {
        if(!Auth::check() || Auth::id() == 999999)
            return false;

        return (bool) $this->usersCompare->find(Auth::user());
    }

    public function getCategoryTree($lang = 1)
    {
        if ($this->category) {
            $main = $this->category->parent;
            $sub_category = $this->category;

            return [
                "id" => $main->id,
                "name" => $main->name, //$main->getName($lang),
                "name_ar" => $main->name_ar, //$main->getName($lang),
                "sub_categories" => [
                    [
                        "id" => $sub_category->id,
                        "name" => $sub_category->name, //$sub_category->getName($lang)
                        "name_ar" => $sub_category->name_ar, //$sub_category->getName($lang)
                    ]
                ]
            ];
        }
    }

    public function getOptionalCategoryTree($lang = 1)
    {
        if ($this->optionalSubCategory) {
            $main = $this->optionalSubCategory->parent;
            $sub_category = $this->optionalSubCategory;

            return [
                "id" => $main->id,
                "name" => $main->name, //$main->getName($lang),
                "name_ar" => $main->name_ar, //$main->getName($lang),
                "sub_categories" => [
                    [
                        "id" => $sub_category->id,
                        "name" => $sub_category->name, //$sub_category->getName($lang)
                        "name_ar" => $sub_category->name_ar, //$sub_category->getName($lang)
                    ]
                ]
            ];
        }
    }

    public function scopeMainProduct($query)
    {
        return $query->where('parent_id', null);
    }

    public function scopeVariantProduct($query)
    {
        return $query->whereNotNull('parent_id');
    }

    public function scopeAvailable($query)
    {

        return   $query->whereHas('availableProductVariants', function($orders) {
            $orders->havingRaw('SUM(stock) > 0');
        });
    }

    public function getHistory()
    {
        $history = OrderProduct::query();

        if (app()->environment(['testing'])) {
            $history = $history->select(DB::raw('count(amount) as `productAmount`'), DB::raw("strftime('%b %Y', `created_at`) as month"));
        } else {
            $history = $history->select(DB::raw('count(amount) as `productAmount`'), DB::raw("DATE_FORMAT(`created_at`,'%b %Y') as month"));
        }
        $history = $history->where("product_id", $this->id)
                ->groupby('product_id', 'month')
                ->get()->toArray();

        return $history;
    }

    public function scopeActive($query)
    {
        // return $query->whereHas("category", function ($q) {
        //     $q->where("active", 1)->whereHas("parent", function ($q2) {
        //         $q2->where("active", 1);
        //     });
        // })->where("active", 1);
        $query->where(function ($qu) {
            $qu->whereHas("parent", function ($q1) {
                $q1->whereHas("category", function ($q) {
                    $q->where("active", 1)->whereHas("parent", function ($q2) {
                        $q2->where("active", 1);
                    });
                });
            })->orWhereHas("category", function ($q) {
                $q->where("active", 1)->whereHas("parent", function ($q2) {
                    $q2->where("active", 1);
                });
            });
        })
        // ->whereHas("parent", function ($query) {
        //     $query->where("active", 1);
        // })
        ->where("active", 1);

        return $query;
        // return $query->where("active", 1);
    }
    public function scopeActiveParent($query)
    {
        // return $query->whereHas("category", function ($q) {
        //     $q->where("active", 1)->whereHas("parent", function ($q2) {
        //         $q2->where("active", 1);
        //     });
        // })->where("active", 1);

        $query->where(function ($qu) {
            $qu->whereHas("parent", function ($q1) {
                $q1->whereHas("category", function ($q) {
                    $q->where("active", 1)->whereHas("parent", function ($q2) {
                        $q2->where("active", 1);
                    });
                });
            })->orWhereHas("category", function ($q) {
                $q->where("active", 1)->whereHas("parent", function ($q2) {
                    $q2->where("active", 1);
                });
            });
        })
        ->whereHas("parent", function ($query) {
            $query->where("active", 1);
        })
        ->where("active", 1);

        return $query;
        // return $query->where("active", 1);
    }

    public function createPrice()
    {
        return $this->prices()->create([
            "price" => $this->price,
            "discount_price" => $this->discount_price,
        ]);
    }

    public function calculateRate()
    {
        $avg = $this->items()->whereNotNull("rate")->get()->avg("rate");

        $this->rate = $avg;
        $this->save();

        return $this->rate;
    }

    public function getCurrentPriceId()
    {
        $current_price = $this->prices()->orderBy("created_at", "DESC")->get()->first();

        return $current_price ? $current_price->id : $this->createPrice()->id;
    }

    public function getShareLink($lang)
    {
        $url = config('app.website_url') . "/products/" . $this->id . "/" . rawurlencode($this->getName($lang));
        return $url;
    }

    public function getActiveDiscountAttribute()
    {
        $startDate = $this->discount_start_date == null ? now() : \Carbon\Carbon::parse($this->discount_start_date);
        $endDate = $this->discount_end_date == null ?  now()->addDay() : \Carbon\Carbon::parse($this->discount_end_date);

        $check = false;
        if($this->discount_price){
            $check = \Carbon\Carbon::now()->between($startDate,$endDate);
        }

        return $check;
    }

    /**
     * Scope a query active discount price.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActiveDiscount($query)
    {
        return $query->whereNotNull('discount_price')
                    ->where(function ($query) {
                        $query->whereNull('discount_start_date')
                            ->orWhere('discount_start_date', '<=', \Carbon\Carbon::now());
                    })
                    ->where(function ($query) {
                        $query->whereNull('discount_end_date')
                            ->orWhere('discount_end_date', '>=', \Carbon\Carbon::now());
                    });

    }

    /**
     * Scope a query active discount price.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActivePreOrder($query)
    {
        return $query->where('preorder', 1)
                    ->where(function ($query) {
                        $query->whereNull('preorder_start_date')
                            ->orWhere('preorder_start_date', '<=', \Carbon\Carbon::now());
                    })
                    ->where(function ($query) {
                        $query->whereNull('preorder_end_date')
                            ->orWhere('preorder_end_date', '>=', \Carbon\Carbon::now());
                    });

    }

    public function getActivePreorderAttribute()
    {
        if ($this->parent_id) {
            return $this->isPreorder($this->parent);
        } else {
            return $this->isPreorder($this);
        }
        // if ($this->preorder) {
        //     if(!$this->preorder_start_date || !$this->preorder_end_date) {
        //         return true;
        //     }
        //     return now() > $this->preorder_start_date && now() < $this->preorder_end_date;
        // }

        // return false;
    }

    public function isPreorder($product)
    {
        $startDate = $product->preorder_start_date == null ? now() : \Carbon\Carbon::parse($product->preorder_start_date);
        $endDate = $product->preorder_end_date == null ? now()->addDay() : \Carbon\Carbon::parse($product->preorder_end_date);

        $check = false;
        if($product->preorder){
            $check = \Carbon\Carbon::now()->between($startDate,$endDate);
        }
        return $check;
    }

    public function promotions()
    {
      $itemLists = collect([]);
      $itemLists->push($this->lists->pluck('id')->toArray());
      $itemLists->push(!$this->parent ?: $this->parent->lists->pluck('id')->toArray());

      $itemLists = $itemLists->filter()->flatten()->unique()->toArray();

      return Promotion::
          whereHas('conditions', function ($query) use ($itemLists){
              $query->whereIn('item_id', $itemLists)
                  ->orWhereRelation('customLists', 'item_id', $this->getOriginal('id'));
          })
          ->orWhereHas('targets', function ($query) use ($itemLists){
              $query->whereIn('item_id', $itemLists)
                  ->orWhereRelation('customLists', 'item_id', $this->getOriginal('id'));
          })
          ->prioritize();
    }

    // public function getPreorderAttribute()
    // {
    //     if (is_null($this->parent_id)) {
    //         return $this->attributes["preorder"];
    //     } else {
    //         return $this->parent->preorder;
    //     }
    // }
}
