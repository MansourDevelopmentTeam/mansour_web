<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("user_id")->unsigned();
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->string("name")->nullable();
            $table->text("address")->nullable();
            $table->string("apartment")->nullable();
            $table->string("floor")->nullable();
            $table->string("landmark")->nullable();
            $table->integer("city_id")->nullable()->unsigned();
            $table->foreign("city_id")->references("id")->on("cities")->onDelete("set null");
            $table->integer("area_id")->nullable()->unsigned();
            $table->foreign("area_id")->references("id")->on("areas")->onDelete("set null");
            $table->boolean('primary')->default(0);
            $table->string("lat")->nullable();
            $table->string("lng")->nullable();
            $table->bigInteger("district_id")->unsigned()->nullable();
            $table->foreign("district_id")->references('id')->on('districts')->onDelete('set null');
//            $table->integer("address_type")->default(1);
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
        Schema::dropIfExists('addresses');
    }
}
