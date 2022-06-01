<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageWebArToCustomAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('custom_ads', function (Blueprint $table) {
            $table->string('image_web_ar')->after('image_web')->nullable();
            $table->text("deactivation_notes")->nullable()->after('active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('custom_ads', function (Blueprint $table) {
            $table->dropColumn('image_web_ar', 'deactivation_notes');
        });
    }
}
