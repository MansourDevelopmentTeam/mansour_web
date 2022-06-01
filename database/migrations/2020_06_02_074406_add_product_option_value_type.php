<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductOptionValueType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_option_values', function (Blueprint $table) {
            $table->enum("type",[0,1])->default(0);
        });
        if (env('APP_ENV') != 'testing') {
            \DB::statement("ALTER TABLE options MODIFY COLUMN type ENUM('1', '2', '3','4','5')");
        }
    }

    public function down()
    {
        Schema::table('product_option_values', function (Blueprint $table) {
            $table->dropColumn("type");
        });
    }
}