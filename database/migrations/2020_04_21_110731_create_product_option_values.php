<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductOptionValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_option_values', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references("id")->on('products')->onDelete('cascade');

            $table->integer('option_id')->unsigned();
            $table->foreign('option_id')->references("id")->on('options')->onDelete('cascade');

            $table->string("input_en")->nullable();
            $table->string("input_ar")->nullable();


            $table->integer('value_id')->unsigned();
            $table->foreign('value_id')->references("id")->on('option_values')->onDelete('cascade');

            $table->text("image")->nullable();
            $table->string("color_code")->nullable();

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
        Schema::dropIfExists('product_option_values');
    }
}
