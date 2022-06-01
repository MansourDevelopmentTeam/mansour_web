<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressPhone extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->string("phone")->nullable();
            if (env('APP_ENV') != 'testing') {
                $table->dropForeign(['user_id']);
            }
            $table->integer('user_id')->nullable()->unsigned()->change();
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->string('email')->nullable();
            $table->integer("verification_code")->nullable();
            $table->boolean("phone_verified")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('email');
        });
    }
}
