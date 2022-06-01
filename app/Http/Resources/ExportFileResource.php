<?php

namespace App\Http\Resources;

use App\Services\ExportFiles\ExportConstants;
use Illuminate\Http\Resources\Json\JsonResource;

class ExportFileResource extends JsonResource
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
            'id' => $this->id,
            'progress' => $this->progress,
            'state' => [
                'id' => $this->state,
                'name' => ExportConstants::getStateConstantsNames($this->state)
            ],
            'type' => $this->type,
            'finish_date' => $this->finish_date,
            'created_at' => $this->created_at->toDateString(),
            'user'=> $this->user
        ];
    }
}
