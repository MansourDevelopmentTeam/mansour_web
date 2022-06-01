<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeIteratorNullableInPromotionSegments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotions_b2b_segments', function (Blueprint $table) {
            $table->decimal('iterator')->nullable()->change(); // in case discount type = per-x-item
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promotion_segments', function (Blueprint $table) {
            //
        });
    }
}
