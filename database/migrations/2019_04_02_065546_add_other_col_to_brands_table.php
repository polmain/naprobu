<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOtherColToBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->boolean('isHide')->default(0)->before('crated_at');
            $table->string('lang',2)->default('ru')->after('name');
            $table->integer('rus_lang_id')->default(0)->after('lang');
            $table->string('alt')->default("")->after('logo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn('isHide');
            $table->dropColumn('lang');
            $table->dropColumn('rus_lang_id');
            $table->dropColumn('alt');
        });
    }
}
