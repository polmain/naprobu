<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50);
            $table->timestamps();
        });
		Schema::table('users', function (Blueprint $table) {
			$table->integer('status_id')->unsigned();
			$table->foreign('status_id')->references('id')->on('project_statuses');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_statuses');

		Schema::table('users', function (Blueprint $table) {
			$table->dropColumn('status_id');
		});
    }
}
