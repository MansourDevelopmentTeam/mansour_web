<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotions', function (Blueprint $table) {

            /** Drop Columns */
            if (Schema::hasColumns('promotions', ['brand_id', 'list_id', 'target_list_id'])) {
                $table->dropForeign(['brand_id']);
                $table->dropForeign(['list_id']);
                $table->dropForeign(['target_list_id']);
            }
            if (Schema::hasColumns('promotions', ['qty', 'qty2', 'brand_id', 'list_id', 'target_list_id'])) {
                $table->dropColumn('qty');
                $table->dropColumn("qty2");
                $table->dropColumn('brand_id');
                $table->dropColumn('list_id');
                $table->dropColumn('target_list_id');
            }
            /** Drop Columns */

            /** Change Columns */
            if (Schema::hasColumn('promotions','expiration_date')){
                $table->dateTime('expiration_date')->change();
            }
            if (Schema::hasColumn('promotions','discount_qty')) {
                $table->integer('discount_qty')->nullable()->change();
            }
            /** Change Columns */

            /** New Columns */
            $table->softDeletes();
            $table->tinyInteger('type')->default(1)->after('name');
            $table->string('gift_ar')->nullable();
            $table->string('gift_en')->nullable();
            $table->dateTime('start_date')->after('expiration_date');
            $table->integer('priority');
            $table->integer('times')->nullable();
            $table->tinyInteger('check_all_conditions')->nullable()->after('priority');
            $table->tinyInteger('different_brands')->nullable();
            $table->tinyInteger('different_categories')->nullable();
            $table->tinyInteger('different_products')->nullable();
            $table->tinyInteger('override_discount')->nullable();
            /** New Columns */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promotions', function (Blueprint $table) {

            /** Drop Columns */
            if (!Schema::hasColumns('promotions', ['qty', 'qty2', 'brand_id', 'list_id', 'target_list_id'])) {
                $table->integer("qty")->nullable();
                $table->integer("qty2")->nullable();
                $table->integer("list_id")->unsigned()->nullable();
                $table->foreign("list_id")->references("id")->on('lists')->onDelete("cascade");
                $table->integer("brand_id")->unsigned()->nullable();
                $table->foreign("brand_id")->references("id")->on("brands")->onDelete("cascade");
                $table->integer("target_list_id")->unsigned()->nullable();
                $table->foreign("target_list_id")->references('id')->on('lists')->onDelete('cascade');
            }
            /** Drop Columns */

            /** Change Columns */
            if (Schema::hasColumn('promotions','expiration_date')){
                $table->date('expiration_date');
            }
            if (Schema::hasColumn('promotions','discount_qty')) {
                $table->integer('discount_qty');
            }
            /** Change Columns */

            /** Add New Columns */
            $table->dropColumn('deleted_at');
            $table->dropColumn('type');
            $table->dropColumn('start_date');
            $table->dropColumn('priority');
            $table->dropColumn('check_all_conditions');
            $table->dropColumn('different_brands');
            $table->dropColumn('different_categories');
            $table->dropColumn('different_products');
            $table->dropColumn('override_discount');
            $table->dropColumn('gift_ar');
            $table->dropColumn('gift_en');
            $table->dropColumn('times');
            /** Add New Columns */
        });
    }
}
