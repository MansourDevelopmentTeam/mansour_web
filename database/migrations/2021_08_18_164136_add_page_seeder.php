<?php

use Database\Seeders\PageSeeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Migrations\Migration;

class AddPageSeeder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        (new PageSeeder())->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
