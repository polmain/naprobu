<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNovaPoshtaToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nova_poshta_city',500)->nullable()->after('city_id');
            $table->string('nova_poshta_warehouse',500)->nullable()->after('nova_poshta_city');
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
            $table->dropColumn('nova_poshta_city');
            $table->dropColumn('nova_poshta_warehouse');
        });
    }
}
