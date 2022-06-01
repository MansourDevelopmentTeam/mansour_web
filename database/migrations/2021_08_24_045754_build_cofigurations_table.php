<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BuildCofigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('label');
            $table->string('key')->unique();
            $table->string('alias')->unique()->nullable();
            $table->string('value')->nullable();
            $table->string('type')->default('text')->comment('input field type');
            $table->json('options')->nullable();
            $table->string('group')->nullable();
            $table->boolean('required')->default(true);
            $table->boolean('editable')->default(true);
            $table->unsignedInteger('order')->default(999);
            $table->enum('scope', ['global', 'customer', 'admin', 'backend'])->default('global');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('configurations');
    }
}
