<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEdProfessionalTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ed_professional', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('prof_id');
			$table->string('prof_first_name', 25);
			$table->string('prof_last_name', 25);
			$table->string('facebook_id', 255);
			$table->text('prof_address', 65535);
			$table->string('prof_phone', 15);
			$table->string('prof_mail', 255);
			$table->string('prof_pincode', 8);
			$table->datetime('prof_created_on');
			$table->datetime('prof_updated_on');
			$table->boolean('prof_is_delete')->default(0);
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
		Schema::drop('ed_professional');
	}

}
