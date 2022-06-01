<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->tinyInteger('type')->nullable()->default(1);
            $table->tinyInteger('has_stock')->nullable()->default(1);
        });
    }

    /** * Reverse the migrations. * * @return void */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(["type", "has_stock"]);
        });
    }
}
