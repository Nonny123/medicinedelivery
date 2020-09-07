<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;

    class CreateEdCustomerTable extends Migration
    {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('customer', function (Blueprint $table) {
                $table->increments('id');
                $table->string('first_name', 25);
                $table->string('last_name', 25);
                $table->string('facebook_id', 255);
                $table->text('address', 65535);
                $table->string('phone', 15);
                $table->string('mail', 255);
                $table->string('pincode', 8);
                $table->integer('country')->comment('Referencing Country Table');
                $table->timestamps();
                $table->boolean('is_delete')->default(0);
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::drop('customer');
        }

    }
