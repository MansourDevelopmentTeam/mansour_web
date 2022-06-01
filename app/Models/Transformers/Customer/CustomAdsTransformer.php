<?php

namespace App\Models\Transformers\Customer;

use App\Models\Repositories\ProductRepository;
use App\Models\Transformers\ProductTransformer;
use App\Models\Transformers\Transformer;

class CustomAdsTransformer extends Transformer
{
    private $productRepo;
    private $productTrans;
    private $BrandsTrans;
    private $ListTrans;
    private $CategoryTrans;

    public function __construct(CategoryTransformer $categoryTrans, ListTransformer $ListTrans, ProductRepository $productRepo, ProductTransformer $productTrans, BrandsTransformer $BrandsTrans)
    {
        $this->productRepo = $productRepo;
        $this->ListTrans = $ListTrans;
        $this->productTrans = $productTrans;
        $this->BrandsTrans = $BrandsTrans;
        $this->CategoryTrans = $categoryTrans;
    }
    public function itemData($ads)
    {
        $itemData = null;
        if ($ads->type == 1) {
            if ($ads->product)
                $itemData = $this->productTrans->transform($ads->product);
        } elseif ($ads->type == 2) {
            if ($ads->category)
                $itemData = $this->CategoryTrans->transform($ads->category);
        } elseif ($ads->type == 3) {
            if ($ads->sub_category)
                $itemData = $this->CategoryTrans->transform($ads->sub_category);
        } elseif ($ads->type == 4) {
            if ($ads->brand)
                $itemData = $this->BrandsTrans->transform($ads->brand);
        } elseif ($ads->type == 5) {
            if ($ads->customList)
                $itemData = $ads->customList;
        } elseif ($ads->type == 6) {
            if ($ads->lists)
                $itemData = $this->ListTrans->transform($ads->lists);
        }
        return $itemData;
    }

    public function transform($ads)
    {
        return [
            "id" => $ads->id,
            "name" => $ads->getName(),
            "description" => $ads->getDescription(),
            "image" => $ads->getImage(),
            "image_web" => $ads->getImageWeb(),
            "just_image_web" => $ads->image_web,
            "type" => $ads->type,
            "active" => $ads->active,
            "dev_key" => $ads->dev_key,
            "item_id" => $ads->item_id,
            "link" => $ads->link,
            "item_data" => $this->itemData($ads),
        ];
    }
}
