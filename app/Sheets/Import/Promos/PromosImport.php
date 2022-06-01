<?php

namespace App\Sheets\Import\Promos;

use App\Models\Locations\Area;
use App\Models\Locations\City;
use App\Models\Locations\District;
use App\Models\Payment\Promo;
use App\Models\Payment\PromoTarget;
use App\Models\Products\Brand;
use App\Models\Products\Lists;
use App\Services\ImportFiles\ImportConstants;
use App\Services\ImportFiles\ImportFiles;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Validators\Failure;

class PromosImport extends ImportFiles implements ToCollection, WithHeadingRow, SkipsOnFailure
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
        try {
            $total = 0;
            $missedDetails = [];
            $index = 0;
            if (!empty($rows)) {
                foreach ($rows as $row) {
                    if (!$this->checkImportCachedStatus($this->history_id, ImportConstants::STATE_CANCEL)) {
                        ++$total;
                        if (!in_array($row->type, [1, 2, 3, 4])) {
                            $missedDetails[] = 'Promo with name ' . $row->name . ' type should be 1,2,3,4';
                            continue;
                        } elseif (!in_array($row->customer_ids_or_phones, [1, 2])) {
                            $missedDetails[] = 'Promo with name ' . $row->name . ' customer_ids_or_phones should be 0,1,2';
                            continue;
                        } elseif (!in_array($row->work_with_promotion, [1, 2, 3])) {
                            $missedDetails[] = 'Promo with name ' . $row->name . ' work_with_promotion should be 1,2,3';
                            continue;
                        } elseif (!in_array($row->active, [0, 1])) {
                            $missedDetails[] = 'Promo with name ' . $row->name . ' active should be 0,1';
                            continue;
                        } elseif (!in_array($row->show_in_product, [0, 1])) {
                            $missedDetails[] = 'Promo with name ' . $row->name . ' show_in_product should be 0,1';
                            continue;
                        } elseif ($row->list_id != null && !Lists::where('id', $row->list_id)->exists()) {
                            $missedDetails[] = 'Promo with name ' . $row->name . ' list not found';
                            continue;
                        }

                        $promo = Promo::updateOrCreate(
                            [
                                "name" => $row->name
                            ], [
                            "name" => $row->name, "description" => $row->description, "type" => $row->type,
                            "amount" => $row->amount_or_percentage, "max_amount" => $row->max_precentage_amount,
                            "max_times_used" => $row->max_times_used, "minimum_amount" => $row->minimum_order_amount,
                            "list_id" => $row->list_id, "start_date" => $row->start_date,
                            "expiration_date" => $row->expiration_date, "is_show_in_product" => $row->show_in_product,
                            "first_order" => $row->first_order_only, "recurrence" => $row->recurrence,
                            "active" => $row->active, "times_used" => $row->uses,
                            "remove_promotions" => $row->work_with_promotion, "target_type" => $row->customer_ids_or_phones,
                        ]);

                        if (isset($row->allowed_payment) && $row->allowed_payment != null) {
                            $payment_methods_ids = explode(',', $row->allowed_payment);
                            $promo->paymentMethods()->sync($payment_methods_ids);
                        }

                        if ($row->customer_ids_or_phones) {
                            if (in_array($row->customer_ids_or_phones, [1, 2])) {
                                $promo->target_lists()->delete();
                            }
                            $customers = explode(',', $row->customers);
                            if ($row->customer_ids_or_phones == 1) {
                                $promo->targets()->attach($customers);
                            } elseif ($row->customer_ids_or_phones == 2) {
                                $customers = collect($customers)->map(function ($item) use ($promo) {
                                    if (!PromoTarget::where('promo_id', $promo->id)->where('phone', $item)->exists()) {
                                        return ['phone' => $item];
                                    }
                                    return null;
                                })->reject(function ($value, $key) {
                                    return $value == null;
                                })->values()->all();

                                $promo->target_lists()->createMany($customers);
                            }
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
                'total_count' => $total,
                'updated_count' => $missedDetails,
            ];
            $this->statusCode = '200';
            $this->reportData = $data;
            $this->errorMessage = null;
        } catch (\Exception $e) {
            $this->status = 'error';
            $this->statusCode = '422';
            $this->reportData = [];
            $this->errorMessage = $e->getMessage();
            Log::channel('imports')->error($e->getMessage());
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
