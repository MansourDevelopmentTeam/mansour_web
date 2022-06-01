<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDelivererDistrictTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliverer_district', function (Blueprint $table) {
            $table->bigInteger('district_id')->unsigned();
            $table->foreign("district_id")->references("id")->on("districts")->onDelete("cascade");
            $table->integer('deliverer_profile_id')->unsigned();
            $table->foreign("deliverer_profile_id")->references("id")->on("deliverer_profiles")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deliverer_district');
    }
}
