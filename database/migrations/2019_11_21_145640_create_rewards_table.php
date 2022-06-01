<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rewards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name");
            $table->string("description");
            $table->string("image")->nullable();
            $table->boolean('type')->default(1);
            $table->boolean('amount_type')->nullable();
            $table->integer("amount")->nullable();
            $table->integer("max_amount")->nullable();
            $table->integer("point_cost")->default(0);
            $table->boolean('is_gold')->default(0);
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('rewards');
    }
}
