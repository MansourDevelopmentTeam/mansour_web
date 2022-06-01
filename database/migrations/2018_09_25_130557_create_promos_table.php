<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name");
            $table->integer("type");
            $table->integer("max_amount")->nullable();
            $table->text("description")->nullable();
            $table->date("expiration_date");
            $table->boolean("active")->default(1);
            $table->boolean("first_order")->default(0);
            $table->decimal("minimum_amount", 8, 2)->nullable();
            $table->decimal("amount", 8, 2)->nullable()->change();
            $table->integer("recurrence")->default(1);
            $table->text("deactivation_notes")->nullable();
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
        Schema::dropIfExists('promos');
    }
}
