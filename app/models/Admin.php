<?php

    class Admin extends Eloquent
    {
        protected $table = 'admin';
        public $timestamps = false;

        /**
         * Return User Details;
         * @return mixed
         */
        public function user_details()
        {
            return $this->hasOne('User', 'user_id', 'id')->where('user_type_id', '=', UserType::ADMIN());
        }
    }
