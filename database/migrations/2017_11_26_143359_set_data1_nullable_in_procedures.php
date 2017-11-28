<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetData1NullableInProcedures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('work_procedures', function (Blueprint $table) {
            $table->renameColumn('data1', 'extract_weight');
            $table->renameColumn('data2', 'water_weight');
        });
        Schema::table('work_procedures', function (Blueprint $table) {
            $table->string('extract_weight')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('work_procedures', function (Blueprint $table) {
            $table->renameColumn('extract_weight', 'data1');
            $table->renameColumn('water_weight', 'data2');
        });
    }
}
