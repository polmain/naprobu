<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',250);
			$table->integer('type')->unsigned();
			$table->foreign('type')->references('id')->on('field_types')->onDelete('cascade');
			$table->integer('parent')->unsigned()->default(0);
			$table->boolean('required')->default(false);
			$table->string('lang',2)->default("ru");
			$table->integer('rus_lang_id')->unsigned()->default(0);
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
        Schema::dropIfExists('questions');
    }
}
