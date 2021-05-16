<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeLogicOnUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vibers', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            $table->string('first_name',255)->nullable();
            $table->string('last_name',255)->nullable();
            $table->string('nickname',255)->nullable();
            $table->string('email',255)->nullable();
            $table->string('lang',2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vibers', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name', 'nickname', 'email', 'lang']);

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
}
