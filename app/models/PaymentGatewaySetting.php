<?php

    /**
     * Class PaymentGateway
     * Model Table Referencing payment_status
     */
    class PaymentGatewaySetting extends Eloquent
    {
        protected $table = 'pay_gateway_setting';
        public $timestamps = false;

    }
