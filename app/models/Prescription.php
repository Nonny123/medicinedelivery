<?php

    class Prescription extends Eloquent
    {
        protected $table = 'prescription';
        public $timestamps = false;

        /**
         * Get Invoice
         * @return mixed
         */
        public function getInvoice()
        {
            return $this->hasOne('Invoice', 'pres_id', 'id');
        }

        /**
         * Get User
         * @return mixed
         */
        public function getUser()
        {
            return $this->hasOne('User', 'id', 'user_id');
        }


    }
