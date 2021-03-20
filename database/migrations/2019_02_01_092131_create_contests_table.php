<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',300);
            $table->text('text')->nullable();
            $table->string('url',200);
            $table->boolean('isHide')->default(false);
			$table->string('lang',2)->default("ru");
			$table->integer('rus_lang_id')->unsigned()->default(0);
			$table->integer('project_id')->unsigned()->nullable();
			$table->foreign('project_id')->references('id')->on('projects');
			$table->integer('type_id')->unsigned();
			$table->foreign('type_id')->references('id')->on('contests_types');
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
        Schema::dropIfExists('contests');
    }
}
