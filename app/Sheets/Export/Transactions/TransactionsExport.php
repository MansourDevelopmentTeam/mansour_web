<?php

namespace App\Sheets\Export\Transactions;

use App\Models\Orders\Transaction;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;


class TransactionsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStrictNullComparison
{
    public function collection()
    {
        $transactions = Transaction::query()->with(['customer', "paymentMethod"]);

        if (request()->status !== null) {
            $transactions->where('transaction_status', request()->status);
        }

        if (request()->date_from) {
            $transactions->whereDate("created_at", ">=", request()->date_from);
        }

        if (request()->date_to) {
            $transactions->whereDate("created_at", "<=",  request()->date_to);
        }

        return $transactions->orderBy("created_at", "DESC")->get();
    }

    public function map($transaction): array
    {
        return [
            $transaction->order_pay_id,
            $transaction->transaction_status == Transaction::TRANSACTION_STATUS_SUCCESS ? "Authorized" : "Unauthorized",
            $transaction->created_at->format("Y-m-d h:i a"),
            $transaction->total_amount,
            $transaction->customer ? $transaction->customer->name : '-',
            $transaction->customer ? $transaction->customer->email : '-',
            $transaction->customer ? $transaction->customer->phone : '-',
            // $transaction->order_id,
            // $transaction->transaction_status == 1 ? $transaction->order_link : "-"
        ];

    }

    public function headings(): array
    {
        return [
            'Reference', 
            "Status", 
            "Creation Date", 
            'Amount', 
            'Customer Name', 
            'Customer Email', 
            'Customer Phone', 
            // 'Order ID', 
            // 'Order Link'
        ];
    }

}
