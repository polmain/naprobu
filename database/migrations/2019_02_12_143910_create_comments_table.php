<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('text');
			$table->boolean('isHide')->default(false);
			$table->integer('review_id')->unsigned();
			$table->foreign('review_id')->references('id')->on('reviews');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->integer('status_id')->unsigned();
			$table->foreign('status_id')->references('id')->on('status_reviews');
			$table->boolean('isImportant')->default(false);
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
        Schema::dropIfExists('comments');
    }
}
