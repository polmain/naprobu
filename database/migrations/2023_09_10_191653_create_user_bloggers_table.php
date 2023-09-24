<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserBloggersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_bloggers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status', 255)->default('IN_MODERATE');
            $table->integer('subscriber_count')->nullable();
            $table->integer('blog_subject')->nullable();
            $table->string('blog_platform')->nullable();
            $table->string('blog_url',255)->nullable();
            $table->unsignedInteger('user_id');
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
        Schema::dropIfExists('user_bloggers');
    }
}
