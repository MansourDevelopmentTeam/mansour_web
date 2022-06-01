<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name");
            $table->string("name_ar");
            $table->integer("area_id")->unsigned();
            $table->foreign("area_id")->references('id')->on('areas')->onDelete('cascade');
            $table->decimal("delivery_fees", 8, 2)->default(0);
            $table->boolean("active")->default(1);
            $table->text("deactivation_notes");
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
        Schema::dropIfExists('districts');
    }
}
