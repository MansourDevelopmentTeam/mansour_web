<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('option_values', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name_en")->nullable();
            $table->string("name_ar")->nullable();
            $table->string("image")->nullable();
            $table->string("color_code")->nullable();
            $table->integer('option_id')->unsigned();
            $table->foreign('option_id')->references("id")->on('options')->onDelete('cascade');
            $table->enum("active",[0,1])->default(0);
            $table->integer("created_by")->nullable()->unsigned();
            $table->foreign("created_by")->references("id")->on("users")->onDelete("set null");
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
        Schema::dropIfExists('option_values');
    }
}
