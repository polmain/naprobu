<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditQuestionnaiteQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::dropIfExists('questionnaire_questions');
		Schema::table('questions', function (Blueprint $table) {
			$table->integer('question_relation_id')->unsigned()->default(0);
			$table->integer('questionnaire_id')->unsigned();
			$table->foreign('questionnaire_id')->references('id')->on('questionnaires');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::create('questionnaire_questions', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('questionnaire_id')->unsigned();
			$table->foreign('questionnaire_id')->references('id')->on('questionnaires');
			$table->integer('question_id')->unsigned();
			$table->foreign('question_id')->references('id')->on('questions');
			$table->integer('sort');
			$table->timestamps();
		});

		Schema::table('questionnaires', function (Blueprint $table) {
			$table->dropColumn('question_relation_id');
			$table->dropColumn('questionnaire_id');
		});
    }
}
