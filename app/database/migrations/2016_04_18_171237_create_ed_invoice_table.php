<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;

    class CreateEdInvoiceTable extends Migration
    {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('invoice', function (Blueprint $table) {
                $table->increments('id');
                $table->string('invoice');
                $table->string('description', 100);
                $table->string('shipping_address');
                $table->integer('pres_id')->comment('Referencing Prescription Table ');
                $table->integer('user_id')->comment('Referencing User Table ');
                $table->integer('status_id')->default(1)->comment('Referencing Invoice Status Table');
                $table->double('sub_total', 10, 2)->default(0.00);
                $table->double('discount', 10, 2)->default(0.00);
                $table->float('tax_percentage', 5, 2)->default(0.00);
                $table->double('tax_amount', 10, 2)->default(0.00);
                $table->double('shipping', 10, 2)->default(0.00);
                $table->double('total', 10, 2)->default(0.00);
                $table->integer('created_by');
                $table->integer('updated_by');
                $table->integer('shipping_status')->default(1)->comment('Referencing Shipping Status Table');
                $table->integer('shipping_mode')->comment('Referencing Shipping Table');
                $table->integer('shipping_id')->comment('Shipping Reference Id');
                $table->integer('payment_status')->default(1)->comment('Referencing payment status Table');
                $table->string('transaction_id')->comment('Payment Reference Transaction ID');
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
            Schema::drop('invoice');
        }

    }
