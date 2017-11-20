<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSessionKeyInWxUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wx_users', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->string('nickname')->nullable()->change();
            $table->string('gender')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('province')->nullable()->change();
            $table->string('country')->nullable()->change();
            $table->string('avatar_url')->nullable()->change();
            $table->string('union_id')->nullable()->change();
            $table->string('session_key', 256)->after('union_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wx_users', function (Blueprint $table) {
            $table->dropForeign('wx_users_user_id_foreign');
            $table->dropColumn('session_key');
        });
    }
}
