<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Customer\PaymentInstallmentResource;

class PaymentMethodsResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name, //$this->getName($request->header('lang')),
            'name_ar' => $this->name_ar,
            'is_online' => $this->is_online,
            'type' => $this->type,
            'icon' => $this->icon,
            'plans' => PaymentInstallmentResource::collection($this->plans->where('active', 1)),
        ];
    }
}
