<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPresentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_presents', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->integer('rang_id')->unsigned();
			$table->foreign('rang_id')->references('id')->on('user_rating_statuses');
			$table->boolean('isGet')->default(0);
			$table->boolean('isSent')->default(0);
			$table->text('email_text')->nullable();
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
        Schema::dropIfExists('user_presents');
    }
}
