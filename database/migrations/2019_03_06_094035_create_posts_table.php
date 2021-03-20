<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',400);
            $table->text('content');
            $table->string('image',500)->nullable();
			$table->integer('isHide')->default(0);
			$table->string('url',500);
			$table->string('password',191)->nullable();
			$table->integer('rus_lang_id')->default(0);
			$table->string('lang',2)->default('ru');
			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('id')->on('projects');
			$table->string('seo_title',400)->nullable();
			$table->string('seo_description',400)->nullable();
			$table->string('seo_keywords',400)->nullable();
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
        Schema::dropIfExists('posts');
    }
}
