<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Products\Lists;
use App\Models\Products\Option;
use Illuminate\Validation\Rule;
use App\Jobs\StockNotifications;
use App\Models\Products\Product;
use App\Http\Controllers\Controller;
use App\Models\Products\OptionValue;
use App\Models\Services\PushService;
use Illuminate\Support\Facades\Cache;
use App\Models\Products\CategoryOption;
use Doctrine\DBAL\Schema\AbstractAsset;
use Illuminate\Support\Facades\Validator;
use App\Models\Products\ProductOptionValues;
use App\Models\Transformers\ProductFullTransformer;
use App\Models\Transformers\ProductVariantFullTransformer;

class ProductVariantsController extends Controller
{
    private $productTrans;
    private $pushService;
    private $lists;
    private $productVariantTrans;

    /**
     * Constructor
     *
     * @param ProductFullTransformer $productTrans
     * @param ProductVariantFullTransformer $productVariantTrans
     * @param PushService $pushService
     * @param Lists $lists
     */
    public function __construct(ProductFullTransformer $productTrans, ProductVariantFullTransformer $productVariantTrans, PushService $pushService, Lists $lists)
    {
        $this->productVariantTrans = $productVariantTrans;
        $this->productTrans = $productTrans;
        $this->pushService = $pushService;
        $this->lists = $lists;
    }

    public function store(Request $request, $mainProductID)
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
            'stock' => 'required|numeric',
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

    public function update(Request $request, $mainProductID, $variantID)
    {
        $product = Product::where('id', $mainProductID)->first();
        $productVariant = Product::where('parent_id', $mainProductID)->where('id', $variantID)->first();

        if (!$productVariant || !$product) {
            return $this->jsonResponse('Product Not Found', null);
        }
        // validate request
        $validator = Validator::make($request->all(), [
            'sku' => ['required', Rule::unique('products')->ignore($variantID)],
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
            'stock' => 'required|numeric',
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
            'affiliate_commission' => 'sometimes|nullable',
            'free_delivery' => 'sometimes|boolean',
        ]);
        if ($validator->fails()) {
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
        $data['category_id'] = $product->category_id;
        $data['brand_id'] = $product->brand_id;

        $productVariant->update($data);
        if ($productVariant->stock > 0) {
            dispatch(new StockNotifications($productVariant));
        }

        if ($request->images) {
            $productVariant->images()->delete();
            foreach ($request->images as $image) {
                if (isset($image['url']) && !empty($image['url'])) {
                    $productVariant->images()->create(['url' => $image['url']]);
                }
            }
        }
        if($request->has('images') && !count($request->images)) {
            $productVariant->images()->delete();
        }

        if($request->has('payment_method_discount_ids')){
            $productVariant->paymentMethods()->sync($request->get('payment_method_discount_ids'));
        }

        if (2 == $product->type && $request->bundle_products_ids) {
            $bundleProducts = Product::where('type', 1)->whereIn('id', $request->bundle_products_ids)->where("id", "!=", $productVariant->id)->whereNotNull('parent_id')->pluck('id');
            $productVariant->bundleProduct()->sync($bundleProducts);
        }

        if ($request->option_values && is_array($request->option_values)) {
            ProductOptionValues::where('product_id', $productVariant->id)->where('type', '0')->delete();
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
            ProductOptionValues::where('product_id', $productVariant->id)->where('type', '1')->delete();
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
        $this->resetProductVariantList($mainProductID);

        Cache::forget("product_images_{$productVariant->id}");
        Cache::forget("product_images_{$product->id}");
        Cache::forget('product_'.$productVariant->id.'_1_options');
        Cache::forget('product_'.$productVariant->id.'_2_options');
        Cache::forget('product_'.$product->id.'_1_options');
        Cache::forget('product_'.$product->id.'_2_options');
        Cache::forget('sections');

        return $this->jsonResponse('Success', $this->productVariantTrans->transform($productVariant));
    }

    public function resetProductVariantList($id)
    {
        $variantOptions = [];
        $mainProductOptions = [];
        $mainProducts = Product::MainProduct()->where('id', $id)->get();
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
            ++$i;
        }
//        $this->pushService->notifyAdmins("Products Reseated", "All Products Reseated Successfully", '', 10, '', \Auth::id());
        return $this->jsonResponse('Success', $i);
    }
}
