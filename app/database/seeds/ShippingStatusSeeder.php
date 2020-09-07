<?php

    class ShippingStatusSeeder extends Seeder
    {

        public function run()
        {
            DB::table('shipping_status')->truncate();
            DB::table('shipping_status')->insert(
                array(
                    array('name' => 'NOT SHIPPED', 'created_at' => date('Y-m-d H:i:s'), 'created_by' => 1),
                    array('name' => 'SHIPPED', 'created_at' => date('Y-m-d H:i:s'), 'created_by' => 1),
                    array('name' => 'RETURNED', 'created_at' => date('Y-m-d H:i:s'), 'created_by' => 1),
                    array('name' => 'RECEIVED', 'created_at' => date('Y-m-d H:i:s'), 'created_by' => 1),
                ));
        }
    }

