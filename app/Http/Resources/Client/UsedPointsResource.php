<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class UsedPointsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "amount" => $this->points_used,
            "date" => (string)$this->created_at,
            "reward" => $this->reward,
            "type" => $this->reward->type,
            "promo" => $this->promo
        ];
    }
}
