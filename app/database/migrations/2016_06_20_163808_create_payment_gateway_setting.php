<?php
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreatePaymentGatewaySetting extends Migration
    {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            //
            Schema::create('pay_gateway_setting', function ($table) {
                $table->increments('id');
                $table->integer('gateway_id')->comment = "References Payment Gateway Table";
                $table->string('key');
                $table->string('value');
                $table->string('description');
                $table->string('type')->default('TEXT');
                $table->boolean('is_hidden')->default(0);
                $table->text('dataset')->default('')->comment = 'Serialised Data set';
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
            //
            Schema::drop('pay_gateway_setting');
        }

    }
