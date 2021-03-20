<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsSendNotificationToSubpagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subpages', function (Blueprint $table) {
            $table->boolean('isSendNotification')->after('isHide')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subpages', function (Blueprint $table) {
			$table->dropColumn('isSendNotification');
        });
    }
}
