<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsEndToUserChangeStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_change_statuses', function (Blueprint $table) {
			$table->boolean('isEnd')->default(false)->after('unlock_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_change_statuses', function (Blueprint $table) {
			$table->dropColumn('isEnd');
		});
    }
}
