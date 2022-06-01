<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsB2bSegmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions_b2b_segments', function (Blueprint $table) {
            $table->id();
            $table->integer('min');
            $table->integer('max')->nullable();

            $table->tinyInteger('discount_type'); // fixed / per-item
            $table->decimal('discount'); // value of discount
            $table->integer('iterator'); // in case discount type = per-x-item

            $table->bigInteger('promotion_id')->unsigned(); // in case discount type = per-x-item
            $table->foreign('promotion_id')->references('id')->on('promotions');//->onDelete('cascade');

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
        Schema::dropIfExists('promotions_b2b_segments');
    }
}
