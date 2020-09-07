<?php

    /**
     * Class UserStatus
     * Model Table Referencing prescription_status
     */
    define('CACHE_PARAM_PRESCRIPTION_STATUS', 'prescription_status');

    class PrescriptionStatus extends Eloquent
    {
        protected $table = 'prescription_status';
        public $timestamps = false;

        /**
         * Get USer Status
         */
        public static function status($key = '')
        {
            $prescription_statuses = Cache::get(CACHE_PARAM_PRESCRIPTION_STATUS, null);
            if (is_null($prescription_statuses)) {
                $prescription_status = self::all();
                $prescription_statuses = [];
                foreach ($prescription_status as $status) {
                    $prescription_statuses[strtoupper($status->name)] = $status->id;
                }
                Cache::put(CACHE_PARAM_PRESCRIPTION_STATUS, $prescription_statuses, 43200);
            }

            return empty($key) ? $prescription_statuses : $prescription_statuses[$key];
        }

        /**
         * Active User Status
         */
        public static function UNVERIFIED()
        {
            return self::status('UNVERIFIED');
        }

        /**
         * Inactive User Status
         */
        public static function VERIFIED()
        {
            return self::status('VERIFIED');
        }

        /**
         * Pending User Status
         */
        public static function REJECTED()
        {
            return self::status('REJECTED');
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
                case (self::UNVERIFIED()):
                    return "Unverified";
                    break;
                case (self::VERIFIED()):
                    return "Verified";
                    break;
                case (self::REJECTED()):
                    return "Rejected";
                    break;
            }
        }


    }
