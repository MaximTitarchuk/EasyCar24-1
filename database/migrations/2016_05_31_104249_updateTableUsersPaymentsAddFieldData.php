<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableUsersPaymentsAddFieldData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_payments', function (Blueprint $table) {
            $table->text('data')->nullable()->after("description");
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('users_payments', function (Blueprint $table) {
            $table->dropColumn('data');
        });
    }
}
