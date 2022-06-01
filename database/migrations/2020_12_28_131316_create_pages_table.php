<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string("slug")->nullable();
            $table->string("title_en")->nullable();
            $table->string("title_ar")->nullable();
            $table->longText("content_ar")->nullable();
            $table->longText("content_en")->nullable();

            $table->text("image_en")->nullable();
            $table->text("image_ar")->nullable();


            $table->boolean('active')->default(1);

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
        Schema::dropIfExists('pages');
    }
}
