<?php

namespace App\Models\Transformers\Customer;

use Facades\App\Models\Transformers\ProductTransformer;
use App\Models\Transformers\Transformer;
use Illuminate\Http\Request;

class CategoryTransformer extends Transformer
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function transform($cat)
    {
        $categoryProducts = $cat->subCategories()->with(['products' => function($q) {
            return $q->orderBy('id', 'desc')->take(10);
        }])->get()->pluck('products')->flatten(1);
        return [
            "id" => $cat->id,
            "name" => $cat->getName($this->request->header('lang')),
            "description" => $cat->getDescription($this->request->header('lang')),
            "order" => $cat->order,
            "parent_id" => $cat->parent_id,
            "image" => $cat->image,
            "attributes" => [],
            "sub_categories" => $this->transformCollection($cat->subCategories),
            "products" => ProductTransformer::transformCollection($categoryProducts)
        ];
    }
}
