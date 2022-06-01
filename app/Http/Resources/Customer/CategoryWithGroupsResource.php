<?php

namespace App\Http\Resources\Customer;

use Facades\App\Models\Transformers\ProductTransformer;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryWithGroupsResource extends JsonResource
{
    public function toArray($request)
    {
//        $categoryProducts = $this->subCategories()->with(['products' => function ($q) {
//            return $q->orderBy('id', 'desc')->take(10);
//        }])->get()->pluck('products')->flatten(1);

        return [
            'id' => $this->id,
            'name' => $this->name, //$this->getName($request->header('lang')),
            'name_en' => $this->name, //$this->getName($request->header('lang')),//$this->getName($request->header('lang')),
            'name_ar' => $this->name_ar, //$this->getName($request->header('lang')),
            'description' => $this->getDescription($request->header('lang')),
            'description_en' => $this->description,
            'description_ar' => $this->description_ar,
            'name' => $this->name, //$this->getName($request->header('lang')),
            'order' => $this->order,
            'parent_id' => $this->parent_id,
            'image' => $this->image,
            'attributes' => [],
            'groups' => $this->homeGroups($request->header('lang')),
//            'products' => ProductTransformer::transformCollection($categoryProducts),
        ];
    }
}
