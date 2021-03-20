<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',400);
            $table->text('content')->nullable();
            $table->string('url',500);
			$table->integer('template_id')->unsigned();
			$table->foreign('template_id')->references('id')->on('templates');
			$table->string('seo_title',400)->nullable();
			$table->string('seo_description',400)->nullable();
			$table->string('seo_keywords',400)->nullable();
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
        Schema::dropIfExists('pages');
    }
}
