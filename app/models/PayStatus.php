<?php

    /**
     * Class PaymentStatus
     * Model Table Referencing payment_status
     */
    define('CACHE_PARAM_PAYMENT_STATUS', 'payment_status');

    class PayStatus extends Eloquent
    {
        protected $table = 'payment_status';
        public $timestamps = false;

        /**
         * Get USer Status
         */
        public static function status($key = '')
        {
            $payment_statuses = Cache::get(CACHE_PARAM_PAYMENT_STATUS, null);
            if (is_null($payment_statuses)) {
                $payment_status = self::all();
                $payment_statuses = [];
                foreach ($payment_status as $status) {
                    $payment_statuses[strtoupper($status->name)] = $status->id;
                }
                Cache::put(CACHE_PARAM_PAYMENT_STATUS, $payment_statuses, 43200);
            }

            return empty($key) ? $payment_statuses : $payment_statuses[$key];
        }

        /**
         * Active User Status
         */
        public static function PENDING()
        {
            return self::status('PENDING');
        }

        /**
         * Inactive User Status
         */
        public static function SUCCESS()
        {
            return self::status('SUCCESS');
        }

        /**
         * Pending User Status
         */
        public static function FAILURE()
        {
            return self::status('FAILURE');
        }


    }
