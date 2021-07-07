<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClassificationFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('education',50)->nullable()->index()->after('nova_poshta_warehouse');
            $table->string('employment',50)->nullable()->index()->after('education');
            $table->string('work',50)->nullable()->index()->after('education');
            $table->string('family_status',50)->nullable()->index()->after('employment');
            $table->string('material_condition',50)->nullable()->index()->after('family_status');
            $table->string('hobbies',3000)->nullable()->after('material_condition');
            $table->string('hobbies_other',500)->nullable()->after('hobbies');
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
            $table->dropIndex(['education','employment','family_status','material_condition','work']);
            $table->dropColumn('education');
            $table->dropColumn('employment');
            $table->dropColumn('work');
            $table->dropColumn('family_status');
            $table->dropColumn('material_condition');
            $table->dropColumn('hobbies');
            $table->dropColumn('hobbies_other');
        });
    }
}
