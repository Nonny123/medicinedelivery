<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;

    class CreateEdPrescriptionTable extends Migration
    {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('prescription', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('pres_id');
                $table->string('path', 100);
                $table->integer('status')->default(1)->comment = "References Prescription Status Table";
                $table->integer('user_id')->comment = "References User Table";
                $table->boolean('is_delete')->default('0');
                $table->string('created_by');
                $table->string('updated_by');
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
            Schema::drop('prescription');
        }

    }
