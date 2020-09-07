<?php

    /**
     * Class UserStatus
     * Model Table Referencing user_status
     */
    define('CACHE_PARAM_ADMIN_TYPE', 'admin_type');

    class AdminType extends Eloquent
    {
        protected $table = 'admin_type';
        public $timestamps = false;

        /**
         * Get USer Status
         */
        public static function types($key = '')
        {
            $admin_types = Cache::get(CACHE_PARAM_ADMIN_TYPE, null);
            if (is_null($admin_types)) {
                $types = self::all();
                $admin_types = [];
                foreach ($types as $type) {
                    $admin_types[strtoupper($type->name)] = $type->id;
                }
                Cache::put(CACHE_PARAM_ADMIN_TYPE, $admin_types, 43200);
            }

            return empty($key) ? $admin_types : $admin_types[$key];
        }

        /**
         * Super Admin Type
         */
        public static function SUPER_ADMIN()
        {
            return self::types('SUPER_ADMIN');
        }




    }