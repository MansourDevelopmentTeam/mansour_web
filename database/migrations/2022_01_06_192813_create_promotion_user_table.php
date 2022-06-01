<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_users', function (Blueprint $table) {
            $table->id();
            $table->integer('promotion_id');
            $table->integer('user_id');
            $table->integer('order_id');
            $table->dateTime('use_date');
            $table->dateTime('valid_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotion_users');
    }
}
