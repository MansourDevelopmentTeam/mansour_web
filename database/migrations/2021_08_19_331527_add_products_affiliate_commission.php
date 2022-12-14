<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductsAffiliateCommission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal("affiliate_commission", 8, 2)->nullable();
        });
        Schema::table('order_products', function (Blueprint $table) {
            $table->decimal("affiliate_commission", 8, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('affiliate_commission');
        });
        Schema::table('order_products', function (Blueprint $table) {
            $table->dropColumn('affiliate_commission');
        });
    }
}
