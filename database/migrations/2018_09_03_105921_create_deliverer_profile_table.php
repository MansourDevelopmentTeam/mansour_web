<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDelivererProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliverer_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("status")->default(0);
            $table->integer("area_id")->nullable()->unsigned();
            $table->foreign("area_id")->references("id")->on("areas")->onDelete("set null");
            $table->string("unique_id")->unique()->nullable();
            $table->string("image")->nullable();

            $table->integer("city_id")->unsigned()->nullable();
            $table->foreign("city_id")->references('id')->on('cities')->onDelete("set null");

            $table->integer("user_id")->nullable()->unsigned();
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
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
        Schema::dropIfExists('deliverer_profiles');
    }
}
