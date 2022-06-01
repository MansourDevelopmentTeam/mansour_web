<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAffiliateLinkHistoriesTable extends Migration
{

    public function up()
    {
        Schema::create('affiliate_link_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_ip')->nullable();
            $table->integer("user_id")->nullable()->unsigned();
            $table->foreign("user_id")->references("id")->on("users")->onDelete("set null");
            $table->integer("link_id")->nullable()->unsigned();
            $table->foreign("link_id")->references("id")->on("affiliate_links")->onDelete("set null");
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
        Schema::dropIfExists('affiliate_link_histories');
    }
}
