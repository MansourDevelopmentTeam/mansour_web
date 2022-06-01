<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use  \App\Models\Orders\OrderState;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {

        $states = [
            [
                "id" => "1",
                "name" => "Placed",
                "name_ar" => "تم الطلب",
                "active" => 1,
                "editable" => 1,
                "parent_id" => null,
                "deactivation_notes" => null,
            ],
            [
                "id" => "2",
                "name" => "Confirmed",
                "name_ar" => "تم تأكيد الطلب",
                "active" => 1,
                "editable" => 1,
                "parent_id" => null,
                "deactivation_notes" => null,
            ],
            [
                "id" => "3",
                "name" => "Shipped",
                "name_ar" => "تم التسليم",
                "active" => 1,
                "editable" => 1,
                "parent_id" => null,
                "deactivation_notes" => null,
            ],
            [
                "id" => 4,
                "name" => "Delivered",
                "name_ar" => "تم التوصيل",
                "active" => 1,
                "editable" => 1,
                "parent_id" => null,
                "deactivation_notes" => null,
            ],
            [
                "id" => 5,
                "name" => "Investigation",
                "name_ar" => "قيد التحقق",
                "active" => 1,
                "editable" => 1,
                "parent_id" => null,
                "deactivation_notes" => null,
            ],
            [
                "id" => 6,
                "name" => "Cancelled",
                "name_ar" => "تم الالغاء",
                "active" => 1,
                "editable" => 1,
                "parent_id" => null,
                "deactivation_notes" => null,
            ],
            [
                "id" => 7,
                "name" => "Returned",
                "name_ar" => "تم الاسترجاع",
                "active" => 1,
                "editable" => 1,
                "parent_id" => null,
                "deactivation_notes" => null,
            ],
            [
                "id" => 8,
                "name" => "Prepared",
                "name_ar" => "جاهزة للتسليم",
                "active" => 1,
                "editable" => 1,
                "parent_id" => null,
                "deactivation_notes" => null,
            ],
            [
                "id" => 9,
                "name" => "In Completed",
                "name_ar" => "مكتمل",
                "active" => 1,
                "editable" => 1,
                "parent_id" => null,
                "deactivation_notes" => null,
            ],
            [
                "id" => 10,
                "name" => "Partially Returned",
                "name_ar" => "تمت إرجاع جزء",
                "active" => 1,
                "editable" => 1,
                "parent_id" => null,
                "deactivation_notes" => null,
            ],
            [
                "id" => 11,
                "name" => "Pending Payment",
                "name_ar" => "في انتظار الدفع",
                "active" => 1,
                "editable" => 1,
                "parent_id" => null,
                "deactivation_notes" => null,
            ],
            [
                "id" => 12,
                "name" => "Pending Expired",
                "name_ar" => "انتهت الدفعة",
                "active" => 1,
                "editable" => 1,
                "parent_id" => null,
                "deactivation_notes" => null,
            ],
            [
                "id" => 14,
                "name" => "Delivery Failed",
                "name_ar" => "فشل التسليم",
                "active" => 1,
                "editable" => 1,
                "parent_id" => null,
                "deactivation_notes" => null,
            ]
        ];
        OrderState::insert($states);
    }
}
