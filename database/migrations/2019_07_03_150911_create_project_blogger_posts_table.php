<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectBloggerPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_blogger_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->text('code');
			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('id')->on('projects');
			$table->boolean('isHide')->default(0);
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
        Schema::dropIfExists('project_blogger_posts');
    }
}
