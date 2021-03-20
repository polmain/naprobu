<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNoteToUserBansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::rename('user_bans', 'user_change_statuses');
        Schema::table('user_change_statuses', function (Blueprint $table) {
			$table->text('note')->nullable()->after('unlock_time');
			$table->integer('next_status_id')->default(1)->unsigned()->after('user_id');
			$table->foreign('next_status_id')->references('id')->on('user_statuses');
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
			$table->dropColumn('note');
			$table->dropColumn('next_status_id');
		});
		Schema::rename('user_change_statuses', 'user_bans');
    }
}
