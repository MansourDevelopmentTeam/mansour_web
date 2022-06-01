<?php

namespace App\Models\Transformers\Customer;

use App\Http\Resources\Customer\SectionImageResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Transformers\Transformer;
use App\Models\Repositories\ProductRepository;
use App\Models\Transformers\ProductTransformer;

class SectionTransformer extends Transformer
{
    private $request;
    private $productRepo;
    private $productTrans;

    public function __construct(Request $request, ProductRepository $productRepo, ProductTransformer $productTrans)
    {
        $this->productRepo = $productRepo;
        $this->request = $request;
        $this->productTrans = $productTrans;
    }

    public function getProductList($section)
    {
        $cacheKey = "section_{$section->id}";
        $data = [];

        // if (Cache::has($cacheKey)) {
        //     $data = Cache::get($cacheKey);
        // } else {
        //     if ($section->type == 0) {
        //         $data = $this->productTrans->transformCollection($section->TenProducts());
        //     } elseif ($section->type == 1) {
        //         $data = $this->productTrans->transformCollection($this->productRepo->getMostRecent());
        //     } elseif ($section->type == 2) {
        //         $data = $this->productTrans->transformCollection($this->productRepo->getMostBought());
        //     } elseif ($section->type == 3) {
        //         $data = $this->productTrans->transformCollection($this->productRepo->getDiscounted());
        //     }
        //     Cache::put($cacheKey, $data, 60*30);
        // }

        switch ($section->type) {
            case 0: // Top ten products
                $products = $section->TenProducts();
                break;
            case 1: // Most recent product
                $products = $this->productRepo->getMostRecent();
                break;
            case 2: // Most bought products
                $products = $this->productRepo->getMostBought();
                break;
            case 3: // Discounted products
                $products = $this->productRepo->getDiscounted();
                break;
        }

        return $this->productTrans->transformCollection($products);
    }


    public function transform($section)
    {
        return [
            "id"=>$section->id,
            "name"=>$section->getName(),
            "description"=>$section->getDescription(),
            "image"=>$section->getImage(),
            "images"=> SectionImageResource::collection($section->images),
            "image_type"=>$section->image_type,
            "order"=>$section->order,
            "list_id"=>$section->list_id,
            "products"=>$this->getProductList($section),
        ];
    }
}
