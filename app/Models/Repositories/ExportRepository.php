<?php 

namespace App\Models\Repositories;

use App\Models\Export\Export;
use App\Models\Import\ImportHistory;
use App\Models\Products\Category;
use App\Services\ExportFiles\ExportConstants;
use App\Services\ImportFiles\ImportConstants;
use Illuminate\Support\Facades\Auth;

/**
* 
*/
class ExportRepository
{

    public function addNewExport($type){
        return Export::create([
            'progress' => 0,
            'type' => $type,
            'state' => ExportConstants::STATE_PENDING,
            'user_id' => Auth::id()
        ])->id;
    }

    public function updateHistoryProgress($progress, $id){
        Export::where('id', $id)->update([
            'progress' => $progress,
            'state' => ExportConstants::STATE_PROGRESS
        ]);
    }

    public function changeState($state, $id){
        Export::where('id', $id)->update([
            'finish_date' => now(),
            'state' => $state
        ]);
    }

    /**
     * @param $data
     * @param $query
     * @return mixed
     */
    public function filter($data, $query)
    {
        $query->when(isset($data['date_to']) && !empty($data['date_to']), function ($q) use($data){
           $q->whereDate('created_at', '<=', $data['date_to']);
        });

        $query->when(isset($data['date_from']) && !empty($data['date_from']), function ($q) use($data){
            $q->whereDate('created_at', '>=', $data['date_from']);
        });

        $query->when(isset($data['type']) && !empty($data['type']), function ($q) use($data){
            $q->where('type', $data['type']);
        });

        $query->when(isset($data['state']) && !empty($data['state']), function ($q) use($data){
            $q->where('state', $data['state']);
        });

        return $query;
    }
}
