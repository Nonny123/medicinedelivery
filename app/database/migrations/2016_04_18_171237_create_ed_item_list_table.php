<?php
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;

    class CreateEdItemListTable extends Migration
    {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('cart', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('invoice_id')->comment("References Invoice Table");
                $table->integer('medicine')->comment('References Medicine Table');
                $table->integer('quantity');
                $table->double('unit_price', 10, 2)->default(0.00);
                $table->double('total_price', 10, 2)->default(0.00);
                $table->string('discount_type');
                $table->double('discount_percentage', 10, 2)->default(0.00);
                $table->float('unit_discount', 5, 2);
                $table->double('discount', 10, 2)->default(0.00);
                $table->boolean('is_removed')->default(0);
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
            Schema::drop('ed_item_list');
        }

    }
