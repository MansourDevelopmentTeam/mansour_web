<?php

namespace App\Sheets\Export\Orders;

use App\Models\Orders\Order;
use App\Models\Orders\OrderState;
use App\Models\Products\Brand;
use App\Models\Products\Product;
use App\Models\Products\Tag;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStrictNullComparison
{

    public function collection()
    {
        return Order::with("address.city", "paymentInstallment", "address.area", "customer", "deliverer", "invoice", "schedule")->get();
    }

    public function map($order): array
    {
        $itemsSkues = [];
        $isBundle = false;
        $promoAmount = 0;
        foreach ($order->items as $item) {
            $product = $item->product;
            $product->type == 2 ? $isBundle = true : '';
            for ($i = 1; $i <= $item->amount; $i++) {
                $itemsSkues[] = $product->sku;
            }
        }
        if ($order->invoice->promo_id) {
            $promo = $order->invoice->promo;
            if ($promo && $promo->type == 3) {
                $promoAmount = $order->invoice->total_delivery_fees;
            } else {
                $promoAmount = !is_null($order->invoice->discount) ? $order->invoice->discount - $order->invoice->total_amount : 0;
            }
        }
        $itemsPrices = $order->items->map(function ($item) {
            if (is_null($item->discount_price)) {
                return $item->price;
            } else {
                return $item->discount_price;
            }
        })->toArray();
        $itemsImplodedPrices = implode(' | ', $itemsPrices);
        $itemsTotalPrices = array_sum($itemsPrices);
        $itemsSkues = implode(' | ', $itemsSkues);
        $itemsNames = $order->products()->pluck('name')->implode(' | ');
        $itemsSerials = $order->items()->pluck('serial_number')->implode(',');
        $delivered = OrderState::DELIVERED;
        $orderPickUp = $order->order_pickup;
        $orderTransaction = $order->transaction;
        $customer = $order->customer;
        if ($order->payment_method == 2) {
            $codAmount = 0;
        } else {
            $codAmount = !is_null($order->invoice->discount) ? $order->invoice->discount : $order->invoice->total_amount;
            $codAmount += $order->invoice->delivery_fees;
        }
        $totalAmount = $order->invoice->grand_total;
        return [
            $order->id,
            $orderPickUp->shipping_id ?? "",
            "ERP Sales order number",
            date("d-m-y H:i A", strtotime((string)$order->created_at)),
            isset($orderPickUp->created_at) ? date("d-m-y H:i A", strtotime((string)$orderPickUp->created_at)) : "",
            $order->state_id == $delivered ? date("d-m-y H:i A", strtotime((string)$order->updated_at)) : "-",
            $orderPickUp->update_description ?? "",
            $order->state->name ?? '-',
            $order->payment_method_name,
            $order->paymentInstallment->name_en ?? "",
            $orderTransaction->order_pay_id ?? "",
            $codAmount,
            "ERP Customer account number",
            $order->customer ? $order->customer->name . ' ' . $order->customer->last_name : "-",
            optional($customer)->phone,
            $order->user_ip,
            $itemsNames,
            $itemsSkues,
            $itemsSerials,
            $isBundle,
            $itemsImplodedPrices,
            $promoAmount,
            $order->invoice->total_delivery_fees,
            $itemsTotalPrices,
            $totalAmount
        ];
    }

    public function headings(): array
    {
        return [
            "Order number",
            "AWBnumber",
            "ERP Sales order number",
            "Order Date",
            "Shipping date",
            "Delivery date",
            "Aramex status",
            "Order status",
            "Payment method",
            "Plan Installment",
            "Accept Transaction number",
            "COD amount",
            "ERP Customer account number",
            "Full Customer name",
            "Customer phone number",
            "Customer IP",
            "Product name",
            "Product Sku",
            "Product Serial",
            "Is Bundle",
            "Items Prices",
            "Promo amount",
            "Shipping fees",
            "Total Cart amount",
            "Total Order Amount"
        ];
    }
}
