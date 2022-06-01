<?php

namespace App\Models\Transformers\Customer;

use App\Models\Transformers\Transformer;

class StoresTransformer extends Transformer
{
    
    public function transform($store)
    {
        return [
            "id" => $store->id,
            "name" => $store->getName(),
            "description" => $store->getDescription(),
            "image" => $store->getImage(),
            "phone" => $store->phone,
            "address" => $store->address,
            "lat" => $store->lat,
            "long" => $store->long,
            "type" => $store->type,
        ];
    }
}
