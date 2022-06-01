<?php

namespace App\Jobs;

use App\Models\Orders\OrderState;
use App\Models\Services\AramexService;
use App\Models\Shipping\OrderPickup;
use App\Notifications\OrderStateChanged;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Octw\Aramex\Aramex;

class UpdateOrderPickupStatus implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(AramexService $aramexService)
    {
        Log::channel('aramex')->info('UPDATING ARAMEX RECORDS');

        try {
            $completedDelivered = [OrderPickup::PICKUP_CANCELLED, OrderPickup::PICKUP_RETURNED, OrderPickup::PICKUP_DELIVERED];
            $orderPickupsArray = OrderPickup::whereNotIn('status', $completedDelivered)->orWhereNull('status')->pluck('shipping_id')->toArray();

            if (!empty($orderPickupsArray)) {
                $orderPickupsArray = array_map('strval', $orderPickupsArray);

                $TrackingData = $aramexService->getMultipleShipmentState($orderPickupsArray);

                Log::channel('aramex')->info($orderPickupsArray);
                // Log::channel('aramex')->info($TrackingData);

                if (!$TrackingData['HasErrors']) {
                    $trackingResults = $TrackingData['TrackingResults'];

                    foreach ($trackingResults as $trackingResult) {
                        $trackRecord = $trackingResult['Value'][0];
                        $orderPickup = OrderPickup::where('shipping_id', $trackRecord['WaybillNumber'])->first();

                        if ($orderPickup) {
                            $oldOrderState = $orderPickup->order->state_id;
                            Log::channel('aramex')->info('Tracking: ', ['waybill' => $trackRecord['WaybillNumber'], 'code' => $trackRecord['UpdateCode'], 'description' => $trackRecord['UpdateDescription'], 'orderPickupId' => $orderPickup->id]);
                            $orderPickup->update(['update_description' => $trackRecord['UpdateDescription'], 'tracking_result' => $trackRecord, 'status' => $trackRecord['UpdateCode']]);
                            if (OrderPickup::PICKUP_CANCELLED == $trackRecord['UpdateCode']) {
//                                $orderPickup->order()->update(['state_id' => OrderState::CANCELLED]);
                            } elseif (OrderPickup::PICKUP_RETURNED == $trackRecord['UpdateCode']) {
                                $orderPickup->order()->update(['state_id' => OrderState::DELIVERY_FAILED]);
                            } elseif (OrderPickup::PICKUP_DELIVERED == $trackRecord['UpdateCode'] || OrderPickup::PICKUP_COLLECTED == $trackRecord['UpdateCode'] || OrderPickup::PICKUP_COD_RECIEVED == $trackRecord['UpdateCode']) {
                                $orderPickup->order()->update(['state_id' => OrderState::DELIVERED]);
                            } elseif (OrderPickup::PICKUP_UP_FROM_SHIPPER == $trackRecord['UpdateCode'] || OrderPickup::PICKUP_RECEIVED_AT_ORIGIN_FACILITY == $trackRecord['UpdateCode']) {
                                $orderPickup->order()->update(['state_id' => OrderState::ONDELIVERY]);
                            }
                            $newOrderData  =  $orderPickup->order()->first();
                            $newOrderState  = $newOrderData->state_id;
                            if ($oldOrderState != $newOrderState) {
                                Notification::send($orderPickup->order->customer, new OrderStateChanged($orderPickup->order));
                            }

                        }
                    }
                }
            }
            Log::error('RESET PICKUPS DONE');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
