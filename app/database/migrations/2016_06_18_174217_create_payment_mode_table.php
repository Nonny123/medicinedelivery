<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentModeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('payment_gateways', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('image');
            $table->boolean('is_delete')->default(0);;
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
        Schema::drop('payment_gateways');
	}

}
