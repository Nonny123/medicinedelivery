<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipping extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
            Schema::create('shipping', function ($table) {
                $table->increments('id');
                $table->string('name');
                $table->string('website');
                $table->timestamps();
                $table->integer('created_by');
                $table->integer('updated_by');
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
            Schema::drop('shipping');
	}

}
