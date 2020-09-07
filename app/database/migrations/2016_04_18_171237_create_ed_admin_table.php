<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;

    class CreateEdAdminTable extends Migration
    {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('admin', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 32);
                $table->string('email', 32);
                $table->integer('admin_type')->comment('Referencing to admin_type table');
                $table->integer('created_by');
                $table->integer('updated_by');
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
            Schema::drop('ed_admin');
        }

    }
