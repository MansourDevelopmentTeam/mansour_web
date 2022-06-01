<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAffiliateLinksTable extends Migration
{

    public function up()
    {
        Schema::create('affiliate_links', function (Blueprint $table) {
            $table->increments('id');
            $table->longText("url")->nullable();
            $table->string('referral')->nullable();
            $table->integer("affiliate_id")->nullable()->unsigned();
            $table->foreign("affiliate_id")->references("id")->on("users")->onDelete("set null");
            $table->dateTime('expiration_date')->nullable();
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
        Schema::dropIfExists('affiliate_links');
    }
}
