<?php

    class UserTypeTableSeeder extends Seeder
    {

        public function run()
        {
            DB::table('user_type')->truncate();
            DB::table('user_type')->insert(
                array(
                    array('user_type' => 'ADMIN'),
                    array('user_type' => 'MEDICAL_PROFESSIONAL'),
                    array('user_type' => 'CUSTOMER')
                ));
        }

    }
