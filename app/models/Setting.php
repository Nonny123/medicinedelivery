<?php

    define('CACHE_PARAM_SETTINGS', 'settings');

    class Setting extends Eloquent
    {
        protected $table = 'settings';
        public $timestamps = false;

        /**
         * Return a setting value
         * @param $group
         * @param $key
         * @return mixed
         */
        static public function param($group, $key)
        {
            $cache_key = implode('|', [$group, $key]);
            $settings = self::settings();

            return $settings[$cache_key];
        }

        /**
         * Load all Settings
         * @return array
         */
        static public function settings()
        {
            $settings = Cache::get(CACHE_PARAM_SETTINGS, null);
            if (is_null($settings)) {
                $settings = [];
                $parameters = self::all();
                foreach ($parameters as $param) {
                    $key = implode('|', [$param->group, $param->key]);
                    $settings[$key] = ['value' => $param->value, 'type' => $param->type];
                }
                Cache::put(CACHE_PARAM_SETTINGS, $settings, 1440);
            }

            return $settings;
        }

        /**
         * Create Currency Format
         */
        public static function currencyFormat($amount){
            $currency_position = self::param('site', 'curr_position')['value'];
            $currency = self::param('site', 'currency')['value'];
            switch ($currency_position) {
                case CURRENCY_BEFORE:
                    return implode(' ', [$currency, number_format($amount, 2)]);
                    break;
                case CURRENCY_AFTER:
                    return implode(' ', [number_format($amount, 2), $currency]);
                    break;
            }
        }
    }
