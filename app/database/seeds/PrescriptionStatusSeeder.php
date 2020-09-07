<?php

    class PrescriptionStatusSeeder extends Seeder
    {

        public function run()
        {
            DB::table('prescription_status')->truncate();
            DB::table('prescription_status')->insert(
                array(
                    array('name' => 'UNVERIFIED', 'created_at' => date('Y-m-d H:i:s'), 'created_by' => 1),
                    array('name' => 'VERIFIED', 'created_at' => date('Y-m-d H:i:s'), 'created_by' => 1),
                    array('name' => 'REJECTED', 'created_at' => date('Y-m-d H:i:s'), 'created_by' => 1),
                ));
        }
    }

