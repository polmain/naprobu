<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_requests', function (Blueprint $table) {
            $table->increments('id');
			$table->boolean('isHide')->default(false);
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->integer('status_id')->unsigned();
			$table->foreign('status_id')->references('id')->on('project_request_statuses');
			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('id')->on('projects');
			$table->integer('old_id')->nullable();
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
        Schema::dropIfExists('project_requests');
    }
}
