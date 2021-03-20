<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->text('text')->nullable();
			$table->string('lang',2)->default("ru");
			$table->integer('rus_lang_id')->unsigned()->default(0);
			$table->boolean('isHide')->default(false);
			$table->string('images',3000)->nullable();
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->integer('subpage_id')->unsigned();
			$table->foreign('subpage_id')->references('id')->on('subpage');
			$table->integer('status_id')->unsigned();
			$table->foreign('status_id')->references('id')->on('status_reviews');
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
        Schema::dropIfExists('reviews');
    }
}
