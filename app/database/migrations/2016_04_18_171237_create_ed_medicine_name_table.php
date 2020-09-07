<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;

    class CreateEdMedicineNameTable extends Migration
    {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('medicine', function (Blueprint $table) {
                $table->increments('id');
                $table->string('item_code', 100);
                $table->string('item_name', 255);
                $table->string('group', 255);
                $table->string('batch_no', 12);
                $table->integer('quantity');
                $table->double('cost_price', 10, 2);
                $table->double('purchase_price', 10, 2);
                $table->string('rack_number', 12);
                $table->double('selling_price', 10, 2);
                $table->date('expiry');
                $table->enum('tax_type', array('PERCENTAGE', 'AMOUNT'))->default('AMOUNT');
                $table->double('tax', 10, 2)->default(0.00);
                $table->text('composition', 65535);
                $table->enum('discount_type', array('PERCENTAGE', 'AMOUNT'))->default('AMOUNT');
                $table->double('discount', 10, 2)->deafult(0.00);
                $table->string('manufacturer', 255);
                $table->string('marketed_by', 255);
                $table->timestamps();
                $table->integer('created_by');
                $table->integer('added_by');
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
            Schema::drop('medicine');
        }

    }
