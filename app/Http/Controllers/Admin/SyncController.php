<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendSMSViaOrange;
use App\Models\Products\Category;
use App\Models\Users\CustomerRequest;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Products\Product;
use App\Models\Products\ProductVariant;

class SyncController extends Controller
{
    public function syncUsers(Request $request)
    {
        $mssqlConnection = DB::connection('sqlsrv');
        $merchants = $mssqlConnection->table('dbo.users')->get();
        $sendSmsTo = [];
        $existedUsers = [];
        foreach($merchants as $merchant) {
            $existedUsers[] = $merchant->user_code;
            try {
                $password = random_int(10000000, 99999999);
            } catch (\Exception $exception) {
                $password = 35779265; //default password
            }
            $existMerchant = User::where('code', $merchant->user_code)->first();
            if ($existMerchant) {
                $existMerchant->update([
                    'phone' => $merchant->Phone,
                    'name' => $merchant->username,
                ]);
            } else {
                $newMerchant = User::create(
                    [
                        'code' => $merchant->user_code,
                        'phone' => $merchant->Phone,
                        'name' => $merchant->username,
                        'password' => bcrypt($password),
                        'phone_verified' => true
                    ]
                );
                $sendSmsTo[$merchant->Phone] = $password;
                $message = __('sync_user_message', ['password' => $password], 'ar');

                try {
                    SendSMSViaOrange::dispatch($merchant->Phone, $message);
                } catch (\Exception $exception) {
                    Log::channel('orange_sms')->info('Error sending sms to phone : ' . $merchant->Phone);
                }
            }
            CustomerRequest::where('mobile', $merchant->Phone)->delete();
        }
        DB::table('users')->where(function($query) use($existedUsers) {
            $query->whereNotIn('code', $existedUsers)->whereNotIn('id', [1, 999999]);
        })->delete();
        return $this->jsonResponse('Users synced successfully');

    }

    public function syncProducts(Request $request)
    {
        $mssqlConnection = DB::connection('sqlsrv');
        $products = $mssqlConnection->table('dbo.Products')
            ->join('dbo.product_price_list', 'dbo.Products.Prod_id', '=', 'dbo.product_price_list.product_id')
            ->join('dbo.product_sub_family', 'dbo.product_sub_family.sub_family_id', '=', 'dbo.Products.sub_family_id')->get();

        $existedProducts = [];
        foreach($products as $product) {
            $existedProduct = Product::where('prod_id', $product->Prod_id)->first();
            $category = Category::where('family_id', $product->family_id)->first();
            if ($existedProduct) {
                $existedProduct->parent->update([
                    'name' => $product->prod_name,
                    'name_ar' => $product->prod_name_ar,
                    'description' => $product->prod_name,
                    'description_ar' => $product->prod_name,
                    'category_id' => $category->id,
                ]);
                $existedProduct->update([
                    'name' => $product->prod_name,
                    'name_ar' => $product->prod_name_ar,
                    'description' => $product->prod_name,
                    'description_ar' => $product->prod_name,
                    'category_id' => $category->id,
                    'type' => 1,
                    'active' => 1,
                    'price' => $product->pricelist_carton,
                    'tax_percentage' => $product->tax_percentage,
                    'fix_tax' => $product->FIX_TAX
                ]);
                $existedProducts[]  = $existedProduct->id;
                $existedProducts[] = $existedProduct->parent->id;
            } else {
                $mainProduct = Product::create(
                    [
                        'sku' => 'main_' . $product->Prod_code,
                        'name' => $product->prod_name,
                        'name_ar' => $product->prod_name_ar,
                        'description' => $product->prod_name,
                        'description_ar' => $product->prod_name,
                        'category_id' => $category->id,
                        'stock' => 99999,
                        'type' => 1,
                        'active' => 1,
                        'price' => $product->pricelist_carton,
                        'last_editor' => auth()->User()->id,
                        'creator_id' => auth()->User()->id
                    ]
                );

                $variantProduct = Product::create(
                    [
                        'prod_id' => $product->Prod_id,
                        'parent_id' => $mainProduct->id,
                        'name' => $product->prod_name,
                        'name_ar' => $product->prod_name_ar,
                        'description' => $product->prod_name,
                        'description_ar' => $product->prod_name,
                        'category_id' => $category->id,
                        'sku' => $product->Prod_code,
                        'stock' => 99999,
                        'type' => 1,
                        'active' => 1,
                        'price' => $product->pricelist_carton,
                        'last_editor' => auth()->User()->id,
                        'creator_id' => auth()->User()->id,
                        'tax_percentage' => $product->tax_percentage,
                        'fix_tax' => $product->FIX_TAX
                    ]
                );
                $existedProducts[]  = $variantProduct->id;
                $existedProducts[] = $variantProduct->parent->id;
            }
        }
        Product::whereNotIn('id', $existedProducts)->delete();
        return $this->jsonResponse('Products synced successfully');
    }

    public function syncProductFamily(Request $request)
    {
        $mssqlConnection = DB::connection('sqlsrv');
        $productFamilies = $mssqlConnection->table('dbo.Prod_family')->get();

        $existedFamilies = [];
        $existedParentFamilies = [];
        foreach($productFamilies as $productFamily) {
            $existedFamilies[] = $productFamily->Family_id;
            $existFamily = Category::where('family_id', $productFamily->Family_id)->first();
            if ($existFamily) {
                $existedParentFamilies[] = $existFamily->parent_id;
                $existFamily->update([
                    'name' => $productFamily->Family_name,
                    'name_ar' => $productFamily->Family_name_ar,
                ]);
            } else {
                $newFamily = Category::create(
                    [
                        'active' => 1,
                        'name' => $productFamily->Family_name,
                        'name_ar' => $productFamily->Family_name_ar,
                    ]
                );
                Category::create(
                    [
                        'active' => 1,
                        'family_id' => $productFamily->Family_id,
                        'name' => $productFamily->Family_name,
                        'name_ar' => $productFamily->Family_name_ar,
                        'parent_id' => $newFamily->id
                    ]
                );
            }
        }
        Category::where(function($query) use($existedFamilies, $existedParentFamilies) {
            $query->whereNotIn('family_id', $existedFamilies)->WhereNotIn('id', $existedParentFamilies);
        })->delete();
        return $this->jsonResponse('Family synced successfully');

    }

    public function syncAll(Request $request)
    {
//        $this->syncUsers($request);
        $this->syncProductFamily($request);
        $this->syncProducts($request);

        return $this->jsonResponse('All data synced successfully');
    }

    /**
     * Get incentive types from Mansour Database
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function incentiveTypes()
    {
        $mssqlConnection = DB::connection('sqlsrv');
        $incentiveTypes = $mssqlConnection->table('dbo.incentive_types')->get();
        return $this->jsonResponse('Success', $incentiveTypes);
    }

    public function storeProduct(Request $request)
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
    
    public function storeProductVariant(Request $request, $mainProductID)
    {
        $product = Product::MainProduct()->where('id', $mainProductID)->first();

        if (!$product) {
            return $this->jsonResponse('Product Not Found', null);
        }
        //validate request
        $validator = Validator::make($request->all(), [
            'sku' => 'required|unique:products,sku',
            'name' => 'required',
            'name_ar' => 'required',
            'description' => 'required',
            'description_ar' => 'required',
            'long_description_en' => 'sometimes|nullable',
            'long_description_ar' => 'sometimes|nullable',
            'meta_title_ar' => 'sometimes|nullable',
            'meta_description_ar' => 'sometimes|nullable',
            'meta_title' => 'sometimes|nullable',
            'meta_description' => 'sometimes|nullable',
            'image' => 'required',
            'images' => 'sometimes|nullable|array',
            'price' => 'sometimes|nullable|numeric',
            'video' => 'sometimes|nullable',
            'available_soon' => 'sometimes|nullable|in:0,1',
            'bundle_checkout' => 'sometimes|nullable|in:0,1',
            'preorder_price' => 'sometimes',
            'preorder' => 'sometimes',
            'stock' => 'required|integer',
            'weight' => 'sometimes|nullable',
            'stock_alert' => 'sometimes|nullable|integer',
            'barcode' => 'sometimes|nullable|string',
            'subtract_stock' => 'sometimes|nullable|boolean',
            'discount_price' => 'sometimes|nullable|numeric',
            'discount_start_date' => 'nullable|date',
            'discount_end_date' => 'nullable|date',
            'options.*.option_id' => 'sometimes|nullable|integer|exists:options,id',
            'options.*.option_value_id' => 'sometimes|nullable|integer|exists:option_values,id',
            'options.*.input_en' => 'sometimes|nullable|string',
            'options.*.input_ar' => 'sometimes|nullable|string',
            'options.*.option_image' => 'sometimes|nullable|string',
            'order' => 'sometimes|nullable|integer',
            'product_with_variant' => 'required|boolean',
            'affiliate_commission' => 'sometimes|nullable',
            'free_delivery' => 'sometimes|boolean',
        ]);
        if ($validator->fails()) {
            if($request->has('product_with_variant') && $request->get('product_with_variant')){
                $product->forceDelete();
            }
            return $this->errorResponse($validator->errors()->first(), 'Invalid data', $validator->errors(), 422);
        }
        $data = $validator->validated();

        if($request->get('discount_start_date') != null && $request->get('discount_end_date') != null){
            $isEndDateBeforeStart = Carbon::parse($request->get('discount_start_date')) > Carbon::parse($request->get('discount_end_date'));
            if($isEndDateBeforeStart){
                return $this->errorResponse('Discount end date before start date', 'Invalid data');
            }
        }
        $data['last_editor'] = auth()->User()->id;
        $data['creator_id'] = auth()->User()->id;
        $data['parent_id'] = $product->id;
        $data['category_id'] = $product->category_id;
        $data['brand_id'] = $product->brand_id;
        // $productVariant = Product::create($product->toArray());
        $productVariant = $product->replicate();
        $productVariant->sku = $data['sku'];
        $productVariant->save();
    
        $productVariant->update($data);
        if (is_null($request->order)) {
            $productVariant->update(['order' => $productVariant->id]);
        }
        if ($request->images) {
            foreach ($request->images as $image) {
                if (isset($image['url']) && !empty($image['url'])) {
                    $productVariant->images()->create(['url' => $image['url']]);
                }
            }
        }
        if (2 == $product->type && $request->bundle_products_ids) {
            $bundleProducts = Product::where('type', 1)->whereIn('id', $request->bundle_products_ids)->where("id", "!=", $productVariant->id)->whereNotNull('parent_id')->pluck('id');
            $productVariant->bundleProduct()->attach($bundleProducts);
        }

        if($request->has('payment_method_discount_ids')){
            $productVariant->paymentMethods()->sync($request->get('payment_method_discount_ids'));
        }

        if ($request->option_values && is_array($request->option_values)) {
            foreach ($request->option_values as $option_value) {
                $option = Option::find($option_value['option_id']);

                if ($option) {
                    $categoryOptions = CategoryOption::where('sub_category_id', $productVariant->category_id)->where('option_id', $option->id)->first();
                    $value = OptionValue::where('id', $option_value['option_value_id'])->where('option_id', $option->id)->first();
                    if ($categoryOptions) {
                        $data = [
                            'product_id' => $productVariant->id,
                            'option_id' => $option->id,
                            'type' => '0',
                            'created_by' => \Auth::id(),
                        ];
                        if (5 == $option->type && isset($option_value['input_en'], $option_value['input_ar'])) {
                            $data['input_en'] = $option_value['input_en'];
                            $data['input_ar'] = $option_value['input_ar'];
                        } elseif (4 == $option->type && isset($option_value['image'])) {
                            $data['image'] = $option_value['image'];
                        } elseif ($value) {
                            $data['value_id'] = $value->id;
                        }
                        $productOptionValue = ProductOptionValues::updateOrCreate($data);
                    }
                }
            }
        }

        if ($request->options && is_array($request->options)) {
            foreach ($request->options as $option) {
                $optionData = Option::find($option['option_id']);
                if ($optionData) {
                    $value = OptionValue::find($option['option_value_id']);
                    $variantOptionValueData = [
                        'product_id' => $productVariant->id,
                        'option_id' => $optionData->id,
                        'type' => '1',
                        'created_by' => \Auth::id(),
                    ];
                    if (4 == $optionData->type && $value) {
                        $variantOptionValueData['value_id'] = $value ? $value->id : null;
                        $variantOptionValueData['image'] = isset($option['option_image']) ? $option['option_image'] : '';
                        ProductOptionValues::create($variantOptionValueData);
                    } elseif (5 == $optionData->type) {
                        $variantOptionValueData['input_en'] = isset($option['input_en']) ? $option['input_en'] : '';
                        $variantOptionValueData['input_ar'] = isset($option['input_ar']) ? $option['input_ar'] : '';
                        ProductOptionValues::create($variantOptionValueData);
                    } elseif ($value) {
                        $variantOptionValueData['value_id'] = $value->id;
                        ProductOptionValues::create($variantOptionValueData);
                    }
                }
            }
        }
        $this->resetProductVariantList($product->id);
        Cache::forget('sections');

        return $this->jsonResponse('Success', $this->productVariantTrans->transform($productVariant));
    }
}
