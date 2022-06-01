<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdjustPromotionsFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->decimal("discount_qty")->nullable()->change();
        });

        Schema::table('promotion_conditions', function (Blueprint $table) {
            $table->decimal("quantity")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->integer("discount_qty")->nullable()->change();
        });

        Schema::table('promotion_conditions', function (Blueprint $table) {
            $table->integer("quantity")->nullable()->change();
        });
    }
}
