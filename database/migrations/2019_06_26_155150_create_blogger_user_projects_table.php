<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBloggerUserProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogger_user_projects', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('blogger_id')->unsigned();
			$table->foreign('blogger_id')->references('id')->on('blogger_users');
			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('id')->on('projects');
			$table->text('format')->nullable();
			$table->text('ohvat')->nullable();
			$table->string('prise_without_nds',200)->nullable();
			$table->text('link_to_post')->nullable();
			$table->text('screen_post')->nullable();
			$table->string('views',200)->nullable();
			$table->string('likes',200)->nullable();
			$table->string('comments',200)->nullable();
			$table->text('ohvat_fact')->nullable();
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
        Schema::dropIfExists('blogger_user_projects');
    }
}
