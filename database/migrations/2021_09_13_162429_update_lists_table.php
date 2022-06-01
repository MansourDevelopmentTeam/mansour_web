<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropColumns('lists', ['image_en', 'image_ar', 'list_method', 'condition_type']);

        DB::unprepared("ALTER TABLE `lists` CHANGE `active` `active` TINYINT(1) NOT NULL DEFAULT '1' AFTER `type`");
        
        Schema::table('lists', function (Blueprint $table) {
            $table->json('rules')->nullable();
        });
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
