<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRedeemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_redeems', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->bigInteger('user_point_id')->unsigned();
            // $table->foreign('user_point_id')->references('id')->on('user_points')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('reward_id')->unsigned();
            $table->foreign('reward_id')->references('id')->on('rewards')->onDelete('cascade');
            $table->integer("promo_id")->nullable()->unsigned();
            $table->integer("points_used")->default(0);
            $table->integer("status")->default(0);
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
        Schema::dropIfExists('user_redeems');
    }
}
