<?php


namespace App\Services\ImportFiles;


use App\Models\Products\Brand;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ImportBrand extends ImportFiles
{

    public function import($file, $history_id)
    {
        Log::channel('imports')->info('Import brands, history id is ' . $history_id);
        try {
            Excel::load($file, function ($reader) use ($file, $history_id) {
                $results = $reader->all();
                if (!empty($results)) {
                    $index = 0;
                    foreach ($results as $row) {
                        if (!$this->checkImportCachedStatus($history_id, ImportConstants::STATE_CANCEL)) {
                            Brand::updateOrCreate(["name" => $row['brand'], "name_ar" => $row['brand_ar'], "image" => $row['image']]);
                            $index++;
                            $progress = ceil(($index / count($results)) * 100);
                            $this->_importRepo->updateHistoryProgress($progress, $history_id);
                        }else{
                            Log::channel('imports')->info('Import Canceled');
                            break;
                        }
                    }
                    $this->_importRepo->changeState(ImportConstants::STATE_COMPLETE, $history_id);
                }
            });
        }catch (\Exception $exception){
            Log::channel('imports')->error($exception->getMessage());
            $this->_importRepo->changeState(ImportConstants::STATE_ERROR, $history_id);
        }
    }
}