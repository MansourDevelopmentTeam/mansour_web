<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePushMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('push_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string("title");
            $table->text("body");
            $table->integer("creator_id")->unsigned()->nullable();
            $table->foreign("creator_id")->references("id")->on("users")->onDelete("set null");
            $table->string("image")->nullable();
            $table->integer("product_id")->nullable()->unsigned();
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
        Schema::dropIfExists('push_messages');
    }
}
