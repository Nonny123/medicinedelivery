<?php
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class SettingsTable extends Migration
    {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            //
            Schema::create('settings', function ($table) {
                $table->increments('id');
                $table->string('group');
                $table->string('key');
                $table->string('value');
                $table->enum('type', array("TEXT", "IMAGE", "INTEGER", "FLOAT", "SERIALIZED", "HASHED"))->default("TEXT");
                $table->boolean('is_active')->default(1);
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
            Schema::drop('settings');
        }

    }
