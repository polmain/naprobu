<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('answers', function (Blueprint $table) {
			$table->dropColumn('user_id');
			$table->dropColumn('questionnaire_id');

			$table->boolean('isHide')->default(false);
			$table->integer('question_id')->unsigned();
			$table->foreign('question_id')->references('id')->on('questions');
			$table->integer('project_request_id')->unsigned();
			$table->foreign('project_request_id')->references('id')->on('project_requests');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('answers', function (Blueprint $table) {
			$table->dropColumn('isHide');
			$table->dropColumn('questionnaire_id');
			$table->dropColumn('questionnaire_id');

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->integer('questionnaire_id')->unsigned();
			$table->foreign('questionnaire_id')->references('id')->on('questionnaire_questions');
		});
    }
}
