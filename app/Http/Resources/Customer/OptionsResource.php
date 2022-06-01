<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class OptionsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->getName($request->header('lang')),
            "values" => OptionValuesResource::collection($this->values),
        ];
    }
}
