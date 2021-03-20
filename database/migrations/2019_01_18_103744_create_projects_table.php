<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name',300);
			$table->integer('category_id')->unsigned();
			$table->foreign('category_id')->references('id')->on('project_categories');
			$table->boolean('isHide')->default(false);
			$table->string('lang',2)->default("ru");
			$table->integer('rus_lang_id')->unsigned()->default(0);
			$table->text('text')->nullable();
			$table->text('short_description')->nullable();
			$table->string('product_name',300)->nullable();
			$table->text('rules')->nullable();
			$table->integer('count_users')->unsigned()->default(0);
			$table->integer('status_id')->unsigned();
			$table->foreign('status_id')->references('id')->on('project_statuses');
			$table->dateTime('start_registration_time');
			$table->dateTime('end_registration_time');
			$table->dateTime('start_test_time');
			$table->dateTime('start_report_time');
			$table->dateTime('end_project_time');
			$table->string('preview_image',300)->nullable();
			$table->string('main_image',300)->nullable();
			$table->string('review_image',300)->nullable();
			$table->string('seo_title',300)->nullable();
			$table->text('seo_description')->nullable();
			$table->string('seo_keyword',300)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
