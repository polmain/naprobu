<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaqQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faq_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('question',500);
            $table->text('answer');
			$table->string('lang',2)->default('ru');
			$table->integer('rus_lang_id')->unsigned()->default(0);
			$table->integer('faq_category_id')->unsigned();
			$table->foreign('faq_category_id')->references('id')->on('faq_categories');
			$table->integer('sort');
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
        Schema::dropIfExists('faq_questions');
    }
}
