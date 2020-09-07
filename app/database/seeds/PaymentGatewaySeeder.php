<?php

    class PaymentGatewaySeeder extends Seeder
    {

        public function run()
        {
            DB::table('payment_gateways')->truncate();
            DB::table('payment_gateways')->insert(
                array(
                    array('id' => 1, 'name' => 'Paypal', 'image' => 'paypal.png', 'created_at' => date('Y-m-d H:i:s'), 'created_by' => 1),
                    array('id' => 2, 'name' => 'Pay U Money', 'image' => 'payumoney.png', 'created_at' => date('Y-m-d H:i:s'), 'created_by' => 1),
                ));
            // Paypal Currency
            $currencies = serialize(['AUD' => 'Australian Dollar',
                'BRL' => 'Brazilian Real',
                'CAD' => 'Canadian Dollar',
                'CZK' => 'Czech Koruna',
                'DKK' => 'Danish Krone',
                'EUR' => 'Euro',
                'HKD' => 'Hong Kong Dollar',
                'HUF' => 'Hungarian Forint',
                'ILS' => 'Israeli New Sheqel',
                'JPY' => 'Japanese Yen',
                'MYR' => 'Malaysian Ringgit',
                'MXN' => 'Mexican Peso',
                'NOK' => 'Norwegian Krone',
                'NZD' => 'New Zealand Dollar',
                'PHP' => 'Philippine Peso',
                'PLN' => 'Polish Zloty',
                'GBP' => 'Pound Sterling',
                'RUB' => 'Russian Ruble',
                'SGD' => 'Singapore Dollar',
                'SEK' => 'Swedish Krona',
                'CHF' => 'Swiss Franc',
                'TWD' => 'Taiwan New Dollar',
                'THB' => 'Thai Baht',
                'TRY' => 'Turkish Lira',
                'USD' => 'U.S. Dollar']);
            // Payment Gateway setting
            $array_values = [['gateway_id' => 2, 'key' => 'merchant_key', 'value' => '', 'type' => 'TEXT', 'description' => 'Merchant Key'],
                ['gateway_id' => 2, 'key' => 'merchant_hash', 'value' => '', 'type' => 'TEXT', 'description' => 'Merchant Hash'],
                ['gateway_id' => 2, 'key' => 'payumoney_live_url', 'value' => 'https://secure.payu.in', 'type' => 'TEXT', 'description' => 'Paypal sandbox url', 'is_hidden' => 1],
                ['gateway_id' => 2, 'key' => 'payumoney_sandbox_url', 'value' => 'https://test.payu.in', 'type' => 'TEXT', 'description' => 'Paypal sandbox url', 'is_hidden' => 1],
                ['gateway_id' => 1, 'key' => 'business_email', 'value' => '', 'type' => 'EMAIL', 'description' => 'Business Account Email ID'],
                ['gateway_id' => 1, 'key' => 'paypal_live_url', 'value' => 'https://www.paypal.com/cgi-bin/webscr?', 'type' => 'TEXT', 'description' => 'Live transaction Url ', 'is_hidden' => 1],
                ['gateway_id' => 1, 'key' => 'paypal_sandbox_url', 'value' => 'https://www.sandbox.paypal.com/cgi-bin/webscr?', 'type' => 'TEXT', 'description' => 'Paypal sandbox url', 'is_hidden' => 1],
                ['gateway_id' => 1, 'key' => 'paypal_currency', 'value' => 'USD', 'type' => 'SELECT', 'description' => 'Paypal Supported Currencies', 'dataset' => $currencies]];
            // Data Insertion
            foreach ($array_values as $values) {
                $count = DB::table('pay_gateway_setting')->where('gateway_id', '=', $values['gateway_id'])->where('key', '=', $values['key'])->count();
                if ($count == 0) {
                    DB::table('pay_gateway_setting')->insert([$values]);
                }
            }
        }
    }

