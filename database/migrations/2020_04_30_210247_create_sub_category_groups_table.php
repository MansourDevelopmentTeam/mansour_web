<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubCategoryGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_category_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("group_id")->unsigned()->nullable();
            $table->foreign("group_id")->references("id")->on("groups")->onDelete("cascade");

            $table->integer("category_id")->unsigned()->nullable();
            $table->foreign("category_id")->references("id")->on("categories")->onDelete("cascade");

            $table->integer("sub_category_id")->unsigned()->nullable();
            $table->foreign("sub_category_id")->references("id")->on("categories")->onDelete("cascade");

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
        Schema::dropIfExists('sub_category_groups');
    }
}
