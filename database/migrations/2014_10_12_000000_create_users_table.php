<?php

use Database\Seeders\AdminSeeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('last_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string("phone")->index()->nullable();
            $table->boolean("active")->default(1);
            $table->boolean("verified")->default(0);
            $table->boolean("admin_first_order")->default(0);
            $table->boolean("type")->default(1);
            $table->string('refered')->default(0);
            $table->boolean('first_order')->default(0);
            $table->string("referal")->nullable();
            $table->integer("spent")->default(0);
            $table->string("image")->nullable();
            $table->boolean("phone_verified")->default(0);
            $table->string("verification_code")->nullable();
            $table->datetime("last_active")->nullable();
            $table->decimal("rating")->nullable();
            $table->text("deactivation_notes")->nullable();
            // $table->dropColumn("verified");
            $table->date("birthdate")->nullable();
//            $table->index("phone");
            $table->rememberToken();
            $table->timestamps();
        });
        $seeder = new AdminSeeder();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
