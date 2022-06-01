<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->increments('id');
            $table->string("sku")->nullable();
            $table->integer("price")->nullable();
            $table->integer("quantity")->nullable();
            $table->enum("default",[0,1])->default(0);

            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references("id")->on('products')->onDelete('cascade');

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
        Schema::dropIfExists('product_variants');
    }
}
