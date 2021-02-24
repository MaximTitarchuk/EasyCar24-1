<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableUsersSearchAddFieldType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_search', function (Blueprint $table) {
            $table->enum('type', ['sms', 'call'])->default('sms')->after("found");
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_search', function (Blueprint $table) {
            $table->dropColumn('type');
        });
        //
    }
}
