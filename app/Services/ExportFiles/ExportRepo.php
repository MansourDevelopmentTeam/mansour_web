<?php


namespace App\Services\ExportFiles;


use App\Models\Export\Export;
use Illuminate\Support\Facades\Auth;

class ExportRepo
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

    public static function changeState($state, $id){
        Export::where('id', $id)->update([
            'finish_date' => now(),
            'state' => $state
        ]);
    }
}