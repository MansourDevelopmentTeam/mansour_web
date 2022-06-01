<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLinkFieldAds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->string("link")->nullable();
        });
        Schema::table('custom_ads', function (Blueprint $table) {
            $table->string("link")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn("link");
        });

        Schema::table('custom_ads', function (Blueprint $table) {
            $table->dropColumn("link");
        });
    }
}
