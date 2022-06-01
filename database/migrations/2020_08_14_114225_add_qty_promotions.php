<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQtyPromotions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotions', function (Blueprint $table) {
            if(!Schema::hasColumn('promotions', 'qty')) {
              $table->integer("qty")->unsigned()->nullable();
            }

            if(!Schema::hasColumn('promotions', 'list_id')) {
              $table->integer("list_id")->unsigned()->nullable();
              $table->foreign("list_id")->references("id")->on('lists')->onDelete("cascade");
            }
            
            $table->integer("brand_id")->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (\DB::getDriverName() !== 'sqlite') {
            Schema::table('promotions', function (Blueprint $table) {
                $table->dropForeign(["promotions_list_id_foreign"]);
            });
        }

        Schema::table('promotions', function (Blueprint $table) {
            $table->dropColumn(["qty", "list_id"]);
        });
    }
}
