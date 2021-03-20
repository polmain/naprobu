<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBloggerUserCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogger_user_categories', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('blogger_id')->unsigned();
			$table->foreign('blogger_id')->references('id')->on('blogger_users');
			$table->integer('category_id')->unsigned();
			$table->foreign('category_id')->references('id')->on('blogger_categories');
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
        Schema::dropIfExists('blogger_user_categories');
    }
}
