<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAndOrToPromotionConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotion_conditions', function (Blueprint $table) {
            $table->tinyInteger('operator')->after('quantity')->default(0); // and => 1, or => 0
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promotion_conditions', function (Blueprint $table) {
            $table->dropColumn('operator');
        });
    }
}
