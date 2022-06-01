<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductOption extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {


        Schema::table('options', function (Blueprint $table) {
            $table->dropColumn("active");
        });
        Schema::table('option_values', function (Blueprint $table) {
            $table->dropColumn("active");
        });
        Schema::table('options', function (Blueprint $table) {
            $table->boolean("active")->default(1);
        });

    }

    public function down()
    {
        Schema::table('options', function (Blueprint $table) {
            $table->dropColumn("active");
        });
    }
}