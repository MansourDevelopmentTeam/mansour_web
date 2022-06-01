<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_options', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('sub_category_id')->unsigned();
            $table->foreign('sub_category_id')->references("id")->on('categories')->onDelete('cascade');

            $table->integer('option_id')->unsigned();
            $table->foreign('option_id')->references("id")->on('options')->onDelete('cascade');


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
