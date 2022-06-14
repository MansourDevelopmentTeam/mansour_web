<?php


namespace App\Http\Controllers\Admin;

use App\Sheets\Export\Orders\OrdersExport;
use App\Sheets\Export\Products\ProductSalesExport;
use App\Sheets\Export\Products\ProductsFullExport;
use App\Sheets\Export\Products\ProductStocksExport;
use App\Sheets\Export\Products\ProductToFbExport;
use App\Sheets\Import\Products\ProductFullImport;
use App\Sheets\Import\Products\ProductFullImportV2;
use App\Sheets\Import\Products\ProductStocksImport;
use Carbon\Carbon;
use App\Models\Users\User;
use Illuminate\Support\Str;
use App\Models\Products\Tag;
use Illuminate\Http\Request;
use App\Models\Products\Brand;
use App\Models\Products\Lists;
use App\Models\Orders\CartItem;
use App\Models\Products\Option;
use Illuminate\Validation\Rule;
use App\Jobs\StockNotifications;
use App\Models\Products\Product;
use App\Models\Orders\OrderState;
use App\Models\Products\Category;
use Illuminate\Support\Facades\DB;
use App\Models\Orders\OrderProduct;
use App\Models\Products\ProductTag;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Products\OptionValue;
use App\Models\Services\PushService;
use Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\Products\ProductImage;
use App\Models\Products\ProductPrice;
use Illuminate\Support\Facades\Cache;
use App\Models\Products\CategoryOption;
use App\Models\Products\ProductVariant;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use App\Models\Services\ProductsService;
use phpDocumentor\Reflection\Types\This;
use Illuminate\Support\Facades\Validator;
use App\Models\Notifications\Notification;
use App\Models\Products\StockNotification;
use App\Models\Products\ProductOptionValues;
use App\Models\Products\ProductVariantImage;
use App\Models\Products\ProductVariantValue;
use App\Models\Transformers\ProductFullTransformer;
use Facades\App\Models\Repositories\ProductRepository;
use App\Models\Transformers\ProductVariantFullTransformer;

class ProductsController extends Controller
{
    private $productTrans;
    private $pushService;
    private $lists;
    private $attributesCount;
    private $optionsCount;
    private $productVariantTrans;

    /**
     * Constructor
     *
     * @param ProductFullTransformer $productTrans
     * @param PushService $pushService
     * @param Lists $lists
     * @param ProductVariantFullTransformer $productVariantTrans
     * @param ProductsService $productsService
     */
    public function __construct(ProductFullTransformer $productTrans, PushService $pushService, Lists $lists, ProductVariantFullTransformer $productVariantTrans, ProductsService $productsService)
    {
        $this->productsService = $productsService;
        $this->productTrans = $productTrans;
        $this->pushService = $pushService;
        $this->lists = $lists;
        $this->productVariantTrans = $productVariantTrans;
    }

    public function index(Request $request)
    {
        $products = Product::query()->with('images', 'ProductVariants', 'ProductVariants.images', 'ProductVariants.productOptions');

        if ($request->q) {
            $products->where(function ($q) use ($request) {
                $q->where(function ($q2) use ($request) {
                    $q2->where('name', 'LIKE', "%{$request->q}%");
                    $q2->orWhere('name_ar', 'LIKE', "%{$request->q}%");
                    $q2->orWhere('description', 'LIKE', "%{$request->q}%");
                    $q2->orWhere('description_ar', 'LIKE', "%{$request->q}%");
                    $q2->orWhere('id', 'LIKE', "%{$request->q}%");
                    $q2->orWhere('sku', 'LIKE', "%{$request->q}%");
                });
                $q->orWhere(function ($q2) use ($request) {
                    $q2->whereHas('ProductVariants', function ($q2) use ($request) {
                        $q2->where('name', 'LIKE', "%{$request->q}%");
                        $q2->orWhere('name_ar', 'LIKE', "%{$request->q}%");
                        $q2->orWhere('description', 'LIKE', "%{$request->q}%");
                        $q2->orWhere('description_ar', 'LIKE', "%{$request->q}%");
                        $q2->orWhere('id', 'LIKE', "%{$request->q}%");
                        $q2->orWhere('sku', 'LIKE', "%{$request->q}%");
                    });
                });
            });
            // $products = $products->where("name", "LIKE", "%{$request->q}%")->orWhere("description", "LIKE", "%{$request->q}%")->orWhere("id", $request->q)->orWhere("sku", $request->q);
        }
        $products->when($request->sub_category_id ?? false, function ($q) use ($request) {
            $q->where(function ($query) use ($request) {
                $query->where('category_id', $request->sub_category_id);
            });
        });

        $products->when($request->category_id, function ($q) use ($request) {
            $q->where(function ($query) use ($request) {
                $query->whereHas('category', function ($q) use ($request) {
                    $q->where('categories.parent_id',  $request->category_id);
                });
            });
        });

        $products->when($request->variant, function ($q) {
            $q->where('parent_id', '!=', null);
        });
        if ($request->parent_id) {
            $products->where("parent_id", $request->parent_id);
            $products = $products->orderBy("created_at", "DESC")->paginate(20);
            // dd($products);
            return $this->jsonResponse("Success", ["products" => $this->productVariantTrans->transformCollection($products->items()), "total" => $products->total()]);
        } else {
            if (!$request->variant) {
                $products->MainProduct();
            }
            $products = $products->orderBy("created_at", "DESC")->paginate(20);
            return $this->jsonResponse("Success", ["products" => $this->productTrans->transformCollection($products->items()), "total" => $products->total()]);
        }
    }

    public function searchVariants(Request $request)
    {
        $products = Product::query()->with('images', 'ProductVariants', 'ProductVariants.images', 'ProductVariants.productOptions')->where("stock", ">", 0)->whereNotNull("parent_id");

        if ($request->q) {
            $products->where(function ($q) use ($request) {
                $q->search($request->q)->orWhere("id", $request->q)->orWhere("sku", "LIKE", "%{$request->q}%");
            });
            // $products = $products->where("name", "LIKE", "%{$request->q}%")->orWhere("description", "LIKE", "%{$request->q}%")->orWhere("id", $request->q)->orWhere("sku", $request->q);
        }
        $products = $products->paginate(20);

        return $this->jsonResponse("Success", ["products" => $this->productTrans->transformCollection($products->items()), "total" => $products->total()]);
    }

    public function search(Request $request)
    {
        $products = Product::query()->with('images', 'ProductVariants', 'ProductVariants.images', 'ProductVariants.productOptions');
        $products->when($request->q, function ($q) use ($request) {
            $q->where(function ($q) use ($request) {
                $q->orWhere("name", "LIKE", "%{$request->q}%");
                $q->orWhere("name_ar", "LIKE", "%{$request->q}%");
                $q->orWhere("description", "LIKE", "%{$request->q}%");
                $q->orWhere("description_ar", "LIKE", "%{$request->q}%");
                $q->orWhere("id", "LIKE", "%{$request->q}%");
                $q->orWhere("sku", "LIKE", "%{$request->q}%");
            });
        });

        $products->when($request->variant, function ($q) {
            $q->where('parent_id', '!=', null);
        });
        $products->when($request->sub_category_id, function ($q) use ($request) {
            $q->where(function ($query) use ($request) {
                $query->where('category_id', $request->sub_category_id);
            });
        });

        if ($request->parent_id) {
            $products->where("parent_id", $request->parent_id);
            $products = $products->orderBy("created_at", "DESC")->paginate(20);
            return $this->jsonResponse("Success", ["products" => $this->productVariantTrans->transformCollection($products->items()), "total" => $products->total()]);
        } else {
            if (!$request->variant) {
                $products->MainProduct();
            }
            $products = $products->orderBy("created_at", "DESC")->paginate(20);
            return $this->jsonResponse("Success", ["products" => $this->productTrans->transformCollection($products->items()), "total" => $products->total()]);
        }
    }

    public function store(Request $request)
    {
        //validate request
        $validator = Validator::make($request->all(), Product::$mainProductValidation + ["sku" => "required|unique:products,sku"]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }

        $category = Category::find($request->category_id);
        if ($category->parent_id == null) {
            $message = 'The Category must be subcategory not Main Category';
            return $this->errorResponse($message, "Invalid data", $message, 422);
        }
        if ($request->brand_id && !is_numeric($request->brand_id)) {
            $brand = Brand::firstOrCreate(["name" => $request->brand_id]);
            $request->merge(["brand_id" => $brand->id]);
        }

        $data = $validator->validated();
        $data["bundle_checkout"] = (bool)$data["bundle_checkout"];
        $data['last_editor'] = auth()->User()->id;
        $data['creator_id'] = auth()->User()->id;
        $data['min_days'] = $data['min_days'] == "" || $data['min_days'] == null ? 1 : $data['min_days'];
        $data['featured'] = (bool)$request->featured;
        $product = Product::create($data);
        // $product = Product::create($request->only([
        //     "sku",
        //     "category_id",
        //     "optional_sub_category_id",
        //     "brand_id",
        //     "stock_alert",
        //     "order",
        //     "active",
        //     "preorder",
        //     "max_per_order",
        //     "min_days",
        //     "name",
        //     "name_ar",
        //     "type",
        // ]));

        $product->active = 1;
        $product->save();
        // $product->createPrice();

        ProductPrice::create([
            "product_id" => $product->id,
            "price" => $product->price,
            "discount_price" => $product->discount_price,
        ]);

        if ($request->has('payment_method_discount_ids')) {
            $product->paymentMethods()->sync($request->get('payment_method_discount_ids'));
        }

        // store related_skus
        if ($request->related_ids) {
            foreach ($request->related_ids as $related_id) {
                $relatedProduct = Product::find($related_id);
                if ($relatedProduct)
                    $product->relatedSkus()->create(["sku" => $relatedProduct->sku]);
            }
        }

        // store images
        if ($request->images) {
            foreach ($request->images as $image) {
                if (isset($image["url"]) && !empty($image["url"])) {
                    $product->images()->create(["url" => $image["url"]]);
                }
            }
        }

        // Store Product Option Values

        if ($request->tags && is_array($request->tags)) {
            foreach ($request->tags as $tag) {
                $tagQuery = Tag::find($tag);
                if ($tagQuery) {
                    $data = [
                        'tag_id' => $tagQuery->id,
                        'product_id' => $product->id,
                    ];
                    ProductTag::updateOrCreate($data);
                }
            }
        }


        if ($request->option_values && is_array($request->option_values)) {
            foreach ($request->option_values as $option_value) {
                $option = Option::find($option_value['option_id']);
                if ($option) {
                    $categoryOptions = CategoryOption::where('sub_category_id', $category->id)->where('option_id', $option->id)->first();
                    $value = OptionValue::where('id', $option_value['option_value_id'])->where('option_id', $option->id)->first();
                    if ($categoryOptions) {
                        $data = [
                            'product_id' => $product->id,
                            'option_id' => $option->id,
                            'type' => '0',
                            'created_by' => auth()->user()->id,
                        ];
                        if ($option->type == 5 && isset($option_value['input_en']) && isset($option_value['input_ar'])) {
                            $data['input_en'] = $option_value['input_en'];
                            $data['input_ar'] = $option_value['input_ar'];
                        } elseif ($option->type == 4 && isset($option_value['image'])) {
                            $data['image'] = $option_value['image'];
                        } elseif ($value) {
                            $data['value_id'] = $value->id;
                        }
                        $productOptionValue = ProductOptionValues::updateOrCreate($data);
                    }
                }
            }
        }

        if ($request->product_variant_options && is_array($request->product_variant_options)) {
            foreach ($request->product_variant_options as $product_variant_option) {
                $option = Option::find($product_variant_option);
                if ($option) {
                    $data = [
                        'product_id' => $product->id,
                        'option_id' => $option->id,
                        'type' => '1',
                        'created_by' => auth()->user()->id
                    ];
                    ProductOptionValues::updateOrCreate($data);
                }
            }
        }
        return $this->jsonResponse("Success", $this->productTrans->transform($product));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return $this->jsonResponse("Success", $this->productTrans->transform($product));
        // return $this->jsonResponse("Success", $product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        // validate request
        $validator = Validator::make($request->all(), Product::$mainProductValidation + ["sku" => ["required", Rule::unique("products")->ignore($id)]]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        $category = Category::find($request->category_id);
        if ($category->parent_id == null) {
            $message = 'The Category must be subcategory not Main Category';
            return $this->errorResponse($message, "Invalid data", $message, 422);
        }
        if ($request->brand_id && !is_numeric($request->brand_id)) {
            $brand = Brand::firstOrCreate(["name" => $request->brand_id]);
            $request->merge(["brand_id" => $brand->id]);
        }

        $price = $product->price;
        $discount_price = $product->discount_price;

        $parentData = [
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id
        ];

        $data = $validator->validated();
        $data['last_editor'] = auth()->User()->id;
        $data['min_days'] = $data['min_days'] == "" || $data['min_days'] == null ? 1 : $data['min_days'];
        $data['featured'] = (bool)$request->featured;
        $product->update($data);
        // $product->update($request->only([
        //     "sku",
        //     "category_id",
        //     "optional_sub_category_id",
        //     "brand_id",
        //     "order",
        //     "stock_alert",
        //     "active",
        //     "preorder",
        //     "max_per_order",
        //     "min_days",
        //     "name",
        //     "name_ar",
        //     "type",
        // ]));

        if ($product->stock > 0) {
            $users = $product->stock_notifiers;
            $product->stock_notifiers()->sync([]);

            $this->pushService->notifyUsers($users, "{$product->name} is now available", "Product in Stock");
        }

        if ($price !== $request->price || $discount_price !== $request->discount_price) {
            $product->createPrice();
        }

        if ($request->deleted_images) {
            ProductImage::whereIn("id", $request->deleted_images)->delete();
        }

        if ($request->has('payment_method_discount_ids')) {
            $product->paymentMethods()->sync($request->get('payment_method_discount_ids'));
        }

        // $optionIDS = array_column($request->option_values, 'option_id');
        // $optionValueIDS = array_column($request->option_values, 'option_value_id');

        // store images
        if ($request->images) {
            foreach ($request->images as $image) {
                if (isset($image["url"]) && !empty($image["url"])) {
                    if (isset($image["id"])) {
                        $product->images()->find($image["id"])->update(["url" => $image["url"]]);
                    } else {
                        $product->images()->create(["url" => $image["url"]]);
                    }
                }
            }
        }

        // store related_skus
        $product->relatedSkus()->delete();
        if ($request->related_ids) {
            foreach ($request->related_ids as $related_id) {
                $relatedProduct = Product::find($related_id);
                if ($relatedProduct)
                    $product->relatedSkus()->create(["sku" => $relatedProduct->sku]);
            }
        }


        // $removedProductOptionsValues =   ProductOptionValues::where('product_id',$id)->whereNotIn('option_id',$optionIDS)->whereNotIn('value_id',$optionValueIDS)->delete();
        // $removedProductOptionsValues = ProductOptionValues::where('product_id', $id)->delete();
        if ($request->option_values && is_array($request->option_values)) {
            ProductOptionValues::where('product_id', $product->id)->where('type', '0')->delete();
            foreach ($request->option_values as $option_value) {
                $option = Option::find($option_value['option_id']);
                if ($option) {
                    $categoryOptions = CategoryOption::where('sub_category_id', $category->id)->where('option_id', $option->id)->first();
                    $value = OptionValue::where('id', $option_value['option_value_id'])->where('option_id', $option->id)->first();
                    if ($categoryOptions) {
                        $data = [
                            'product_id' => $product->id,
                            'option_id' => $option->id,
                            'type' => '0',
                            'created_by' => auth()->user()->id,
                        ];
                        if ($option->type == 5 && isset($option_value['input_en']) && isset($option_value['input_ar'])) {
                            $data['input_en'] = $option_value['input_en'];
                            $data['input_ar'] = $option_value['input_ar'];
                        } elseif ($option->type == 4 && isset($option_value['image'])) {
                            $data['image'] = $option_value['image'];
                        } elseif ($value) {
                            $data['value_id'] = $value->id;
                        }
                        $productOptionValue = ProductOptionValues::updateOrCreate($data);
                    }
                }
            }
        }

        if ($request->has('product_variant_options') && is_array($request->product_variant_options) && count($request->get('product_variant_options')) > 0) {
            $productOldOptionValues = $product->productVariantOptions->pluck('id')->unique()->toArray();

            foreach ($request->get('product_variant_options') as $product_variant_option) {
                $option = Option::find($product_variant_option);
                if ($option) {
                    if (($key = array_search($option->id, $productOldOptionValues)) !== false) {
                        unset($productOldOptionValues[$key]);
                        continue;
                    }

                    $productOptionValue = ProductOptionValues::where('type', '1')->where('product_id', $product->id)->where('option_id', $option->id)->first();
                    if (!$productOptionValue) {
                        $data = [
                            'product_id' => $product->id,
                            'option_id' => $option->id,
                            'type' => '1',
                            'created_by' => auth()->user()->id
                        ];
                        ProductOptionValues::create($data);
                    }
                }
            }

            if (count($productOldOptionValues) > 0) {
                ProductOptionValues::where('type', '1')->where('product_id', $product->id)->whereIn('option_id', $productOldOptionValues)->delete();
            }
            foreach ($product->productVariants as $variant) {
                ProductOptionValues::where('type', '1')->where('product_id', $variant->id)->whereIn('option_id', $productOldOptionValues)->delete();
            }
        } else {
            $product_ids = $product->productVariants->pluck('id')->toArray();
            $product_ids[] = $product->id;

            ProductOptionValues::where('type', '1')->whereIn('product_id', $product_ids)->delete();
        }

        $variants = $product->productVariants;
        foreach ($variants as $variant) {
            $variant->update($parentData);
        }

        Cache::forget("product_images_{$product->id}");
        Cache::forget("product_" . $product->id . "_1_options");
        Cache::forget("product_" . $product->id . "_2_options");

        return $this->jsonResponse("Success", $this->productTrans->transform($product));
    }

    public function resetVariantList()
    {
        $variantOptions = [];
        $mainProductOptions = [];
        $mainProducts = Product::MainProduct()->get();
        $i = 0;
        foreach ($mainProducts as $mainProduct) {
            $variantOptions = [];
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
            // $mainProductVariants = ProductOptionValues::where('product_id', $mainProduct->id)->where('type', '1')->get();
            // if (count($mainProductVariants) > 0) {
            //     foreach ($mainProductVariants as $mainProductVariant) {
            //         $mainProductOptions[] = [
            //             'product_id' => $mainProduct->id,
            //             'option_id' => $mainProductVariant->option_id,
            //             'value_id' => $mainProductVariant->value_id,
            //             'image' => $mainProductVariant->image,
            //             'input_en' => $mainProductVariant->input_en,
            //             'input_ar' => $mainProductVariant->input_ar,
            //             'type' => '1',
            //         ];
            //     }
            // }
            ProductOptionValues::where('product_id', $mainProduct->id)->where('type', '1')->delete();
            foreach ($variantOptions as $variantOption) {
                $variantOption['product_id'] = $mainProduct->id;
                ProductOptionValues::updateOrCreate($variantOption);
            }
            // foreach ($mainProductOptions as $mainProductOption) {
            //     $productOption = ProductOptionValues::where('option_id', $mainProductOption['option_id'])->where('value_id', $mainProductOption['value_id'])->where('product_id', $mainProduct->id)->where('type', '1')->first();
            //     if ($productOption) {
            //         $productOption->update($mainProductOption);
            //     }
            // }
            $i++;
        }
        $this->pushService->notifyAdmins("Products Reseated", "All Products Reseated Successfully", '', 10, '', auth()->user()->id);
        Log::info("PRODUCT RESET SUCCESSFULLY");
        Artisan::call('cache:clear');
        return $this->jsonResponse("Success", $i);
    }

    public function resetProductVariantList($id)
    {
        $variantOptions = [];
        $mainProductOptions = [];
        $mainProducts = Product::MainProduct()->where("id", $id)->get();
        $i = 0;
        foreach ($mainProducts as $mainProduct) {
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
            // $mainProductVariants = ProductOptionValues::where('product_id', $mainProduct->id)->where('type', '1')->get();
            // if (count($mainProductVariants) > 0) {
            //     foreach ($mainProductVariants as $mainProductVariant) {
            //         $mainProductOptions[] = [
            //             'product_id' => $mainProduct->id,
            //             'option_id' => $mainProductVariant->option_id,
            //             'value_id' => $mainProductVariant->value_id,
            //             'image' => $mainProductVariant->image,
            //             'input_en' => $mainProductVariant->input_en,
            //             'input_ar' => $mainProductVariant->input_ar,
            //             'type' => '1',
            //         ];
            //     }
            // }
            ProductOptionValues::where('product_id', $mainProduct->id)->where('type', '1')->delete();

            foreach ($variantOptions as $variantOption) {
                $variantOption['product_id'] = $mainProduct->id;
                ProductOptionValues::create($variantOption);
            }
            // foreach ($mainProductOptions as $mainProductOption) {
            //     $productOption = ProductOptionValues::where('option_id', $mainProductOption['option_id'])->where('value_id', $mainProductOption['value_id'])->where('product_id', $mainProduct->id)->where('type', '1')->first();
            //     if ($productOption) {
            //         $productOption->update($mainProductOption);
            //     }
            // }
            $i++;
        }
        $this->pushService->notifyAdmins("Products Reseated", "All Products Reseated Successfully", '', 10, '', auth()->user()->id);
        return $this->jsonResponse("Success", $i);
    }

    public function getStats(Request $request, $product_id)
    {
        // validate request
        $validator = Validator::make($request->all(), ["begin" => "required", "end" => "required"]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }


        $begin = date("Y-m-d", strtotime($request->begin));
        $end = date("Y-m-d", strtotime($request->end));

        $history = OrderProduct::query()
            ->select(DB::raw('count(amount) as `productAmount`'), DB::raw("DATE_FORMAT(`created_at`,'%b %Y') as month"))
            ->where("created_at", ">=", $begin)
            ->where("created_at", "<=", $end)
            ->where("product_id", $product_id)
            ->groupby('product_id', 'month')
            ->get()->toArray();

        return $this->jsonResponse("Success", $history);
    }

    public function stockAlert()
    {
        $stockNotification = StockNotification::with('user', 'product')->paginate(20);
        return $this->jsonResponse("Success", ["items" => $stockNotification->items(), "total" => $stockNotification->total()]);
    }

    public function activate($id)
    {
        $product = Product::findOrFail($id);

        $product->active = 1;
        $product->deactivation_notes = null;
        $product->save();

        return $this->jsonResponse("Success");
    }

    public function deactivate(Request $request, $id)
    {
        // validate request
        // $validator = Validator::make($request->all(), ["deactivation_notes" => "required"]);

        // if ($validator->fails()) {
        //     return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        // }

        $product = Product::findOrFail($id);

        $product->active = 0;
        $product->deactivation_notes = $request->deactivation_notes;
        $product->save();

        return $this->jsonResponse("Success");
    }

    public function importStocks(Request $request)
    {
        $this->validate($request, ["file" => "required", "approved" => "sometimes|nullable|boolean"]);
        try {
            $file = $request->file('file');
            $fileName = "Products_" . date("Y_m_d H_i_s") . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/imports/products', $fileName);
            $import = new ProductStocksImport();
            Excel::import($import, $path);

            $pathUrl = Str::replaceFirst('public/', 'storage/', $path);
            Log::channel('imports')->info('Action: import stocks, File link: ' . url($pathUrl) . ' Admin name: ' . auth()->user()->name . ' Date: ' . now());

            $this->pushService->notifyAdmins("File Imported", "Your import has completed! You can check the result from", '', 10, null);
            return $this->jsonResponse("Success");
        } catch (\Exception $e) {
            Log::error("ImportFactory File Error: " . $e->getMessage());
            return $this->errorResponse($e->getMessage(), "Invalid data", [], 422);
        }
    }

    public function export()
    {
        $products = Product::with("category.parent", "brand")->get();

        return Excel::create('products_' . date("Ymd"), function ($excel) use ($products) {
            $excel->sheet('report', function ($sheet) use ($products) {
                // $sheet->fromArray($players);
                $sheet->row(1, ["id", "name", "name_ar", "description", "meta_title", "meta_description", "keywords", "preorder", "preorder_price", "description_ar", "category", "subcategory", "brand", "sku", "total_orders", "price", "discount_price", "image", "active", "weight"]);

                foreach ($products as $key => $product) {
                    // dd(array_values($player));
                    $brand_name = $product->brand ? $product->brand->name : "";
                    $sheet->row($key + 2, [
                        $product->id,
                        $product->name,
                        $product->name_ar,
                        $product->description,
                        $product->meta_title,
                        $product->meta_description,
                        $product->keywords,
                        $product->preorder,
                        $product->preorder_price,
                        $product->description_ar,
                        $product->category->parent->name,
                        $product->category->name,
                        $brand_name,
                        $product->sku,
                        $product->orders_count,
                        $product->price,
                        $product->discount_price,
                        $product->image,
                        (int)$product->active,
                        $product->weight,
                    ]);
                }
            });
        })->download('csv');
        $this->pushService->notifyAdmins("File Imported", "the File Has Been Imported Successfully", '', 10, null);
    }

    public function exportStocks()
    {
        $fileName = 'products_stocks__by_' . auth()->user()->name . '_' . date("Y_m_d H_i_s") . '.xlsx';

        $filePath = "public/exports/products/" . $fileName;

        Excel::store(new ProductStocksExport(), $filePath);

        $fileUrl = url("storage/exports/products") . "/" . $fileName;
        Log::channel('exports')->info('Action: Export Stocks, File link: ' . url($filePath) . ' Admin name: ' . auth()->user()->name . ' Date: ' . now());
        $this->pushService->notifyAdmins("File Exported ", "Your export has completed! You can download the file from", '', 11, $fileUrl, auth()->User()->id);
        return $this->jsonResponse("Success");
    }

    public function import(Request $request)
    {
        try {
            Excel::load($request->file, function ($reader) {
                // Loop through all sheets

                $results = $reader->all();
                $missed_categories = [];
                $missed_count = 0;
                $missed_images = [];
                $missed_keys = [];
                foreach ($results as $key => $record) {

                    if (is_float($record->sku)) {
                        $sku = (int)$record->sku;
                    } else {
                        $sku = $record->sku;
                    }
                    $category_name = $record->subcategory;

                    if ($category = Category::whereNotNull("parent_id")->where("name", trim($category_name))->first()) {
                        $category_id = $category->id;
                    } else {
                        $missed_categories[] = $category_name;
                        $missed_keys[] = $key;
                        $missed_count++;
                        continue;
                    }

                    $brand_id = null;
                    if ($record->brand) {
                        $brand = Brand::where("name", $record->brand)->first();
                        if ($brand) {
                            $brand_id = $brand->id;
                        }
                    }

                    $images = explode(',', $record->image);
                    $main_image = null;
                    if (count($images)) {
                        $main_image = trim($images[0]);
                        $main_image = preg_replace("/\s/", "-", $main_image);
                        unset($images[0]);
                        if (filter_var($main_image, FILTER_VALIDATE_URL) === FALSE) {
                            $main_image = "storage/uploads/" . $main_image;
                        }
                        // if (!Storage::disk('public')->has('uploads/' . $main_image)) {
                        //     $missed_images[] = $main_image;
                        // }
                    }

                    // if product exists
                    $product_data = [
                        "name" => $record->name,
                        "name_ar" => $record->name_ar,
                        "price" => $record->price,
                        "weight" => $record->weight,
                        "discount_price" => $record->discount_price,
                        "description" => $record->description,
                        "meta_title" => $record->meta_title,
                        "meta_description" => $record->meta_description,
                        "keywords" => $record->keywords,
                        "preorder" => $record->preorder,
                        "preorder_price" => $record->preorder_price,
                        "description_ar" => $record->description_ar,
                        "sku" => $record->sku,
                        "brand_id" => $brand_id,
                        // "image" => preg_replace("/\s/", "-", $record->image),
                        "image" => $main_image,
                        "category_id" => $category_id,
                        "active" => $record->active
                    ];

                    if ($product = Product::where("sku", $sku)->first()) {
                        $product->update($product_data);
                    } else {
                        $product = Product::create($product_data + ["creator_id" => auth()->user()->id]);
                    }

                    if (count($images)) {
                        $product->images()->delete();
                        foreach ($images as $image) {
                            $image = preg_replace("/\s/", "-", trim($image));
                            if (filter_var($main_image, FILTER_VALIDATE_URL) === FALSE) {
                                $image = "storage/uploads/" . $image;
                            }
                            $product->images()->create([
                                "url" => $image
                            ]);
                        }
                    }
                }
                Log::info($missed_images);
                Log::info($missed_categories);
                Log::info($missed_keys);
                Log::info("Missed Products: {$missed_count}");
            });
        } catch (\Exception $e) {

            Log::error("HandleFileError: " . $e->getMessage());
            Log::error($e->getTrace());
        }
    }

    public function importBrands(Request $request)
    {
        try {
            Excel::load($request->file, function ($reader) {
                // Loop through all sheets

                $results = $reader->all();

                foreach ($results as $key => $record) {

                    if (is_float($record->sku)) {
                        $sku = (int)$record->sku;
                    } else {
                        $sku = $record->sku;
                    }

                    if (!$record->brand) {
                        continue;
                    }
                    $brand = Brand::firstOrCreate(["name" => $record->brand]);


                    if ($product = Product::where("sku", $sku)->first()) {
                        $product->update(["brand_id" => $brand->id]);
                    }
                }
            });
        } catch (\Exception $e) {

            Log::error("HandleFileError: " . $e->getMessage());
        }
    }

    public function importPrices(Request $request)
    {
        // get file
        ini_set('max_execution_time', 900);
        ini_set('memory_limit', '1024M');
        Log::error("IMPORT START");

        try {
            Excel::load($request->file, function ($reader) {
                // Loop through all sheets

                $results = $reader->all();
                foreach ($results as $key => $record) {

                    if (is_float($record->sku)) {
                        $sku = (int)$record->sku;
                    } else {
                        $sku = $record->sku;
                    }

                    if ($product = Product::where("sku", $sku)->first()) {
                        $product->update(["stock" => $record->stock, "price" => $record->price, "discount_price" => $record->discount_price]);
                    }

                }
            });
        } catch (\Exception $e) {
            Log::error("ImportFactory File Error: " . $e->getMessage());
            return $this->errorResponse($e->getMessage(), "Invalid data", [], 422);
        }

        Log::info("IMPORT COMPLETE");
        $this->pushService->notifyAdmins("File Imported", "the File Has Been Imported Successfully", '', 10, null, auth()->user()->id);
        // return response
        return $this->jsonResponse("Success");
    }

    /**
     * Export product sales
     *
     * @param Request $request
     * @return void
     */
    public function exportProductSales(Request $request)
    {
        $items = OrderProduct::with("order", "product")->whereHas("order", function ($q) {
            $q->where("state_id", OrderState::DELIVERED);
        });
        if ($request->date_from) {
            $items = $items->whereDate("created_at", ">=", date("Y-m-d", strtotime($request->date_from)));
        }
        if ($request->date_to) {
            $items = $items->whereDate("created_at", "<=", date("Y-m-d", strtotime($request->date_to)));
        }
        $items = $items->select("*", DB::raw("SUM(amount) as sale_count"))->groupby("product_id")->get();
        $fileName = "Product_sales_" . date("YmdHis") . '.xlsx';
        $filePath = 'public/exports/products/' . $fileName;
        $fileUrl = url("storage/exports/products") . "/" . $fileName;

        Excel::store(new ProductSalesExport($items), $filePath);

        Log::channel('exports')->info('Action: Export Product Sale, File link: ' . url($filePath) . ' Admin name: ' . auth()->user()->name . ' Date: ' . now());
        $this->pushService->notifyAdmins("File Exported ", "Your export has completed! You can download the file from", '', 11, $fileUrl, auth()->User()->id);
        return $this->jsonResponse("Success");
    }

    public function fullExport(Request $request)
    {
        try {
            $fileName = "productFullExport_" . date("YmdHis") . '.xlsx';
            $filePath = 'public/exports/products/' . $fileName;
            $fileUrl = url("storage/exports/products") . "/" . $fileName;
            Excel::store(new ProductsFullExport($request), $filePath);
            $filePath = url("storage/exports") . '/' . $fileName . '.xlsx';
            Log::channel('exports')->info('Action: Full Export Product, File link: ' . url($filePath) . ' Admin name: ' . auth()->user()->name . ' Date: ' . now());
            $this->pushService->notifyAdmins("File Exported ", "Your export has completed! You can download the file from", '', 11, $fileUrl, auth()->User()->id);
            return $this->jsonResponse("Success");
        } catch (\Exception $e) {
            $this->pushService->notifyAdmins("Failed To Export ", "Failed To Export Sheet :" . $e->getMessage(), '', 11, $fileUrl, auth()->User()->id);
            Log::error("Failed To Export: " . $e->getMessage());
            return $this->errorResponse($e->getMessage(), "Failed To Export", $e->getTrace(), 422);
        }
    }

    public function fullImport(Request $request)
    {
        $this->validate($request, ["file" => "required", "approved" => "sometimes|nullable|boolean"]);
        isset($request->approved) ? $approved = $request->approved : $approved = 1;
        try {
            $file = $request->file('file');
            $fileName = "Products_" . date("Y_m_d H_i_s") . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/imports/products', $fileName);
            $import = new ProductFullImport($approved, $this->pushService);
            Excel::import($import, $path);
            $this->pushService->notifyAdmins("File Imported", "Your import has completed! You can check the result from", '', 10, json_encode($import->reportData), auth()->user()->id);
            return $this->jsonResponse("Success", $import->reportData);
        } catch (\Exception $e) {
            Log::error("ImportFactory File Error: " . $e->getMessage());
            return $this->errorResponse($e->getMessage(), "Invalid data", $e->getTrace(), 422);
        }
    }

    public function fullImportV2(Request $request)
    {
        $this->validate($request, ["file" => "required", "approved" => "sometimes|nullable|boolean"]);
        isset($request->approved) ? $approved = $request->approved : $approved = 1;
        try {
            $file = $request->file('file');
            $fileName = "Products_" . date("Y_m_d H_i_s") . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/imports/products', $fileName);

            $import = new ProductFullImportV2($approved, $this->pushService);
            Excel::import($import, $path);

            $pathUrl = Str::replaceFirst('public/', 'storage/', $path);
            Log::channel('imports')->info('Action: Full import Products, File link: ' . url($pathUrl) . ' Admin name: ' . auth()->user()->name . ' Date: ' . now());

            $this->pushService->notifyAdmins("File Imported", "Your import has completed! You can check the result from", '', 10, json_encode($data), auth()->user()->id);

            return $this->jsonResponse("Success", $import->data);
        } catch (\Exception $e) {
            Log::error("ImportFactory File Error: " . $e->getMessage());
            $trace = $e->getTrace();

            $traceCustom = [
                'file_path' => isset($trace[0]['file']) ? $trace[0]['file'] : '',
                'line' => isset($trace[0]['line']) ? $trace[0]['line'] : '',
            ];
            return $this->errorResponse($e->getMessage(), "Invalid data", $traceCustom, 422);
        }
    }

    public function magentoImport(Request $request)
    {
        $this->validate($request, ["file" => "required", "approved" => "sometimes|nullable|boolean"]);
        isset($request->approved) ? $approved = $request->approved : $approved = 1;
        $totalCount = 0;
        $totalMainProductCount = 0;
        $totalVariantProductCount = 0;
        $totalMissedProductsCount = 0;
        $totalMissedVariantsCount = 0;
        $totalCreatedProductsCount = 0;
        $totalCreatedVariantsCount = 0;
        $totalUpdatedVariantsCount = 0;
        $totalUpdatedProductsCount = 0;
        $missedDetails = [];
        $mainSkuArray = [];
        $mainProductIDS = [];
        $variantProductIDS = [];
        try {
            //$file = $request->file('file')->getRealPath();
            Excel::load($request->file, function ($reader) use (&$variantProductIDS, &$mainProductIDS, &$missedDetails, &$totalMainProductCount, &$totalVariantProductCount, &$totalCount, &$approved, &$totalMissedProductsCount, &$totalMissedVariantsCount, &$totalCreatedProductsCount, &$totalCreatedVariantsCount, &$totalUpdatedProductsCount, &$totalUpdatedVariantsCount, &$mainSkuArray) {
                // Loop through all sheets
                $rows = $reader->all();
                if (!empty($rows)) {
                    foreach ($rows as $row) {
                        if ($row['store_view_code'] == 'en') {
                            continue;
                        }
                        if (isset($row["sku"]) && is_float($row['sku'])) {
                            $MainSku = (int)$row['sku'];
                        } elseif (isset($row["sku"])) {
                            $MainSku = $row['sku'];
                        }
                        $productCategories = isset($row['categories']) && !empty($row['categories']) ? $row['categories'] : null;
                        $productLang = isset($row['store_view_code']) && !empty($row['store_view_code']) ? $row['store_view_code'] : null;
                        $productNameEn = isset($row['name']) && !empty($row['name']) ? $row['name'] : null;
                        $productNameAr = isset($row['name']) && !empty($row['name']) ? $row['name'] : null;
                        $productDescriptionEn = isset($row['short_description']) && !empty($row['short_description']) ? $row['short_description'] : " ";
                        $productDescriptionAr = isset($row['short_description']) && !empty($row['short_description']) ? $row['short_description'] : " ";
                        $productLongDescriptionEn = isset($row['description']) && !empty($row['description']) ? $row['description'] : null;
                        $productLongDescriptionAr = isset($row['description']) && !empty($row['description']) ? $row['description'] : null;
                        $productWeight = isset($row['weight']) && !empty($row['weight']) ? $row['weight'] : null;
                        $productPrice = isset($row['price']) && !empty($row['price']) && $row['price'] > 0 ? $row['price'] : null;
                        $productDiscountPrice = isset($row['special_price']) && !empty($row['special_price']) && $row['special_price'] > 0 && $row['special_price'] != 0 ? $row['special_price'] : null;
                        $productMainImage = isset($row['base_image']) && !empty($row['base_image']) ? config('app.website_url') . "/media/catalog/product" . $row['base_image'] : " ";
                        $productImagesRows = isset($row['additional_images']) && !empty($row['additional_images']) ? $row['additional_images'] : null;
                        $productAttributes = isset($row['additional_attributes']) && !empty($row['additional_attributes']) ? $row['additional_attributes'] : null;
                        $productStock = isset($row['qty']) && !empty($row['qty']) && ($row['qty']) > 0 ? $row['qty'] : 0;
                        $productSubtractStock = isset($row['is_in_stock']) && !empty($row['is_in_stock']) && ($row['is_in_stock']) ? $row['is_in_stock'] : 1;
                        $productMaxPerOrder = isset($row['max_cart_qty']) && !empty($row['max_cart_qty']) && ($row['max_cart_qty']) ? $row['max_cart_qty'] : 0;
                        $productStockAlert = isset($row['notify_on_stock_below']) && !empty($row['notify_on_stock_below']) && ($row['notify_on_stock_below']) ? $row['notify_on_stock_below'] : 0;
                        preg_match_all("/([a-zA-Z0-9_]+=(?:[<>\p{Arabic}a-zA-Z0-9×\s\-\–\/\;\'\"\:\%\.\&\@\~\+\*\(\)\=]|(?:,\s))+)/u", $productAttributes, $output_array);


                        if ($productCategories) {
                            $productCategories = explode(',', $productCategories);
                            $productCategories = array_reverse($productCategories);
                            $productCategories = explode('/', $productCategories[0]);
                            $category = $productCategories[1];
                            $subCategory = isset($productCategories[2]) ? $productCategories[2] : $category;
                        } else {
                            $category = null;
                            $subCategory = null;
                        }


                        if ($category && $subCategory) {
                            $category = Category::firstOrCreate([
                                'parent_id' => null,
                                'name' => $category
                            ]);
                            $subCategory = Category::firstOrCreate([
                                'parent_id' => $category->id,
                                'name' => $subCategory
                            ]);
                            $subCategoryID = $subCategory->id;
                        } else {
                            if (!$productLang) {
                                continue;
                            }
                        }
                        $totalCount++;
                        if ($productLang == 'en') {
                            continue;
                        }

                        if (isset($row['sku']) && $row['sku'] != null && isset($row['sku'])) {

                            $productData = [
                                "sku" => "main_" . $MainSku,
                            ];
                            if ($productLang) {
                                if ($productLang == 'sa') {
                                    $productData['name_ar'] = $productNameAr;
                                    $productData['description_ar'] = $productDescriptionAr;
                                    $productData['long_description_ar'] = $productLongDescriptionAr;
                                } else {
                                    continue;
                                }
                            } else {
                                $productData['category_id'] = $subCategoryID;
                                $productData['stock_alert'] = $productStockAlert;
                                $productData['max_per_order'] = $productMaxPerOrder;
                                $productData['subtract_stock'] = $productSubtractStock;
                                $productData['discount_price'] = $productDiscountPrice;
                                $productData['stock'] = $productStock;
                                $productData['weight'] = $productWeight;
                                $productData['price'] = $productPrice;
                                $productData['image'] = $productMainImage;
                                $productData['name'] = $productNameEn;
                                $productData['description'] = $productDescriptionEn;
                                $productData['long_description_en'] = $productLongDescriptionEn;
                            }

                            $variantData = $productData;
                            $variantData['sku'] = $MainSku;


                            $mainProduct = Product::where('sku', $productData['sku'])->first();


                            if ($mainProduct) {
                                $totalUpdatedProductsCount++;
                                $mainProduct->update($productData);
                            } else {
                                $totalCreatedProductsCount++;
                                $mainProduct = Product::create($productData);
                            }
                            if (!in_array($mainProduct->id, $mainProductIDS)) {
                                $totalMainProductCount++;
                                array_push($mainProductIDS, $mainProduct->id);
                            }

                            $variantData['parent_id'] = $mainProduct->id;

                            $variantProduct = Product::where('sku', $variantData['sku'])->where('parent_id', $mainProduct->id)->first();


                            if ($variantProduct) {
                                $totalUpdatedVariantsCount++;
                                $variantProduct->update($variantData);
                            } else {
                                $totalCreatedVariantsCount++;
                                $variantProduct = Product::create($variantData);
                            }
                            if (!in_array($variantProduct->id, $variantProductIDS)) {
                                $totalVariantProductCount++;
                                array_push($variantProductIDS, $mainProduct->id);
                            }


                            if (!$productLang) {
                                if (isset($output_array[0]) && is_array($output_array[0])) {
                                    ProductOptionValues::where('product_id', $mainProduct->id)->where('type', 0)->delete();
                                    foreach ($output_array[0] as $attribute) {
                                        $optionValues = explode('=', $attribute, 2);
                                        $optionData = isset($optionValues[0]) ? $optionValues[0] : null;
                                        $valueData = isset($optionValues[1]) ? rtrim($optionValues[1], ",") : null;

                                        if ($optionData == "mgs_brand") {
                                            $brand = Brand::firstOrCreate([
                                                'name' => $valueData
                                            ]);
                                            $variantProduct->update(['brand_id' => $brand->id]);
                                            $mainProduct->update(['brand_id' => $brand->id]);
                                        }
                                        if ($optionData && $valueData) {
                                            $option = Option::where('name_en', $optionData)->where('type', 5)->first();
                                            if (!$option) {
                                                $option = Option::create(['name_en' => $optionData, 'name_ar' => $optionData, 'type' => 5,]);
                                            }
                                            $productOptionValue = ProductOptionValues::where('product_id', $mainProduct->id)->where('option_id', $option->id)->first();
                                            if ($productOptionValue) {
                                                $productOptionValue->update(['input_en' => $valueData, 'input_ar' => $valueData]);
                                            } else {
                                                ProductOptionValues::create(['product_id' => $mainProduct->id, 'option_id' => $option->id, 'input_en' => $valueData, 'input_ar' => $valueData, 'type' => "0"]);
                                            }
                                        }
                                    }
                                }
                                if ($productImagesRows) {
                                    $productImagesRows = explode(',', $productImagesRows);
                                    if (is_array($productImagesRows)) {
                                        $variantProduct->images()->delete();
                                        foreach ($productImagesRows as $productImagesRow) {
                                            if ($productImagesRow && $productImagesRow != $row['base_image']) {
                                                $variantProduct->images()->create(["url" => config('app.website_url') . "/media/catalog/product" . $productImagesRow]);
                                            }
                                        }
                                    }
                                }
                                $x = 1;
                                while ((isset($row['option_name_' . $x]) && !empty($row['option_name_' . $x]))) {
                                    $option = Option::where('name_en', trim($row['option_name_' . $x]))->first();

                                    if ($option) {
                                        if ($x == 1) {
                                            // make first option the default
                                            $mainProduct->update(["option_default_id" => $option->id]);
                                            $variantProduct->update(["option_default_id" => $option->id]);
                                        }

                                        $value = OptionValue::where('name_en', trim($row['option_value_' . $x]))->where('option_id', $option->id)->first();
                                        $variantOptionValueData = [
                                            'product_id' => $variantProduct->id,
                                            'option_id' => $option->id,
                                            'type' => '1'
                                        ];

                                        if ($option->type == 4 && $value) {
                                            $variantOptionValueData['value_id'] = $value ? $value->id : null;
                                            //    $image = isset($row['option_image_' . $x]) ? $row['option_image_' . $x] : '';
                                            //    if (filter_var($image, FILTER_VALIDATE_URL) === FALSE) {
                                            //        $image = str_replace(' ', '-', $image);
                                            //        $image = url("storage/uploads/" . $image);
                                            //    }
                                            $image = $productMainImage;
                                            $variantOptionValueData['image'] = isset($row['option_image_' . $x]) ? $image : '';
                                            ProductOptionValues::updateOrCreate(['product_id' => $variantProduct->id, 'option_id' => $option->id], $variantOptionValueData);
                                        } elseif ($value) {
                                            $variantOptionValueData['value_id'] = $value->id;
                                            ProductOptionValues::updateOrCreate(['product_id' => $variantProduct->id, 'option_id' => $option->id], $variantOptionValueData);
                                        } else {
                                            $totalMissedVariantsCount++;
                                            $missedDetails[] = 'variant with sku ' . $MainSku . '( value ' . $row['option_value_' . $x] . ' Not Found )';
                                        }

                                    } else {
                                        $totalMissedVariantsCount++;
                                        $missedDetails[] = 'variant with sku ' . $MainSku . '( option ' . $row['option_name_' . $x] . ' Not Found )';
                                    }
                                    $x++;
                                }

                            } elseif ($productLang == "sa") {
                                if (isset($output_array[0]) && is_array($output_array[0])) {
                                    // ProductOptionValues::where('product_id', $mainProduct->id)->where('type', 0)->delete();
                                    foreach ($output_array[0] as $attribute) {
                                        $optionValues = explode('=', $attribute, 2);
                                        $optionData = isset($optionValues[0]) ? $optionValues[0] : null;
                                        $valueData = isset($optionValues[1]) ? rtrim($optionValues[1], ",") : null;
                                        if ($optionData && $valueData) {
                                            $option = Option::where('name_en', $optionData)->where('type', 5)->first();
                                            if (!$option) {
                                                $option = Option::create(['name_en' => $optionData, 'name_ar' => $optionData, 'type' => 5,]);
                                            }
                                            $productOptionValue = ProductOptionValues::where('product_id', $mainProduct->id)->where('option_id', $option->id)->first();
                                            if ($productOptionValue) {
                                                $productOptionValue->update(['input_ar' => $valueData]);
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        usleep(200);
                    }
                }

            });
            $totalApprovedProductsCount = $totalCreatedProductsCount + $totalUpdatedProductsCount;
            $totalApprovedVariantsCount = $totalCreatedVariantsCount + $totalUpdatedVariantsCount;
            $totalApprovedCount = $totalApprovedProductsCount + $totalApprovedVariantsCount;
            $totalMissedCount = $totalMissedProductsCount + $totalMissedVariantsCount;
            $totalCreatedCount = $totalCreatedProductsCount + $totalCreatedVariantsCount;
            $totalUpdatedCount = $totalUpdatedProductsCount + $totalUpdatedVariantsCount;
            $data = [
                'total_count' => $totalCount,
                'total_product_count' => count($mainProductIDS),
                'total_variant_product_count' => count($variantProductIDS),
                'total_approved_count' => $totalApprovedCount,
                'total_approved_products_count' => $totalApprovedProductsCount,
                'total_approved_variants_count' => $totalApprovedVariantsCount,
                'total_missed_count' => $totalMissedCount,
                'total_missed_products_count' => $totalMissedProductsCount,
                'total_missed_variants_count' => $totalMissedVariantsCount,
                'total_created_count' => $totalCreatedCount,
                'total_created_products_count' => $totalCreatedProductsCount,
                'total_created_variants_count' => $totalCreatedVariantsCount,
                'total_updated_count' => $totalUpdatedCount,
                'total_updated_products_count' => $totalUpdatedProductsCount,
                'total_updated_variants_count' => $totalUpdatedVariantsCount,
                'missed_details' => $missedDetails,
            ];
            Log::info("IMPORT FINISHED");
            Artisan::call('cache:clear');
            $this->pushService->notifyAdmins("File Imported", "Your import has completed! You can check the result from", '', 10, json_encode($data), auth()->user()->id);
            return $this->jsonResponse("Success", $data);
        } catch (\Exception $e) {
            // dd($e);
            Log::error("ImportFactory File Error: " . $e->getMessage());
            return $this->errorResponse($e->getMessage(), "Invalid data", [], 422);
        }
    }

    public function magentoImportAttributesAndImages(Request $request)
    {
        $this->validate($request, ["file" => "required", "approved" => "sometimes|nullable|boolean"]);
        isset($request->approved) ? $approved = $request->approved : $approved = 1;
        $totalCount = 0;
        $totalMainProductCount = 0;
        $totalVariantProductCount = 0;
        $totalMissedProductsCount = 0;
        $totalMissedVariantsCount = 0;
        $totalCreatedProductsCount = 0;
        $totalCreatedVariantsCount = 0;
        $totalUpdatedVariantsCount = 0;
        $totalUpdatedProductsCount = 0;
        $missedDetails = [];
        $mainSkuArray = [];
        $mainProductIDS = [];
        $variantProductIDS = [];
        Log::info("Starting ImportFactory Magento Attributes Sheet");
        try {
            //$file = $request->file('file')->getRealPath();
            Excel::load($request->file, function ($reader) use (&$variantProductIDS, &$mainProductIDS, &$missedDetails, &$totalMainProductCount, &$totalVariantProductCount, &$totalCount, &$approved, &$totalMissedProductsCount, &$totalMissedVariantsCount, &$totalCreatedProductsCount, &$totalCreatedVariantsCount, &$totalUpdatedProductsCount, &$totalUpdatedVariantsCount, &$mainSkuArray) {
                // Loop through all sheets
                $rows = $reader->all();
                if (!empty($rows)) {
                    foreach ($rows as $rowKey => $row) {
                        Log::info("Row: {$rowKey}");
                        $totalCount++;
                        if ($row['store_view_code'] == 'en') {
                            continue;
                        }

                        if (isset($row["sku"]) && is_float($row['sku'])) {
                            $sku = (int)$row['sku'];
                        } elseif (isset($row["sku"])) {
                            $sku = $row['sku'];
                        }

                        $productMainImage = isset($row['base_image']) && !empty($row['base_image']) ? config('app.website_url') . "/media/catalog/product" . $row['base_image'] : " ";
                        $productLang = isset($row['store_view_code']) && !empty($row['store_view_code']) ? $row['store_view_code'] : null;
                        $productImagesRows = isset($row['additional_images']) && !empty($row['additional_images']) ? $row['additional_images'] : null;
                        $productAttributes = isset($row['additional_attributes']) && !empty($row['additional_attributes']) ? $row['additional_attributes'] : null;
                        preg_match_all("/([a-zA-Z0-9_]+=(?:[<>\p{Arabic}a-zA-Z0-9×\s\-\–\/\;\'\"\:\%\.\&\@\~\+\*\(\)\=]|(,Ä≥)|(,,)|(?:,\s))+)/u", $productAttributes, $output_array);


                        if (isset($row['sku']) && $row['sku'] != null && isset($row['sku'])) {
                            $product = Product::where('sku', $row['sku'])->whereNotNull('parent_id')->first();

                            $mainProduct = $product ? $product->parent : null;
                            if (!$product || !$mainProduct) {
                                continue;
                            }
                            if (!$productLang) {
                                if (isset($output_array[0]) && is_array($output_array[0])) {
                                    ProductOptionValues::where('product_id', $mainProduct->id)->where('type', 0)->delete();
                                    foreach ($output_array[0] as $attribute) {
                                        $optionValues = explode('=', $attribute, 2);
                                        $optionData = isset($optionValues[0]) ? $optionValues[0] : null;
                                        $valueData = isset($optionValues[1]) ? rtrim($optionValues[1], ",") : null;


                                        if ($optionData == "mgs_brand") {
                                            $brand = Brand::firstOrCreate([
                                                'name' => $valueData
                                            ]);
                                            $mainProduct->update(['brand_id' => $brand->id]);
                                        }
                                        if ($optionData && $valueData) {
                                            $option = Option::where('name_en', $optionData)->where('type', 5)->first();
                                            if (!$option) {
                                                $option = Option::create(['name_en' => $optionData, 'name_ar' => $optionData, 'type' => 5,]);
                                            }
                                            $productOptionValue = ProductOptionValues::where('product_id', $mainProduct->id)->where('option_id', $option->id)->first();
                                            if ($productOptionValue) {
                                                $productOptionValue->update(['input_en' => $valueData, 'input_ar' => $valueData]);
                                            } else {
                                                ProductOptionValues::create(['product_id' => $mainProduct->id, 'option_id' => $option->id, 'input_en' => $valueData, 'input_ar' => $valueData, 'type' => "0"]);
                                            }
                                            CategoryOption::firstOrCreate([
                                                'option_id' => $option->id,
                                                'sub_category_id' => $mainProduct->category->id
                                            ]);
                                        }
                                    }
                                }
                                if ($productImagesRows) {
                                    $productImagesRows = explode(',', $productImagesRows);
                                    if (is_array($productImagesRows)) {
                                        $product->images()->delete();
                                        foreach ($productImagesRows as $productImagesRow) {
                                            if ($productImagesRow && $productImagesRow != $row['base_image']) {
                                                $product->images()->create(["url" => config('app.website_url') . "/media/catalog/product" . $productImagesRow]);
                                            }
                                        }
                                    }
                                }

                                $x = 1;
                                while ((isset($row['option_name_' . $x]) && !empty($row['option_name_' . $x]))) {
                                    $option = Option::where('name_en', trim($row['option_name_' . $x]))->first();

                                    if ($option) {
                                        if ($x == 1) {
                                            // make first option the default
                                            $mainProduct->update(["option_default_id" => $option->id]);
                                            $product->update(["option_default_id" => $option->id]);
                                        }

                                        $value = OptionValue::where('name_en', trim($row['option_value_' . $x]))->where('option_id', $option->id)->first();
                                        $variantOptionValueData = [
                                            'product_id' => $product->id,
                                            'option_id' => $option->id,
                                            'type' => '1'
                                        ];

                                        if ($option->type == 4 && $value) {
                                            $variantOptionValueData['value_id'] = $value ? $value->id : null;
                                            //    $image = isset($row['option_image_' . $x]) ? $row['option_image_' . $x] : '';
                                            //    if (filter_var($image, FILTER_VALIDATE_URL) === FALSE) {
                                            //        $image = str_replace(' ', '-', $image);
                                            //        $image = url("storage/uploads/" . $image);
                                            //    }
                                            $image = $productMainImage;
                                            $variantOptionValueData['image'] = isset($row['option_image_' . $x]) ? $image : '';
                                            ProductOptionValues::updateOrCreate(['product_id' => $product->id, 'option_id' => $option->id], $variantOptionValueData);
                                        } elseif ($value) {
                                            $variantOptionValueData['value_id'] = $value->id;
                                            ProductOptionValues::updateOrCreate(['product_id' => $product->id, 'option_id' => $option->id], $variantOptionValueData);
                                        } else {
                                            $totalMissedVariantsCount++;
                                            $missedDetails[] = 'variant with sku ' . $sku . '( value ' . $row['option_value_' . $x] . ' Not Found )';
                                        }

                                    } else {
                                        $totalMissedVariantsCount++;
                                        $missedDetails[] = 'variant with sku ' . $sku . '( option ' . $row['option_name_' . $x] . ' Not Found )';
                                    }
                                    $x++;
                                }

                            } elseif ($productLang == "sa") {
                                if (isset($output_array[0]) && is_array($output_array[0])) {
                                    // ProductOptionValues::where('product_id', $mainProduct->id)->where('type', 0)->delete();
                                    foreach ($output_array[0] as $attribute) {
                                        $optionValues = explode('=', $attribute, 2);
                                        $optionData = isset($optionValues[0]) ? $optionValues[0] : null;
                                        $valueData = isset($optionValues[1]) ? rtrim($optionValues[1], ",") : null;
                                        if ($optionData && $valueData) {
                                            $option = Option::where('name_en', $optionData)->where('type', 5)->first();
                                            if (!$option) {
                                                $option = Option::create(['name_en' => $optionData, 'name_ar' => $optionData, 'type' => 5,]);
                                            }
                                            $productOptionValue = ProductOptionValues::where('product_id', $mainProduct->id)->where('option_id', $option->id)->first();
                                            if ($productOptionValue) {
                                                $productOptionValue->update(['input_ar' => $valueData]);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        usleep(200);
                    }
                }

            });
            $totalApprovedProductsCount = $totalCreatedProductsCount + $totalUpdatedProductsCount;
            $totalApprovedVariantsCount = $totalCreatedVariantsCount + $totalUpdatedVariantsCount;
            $totalApprovedCount = $totalApprovedProductsCount + $totalApprovedVariantsCount;
            $totalMissedCount = $totalMissedProductsCount + $totalMissedVariantsCount;
            $totalCreatedCount = $totalCreatedProductsCount + $totalCreatedVariantsCount;
            $totalUpdatedCount = $totalUpdatedProductsCount + $totalUpdatedVariantsCount;
            $data = [
                'total_count' => $totalCount,
                // 'total_product_count' => count($mainProductIDS),
                // 'total_variant_product_count' => count($variantProductIDS),
                // 'total_approved_count' => $totalApprovedCount,
                // 'total_approved_products_count' => $totalApprovedProductsCount,
                // 'total_approved_variants_count' => $totalApprovedVariantsCount,
                // 'total_missed_count' => $totalMissedCount,
                // 'total_missed_products_count' => $totalMissedProductsCount,
                // 'total_missed_variants_count' => $totalMissedVariantsCount,
                // 'total_created_count' => $totalCreatedCount,
                // 'total_created_products_count' => $totalCreatedProductsCount,
                // 'total_created_variants_count' => $totalCreatedVariantsCount,
                // 'total_updated_count' => $totalUpdatedCount,
                // 'total_updated_products_count' => $totalUpdatedProductsCount,
                // 'total_updated_variants_count' => $totalUpdatedVariantsCount,
                // 'missed_details' => $missedDetails,
            ];
            Log::info("IMPORT FINISHED");
            Artisan::call('sitemap:generate');
            Artisan::call('cache:clear');
            $this->pushService->notifyAdmins("File Imported", "Your import has completed! You can check the result from", '', 10, json_encode($data), auth()->user()->id);
            return $this->jsonResponse("Success", $data);
        } catch (\Exception $e) {

            Log::error("ImportFactory File Error: " . $e->getMessage());
            return $this->errorResponse($e->getMessage(), "Invalid data", $e->getTrace(), 422);
        }
    }

    public function clone($id)
    {
        $product = Product::findOrFail($id);
        $clonedProduct = $this->productsService->cloneProduct($product);
        if ($clonedProduct->parent_id) {
            return $this->jsonResponse("Success", $this->productVariantTrans->transform($clonedProduct));
        } else {
            return $this->jsonResponse("Success", $this->productTrans->transform($clonedProduct));
        }

    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $productIds = $product->productVariants->pluck('id');
        $productIds->push($id);

        $ids = [$id];
        foreach ($product->productVariants as $variant) {
            $variant->update(['sku' => $variant->sku . '_deleted_' . strtotime(now())]);
            $ids[] = $variant->id;
            $variant->delete();
        }
        Notification::where('type', Notification::TYPE_PRODUCT)->whereIn('item_id', $ids)->delete();
        $product->update(['sku' => $product->sku . '_deleted_' . strtotime(now())]);
        $product->delete();

        CartItem::whereIn('product_id', $productIds)->delete();

        return $this->jsonResponse("Success");
    }

    public function exportToFb()
    {
        $fileName = "fb_products_".date("YmdHis").".csv";
        $filePath = 'public/exports/fb/' . $fileName;
        $fileUrl = url("storage/exports/fb") . "/" . $fileName;

        Excel::store(new ProductToFbExport, $filePath);

        $this->pushService->notifyAdmins("File Exported ", "Your export has completed! You can download the file from ", '', 11, $fileUrl);

        Log::channel('exports')->info('Action: Full Export Product, File link: ' . $fileUrl . ' from Admin' . ' Date: ' . now());

        return $this->jsonResponse("Success");
    }
}
