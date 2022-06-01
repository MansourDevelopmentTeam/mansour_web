<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderHistory extends Migration
{

    public function up()
    {
        Schema::table('order_history', function (Blueprint $table) {
            $table->text("status_notes")->nullable();
        });
    }

    public function down()
    {
        Schema::table('order_history', function (Blueprint $table) {
            $table->dropColumn("status_notes");
        });
    }
}