<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")->index();
            $table->string("sku")->nullable();
            $table->integer("discount_price")->nullable();
            $table->text("description");
            $table->integer("price");
            $table->string("image");
            $table->boolean("active")->default(1);
            $table->integer("brand_id")->unsigned()->nullable();
            $table->foreign("brand_id")->references("id")->on("brands")->onDelete("set null");
            $table->integer("orders_count")->default(0);
            $table->integer("category_id")->unsigned()->nullable();
            $table->foreign("category_id")->references("id")->on("categories")->onDelete("set null");
            $table->integer("creator_id")->nullable()->unsigned();
            $table->foreign("creator_id")->references("id")->on("users")->onDelete("set null");
            $table->text("deactivation_notes")->nullable();
            $table->string("name_ar")->nullable();
            $table->string("description_ar")->nullable();
            $table->decimal("rate", 8, 2)->nullable()->default(5);
            $table->integer("stock")->default(0);
            $table->longText("long_description_ar")->nullable();
            $table->longText("long_description_en")->nullable();
            $table->integer("stock_alert")->nullable();
            $table->integer("max_per_order")->nullable();
            $table->integer("min_days")->nullable();
            $table->timestamps();
        });
        if(env('APP_ENV') != 'testing') {
            DB::statement('ALTER TABLE products ADD FULLTEXT fulltext_index (name, name_ar)');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
