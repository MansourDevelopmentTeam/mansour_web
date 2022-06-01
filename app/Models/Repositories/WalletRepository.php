<?php

namespace App\Models\Repositories;

use App\Models\ACL\Role;
use App\Models\Orders\OrderState;
use App\Models\Users\Affiliates\WalletHistory;
use App\Models\Users\Profile;
use App\Models\Users\User;
use Illuminate\Http\Request;

/**
 * Social repo
 */
class WalletRepository
{

    public function getPaginatedFilteredAffiliatesWalletHistory(Request $request)
    {
        $walletRecords = $this->getFilteredWalletHistoryQuery($request);
        return $walletRecords->orderBy('created_at', 'DESC')->paginate(20);
    }

    public function getFilteredAffiliateWalletStatistics($request)
    {
        //order Statistics
        $orders = $this->getFilteredWalletHistoryQuery($request)->where('type', 1);

        $completedOrders = $this->getFilteredWalletHistoryQuery($request)->where('type', 1)->where('status', 1)->whereHas('order', function ($q) {
            $q->where('state_id', OrderState::DELIVERED);
        });
        $pendingOrders = $this->getFilteredWalletHistoryQuery($request)->where('type', 1)->where('status', 1)->whereHas('order', function ($q) {
            $q->whereNotIn('state_id', [OrderState::DELIVERED, OrderState::CANCELLED]);
        });

        $cancelledOrders = $this->getFilteredWalletHistoryQuery($request)->where('type', 1)->whereHas('order', function ($q) {
            $q->where('state_id', OrderState::CANCELLED);
        });
        $orderStatistics = [
            'total_count' => (double)$orders->count(),
            'total_commission' => (double)$orders->sum('amount'),
            'completed_count' => (double)$completedOrders->count(),
            'completed_commission' => (double)$completedOrders->sum('amount'),
            'pending_count' => (double)$pendingOrders->count(),
            'pending_commission' => (double)$pendingOrders->sum('amount'),
            'cancelled_count' => (double)$cancelledOrders->count(),
            'cancelled_commission' => (double)$cancelledOrders->sum('amount'),
        ];

        $approvedWithdraw = $this->getFilteredWalletHistoryQuery($request)->where('type', 3)->where('status', 1)->sum('amount');
        $pendingWithdraw = $this->getFilteredWalletHistoryQuery($request)->where('type', 3)->where('status', 0)->sum('amount');
        $totalWithdraw = $approvedWithdraw + $pendingWithdraw;
        $withdrawStatistics = [
            'total_withdraw' => (double)$totalWithdraw,
            'approved_withdraw' => (double)$approvedWithdraw,
            'pending_withdraw' => (double)$pendingWithdraw,
        ];

        //balance Statistics
        $pendingBalance = $this->getFilteredWalletHistoryQuery($request)->where('type', 1)->where('status', 1)->whereNotNull('due_date')->whereDate('due_date', '>', now())->whereHas('order', function ($q) {
            $q->where('state_id', OrderState::DELIVERED);
        })->sum('amount');
        $adminBalance = $this->getFilteredWalletHistoryQuery($request)->where('type', 2)->where('status', 1)->sum('amount');
        $availableFromOrders = $completedOrders->whereDate('due_date', '<=', now())->sum('amount');
        $totalBalance = $pendingBalance + $adminBalance + $availableFromOrders;
        $totalCurrently = ($availableFromOrders + $adminBalance) - ($pendingWithdraw + $approvedWithdraw);
        $balanceStatistics = [
            'pending_balance' => (double)$pendingBalance,
            'admin_balance' => (double)$adminBalance,
            'available_from_orders' => (double)$availableFromOrders,
            'total_balance' => (double)$totalBalance,
            'total_currently' => (double)$totalCurrently,
        ];

        //withdraw Statistics
        $statistics = [
            'order_statistics' => $orderStatistics,
            'balance_statistics' => $balanceStatistics,
            'withdraw_statistics' => $withdrawStatistics,
        ];
        return $statistics;
    }

    public function getFilteredWalletHistoryQuery($request)
    {
        $walletQuery = WalletHistory::query()->with('affiliate', 'order');
        $walletQuery->when(isset($request->status), function ($q) use ($request) {

            $q->where(function ($query) use ($request) {
                $query->whereIn("type", [2, 3]);
                $query->where("status", $request->status);
            })->orWhere(function ($query) use ($request) {
                $query->where("type", 1);
                if ($request->status == 1) {
                    $query->where("status", 1);
                    $query->whereDate('due_date', '<=', now());
                    $query->whereHas('order', function ($q) {
                        $q->where('state_id', OrderState::DELIVERED);
                    });
                } elseif ($request->status == 0) {
                    $query->whereDate('due_date', '>', now());
                    $query->whereHas('order', function ($q) {
                        $q->where('state_id', '!=', OrderState::DELIVERED);
                    });
                }else{
                    $query->where("status", $request->status);
                }
            });
        });

        $walletQuery->when($request->affiliate_id, function ($q) use ($request) {
            $q->where("affiliate_id", $request->affiliate_id);
        });
        $walletQuery->when($request->type, function ($q) use ($request) {
            $q->where("type", $request->type);
        });
        $walletQuery->when($request->date_from, function ($q) use ($request) {
            $date = strtotime($request->date_from);
            $q->whereDate("created_at", ">=", date("Y-m-d", $date));
        });
        $walletQuery->when($request->date_to, function ($q) use ($request) {
            $date = strtotime($request->date_to);
            $q->whereDate("created_at", "<=", date("Y-m-d", $date));
        });
        $walletQuery->when($request->q, function ($q) use ($request) {
            $q->whereHas("affiliate", function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->orWhere("name", "LIKE", "%{$request->q}%")
                        ->orWhere("email", "LIKE", "%{$request->q}%")
                        ->orWhere("phone", "LIKE", "%{$request->q}%")
                        ->orWhere("id", "LIKE", "%{$request->q}%");
                });
            });
        });
        return $walletQuery;
    }

    public function getPaginatedAffiliateWalletHistory(Request $request)
    {
        $affiliate = User::findOrFail($request->affiliate_id);
        $walletHistory = $affiliate->walletHistory();
        $walletHistory->when($request->type, function ($q) use ($request) {
            $q->where("type", $request->type);
        });
        $walletHistory->when(isset($request->status), function ($q) use ($request) {
            $q->where("status", $request->status);
        });
        $walletHistory = $walletHistory->orderBy('created_at', 'DESC')->paginate(20);
        return $walletHistory;
    }

    public function getAffiliateWalletStatistics(Request $request)
    {
        $affiliate = User::findOrFail($request->affiliate_id);
        $walletHistory = $affiliate->walletHistory();

        //order Statistics
        $orders = $affiliate->walletHistory()->where('type', 1);
        $completedOrders = $affiliate->walletHistory()->where('type', 1)->where('status', 1)->whereHas('order', function ($q) {
            $q->where('state_id', OrderState::DELIVERED);
        });
        $pendingOrders = $affiliate->walletHistory()->where('type', 1)->where('status', 1)->whereHas('order', function ($q) {
            $q->whereNotIn('state_id', [OrderState::DELIVERED, OrderState::CANCELLED]);
        });
        $cancelledOrders = $affiliate->walletHistory()->where('type', 1)->whereHas('order', function ($q) {
            $q->where('state_id', OrderState::CANCELLED);
        });
        $orderStatistics = [
            'total_count' => (double)$orders->count(),
            'total_commission' => (double)$orders->sum('amount'),
            'completed_count' => (double)$completedOrders->count(),
            'completed_commission' => (double)$completedOrders->sum('amount'),
            'pending_count' => (double)$pendingOrders->count(),
            'pending_commission' => (double)$pendingOrders->sum('amount'),
            'cancelled_count' => (double)$cancelledOrders->count(),
            'cancelled_commission' => (double)$cancelledOrders->sum('amount'),
        ];


        $approvedWithdraw = $affiliate->walletHistory()->where('type', 3)->where('status', 1)->sum('amount');
        $pendingWithdraw = $affiliate->walletHistory()->where('type', 3)->where('status', 0)->sum('amount');
        $totalWithdraw = $approvedWithdraw + $pendingWithdraw;
        $withdrawStatistics = [
            'total_withdraw' => (double)$totalWithdraw,
            'approved_withdraw' => (double)$approvedWithdraw,
            'pending_withdraw' => (double)$pendingWithdraw,
        ];

        //balance Statistics
        $pendingBalance = $affiliate->walletHistory()->where('type', 1)->where('status', 1)->whereNotNull('due_date')->whereDate('due_date', '>', now())->whereHas('order', function ($q) {
            $q->where('state_id', OrderState::DELIVERED);
        })->sum('amount');
        $adminBalance = $affiliate->walletHistory()->where('type', 2)->where('status', 1)->sum('amount');
        $availableFromOrders = $completedOrders->whereDate('due_date', '<=', now())->sum('amount');
        $totalBalance = $pendingBalance + $adminBalance + $availableFromOrders;
        $totalCurrently = ($availableFromOrders + $adminBalance) - ($pendingWithdraw + $approvedWithdraw);
        $balanceStatistics = [
            'pending_balance' => (double)$pendingBalance,
            'admin_balance' => (double)$adminBalance,
            'available_from_orders' => (double)$availableFromOrders,
            'total_balance' => (double)$totalBalance,
            'total_currently' => (double)$totalCurrently,
        ];

        //withdraw Statistics
        $statistics = [
            'order_statistics' => $orderStatistics,
            'balance_statistics' => $balanceStatistics,
            'withdraw_statistics' => $withdrawStatistics,
        ];
        return $statistics;
    }

    public function getAvailableWalletBalance(Request $request)
    {
        $affiliate = User::findOrFail($request->affiliate_id);
        $completedOrders = $affiliate->walletHistory()->where('type', 1)->where('status', 1)->whereHas('order', function ($q) {
            $q->where('state_id', OrderState::DELIVERED);
        });
        $approvedWithdraw = $affiliate->walletHistory()->where('type', 3)->where('status', 1)->sum('amount');
        $pendingWithdraw = $affiliate->walletHistory()->where('type', 3)->where('status', 0)->sum('amount');
        $adminBalance = $affiliate->walletHistory()->where('type', 2)->where('status', 1)->sum('amount');
        $availableFromOrders = $completedOrders->whereDate('due_date', '<=', now())->sum('amount');
        $totalCurrently = ($availableFromOrders + $adminBalance) - ($pendingWithdraw + $approvedWithdraw);

        return $totalCurrently;
    }

}
