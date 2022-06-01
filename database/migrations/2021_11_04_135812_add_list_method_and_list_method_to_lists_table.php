<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddListMethodAndListMethodToListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('lists', 'list_method')) {
            Schema::table('lists', function (Blueprint $table) {
                $table->boolean('list_method')->nullable();
            });
        }

        if (!Schema::hasColumn('lists', 'condition_type')) {
            Schema::table('lists', function (Blueprint $table) {
                $table->boolean('condition_type')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lists', function (Blueprint $table) {
            $table->dropColumn(['condition_type', 'list_method']);
        });
    }
}
