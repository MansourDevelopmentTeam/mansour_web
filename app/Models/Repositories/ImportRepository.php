<?php

namespace App\Models\Repositories;

use App\Models\Import\ImportHistory;
use App\Services\ImportFiles\ImportConstants;
use Illuminate\Support\Facades\Auth;
use Facades\App\Models\Services\PushService;

/**
*
*/
class ImportRepository
{

    /**
     * @param $type
     * @param $filePath
     * @return mixed
     */
    public function storeHistory($type, $filePath){
        return ImportHistory::create([
            'progress' => 0,
            'type' => $type,
            'state' => ImportConstants::STATE_PENDING,
            'file_path' => $filePath,
            'user_id' => Auth::id()
        ])->id;
    }

    public function updateHistoryProgress($progress, $id){
        ImportHistory::where('id', $id)->update([
            'progress' => $progress,
            'state' => ImportConstants::STATE_PROGRESS
        ]);
    }

    public function changeState($state, $id){
        ImportHistory::where('id', $id)->update([
            'finish_date' => now(),
            'state' => $state
        ]);
    }

    public function sendImportNotifications($status,$reportData,$statusCode,$errorMessage,$user){
        switch($status){
            case 'success':
                $title = 'File Imported';
                $body = 'Your import has completed! You can check the result from';
                PushService::notifyAdmins($title, $body, '', 10, json_encode($reportData), $user->id);
                return true;
                break;
            case 'cancelled':
                $title = 'File Cancelled';
                $body = 'Your import has Cancelled!';
                return true;
                break;
            case 'error':
                $title = 'Filed To Imported';
                $body = $errorMessage;
                PushService::notifyAdmins($title, $body, '', 10, json_encode($reportData), auth()->user()->id);
                return true;
                break;
        }


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

        $query->orderBy("created_at", "DESC");

        return $query;
    }
}
