<?php

    class SettingSeeder extends Seeder
    {

        public function run()
        {
            $array_values = array(
                array('group' => 'site', 'key' => 'app_name', 'value' => '', 'type' => 'TEXT'),
                array('group' => 'site', 'key' => 'logo', 'value' => '', 'type' => 'IMAGE'),
                array('group' => 'site', 'key' => 'mail', 'value' => '', 'type' => 'TEXT'),
                array('group' => 'site', 'key' => 'website', 'value' => '', 'type' => 'TEXT'),
                array('group' => 'site', 'key' => 'address', 'value' => '', 'type' => 'TEXT'),
                array('group' => 'site', 'key' => 'timezone', 'value' => '', 'type' => 'TEXT'),
                array('group' => 'site', 'key' => 'phone', 'value' => '', 'type' => 'TEXT'),
                array('group' => 'site', 'key' => 'discount', 'value' => '', 'type' => 'FLOAT'),
                array('group' => 'site', 'key' => 'currency', 'value' => '', 'type' => 'TEXT'),
                array('group' => 'site', 'key' => 'curr_position', 'value' => 'BEFORE', 'type' => 'TEXT'),
                array('group' => 'mail', 'key' => 'username', 'value' => '', 'type' => 'TEXT'),
                array('group' => 'mail', 'key' => 'password', 'value' => '', 'type' => 'TEXT'),
                array('group' => 'mail', 'key' => 'address', 'value' => '', 'type' => 'TEXT'),
                array('group' => 'mail', 'key' => 'name', 'value' => '', 'type' => 'TEXT'),
                array('group' => 'mail', 'key' => 'port', 'value' => '587', 'type' => 'TEXT'),
                array('group' => 'mail', 'key' => 'host', 'value' => 'smtp.gmail.com', 'type' => 'TEXT'),
                array('group' => 'mail', 'key' => 'driver', 'value' => 'smtp', 'type' => 'TEXT'),
                array('group' => 'payment', 'key' => 'mode', 'value' => '', 'type' => 'TEXT'),
                array('group' => 'payment', 'key' => 'type', 'value' => 'TEST', 'type' => 'TEXT')
            );
            // Find and Update
            foreach ($array_values as $value) {
                $count = DB::table('settings')->where('group', '=', $value['group'])->where('key', '=', $value['key'])->count();
                if ($count == 0) {
                    DB::table('settings')->insert(array(array('group' => $value['group'], 'key' => $value['key'], 'value' => $value['value'], 'type' => $value['type'])));
                }
            }
//            DB::table('settings')->insert(
//                array(
//                    array('group' => 'site', 'key' => 'app_name', 'value' => '', 'type' => 'TEXT'),
//                    array('group' => 'site', 'key' => 'logo', 'value' => '', 'type' => 'IMAGE'),
//                    array('group' => 'site', 'key' => 'mail', 'value' => '', 'type' => 'TEXT'),
//                    array('group' => 'site', 'key' => 'website', 'value' => '', 'type' => 'TEXT'),
//                    array('group' => 'site', 'key' => 'address', 'value' => '', 'type' => 'TEXT'),
//                    array('group' => 'site', 'key' => 'timezone', 'value' => '', 'type' => 'TEXT'),
//                    array('group' => 'site', 'key' => 'phone', 'value' => '', 'type' => 'TEXT'),
//                    array('group' => 'site', 'key' => 'discount', 'value' => '', 'type' => 'FLOAT'),
//                    array('group' => 'site', 'key' => 'currency', 'value' => '', 'type' => 'TEXT'),
//                    array('group' => 'site', 'key' => 'curr_position', 'value' => 'BEFORE', 'type' => 'TEXT'),
//                    array('group' => 'mail', 'key' => 'username', 'value' => '', 'type' => 'TEXT'),
//                    array('group' => 'mail', 'key' => 'password', 'value' => '', 'type' => 'TEXT'),
//                    array('group' => 'mail', 'key' => 'address', 'value' => '', 'type' => 'TEXT'),
//                    array('group' => 'mail', 'key' => 'name', 'value' => '', 'type' => 'TEXT'),
//                    array('group' => 'mail', 'key' => 'port', 'value' => '587', 'type' => 'TEXT'),
//                    array('group' => 'mail', 'key' => 'host', 'value' => 'smtp.gmail.com', 'type' => 'TEXT'),
//                    array('group' => 'mail', 'key' => 'driver', 'value' => 'smtp', 'type' => 'TEXT'),
//                    array('group' => 'payment', 'key' => 'mode', 'value' => '', 'type' => 'TEXT'),
//                    array('group' => 'payment', 'key' => 'business_email', 'value' => '', 'type' => 'TEXT'),
//                    array('group' => 'payment', 'key' => 'merchant_key', 'value' => '', 'type' => 'TEXT'),
//                    array('group' => 'payment', 'key' => 'php ', 'value' => '', 'type' => 'TEXT'),
//                ));
        }
    }

