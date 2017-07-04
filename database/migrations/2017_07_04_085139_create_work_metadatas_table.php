<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkMetadatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_metadatas', function (Blueprint $table) {
            $table->integer('work_id')->unsigned();
            $table->string('bean_category');
            $table->string('bean_weight');
            $table->string('water_ratio');
            $table->string('water_weight');
            $table->string('work_time');
            $table->string('feeling');
            $table->string('thumbnail');
            $table->string('rank');
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
        Schema::dropIfExists('work_metadatas');
    }
}
