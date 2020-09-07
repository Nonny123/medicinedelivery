<?php

    class AdminTypeSeeder extends Seeder
    {

        public function run()
        {
            DB::table('admin_type')->truncate();
            DB::table('admin_type')->insert(
                array(
                    array('name' => 'SUPER_ADMIN', 'created_at' => date('Y-m-d H:i:s'), 'created_by' => '1'),
                ));
        }
    }

