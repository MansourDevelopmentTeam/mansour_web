<?php

namespace App\Models\Transformers;

use App\Models\Services\PushService;
use Illuminate\Http\Request;

/**
 *
 */
class CustomAdsTransformer extends Transformer
{
    private $productTrans;

    public function __construct(ProductFullTransformer $productTrans)
    {
        $this->productTrans = $productTrans;
    }

    public function itemData($ads)
    {
        $itemData = null;
        if ($ads->type == 1) {
            $itemData = $this->productTrans->transform($ads->product);
        } elseif ($ads->type == 2) {
            $itemData = $ads->category->load("subCategories");
        } elseif ($ads->type == 3) {
            $itemData = $ads->sub_category->load("parent");
        } elseif ($ads->type == 4) {
            $itemData = $ads->brand;
        } elseif ($ads->type == 5) {
            $itemData = $ads->lists;
        }
        return $itemData;
    }


    public function transform($ads)
    {
        return [
            "id" => $ads->id,
            "name_en" => $ads->name_en,
            "name_ar" => $ads->name_ar,
            "description_ar" => $ads->description_ar,
            "description_en" => $ads->description_en,
            "type" => $ads->type,
            "image_en" => $ads->image_en,
            "image_ar" => $ads->image_ar,
            "image_web" => $ads->image_web,
            "image_web_ar" => $ads->image_web_ar,
            "active" => $ads->active,
            "dev_key" => $ads->dev_key,
            "item_id" => $ads->item_id,
            "link" => $ads->link,
            "item_data" => $this->itemData($ads),
        ];
    }
}
