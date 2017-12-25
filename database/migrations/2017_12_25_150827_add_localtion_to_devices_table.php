<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLocaltionToDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('devices', function (Blueprint $table) {
            $table->string('address')->after('ip_address')->nullable();
            $table->string('street_num',50)->after('address')->nullable();
            $table->string('street')->after('street_num')->nullable();
            $table->string('district')->after('street')->nullable();
            $table->string('city',50)->after('district')->nullable();
            $table->string('province',50)->after('city')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->dropColumn('street_num');
            $table->dropColumn('street');
            $table->dropColumn('district');
            $table->dropColumn('city');
            $table->dropColumn('province');
        });
    }
}
