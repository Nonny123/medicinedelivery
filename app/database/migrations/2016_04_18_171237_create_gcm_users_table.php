<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGcmUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gcm_users', function(Blueprint $table) {
			$table->increments('id');
			$table->string('gcm_regid', 64)->nullable();
			$table->string('name', 64)->nullable();
			$table->string('email', 64)->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('gcm_users');
	}

}
