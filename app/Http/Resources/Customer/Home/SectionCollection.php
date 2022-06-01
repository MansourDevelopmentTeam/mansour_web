<?php

namespace App\Http\Resources\Customer\Home;

use App\Models\Home\Section;
use App\Models\Repositories\ProductRepository;
use App\Http\Resources\Master\ProductCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Customer\SectionImageResource;

class SectionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($section) {

            $productRepo = new ProductRepository();

            switch ($section->type) {
                case Section::CUSTOM_LIST_TYPE:
                    $products = $productRepo->getTenProductBySection($section); 
                    break;
                case Section::MOST_RECENT_TYPE:
                    $products = $productRepo->getMostRecent();
                    break;
                case Section::MOST_BOUGHT_TYPE:
                    $products = $productRepo->getMostBought();
                    break;
                case Section::DISCOUNT_TYPE:
                    $products = $productRepo->getDiscounted(); 
                    break;
                default:
                    $products = collect([]);
                    break;
            }

            return [
                "id"=>$section->id,
                "name"=>$section->getName(),
                "name_en"=>$section->name_en,
                "name_ar"=>$section->name_ar,
                "description"=>$section->getDescription(),
                "image"=>$section->getImage(),
                "images"=> SectionImageResource::collection($section->images),
                "image_type"=>$section->image_type,
                "order"=>$section->order,
                "list_id"=>$section->list_id,
                "products" => new ProductCollection($products)
            ];

        });
    }
}
