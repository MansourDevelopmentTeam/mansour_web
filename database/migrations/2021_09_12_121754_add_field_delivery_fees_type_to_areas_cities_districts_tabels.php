<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldDeliveryFeesTypeToAreasCitiesDistrictsTabels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('areas', function (Blueprint $table) {
            $table->integer("delivery_fees_type")->default(1);
        });
        Schema::table('cities', function (Blueprint $table) {
            $table->integer("delivery_fees_type")->default(1);
        });
        Schema::table('districts', function (Blueprint $table) {
            $table->integer("delivery_fees_type")->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('areas', function (Blueprint $table) {
            $table->dropColumn("delivery_fees_type");
        });
        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn("delivery_fees_type");
        });
        Schema::table('districts', function (Blueprint $table) {
            $table->dropColumn("delivery_fees_type");
        });
    }
}
