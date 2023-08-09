<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKpiDataToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_good_photo')->default(false)->after('rang_id');
            $table->boolean('is_good_video')->default(false)->after('is_good_photo');
            $table->boolean('is_good_review')->default(false)->after('is_good_video');
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
            $table->dropColumn('is_good_photo');
            $table->dropColumn('is_good_video');
            $table->dropColumn('is_good_review');
        });
    }
}
