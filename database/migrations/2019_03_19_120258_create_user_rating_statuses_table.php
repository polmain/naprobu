<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRatingStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_rating_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100);
            $table->integer('min')->unsigned()->default(0);
            $table->integer('max')->unsigned()->default(10000000);
            $table->string('lang',2)->default('ru');
			$table->integer('rus_lang_id')->default(0);
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
        Schema::dropIfExists('user_rating_statuses');
    }
}
