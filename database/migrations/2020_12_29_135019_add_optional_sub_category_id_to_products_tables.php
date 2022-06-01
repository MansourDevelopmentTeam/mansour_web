<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOptionalSubCategoryIdToProductsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $colExists = Schema::hasColumn('products', 'optional_sub_category_id');
        
        if(!$colExists) {
            Schema::table('products', function (Blueprint $table) {
              $table->integer('optional_sub_category_id')->nullable()->after('category_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('optional_sub_category_id');
        });
    }
}
