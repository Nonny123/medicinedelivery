<?php

    class BaseController extends Controller
    {

        /**
         * Set Up Basic config
         */
        public function __construct()
        {
            Config::set('app.timezone', Setting::param('site', 'timezone')['value']);
        }

        /**
         * Setup the layout used by the controller.
         *
         * @return void
         */
        protected function setupLayout()
        {
            if (!is_null($this->layout)) {
                $this->layout = View::make($this->layout);
            }
        }

        /**
         * CSRF FILTER
         */
        public function isCsrfAccepted()
        {
            $session_token = Session::token() ;
            $input_token = Input::get('_token');
            if ($session_token != $input_token)
                return false;
            else
                return true;


        }


    }
