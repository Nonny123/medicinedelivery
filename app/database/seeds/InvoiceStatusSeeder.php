<?php

    class InvoiceStatusSeeder extends Seeder
    {

        public function run()
        {
            DB::table('invoice_status')->truncate();
            DB::table('invoice_status')->insert(
                array(
                    array('name' => 'PENDING', 'created_at' => date('Y-m-d H:i:s'), 'created_by' => 1),
                    array('name' => 'PAID', 'created_at' => date('Y-m-d H:i:s'), 'created_by' => 1),
                    array('name' => 'UNPAID', 'created_at' => date('Y-m-d H:i:s'), 'created_by' => 1),
                    array('name' => 'CANCELLED', 'created_at' => date('Y-m-d H:i:s'), 'created_by' => 1),
                ));
        }
    }

