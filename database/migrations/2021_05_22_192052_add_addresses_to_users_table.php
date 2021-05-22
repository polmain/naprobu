<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressesToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('city_id')->nullable()->after('country');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->unsignedInteger('region_id')->nullable()->after('country');
            $table->foreign('region_id')->references('id')->on('regions');
            $table->unsignedInteger('country_id')->nullable()->after('country');
            $table->foreign('country_id')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['country_id','region_id','city_id']);
            $table->dropColumn('country_id');
            $table->dropColumn('region_id');
            $table->dropColumn('city_id');
        });
    }
}
