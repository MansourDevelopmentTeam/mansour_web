<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name");
            $table->text("description")->nullable();
            $table->integer("parent_id")->unsigned()->nullable();
            $table->foreign("parent_id")->references("id")->on("categories")->onDelete("cascade");
            $table->string("image")->nullable();
            $table->integer("created_by")->nullable()->unsigned();
            $table->foreign("created_by")->references("id")->on("users")->onDelete("set null");
            $table->boolean("active")->default(0);
            $table->text("deactivation_notes")->nullable();
            $table->integer("order")->default(0);
            $table->string("name_ar")->nullable();
            $table->string("description_ar")->nullable();
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
        Schema::dropIfExists('categories');
    }
}
