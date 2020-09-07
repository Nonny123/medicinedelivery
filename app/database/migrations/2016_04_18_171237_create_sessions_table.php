<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;

    class CreateSessionsTable extends Migration
    {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('sessions', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('medicine_id')->default(0)->comment = "Reference Medicine Table";
                $table->text('medicine_name', 65535);
                $table->text('medicine_count', 65535);
                $table->text('user_id', 65535);
                $table->enum('status', array('active', 'pending'))->default('pending');
                $table->float('unit_price');
                $table->string('item_code', 255);
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
            Schema::drop('sessions');
        }

    }
