<?php


namespace App\Services\ImportFiles;


use App\Models\Payment\Promo;
use App\Models\Payment\PromoTarget;
use App\Models\Products\Lists;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ImportPromoCode extends ImportFiles
{

    public function import($file, $history_id)
    {

        try {
            $total = 0;
            $missedDetails = [];

            Excel::load($file, function ($reader) use(&$missedDetails, &$total, $history_id) {
                // Loop through all sheets
                $results = $reader->all();
                $index = 0;
                foreach ($results as $record) {
                    if (!$this->checkImportCachedStatus($history_id, ImportConstants::STATE_CANCEL)) {
                        ++$total;
                        if (!in_array($record->type, [1, 2, 3, 4])) {
                            $missedDetails[] = 'Promo with name ' . $record->name . ' type should be 1,2,3,4';
                            continue;
                        } elseif (!in_array($record->customer_ids_or_phones, [1, 2])) {
                            $missedDetails[] = 'Promo with name ' . $record->name . ' customer_ids_or_phones should be 0,1,2';
                            continue;
                        } elseif (!in_array($record->work_with_promotion, [1, 2, 3])) {
                            $missedDetails[] = 'Promo with name ' . $record->name . ' work_with_promotion should be 1,2,3';
                            continue;
                        } elseif (!in_array($record->active, [0, 1])) {
                            $missedDetails[] = 'Promo with name ' . $record->name . ' active should be 0,1';
                            continue;
                        } elseif (!in_array($record->show_in_product, [0, 1])) {
                            $missedDetails[] = 'Promo with name ' . $record->name . ' show_in_product should be 0,1';
                            continue;
                        } elseif ($record->list_id != null && !Lists::where('id', $record->list_id)->exists()) {
                            $missedDetails[] = 'Promo with name ' . $record->name . ' list not found';
                            continue;
                        }

                        $promo = Promo::updateOrCreate(
                            [
                                "name" => $record->name
                            ], [
                            "name" => $record->name, "description" => $record->description, "type" => $record->type,
                            "amount" => $record->amount_or_percentage, "max_amount" => $record->max_precentage_amount,
                            "max_times_used" => $record->max_times_used, "minimum_amount" => $record->minimum_order_amount,
                            "list_id" => $record->list_id, "start_date" => $record->start_date,
                            "expiration_date" => $record->expiration_date, "is_show_in_product" => $record->show_in_product,
                            "first_order" => $record->first_order_only, "recurrence" => $record->recurrence,
                            "active" => $record->active, "times_used" => $record->uses,
                            "remove_promotions" => $record->work_with_promotion, "target_type" => $record->customer_ids_or_phones,
                        ]);

                        if (isset($record->allowed_payment) && $record->allowed_payment != null) {
                            $payment_methods_ids = explode(',', $record->allowed_payment);
                            $promo->paymentMethods()->sync($payment_methods_ids);
                        }

                        if ($record->customer_ids_or_phones) {
                            if (in_array($record->customer_ids_or_phones, [1, 2])) {
                                $promo->target_lists()->delete();
                            }
                            $customers = explode(',', $record->customers);
                            if ($record->customer_ids_or_phones == 1) {
                                $promo->targets()->attach($customers);
                            } elseif ($record->customer_ids_or_phones == 2) {
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
