<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariantValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variant_values', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('option_id')->unsigned();
            $table->foreign('option_id')->references("id")->on('options')->onDelete('cascade');

            $table->integer('value_id')->unsigned();
            $table->foreign('value_id')->references("id")->on('option_values')->onDelete('cascade');

            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references("id")->on('products')->onDelete('cascade');

            $table->integer('product_variant_id')->unsigned();
            $table->foreign('product_variant_id')->references("id")->on('product_variants')->onDelete('cascade');

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
        Schema::dropIfExists('product_variant_values');
    }
}
