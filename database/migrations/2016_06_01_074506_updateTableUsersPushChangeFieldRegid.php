<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableUsersPushChangeFieldRegid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_push', function (Blueprint $table) {
            $table->string('regid')->change()->default("");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_push', function (Blueprint $table) {
            $table->double('regid')->change()->default(0);
        });

    }
}
