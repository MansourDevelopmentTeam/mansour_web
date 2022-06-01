<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_points', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer("order_id")->nullable();
            $table->integer("referer_id")->nullable();
            $table->integer("amount_spent")->default(0);
            $table->integer('total_points')->default(0);
            $table->integer('used_points')->default(0);
            $table->integer('expired_points')->default(0);
            $table->date('expiration_date');
            $table->date('activation_date')->nullable();
            $table->integer("remaining_points")->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('user_points');
    }
}
