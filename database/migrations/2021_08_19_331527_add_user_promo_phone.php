<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserPromoPhone extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_promo', function (Blueprint $table) {
            if (env('APP_ENV') != 'testing') {
                $table->dropForeign(['user_id']);
            }
            $table->dropColumn('user_id');
            $table->string("phone")->nullable();
        });
        Schema::table('user_promo', function (Blueprint $table) {
            $table->integer("user_id")->nullable()->unsigned();
            $table->foreign("user_id")->references("id")->on("users")->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_promo', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('phone');
        });
    }
}
