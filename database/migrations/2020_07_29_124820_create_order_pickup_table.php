<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderPickupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_pickups', function (Blueprint $table) {
            $table->bigInteger('pickup_id')->unsigned();
            $table->foreign("pickup_id")->references("id")->on("pickups")->onDelete("cascade");
            $table->integer('order_id')->unsigned();
            $table->foreign("order_id")->references("id")->on("orders")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_pickups');
    }
}
