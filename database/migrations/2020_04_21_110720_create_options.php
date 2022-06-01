<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name_en")->nullable();
            $table->string("name_ar")->nullable();
            $table->text("description_en")->nullable();
            $table->text("description_ar")->nullable();
            $table->enum("active",[0,1])->default(0);
            $table->enum("type",[1,2,3,4])->default(1);
            $table->enum("appear_in_search",[0,1])->default(1);
            $table->integer("created_by")->nullable()->unsigned();
            $table->foreign("created_by")->references("id")->on("users")->onDelete("set null");
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
        Schema::dropIfExists('options');
    }
}
