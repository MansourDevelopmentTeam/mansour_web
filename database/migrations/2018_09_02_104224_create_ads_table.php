<?php

use Database\Seeders\AdsSeeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("type");
            $table->string("image");
            $table->integer("item_id")->nullable();
            $table->text("image_web")->nullable();
            $table->text("image_web_ar")->nullable();
            $table->boolean("active")->default(1);
            $table->text("deactivation_notes")->nullable();
            $table->integer("order")->nullable();
            $table->boolean("popup")->default(0);
            $table->boolean('banner_ad')->default(0);
            $table->string("banner_title")->nullable();
            $table->string("banner_description")->nullable();
            $table->string("banner_title_ar")->nullable();
            $table->string("banner_description_ar")->nullable();
            $table->longText("image_ar")->nullable();
            $table->timestamps();
        });
        $seeder = new AdsSeeder();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads');
    }
}
