<?php

namespace App\Sheets\Import\Lists;

use App\Models\Products\Brand;
use App\Models\Products\ListItems;
use App\Models\Products\Lists;
use App\Models\Products\Product;
use App\Services\ImportFiles\ImportConstants;
use App\Services\ImportFiles\ImportFiles;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Validators\Failure;

class ImportListItems extends ImportFiles implements ToCollection, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    private $listID;
    protected $history_id;
    public $reportData;
    public $status;
    public $statusCode;
    public $errorMessage;

    public function __construct($history_id, $listID)
    {
        parent::__construct();
        $this->history_id = $history_id;
        $this->listID = $listID;
    }

    public function collection(Collection $rows)
    {
        $totalCount = 0;
        $totalAddedCount = 0;
        $totalMissedCount = 0;
        $missedDetails = [];

        Log::channel('imports')->info('Import brands, history id is ' . $this->history_id);
        try {
            $index = 0;
            if (!$this->checkImportCachedStatus($this->history_id, ImportConstants::STATE_CANCEL)) {
                if (!empty($rows)) {
                    $list = Lists::findOrFail($this->listID);
                    $list->listItems()->delete();
                    foreach ($rows as $row) {
                        if (!$this->checkImportCachedStatus($this->history_id, ImportConstants::STATE_CANCEL)) {
                            $totalCount++;
                            $product = Product::where('sku', $row['sku'])->first();
                            if ($product) {
                                $totalAddedCount++;
                                $data = [
                                    'item_id' => $product->id,
                                    'list_id' => $list->id,
                                ];
                                ListItems::updateOrCreate($data);
                            } else {
                                $totalMissedCount++;
                                $missedDetails[] = 'product with sku ' . $row['sku'] . '( Sku Not Found )';
                            }
                            $index++;
                            $progress = ceil(($index / count($rows)) * 100);
                            $this->_importRepo->updateHistoryProgress($progress, $this->history_id);
                            $this->status = 'success';
                        } else {
                            $this->status = 'cancelled';
                            Log::channel('imports')->info('Import Canceled');
                            break;
                        }
                    }
                }
                $this->_importRepo->changeState(ImportConstants::STATE_COMPLETE, $this->history_id);
                $data = [
                    'total_count' => $totalCount,
                    'total_added_count' => $totalAddedCount,
                    'missed_count' => $totalMissedCount,
                    'missed_details' => $missedDetails,
                ];
                $this->statusCode = '200';
                $this->reportData = $data;
                $this->errorMessage = null;
            }
        } catch (\Exception $exception) {
            $this->status = 'error';
            $this->statusCode = '422';
            $this->reportData = [];
            $this->errorMessage = $exception->getMessage();
            Log::channel('imports')->error($exception->getMessage());
            $this->_importRepo->changeState(ImportConstants::STATE_ERROR, $this->history_id);
        }
    }

    public function onError(\Throwable $e)
    {
    }

    public function onFailure(Failure ...$failures)
    {
    }

    public function import($file, $history_id)
    {
        // TODO: Implement import() method.
    }
}
