<?php

namespace App\Http\Resources\Client;

use App\Models\Transformers\CustomerOrderTransformer;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class EarnedPointsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $orderTrans = app()->make(CustomerOrderTransformer::class);

        return [
            "id" => $this->id,
            "amount" => $this->amount_spent,
            "total_points" => $this->total_points,
            "type" => ($this->referer ? 2 : 1),
            "order" => $this->order ? $orderTrans->transform($this->order) : null,
            "referer" => $this->referer,
            "date" => (string)$this->created_at,
            "activation_date" => $this->activation_date,
            "pending_days" => ($this->isActive() ? null : now()->diffInDays(Carbon::parse($this->activation_date))),
            "status" => ($this->isActive() ? 1 : 0 )
        ];
    }

    public function isActive()
    {
        return $this->activation_date < now();
    }
}
