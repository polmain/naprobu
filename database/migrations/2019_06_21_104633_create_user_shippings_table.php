<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_shippings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ttn')->nullable();
			$table->integer('request_id')->unsigned();
			$table->foreign('request_id')->references('id')->on('project_requests');
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
        Schema::dropIfExists('user_shippings');
    }
}
