<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ex_rate_pts')->default(0);
            $table->integer('ex_rate_egp')->default(0);
            $table->integer('ex_rate_gold')->default(0);
            $table->integer('egp_gold')->default(0);
            $table->integer('pending_days')->default(0);
            $table->integer('refer_points')->default(0);
            $table->integer('refer_minimum')->default(0);
            $table->string("open_time")->nullable();
            $table->string("off_time")->nullable();
            $table->decimal("min_order_amount", 8, 2)->nullable();
            $table->timestamps();
        });
        // $seeder = new SettingsSeeder(); //Changed to configurations table
        // $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
