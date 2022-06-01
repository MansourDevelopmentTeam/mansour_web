<?php


namespace App\Services\ImportFiles;


use App\Models\Products\ListItems;
use App\Models\Products\Lists;
use App\Models\Products\Product;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ImportList extends ImportFiles
{

    public function import($file, $history_id)
    {
        $totalCount = 0;
        $totalAddedCount = 0;
        $totalMissedCount = 0;
        $missedDetails = [];
        $list = Lists::findOrFail(request('id'));
        Log::channel('imports')->info('Import Lists, history id is ' . $history_id);

        try {
            Excel::load($file, function ($reader) use ($list,$history_id,&$totalCount, &$totalAddedCount, &$totalMissedCount,&$missedDetails ){
                $results = $reader->all();
                $index = 0;
                foreach ($results as $record) {
                    if (!$this->checkImportCachedStatus($history_id, ImportConstants::STATE_CANCEL)) {
                        $totalCount++;
                        $product = Product::where('sku', $record)->first();
                        if ($product) {
                            $totalAddedCount++;
                            $data = [
                                'item_id' => $product->id,
                                'list_id' => $list->id,
                            ];
                            ListItems::updateOrCreate($data);
                        } else {
                            $totalMissedCount++;
                            $missedDetails[] = 'product with sku ' . $record . '( Sku Not Found )';
                        }

                        $index++;
                        $progress = ceil(($index / count($results)) * 100);
                        $this->_importRepo->updateHistoryProgress($progress, $history_id);
                    }else{
                        Log::channel('imports')->info('Import Canceled');
                        break;
                    }
                }
            });
        } catch (\Exception $e) {
            Log::channel('imports')->error($e->getMessage());
            $this->_importRepo->changeState(ImportConstants::STATE_ERROR, $history_id);
        }
    }
}