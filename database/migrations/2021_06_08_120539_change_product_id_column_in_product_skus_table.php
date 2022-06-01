<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeProductIdColumnInProductSkusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (\DB::getDriverName() !== 'sqlite') {
            Schema::table('product_skus', function (Blueprint $table) {
                $table->dropForeign(["product_id"]);
            });
        }

        Schema::table('product_skus', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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
            Schema::table('product_skus', function (Blueprint $table) {
                $table->dropForeign(["product_id"]);
            });
        }
    }
}
