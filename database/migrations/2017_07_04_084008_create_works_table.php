<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('works', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('device_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('bean_category')->nullable();
            $table->string('bean_weight')->nullable();
            $table->string('water_ratio')->nullable();
            $table->string('water_weight')->nullable();
            $table->string('work_time')->nullable();
            $table->smallInteger('rating')->nullable();
            $table->string('flavor')->nullable();
            $table->string('feeling')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('views')->unsigned()->nullable();
            $table->integer('likes')->unsigned()->nullable();
            $table->integer('unlikes')->unsigned()->nullable();
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
        Schema::dropIfExists('works');
    }
}
