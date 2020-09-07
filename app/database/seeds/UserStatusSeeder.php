<?php

    class UserStatusSeeder extends Seeder
    {

        public function run()
        {
            DB::table('user_status')->truncate();
            DB::table('user_status')->insert(
                array(
                    array('name' => 'PENDING', 'created_at' => date('Y-m-d H:i:s'), 'created_by' => 1),
                    array('name' => 'ACTIVE', 'created_at' => date('Y-m-d H:i:s'), 'created_by' => 1),
                    array('name' => 'INACTIVE', 'created_at' => date('Y-m-d H:i:s'), 'created_by' => 1),
                ));
        }
    }

