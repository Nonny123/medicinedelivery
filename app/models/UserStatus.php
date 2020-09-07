<?php

    /**
     * Class UserStatus
     * Model Table Referencing user_status
     */
    define('CACHE_PARAM_USER_STATUS', 'user_status');

    class UserStatus extends Eloquent
    {
        protected $table = 'user_status';
        public $timestamps = false;

        /**
         * Get USer Status
         */
        public static function status($key = '')
        {
            $user_statuses = Cache::get(CACHE_PARAM_USER_STATUS, null);
            if (is_null($user_statuses)) {
                $user_status = self::all();
                $user_statuses = [];
                foreach ($user_status as $status) {
                    $user_statuses[strtoupper($status->name)] = $status->id;
                }
                Cache::put(CACHE_PARAM_USER_STATUS, $user_statuses, 43200);
            }

            return empty($key) ? $user_statuses : $user_statuses[$key];
        }

        /**
         * Active User Status
         */
        public static function ACTIVE()
        {
            return self::status('ACTIVE');
        }

        /**
         * Inactive User Status
         */
        public static function INACTIVE()
        {
            return self::status('INACTIVE');
        }

        /**
         * Pending User Status
         */
        public static function PENDING()
        {
            return self::status('PENDING');
        }


    }
