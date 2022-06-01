<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmailColumnToStockNotifiactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (\DB::getDriverName() !== 'sqlite') {
            Schema::table('stock_notifications', function (Blueprint $table) {
                $table->dropForeign(["user_id"]);
            });
        }

        Schema::table('stock_notifications', function (Blueprint $table) {
            // $table->dropForeign(['user_id']);
            $table->string('email')->nullable();
            $table->integer('user_id')->nullable()->unsigned()->change();   
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (\DB::getDriverName() !== 'sqlite') {
            Schema::table('stock_notifications', function (Blueprint $table) {
                $table->dropForeign(["user_id"]);
            });
        }

        Schema::table('stock_notifications', function (Blueprint $table) {
            $table->dropColumn(['user_id','email']);
        });
    }
}
