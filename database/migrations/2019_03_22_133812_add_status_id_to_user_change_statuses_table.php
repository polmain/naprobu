<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusIdToUserChangeStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_change_statuses', function (Blueprint $table) {
			$table->integer('status_id')->default(1)->unsigned()->before('next_status_id');
			$table->foreign('status_id')->references('id')->on('user_statuses');
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
			$table->dropColumn('status_id');
		});
    }
}
