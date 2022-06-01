<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->type == 1) {
            $name = $this->product ? $this->product->getName($request->header("lang")) : "";
        } elseif ($this->type == 2) {
            $name = $this->sub_category ? $this->sub_category->getName($request->header("lang")) : "";
        } elseif ($this->type == 4) {
            $name = $this->brand ? $this->brand->getName($request->header("lang")) : "";
        } else {
            $name = "-";
        }

        return [
            "title" => $this->title,
            "body" => $this->body,
            "title_ar" => $this->title_ar,
            "body_ar" => $this->body_ar,
            "type" => $this->type,
            "item_id" => $this->item_id,
            "item_link" => $this->item_link ?? null,
            "read" => $this->read,
            "image" => $this->image,
            "name" => $name,
            "created_at" => (string)$this->created_at
        ];
    }
}
