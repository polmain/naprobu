<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBloggerUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogger_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',200)->nullable();
            $table->string('fio',300)->nullable();
            $table->text('link')->nullable();
            $table->text('site')->nullable();
            $table->text('instagram_link')->nullable();
            $table->string('instagram_subscriber',200)->nullable();
            $table->text('facebook_link')->nullable();
            $table->string('facebook_subscriber',200)->nullable();
            $table->text('youtube_link')->nullable();
            $table->string('youtube_subscriber',200)->nullable();
            $table->string('youtube_avg_views',300)->nullable();
            $table->text('other_network')->nullable();
            $table->text('contacts')->nullable();

			$table->integer('city_id')->unsigned();
			$table->foreign('city_id')->references('id')->on('blogger_cities');

            $table->text('nova_poshta')->nullable();
            $table->string('phone',300)->nullable();
			$table->text('description')->nullable();
			$table->text('children')->nullable();
			$table->text('price')->nullable();
			$table->text('note')->nullable();
			$table->text('old_member_in_project')->nullable();

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
        Schema::dropIfExists('blogger_users');
    }
}
