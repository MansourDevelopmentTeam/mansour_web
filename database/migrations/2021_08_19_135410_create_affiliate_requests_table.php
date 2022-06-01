<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAffiliateRequestsTable extends Migration
{

    public function up()
    {
        Schema::create('affiliate_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string("phone")->index()->nullable();
            $table->string("image")->nullable();
            $table->boolean("phone_verified")->default(0);
            $table->string("verification_code")->nullable();
            $table->date("birthdate")->nullable();
            $table->tinyInteger("status")->default(0);
            $table->string("last_name")->nullable();
            $table->string("password")->nullable();
            $table->integer("user_id")->nullable()->unsigned();
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->text("rejection_reason")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('affiliate_requests');
    }
}
