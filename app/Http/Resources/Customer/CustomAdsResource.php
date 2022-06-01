<?php

namespace App\Http\Resources\Customer;

use App\Models\Repositories\ProductRepository;
use App\Models\Transformers\Customer\BrandsTransformer;
use App\Models\Transformers\Customer\CategoryTransformer;
use App\Models\Transformers\Customer\ListTransformer;
use App\Models\Transformers\ProductTransformer;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomAdsResource extends JsonResource
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
            if ($ads->tags)
                $itemData = $ads->tags;
        } elseif ($ads->type == 6) {
            if ($ads->lists)
                $itemData = $this->ListTrans->transform($ads->lists);
        }
        return $itemData;
    }
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->getName(),
            "description" => $this->getDescription(),
            "image" => $this->getImage(),
            "type" => $this->type,
            "active" => $this->active,
            "dev_key" => $this->dev_key,
            "item_id" => $this->item_id,
            "item_data" => $this->itemData($ads),
        ];
    }
}
