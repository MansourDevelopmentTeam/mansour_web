<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionConditionsCustomListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_conditions_custom_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('item_id');

            $table->bigInteger('condition_id')->unsigned();
            $table->foreign("condition_id")->references('id')
                ->on('promotion_conditions')->onDelete('cascade');

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
        Schema::dropIfExists('promotion_conditions_custom_lists');
    }
}
