<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_ads', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name_en")->nullable();
            $table->string("name_ar")->nullable();
            $table->text("description_ar")->nullable();
            $table->text("description_en")->nullable();
            $table->tinyInteger("type")->nullable();
            $table->text("image_en")->nullable();
            $table->text("image_ar")->nullable();
            $table->boolean("active")->default(1);
            $table->string("dev_key")->nullable();
            $table->integer("item_id")->nullable();
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
        Schema::dropIfExists('custom_ads');
    }
}
