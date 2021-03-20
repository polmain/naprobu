<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditQuestionnaireTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('questionnaires', function (Blueprint $table) {
			$table->renameColumn('type','type_id');
			$table->text('text')->nullable();
			$table->boolean('isHide')->default(false);
		});
		Schema::table('questions', function (Blueprint $table) {
			$table->renameColumn('type','type_id');
			$table->text('restrictions')->nullable();
			$table->string('help',250)->nullable();
			$table->integer('sort')->default(1);
			$table->boolean('isHide')->default(false);
		});
		Schema::table('answers', function (Blueprint $table) {
			$table->renameColumn('user','user_id');
			$table->renameColumn('questionnaire','questionnaire_id');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('questionnaires', function (Blueprint $table) {
			$table->renameColumn('type_id','type');
			$table->dropColumn('text');
			$table->dropColumn('isHide');
		});
		Schema::table('questions', function (Blueprint $table) {
			$table->renameColumn('type_id','type');
			$table->dropColumn('restrictions');
			$table->dropColumn('help');
			$table->dropColumn('isHide');
			$table->dropColumn('sort');
		});
		Schema::table('answers', function (Blueprint $table) {
			$table->renameColumn('user_id','user');
			$table->renameColumn('questionnaire_id','questionnaire');
		});
    }
}
