<?php

namespace App\Models\Transformers\Customer;

use App\Models\Transformers\Transformer;
use Illuminate\Http\Request;

class BrandsTransformer extends Transformer
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    public function transform($brand)
    {
        return [
            "id" => $brand->id,
            "name" => $brand->getName($this->request->header('lang')),
        ];
    }
}
