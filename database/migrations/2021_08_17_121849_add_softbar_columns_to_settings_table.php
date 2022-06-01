<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftbarColumnsToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->longText('softbar_text_ar')->nullable();
            $table->longText('softbar_text_en')->nullable();
            $table->string('softbar_bg_color', 50)->nullable();
            $table->tinyInteger('softbar_view')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('softbar_text_ar');
            $table->dropColumn('softbar_text_en');
            $table->dropColumn('softbar_bg_color');
            $table->dropColumn('softbar_view');
        });
    }
}
