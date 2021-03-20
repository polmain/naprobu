<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubpagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subpages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',300);
            $table->string('short_description',300)->nullable();
            $table->text('text')->nullable();
            $table->string('url',200);
            $table->boolean('isHide')->default(false);
			$table->string('lang',2)->default("ru");
			$table->integer('rus_lang_id')->unsigned()->default(0);
			$table->integer('project_id')->unsigned()->nullable();
			$table->foreign('project_id')->references('id')->on('projects');
			$table->integer('type_id')->unsigned();
			$table->foreign('type_id')->references('id')->on('subpage_types');

			$table->boolean('hasComments')->default(false);
			$table->boolean('hasReviews')->default(false);
			$table->boolean('isReviewForm')->default(true);

			$table->string('image', 100)->nullable();

			$table->string('seo_title',300)->nullable();
			$table->string('seo_description',300)->nullable();
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
        Schema::dropIfExists('subpages');
    }
}
