<?php

    /**
     * Class UserStatus
     * Model Table Referencing shipping_status
     */
    define('CACHE_PARAM_SHIPPING_STATUS', 'shipping_status');

    class ShippingStatus extends Eloquent
    {
        protected $table = 'shipping_status';
        public $timestamps = false;

        /**
         * Get USer Status
         */
        public static function status($key = '')
        {
            $shipping_statuses = Cache::get(CACHE_PARAM_SHIPPING_STATUS, null);
            if (is_null($shipping_statuses)) {
                $shipping_status = self::all();
                $shipping_statuses = [];
                foreach ($shipping_status as $status) {
                    $shipping_statuses[strtoupper($status->name)] = $status->id;
                }
                Cache::put(CACHE_PARAM_SHIPPING_STATUS, $shipping_statuses, 43200);
            }

            return empty($key) ? $shipping_statuses : $shipping_statuses[$key];
        }

        /**
         * Not Shipped
         */
        public static function NOTSHIPPED()
        {
            return self::status('NOT SHIPPED');
        }

        /**
         * shipped
         */
        public static function SHIPPED()
        {
            return self::status('SHIPPED');
        }

        /**
         * Returned
         */
        public static function RETURNED()
        {
            return self::status('RETURNED');
        }

        /**
         * Received
         */
        public static function RECEIVED()
        {
            return self::status('RECEIVED');
        }

        /**
         * Get  Status Name
         * @param $status_id
         * @return string
         */
        public static function statusName($status_id)
        {
            $i = 0;
            switch ($status_id) {
                case (self::RECEIVED()):
                    return "Received";
                    break;
                case (self::RETURNED()):
                    return "Returned";
                    break;
                case (self::SHIPPED()):
                    return "Shipped";
                    break;
                case (self::NOTSHIPPED()):
                    return "Not Shipped";
                    break;
                default:
                    return "Not Shipped";
                    break;
            }
        }


    }
