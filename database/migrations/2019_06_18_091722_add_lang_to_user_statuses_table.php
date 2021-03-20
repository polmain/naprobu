<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLangToUserStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_statuses', function (Blueprint $table) {
            $table->string('lang',2)->after('name')->default('ru');
            $table->integer('rus_lang_id')->after('lang')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_statuses', function (Blueprint $table) {
			$table->dropColumn('lang');
			$table->dropColumn('rus_lang_id');
        });
    }
}
