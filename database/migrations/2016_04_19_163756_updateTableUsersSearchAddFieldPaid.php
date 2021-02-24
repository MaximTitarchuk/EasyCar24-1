<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableUsersSearchAddFieldPaid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_search', function (Blueprint $table) {
            $table->boolean('paid')->default(false)->after("cost");
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
            $table->dropColumn('paid');
        });
    }
}
