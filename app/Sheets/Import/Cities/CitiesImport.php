<?php

namespace App\Sheets\Import\Cities;

use App\Models\Locations\Area;
use App\Models\Locations\City;
use App\Models\Locations\District;
use App\Models\Products\Brand;
use App\Services\ImportFiles\ImportConstants;
use App\Services\ImportFiles\ImportFiles;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Validators\Failure;

class CitiesImport extends ImportFiles implements ToCollection, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    private $listID;
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
        $data = [];
        $missedDetails = [];

        try {
            $index = 0;
            foreach ($rows as $key => $row) {
                $rowNumber = $key + 2;
                if (!$this->checkImportCachedStatus($this->history_id, ImportConstants::STATE_CANCEL)) {
                    if (!isset($row['city_name']) || empty($row['city_name'])) {
                        $missedDetails[] = 'Missed city name in row ' . $rowNumber;
                        continue;
                    }
                    $city = City::firstOrCreate(["name" => $row["city_name"]], ["name_ar" => $row["city_name_ar"], "delivery_fees" => $row["city_fees"]]);
                    if (isset($row["area_name"]) && !empty($row["area_name"])) {
                        $area = Area::firstOrCreate(["city_id" => $city->id, "name" => $row["area_name"]], ["name_ar" => $row["area_name_ar"], "delivery_fees" => $row["area_fees"], 'active' => true]);

                        if (isset($row["district_name"]) && !empty($row["district_name"])) {
                            District::firstOrCreate(["name" => $row["district_name"]], ["name_ar" => $row["district_name_ar"], "delivery_fees" => $row["district_fees"], "area_id" => $area->id]);
                        }
                    }
                    $index++;
                    $progress = floor(($index / count($rows)) * 100);
                    $this->_importRepo->updateHistoryProgress($progress, $this->history_id);
                    $this->status = 'success';
                } else {
                    $this->status = 'cancelled';
                    Log::channel('imports')->info('Import Canceled');
                    break;
                }
            }
            $data = [
                'total_counts' => count($rows),
                'total_imported' => $index,
                'missed_details' => $missedDetails
            ];
            $this->_importRepo->changeState(ImportConstants::STATE_COMPLETE, $this->history_id);
            $this->statusCode = '200';
            $this->reportData = $data;
            $this->errorMessage = null;
            Log::info("IMPORT FINISHED");
            
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
