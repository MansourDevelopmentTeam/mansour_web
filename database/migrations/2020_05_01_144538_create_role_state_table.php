<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleStateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_state', function (Blueprint $table) {
            $table->bigInteger("role_id")->unsigned();
            $table->foreign("role_id")->references('id')->on("roles")->onDelete("cascade");
            $table->integer("order_state_id")->unsigned();
            $table->foreign("order_state_id")->references('id')->on("order_states")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_state');
    }
}
