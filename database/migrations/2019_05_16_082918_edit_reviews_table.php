<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('reviews', function (Blueprint $table) {
			$table->dropColumn('lang');
			$table->dropColumn('rus_lang_id');
			$table->string('name',200)->after('id')->nullable();

		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('reviews', function (Blueprint $table) {
			$table->string('lang',2)->default("ru");
			$table->integer('rus_lang_id')->unsigned()->default(0);
			$table->dropColumn('name');
		});
    }
}
