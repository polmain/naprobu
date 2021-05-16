<?php

use App\Exceptions\IrreversibleMigration;
use Illuminate\Database\Migrations\Migration;

class StartMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $message = 'This migration is irreversible and cannot be reverted.';

        throw new IrreversibleMigration($message);
    }
}
