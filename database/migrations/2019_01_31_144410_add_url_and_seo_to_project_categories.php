<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUrlAndSeoToProjectCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_categories', function (Blueprint $table) {
			$table->string('url',200)->nullable();
			$table->string('seo_title',300)->nullable();
			$table->string('seo_description',300)->nullable();
			$table->string('seo_keyword',300)->nullable();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_categories', function (Blueprint $table) {
			$table->dropColumn('url');
			$table->dropColumn('seo_title');
			$table->dropColumn('seo_description');
			$table->dropColumn('seo_keyword');
		});
    }
}
