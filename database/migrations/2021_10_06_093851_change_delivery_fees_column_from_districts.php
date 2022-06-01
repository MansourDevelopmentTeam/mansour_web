<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDeliveryFeesColumnFromDistricts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('districts', function (Blueprint $table) {
            $table->decimal("delivery_fees", 8, 2)->nullable()->default(NULL)->change();
        });

        Schema::table('areas', function (Blueprint $table) {
            $table->decimal("delivery_fees", 8, 2)->nullable()->default(NULL)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('districts', function (Blueprint $table) {
            $table->dropColumn("delivery_fees");
        });

        Schema::table('areas', function (Blueprint $table) {
            $table->dropColumn("delivery_fees");
        });
    }
}
