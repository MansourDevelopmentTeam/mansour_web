<?php

namespace App\Models\Transformers\Customer;

use App\Models\Transformers\Customer\CategoryTransformer;
use App\Models\Transformers\Transformer;
use Illuminate\Http\Request;

class AdsTransformer extends Transformer
{
    private $categoryTrans;
    private $request;

    public function __construct(CategoryTransformer $categoryTrans, Request $request)
    {
        $this->categoryTrans = $categoryTrans;
        $this->request = $request;
    }


    public function transform($ad)
    {
        if ($ad->type == 1) {
            $name = $ad->product ? $ad->product->getName($this->request->header("lang")) : "";
        } elseif ($ad->type == 2) {
            $name = $ad->sub_category ? $ad->sub_category->getName($this->request->header("lang")) : "";
        } elseif ($ad->type == 4) {
            $name = $ad->brand ? $ad->brand->getName($this->request->header("lang")) : "";
        } elseif ($ad->type == 5) {
            $name = $ad->customList ? $ad->customList->getName($this->request->header("lang")) : "";
        } else {
            $name = "--";
        }
        return [
            "id" => $ad->id,
            "image" => $this->getImage($ad),
            "image_web" => $this->getImageWeb($ad),
            "type" => $ad->type,
            "item_id" => $ad->item_id,
            "name" => $name,
            "popup" => $ad->popup,
            "order" => $ad->order,
            "banner_title" => $this->request->header("lang") == 1 ? $ad->banner_title : $ad->banner_title_ar,
            "banner_description" => $this->request->header("lang") == 1 ? $ad->banner_description : $ad->banner_description_ar
        ];
    }

    public function getImage($ad)
    {
        if (request()->header("lang") == '2') {
            return $ad->image_ar;
        } else {
            return $ad->image;
        }
    }
    public function getImageWeb($ad)
    {
        if (request()->header("lang") == '2') {
            return $ad->image_web_ar;
        } else {
            return $ad->image_web;
        }
    }
}
