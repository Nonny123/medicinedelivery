<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;

    class CreateEdNewMedEmailTable extends Migration
    {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('request_list', function (Blueprint $table) {
                $table->increments('id');
                $table->string('email', 32);
                $table->integer('user_id');
                $table->integer('request_id')->comment = "Reference Medicine request table";
                $table->boolean('is_delete')->default(0);
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
            Schema::drop('request_list');
        }

    }
