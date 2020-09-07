<?php

    class PaymentStatusSeeder extends Seeder
    {

        public function run()
        {
            DB::table('payment_status')->truncate();
            DB::table('payment_status')->insert(
                array(
                    array('name' => 'PENDING', 'created_at' => date('Y-m-d H:i:s'), 'created_by' => 1),
                    array('name' => 'SUCCESS', 'created_at' => date('Y-m-d H:i:s'), 'created_by' => 1),
                    array('name' => 'FAILURE', 'created_at' => date('Y-m-d H:i:s'), 'created_by' => 1),
                ));
        }
    }

