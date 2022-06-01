<?php

namespace App\Models\Transformers\Customer;

use App\Models\Repositories\ProductRepository;
use App\Models\Transformers\ProductTransformer;
use App\Models\Transformers\Transformer;
use Illuminate\Http\Request;

class ListTransformer extends Transformer
{
    private $request;
    private $productRepo;
    private $productTrans;

    public function __construct(Request $request, ProductRepository $productRepo,ProductTransformer $productTrans)
    {
        $this->productRepo = $productRepo;
        $this->request = $request;
        $this->productTrans = $productTrans;
    }

    public function getProductList($list)
    {
        $data = $this->productTrans->transformCollection($list->products);
        return $data;
    }


    public function transform($list)
    {
        return [
            "id"=>$list->id,
            "name"=>$list->getName(),
            "description"=>$list->getDescription(),
            "image"=>$list->getImage(),
            "products"=>$this->getProductList($list),
        ];
    }
}
