<?php

use App\Services\ImportFiles\ImportConstants;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("progress")->default(0);
            $table->tinyInteger('state')->default(ImportConstants::STATE_PENDING);
            $table->dateTime("finish_date")->nullable();
            $table->integer('type');
            $table->string('file_path');
            $table->integer("user_id")->unsigned()->nullable();
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
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
        Schema::dropIfExists('import_histories');
    }
}
