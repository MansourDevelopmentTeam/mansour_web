<?php

namespace App\Models\Services;

use App\Events\WalletRedeem;
use App\Models\Orders\Order;
use App\Notifications\WalletRedeemNotification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class MansourService
{
    const PLACED = 1;
    const PROCESSING = 2;
    const DELIVERED = 4;
    const CANCELLED = 6;
    const RETURNED = 7;

    // UOM (Unit Of Measure)
    const CASE_UOM = 1;

    const INCENTIVE_TYPE_PROMOCODE = 'promocode';

    const INCENTIVE_TYPE_INCENTIVE = 'incentive';

    const INCENTIVE_TYPE_WALLET = 'wallet';

    const PROMO_ID = 4040;

    public function createOrder($user, $order, $promotionDiscounts = null, $promoDiscount = null, $useWallet = false)
    {
        $mssqlConnection = DB::connection('sqlsrv');
        $total = $order->getTotal();
        $totalIncentives = 0;
        $incentiveDetails = [];
        $giftProducts = [];
        $orderItems = $order->items;
        $tax = 0;
        $newWallet = [];
        $newWalletAmount = 0;
        $currentWalletAmount = $user->wallet->sum('amount');
        if ($promotionDiscounts instanceof Collection || is_array($promotionDiscounts)) {
            foreach ($promotionDiscounts as $promotionDiscount) {
                $incentive = $mssqlConnection->table('incentive_types')->where('incentive_id', $promotionDiscount['promotion']->incentive_id)
                    ->first();
                if ($incentive) {
                    $incentiveDetails[] = [
                        'prod_id' => explode(',', $incentive->prod_id),
                        'tax_prods' => explode(',', $incentive->tax_prods),
                        'discount' => $promotionDiscount['discount'],
                        'incentive_id' => $promotionDiscount['promotion']->incentive_id,
                        'total' => 0,
                        'amount_sold_products' => 0,
                        'instant' => $promotionDiscount['promotion']->instant
                    ];
                    if ($promotionDiscount['promotion']->instant) {
                        $totalIncentives += $promotionDiscount['discount'];
                    } else {
                        $newWallet[] = [
                            'amount' => $promotionDiscount['discount'],
                            'incentive_id' => $promotionDiscount['promotion']->incentive_id,
                            'order_id' => $order->id
                        ];
                        $newWalletAmount += $promotionDiscount['discount'];
                    }
                }
            }
        }
        $netAmount = $total - ($totalIncentives + ($promoDiscount['discount'] ?? 0));
        $mssqlConnection->table('dbo.Orders')->insert([
            'Order_id' => $order->id,
            'pos_code' => $user->code,
            'order_date' => $order->created_at,
            'status' => self::PLACED,
            'total_price' => $total,
            'total_incentives' => $totalIncentives,
            'tax' => 0,
            'net_amount' => $netAmount
        ]);
        Log::info("Current net amount : {$netAmount} and current wallet : {$currentWalletAmount} and order total : {$total} and total incentives : {$totalIncentives}");
        if ($useWallet) {
            $userWallet = $user->wallet;
            if ($netAmount > $currentWalletAmount) {
                foreach ($userWallet as $wallet) {
                    $mssqlConnection->table('dbo.Order_Incentives_Transactions')->insert([
                        'Order_id' => $order->id,
                        'incentive_type' => self::INCENTIVE_TYPE_WALLET,
                        'incentive_payed' => $wallet->amount,
                        'qty_sold' => null,
                        'incentive_id' => $wallet->incentive_id,
                        'PromoCode_no' => null
                    ]);
                }
                $netAmount -= $currentWalletAmount;
                $user->wallet()->delete();
                $order->update([
                    'wallet_redeem' => $currentWalletAmount
                ]);
//                Notification::send($user, new WalletRedeemNotification($currentWalletAmount));
                WalletRedeem::dispatch($user, $currentWalletAmount);
            }
        }

        foreach ($orderItems as $item) {
            $itemPrice = $item->product->discount_price ?? $item->product->price;
            $itemTax = 0;
            if (($item->product->tax_percentage || $item->product->fix_tax) && !in_array($item->product->prod_id, $giftProducts)) {
                $itemTax = ($item->product->tax_percentage) ? (($item->product->tax_percentage / 100) * $itemPrice) * $item->amount : ($item->product->fix_tax * $item->amount);
            }
            $mssqlConnection->table('dbo.Order_details')->insert([
                'order_id' => $order->id,
                'prod_id' => $item->product->prod_id ?? null,
                'uom' => self::CASE_UOM, // Unit of measure
                'quantity' => $item->amount,
                'item_price' => $item->product->discount_price ?? $item->product->price
            ]);
            $tax +=  $itemTax;
            foreach ($incentiveDetails as $key => $incentive) {
                if (in_array($item->product->prod_id, $incentive['tax_prods'])) {
                    $incentiveDetails[$key]['total'] += $itemPrice * $item->amount;
                    $incentiveDetails[$key]['amount_sold_products'] += $item->amount;
                }
            }
        }
        $mssqlConnection->table('dbo.Orders')->where('Order_id', $order->id)->update([
            'Tax' => $tax,
            'Net_amount' => $netAmount
        ]);
        foreach ($incentiveDetails as $incentive) {
            if (!$incentive['instant']) {
                continue;
            }
            $mssqlConnection->table('dbo.Order_Incentives_Transactions')->insert([
                'Order_id' => $order->id,
                'incentive_type' => self::INCENTIVE_TYPE_INCENTIVE,
                'incentive_payed' => $incentive['discount'],
                'qty_sold' => $incentive['amount_sold_products'],
                'incentive_id' => $incentive['incentive_id'],
                'PromoCode_no' => null
            ]);
            $total = $incentive['total'];
            if (!$total) {
                continue;
            }
            foreach ($orderItems as $item) {
                if (in_array($item->product->prod_id, $incentive['tax_prods'])) {
                    $itemPrice = $item->product->discount_price ?? $item->product->price;
                    $incentiveValue = floatval((($itemPrice * $item->amount) / $total) * $incentive['discount']);
                    $mssqlConnection->table('dbo.Order_incentives_details')->insert([
                        'order_id' => $order->id,
                        'prod_id' => $item->product->prod_id,
                        'incentive_id' => $incentive['incentive_id'], // Unit of measure
                        'incentive_value' => $incentiveValue,
                        'qty_sold' => floatval($item->amount)
                    ]);
                }
            }
        }
        if (isset($promoDiscount['promo'])) {
            $mssqlConnection->table('dbo.Order_Incentives_Transactions')->insert([
                'Order_id' => $order->id,
                'incentive_type' => self::INCENTIVE_TYPE_PROMOCODE,
                'incentive_payed' => $promoDiscount['discount'],
                'qty_sold' => isset($promoDiscount['products']) ? $promoDiscount['products']->count() : null,
                'incentive_id' => self::PROMO_ID,
                'PromoCode_no' => $promoDiscount['promo']->name ?? null
            ]);
        }
        if ($newWallet) {
            $user->wallet()->createMany($newWallet);
            $order->update([
                'cashback_amount' => $newWalletAmount
            ]);
        }
        return true;
    }

    public function changeOrderState($orderId, $stateId)
    {
        $mssqlConnection = DB::connection('sqlsrv');
        $mssqlConnection->table('dbo.Orders')->where('Order_id', '=', $orderId)->update([
            'status' => $stateId
        ]);
    }
}