<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMinCharsetsToSubpageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subpages', function (Blueprint $table) {
			$table->integer('min_charsets')->after('isReviewForm')->default(0);
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
            $table->dropColumn('min_charsets');
        });
    }
}
