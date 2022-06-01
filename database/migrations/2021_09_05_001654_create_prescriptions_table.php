<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('prescriptions');
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('address_id')->unsigned()->nullable();
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete("set null");
            $table->string("image");
            $table->string("name")->nullable();
            $table->text("note")->nullable();
            $table->integer("user_id")->unsigned()->nullable();
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->string('invoice_id')->nullable();
            $table->integer('amount')->nullable();
            $table->text('comment')->nullable();
            $table->text('cancellation_text')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->integer('cancellation_id')->unsigned()->nullable();
            $table->foreign('cancellation_id')->references('id')->on('prescription_cancellation_reasons')->onDelete('no action');
            $table->integer('admin_id')->unsigned()->nullable();
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('NO ACTION');
            $table->dateTime('assigned_at')->nullable();

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
        Schema::dropIfExists('prescriptions');
    }
}
