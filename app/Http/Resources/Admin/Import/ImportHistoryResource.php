<?php

namespace App\Http\Resources\Admin\Import;

use App\Services\ImportFiles\ImportConstants;
use Illuminate\Http\Resources\Json\JsonResource;

class ImportHistoryResource extends JsonResource
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
                'name' => ImportConstants::getStateConstantsNames($this->state)
            ],
            'type' => $this->type,
            'file_path' => $this->file_path,
            'report' => $this->report,
            'finish_date' => $this->finish_date,
            'created_at' => $this->created_at->toDateString(),
            'user'=> $this->user
        ];
    }

}
