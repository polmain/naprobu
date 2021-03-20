<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeIdToBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks', function (Blueprint $table) {
			$table->integer('type_id')->unsigned();
			$table->foreign('type_id')->references('id')->on('block_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks', function (Blueprint $table) {
            $table->dropColumn('type_id');
        });
    }
}
