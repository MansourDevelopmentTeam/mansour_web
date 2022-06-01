<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddB2bColumnsToPromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->smallInteger('category')->default(1); // 1 => B2C, 2 => B2B
            $table->decimal('boost')->nullable(); // as gift discount, an amount added to total cart.

            if (Schema::hasColumn('promotions', 'discount')){
                $table->decimal('discount')->nullable()->change();
            }
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
            $table->dropColumn('category');
            $table->dropColumn('boost');
        });
    }
}
