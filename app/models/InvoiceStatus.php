<?php

    /**
     * Class UserStatus
     * Model Table Referencing invoice_status
     */
    define('CACHE_PARAM_INVOICE_STATUS', 'invoice_status');

    class InvoiceStatus extends Eloquent
    {
        protected $table = 'invoice_status';
        public $timestamps = false;

        /**
         * Get USer Status
         */
        public static function status($key = '')
        {
            $invoice_statuses = Cache::get(CACHE_PARAM_INVOICE_STATUS, null);
            if (is_null($invoice_statuses)) {
                $invoice_status = self::all();
                $invoice_statuses = [];
                foreach ($invoice_status as $status) {
                    $invoice_statuses[strtoupper($status->name)] = $status->id;
                }
                Cache::put(CACHE_PARAM_INVOICE_STATUS, $invoice_statuses, 43200);
            }

            return empty($key) ? $invoice_statuses : $invoice_statuses[$key];
        }

        /**
         * PENDING
         */
        public static function PENDING()
        {
            return self::status('PENDING');
        }

        /**
         * PAID
         */
        public static function PAID()
        {
            return self::status('PAID');
        }

        /**
         * UNPAID
         */
        public static function UNPAID()
        {
            return self::status('UNPAID');
        }

        /**
         * CANCELLED
         */
        public static function CANCELLED()
        {
            return self::status('CANCELLED');
        }

        /**
         * Get  Status Name
         * @param $status_id
         * @return string
         */
        public static function statusName($status_id)
        {
            $i= 0;
            switch ($status_id) {
                case (self::PENDING()):
                    return "Pending";
                    break;
                case (self::PAID()):
                    return "Paid";
                    break;
                case (self::UNPAID()):
                    return "Unpaid";
                    break;
                case (self::CANCELLED()):
                    return "Cancelled";
                    break;
                default:
                    return "Invoice Not Created";
                    break;
            }
        }


    }
