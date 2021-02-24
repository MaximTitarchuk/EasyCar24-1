<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsersPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
	    $table->integer('balance')->default(0);
	    $table->boolean('paid')->default(false);
	    $table->string("description")->nullable();
            $table->timestamps();

	    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("users_payments");
    }
}
