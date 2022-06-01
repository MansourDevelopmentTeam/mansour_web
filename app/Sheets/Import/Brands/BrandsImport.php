<?php

namespace App\Sheets\Import\Brands;

use App\Models\Products\Brand;
use App\Models\Repositories\ImportRepository;
use App\Services\ImportFiles\ImportConstants;
use App\Services\ImportFiles\ImportFiles;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Validators\Failure;

class BrandsImport extends ImportFiles implements ToCollection, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    protected $history_id;
    public $reportData;
    public $status;
    public $statusCode;
    public $errorMessage;

    public function __construct($history_id)
    {
        parent::__construct();
        $this->history_id = $history_id;
    }

    public function collection(Collection $rows)
    {
        Log::channel('imports')->info('Import brands, history id is ' . $this->history_id);
        $createdCount = 0;
        $updatedCount = 0;
        $totalCount = 0;
        $data = [
            'total_count' => count($rows),
            'updated_count' => &$updatedCount,
            'created_count' => &$createdCount,
        ];
        try {
            foreach ($rows as $key => $row) {
                $rowNumber = $key + 2;
                if (!$this->checkImportCachedStatus($this->history_id, ImportConstants::STATE_CANCEL)) {
                    if (!isset($row['brand']) && !isset($row['brand_ar'])) {
                        $data['error'][] = "Missed data in row {$rowNumber}";
                        continue;
                    }
                    try {
                        $brand = Brand::where("name", $row['brand'])->orWhere('name_ar', $row['brand_ar'])->first();
                        if ($brand) {
                            $brand->update(["name" => $row['brand'], "name_ar" => $row['brand_ar'], "image" => $row['image']]);
                            $updatedCount++;
                        } else {
                            Brand::create(["name" => $row['brand'], "name_ar" => $row['brand_ar'], "image" => $row['image']]);
                            $createdCount++;
                        }

                    } catch(\Exception $exception) {
                        Log::channel('imports')->error("Can not update or create brand {$row['brand']} in row {$key}");
                        $data['error'][] = "Can not update or create brand {$row['brand']} in row {$key}";
                    }
                } else {
                    $this->status = 'cancelled';
                    Log::channel('imports')->info('Import Canceled');
                    break;
                }
            }
            $progress = floor((($updatedCount + $createdCount) / count($rows)) * 100);
            $this->_importRepo->updateHistoryProgress($progress, $this->history_id);
            $this->status = 'success';

            $this->_importRepo->changeState(ImportConstants::STATE_COMPLETE, $this->history_id);
            $this->statusCode = '200';
            $this->reportData = $data;
            $this->errorMessage = null;
            
        } catch (\Exception $exception) {
            $this->status = 'error';
            $this->statusCode = '422';
            $this->reportData = $data;
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
