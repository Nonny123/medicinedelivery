<?php

    class Invoice extends Eloquent
    {
        protected $table = 'invoice';
        public $timestamps = false;

        /**
         * Prescriptions
         */
        public function prescription()
        {
            return $this->hasOne('Prescription', 'id', 'pres_id')->first();
        }

        /**
         * Verified Prescriptions
         */
        public function verifiedPrescription()
        {
            return $this->hasOne('Prescription', 'id', 'pres_id')->where('status', '=', PrescriptionStatus::VERIFIED())->first();

        }

        /**
         * Unverified Prescription
         * @return mixed
         */
        public function unverifiedPrescription()
        {
            return $this->hasOne('Prescription', 'id', 'pres_id')->where('status', '=', PrescriptionStatus::UNVERIFIED())->first();
        }

        /**
         * Get Cart List
         */
        public function cartList()
        {
            return $this->hasMany('ItemList', 'invoice_id', 'id')->where('is_removed','=',0)->get();
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
