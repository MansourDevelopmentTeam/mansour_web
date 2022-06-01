<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name");
            $table->integer("brand_id")->unsigned();
            $table->foreign("brand_id")->references("id")->on("brands")->onDelete("cascade");
            $table->decimal("discount", 8, 2);
            $table->date("expiration_date")->nullable();
            $table->boolean("active")->default(1);
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
        Schema::dropIfExists('promotions');
    }
}
