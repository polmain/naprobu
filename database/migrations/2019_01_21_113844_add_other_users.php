<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOtherUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		Schema::table('users', function (Blueprint $table) {
			$table->string('patronymic',100)->nullable();
			$table->string('phone',150)->nullable();
			$table->boolean('isHide')->default(false);
			$table->boolean('isFreeComments')->default(false);
			$table->boolean('isNewsletter')->default(false);
			$table->string('md5_pass',400)->nullable();
			$table->string('ip',15)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function (Blueprint $table) {
			$table->dropColumn('isHide');
			$table->dropColumn('md5_pass');
			$table->dropColumn('phone');
			$table->dropColumn('patronymic');
			$table->dropColumn('isFreeComments');
			$table->dropColumn('isNewsletter');
			$table->dropColumn('ip');
		});
	}
}
