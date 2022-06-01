<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('shop_name');
            $table->string('shop_name_ar');
            $table->text('address');
            $table->text('address_ar');
            $table->string('area');
            $table->string('area_ar');
            $table->string('lat');
            $table->string('lng');
            $table->text('phone');
            $table->string('email', 100)->nullable();
            $table->string('type', 100)->nullable();
            $table->integer('order')->default(1);
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
        Schema::dropIfExists('branches');
    }
}
