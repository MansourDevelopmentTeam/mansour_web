<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionTargetsCustomListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_targets_custom_lists', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->integer('item_id');

            $table->bigInteger('target_id')->unsigned();
            $table->foreign("target_id")->references('id')
                ->on('promotion_targets')->onDelete('cascade');

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
        Schema::dropIfExists('promotion_targets_custom_lists');
    }
}
