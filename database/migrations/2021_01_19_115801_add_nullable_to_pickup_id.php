<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullableToPickupId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_pickups', function (Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign('order_pickups_pickup_id_foreign');
            }else{
                $table->dropColumn('pickup_id');
            }

            $table->bigInteger('pickup_id')->nullable()->unsigned()->change();
            $table->foreign("pickup_id")->references("id")->on("pickups")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_pickups', function (Blueprint $table) {
//            $table->dropColumn('phone');
        });
    }
}
