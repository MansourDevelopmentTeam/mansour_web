<?php

namespace App\Models\Transformers\Customer;

use App\Models\Transformers\Transformer;

class PagesTransformer extends Transformer
{

    public function transform($page)
    {
        return [
            "id" => $page->id,
            "slug" => $page->slug,
            "title" => $page->getTitle(),
            "content" => $page->getContent(),
            "image" => $page->getImage(),
        ];
    }
}
