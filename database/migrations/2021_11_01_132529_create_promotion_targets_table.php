<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_targets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('item_type');
            $table->integer('item_id')->nullable();

            $table->bigInteger('promotion_id')->unsigned();
            $table->foreign("promotion_id")->references('id')
                ->on('promotions')->onDelete('cascade');

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
        Schema::dropIfExists('promotion_targets');
    }
}
