<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterIntegerToFloat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_products', function (Blueprint $table) {
            $table->decimal('amount')->change();
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->decimal('amount')->change();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->decimal('stock')->change();
            $table->decimal('max_per_order')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
