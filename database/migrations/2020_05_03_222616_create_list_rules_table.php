<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->string("field")->nullable();
            $table->integer("condition")->nullable();
            $table->string("value")->nullable();

            $table->integer("type")->nullable();
            $table->integer("item_id")->nullable();

            $table->integer('list_id')->unsigned();
            $table->foreign("list_id")->references("id")->on("lists")->onDelete("cascade");

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
        Schema::dropIfExists('list_rules');
    }
}
