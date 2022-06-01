<?php

use Illuminate\Support\Facades\Schema;
use Database\Seeders\OrderStatesSeeder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_states', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name");
            $table->boolean('editable')->default(1);
            $table->boolean("active")->default(1);
            $table->text("deactivation_notes")->nullable();
            $table->string("name_ar")->nullable();
            $table->integer("parent_id")->unsigned()->nullable();
            $table->foreign("parent_id")->references("id")->on("order_states")->onDelete("cascade");
            $table->timestamps();
        });
        $seeder = new OrderStatesSeeder();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_states');
    }
}
