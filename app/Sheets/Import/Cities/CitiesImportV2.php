<?php

namespace App\Sheets\Import\Cities;

use App\Models\Locations\Area;
use App\Models\Locations\City;
use App\Models\Locations\District;
use App\Models\Products\Brand;
use App\Models\Shipping\DeliveryFees;
use App\Models\Shipping\ShippingAreas;
use App\Models\Shipping\ShippingMethod;
use App\Models\Shipping\ShippingMethods;
use App\Services\ImportFiles\ImportConstants;
use App\Services\ImportFiles\ImportFiles;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Validators\Failure;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;

class CitiesImportV2 extends ImportFiles implements ToCollection, WithHeadingRow, SkipsOnFailure
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

        // try {
            $index = 0;
            // if (!$this->checkImportCachedStatus($this->history_id, ImportConstants::STATE_CANCEL)) {
            //     if (!empty($rows)) {
                    foreach ($rows as $row) {
			if (!$this->checkImportCachedStatus($this->history_id, ImportConstants::STATE_CANCEL)) {
				$city = City::updateOrCreate(["name" => $row["city_name"]], ["name_ar" => $row["city_name_ar"], "active" => 1]);
				if ($row["area_name"]) {
					$area = Area::updateOrCreate(["city_id" => $city->id, "name" => $row["area_name"]], ["name_ar" => $row["area_name_ar"], "active" => 1]);

					if ($row["district_name"]) {
						$district = District::updateOrCreate(["name" => $row["district_name"]], ["name_ar" => $row["district_name_ar"], "active" => 1, "area_id" => $area->id]);
					}

					$this->updateShipments($row, $city->id, $area->id);
				}

				$this->updateDeliveryFees($row, $city, $area ?? false, $district ?? false);

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
        //         }

        //         $this->_importRepo->changeState(ImportConstants::STATE_COMPLETE, $this->history_id);
        //         $this->statusCode = '200';
        //         $this->reportData = [];
        //         $this->errorMessage = null;
        //     }
        // } catch (\Exception $exception) {
        //     $this->status = 'error';
        //     $this->statusCode = '422';
        //     $this->reportData = [];
        //     $this->errorMessage = $exception->getMessage();
        //     Log::channel('import')->error($exception->getMessage());
        //     $this->_importRepo->changeState(ImportConstants::STATE_ERROR, $this->history_id);
        // }
    }

    public function updateDeliveryFees($row, $city, $area, $district)
    {
        self::feesProcess($row, $city, 'city');
       
        if ($area) {
            self::feesProcess($row, $area, 'area');
        }

        if ($district) {
            self::feesProcess($row, $district, 'district');
        }
    }

    static function feesProcess($row, $dataObj, $source)
    {
        if (!isset($row[$source . '_fees_type'])) {
            return false;
        }

        $feesType = $row[$source . '_fees_type'];

        if (!in_array($feesType, ['range', 'fixed'])) {
            return false;
        }

        DeliveryFees::where('source', $source)->where('source_id', $dataObj->id)->delete();

        if ($feesType == 'fixed') {
            $dataObj->delivery_fees = (int) $row[$source . '_fees'];
        }

        if ($feesType == 'range') {
            $dataObj->delivery_fees = 0;

            $key = 1;
            // dd($row, ($row[$source . '_range_from_' . $key]) !== "", $source . '_range_from_' . $key, (isset($row[$source . '_range_from_' . $key]) && !empty($row[$source . '_range_from_' . $key])));
            while (isset($row[$source . '_range_from_' . $key]) && ($row[$source . '_range_from_' . $key]) !== "") {
                $createFees[$key]['source'] = $source;
                $createFees[$key]['source_id'] = $dataObj->id;
                $createFees[$key]['weight_from'] = (int) $row[$source . '_range_from_' . $key];
                $createFees[$key]['weight_to'] = (int) $row[$source . '_range_to_' . $key];
                $createFees[$key]['fees'] = (int) $row[$source . '_range_fees_' . $key];

                DeliveryFees::create($createFees[$key]);
                $key++;
            }
        }

        $dataObj->delivery_fees_type = $feesType == "fixed" ? 1 : 2;
        $dataObj->save();
    }

    public function updateShipments($row, $cityId, $areaId)
    {
        $x = 1;
        while ((isset($row['shipping_' . $x]) && !empty($row['shipping_' . $x]))) {
            $shippingName = $row['shipping_' . $x];
            $shippingMethod = ShippingMethods::where('name', $shippingName)->first();

            if ($shippingMethod) {
                $shippingCity = isset($row['shipping_city_' . $x]) ? $row['shipping_city_' . $x] : null;
                $shippingArea = isset($row['shipping_area_' . $x]) ? $row['shipping_area_' . $x] : null;

                ShippingAreas::updateOrCreate(['shipping_id' => $shippingMethod->id, 'city_id' => $cityId, 'area_id' => $areaId], ['shipping_area_name' => $shippingCity, 'shipping_area_code' => $shippingArea]);
            }

            $x++;
        }

        return true;
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
