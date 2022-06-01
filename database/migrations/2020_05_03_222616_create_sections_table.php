<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name_en")->nullable();
            $table->string("name_ar")->nullable();
            $table->text("description_ar")->nullable();
            $table->text("description_en")->nullable();
            $table->tinyInteger("type")->nullable();
            $table->text("image_en")->nullable();
            $table->text("image_ar")->nullable();

            $table->integer('order')->default(0);
            $table->boolean('active')->default(1);

            $table->integer('list_id')->unsigned();
            $table->foreign("list_id")->references("id")->on("lists")->onDelete("cascade");

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
        Schema::dropIfExists('sections');
    }
}
