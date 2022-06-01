<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGroupOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->integer("order")->default(0);
            
        });
    }


    public function down()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropColumn("order");
        });
    }
}
