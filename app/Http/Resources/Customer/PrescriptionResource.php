<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class PrescriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $adminCancellation = $this->cancellationReason ? $this->cancellationReason->user_type == 'admin' : false;

        return [
            "id" => $this->id,
            "note" => $this->note,
            "images" => $this->images->pluck('url'),
            "status" => $this->status,
            "created_at" => $this->created_at,
            "creation_date" => (string)$this->created_at,
            "user" => $this->user,
            "address" => $this->address,
            "cancellation_id" => $adminCancellation ? null : $this->cancellation_id,
            "cancellation_reason" => $adminCancellation ? null : $this->CancellationReason,
            "cancellation_text" => $adminCancellation ? null : $this->cancellation_text,
        ];
    }
}
