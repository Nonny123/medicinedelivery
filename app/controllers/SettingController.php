<?php
    define('SYSTEM_SETTINGS_IMAGE', base_path() . '/assets/images/setting/');
    define('SYSTEM_IMAGE_URL', URL::to('/') . '/assets/images/setting/');

    class SettingController extends BaseController
    {

        /**
         * Add Basic Settings
         */
        public function postBasic()
        {
            try {
                if (!$this->isCsrfAccepted())
                    throw new Exception('Invalid request parameters', 401);
                $app_name = Input::get('name', '');
                $email = Input::get('email', '');
                $location = Input::get('location', '');
                $website = Input::get('website', '');
                $phone = Input::get('phone', '');
                $timezone = Input::get('timezone', 'UTC');
                $currency = Input::get('currency', '');
                $curreny_position = Input::get('curreny_position', 'BEFORE');
                $discount = Input::get('discount', '0');
                $image = "";
                if (Input::hasFile('file')) {
                    $file = Input::file('file', '');
                    $extension = strtolower($file->getClientOriginalExtension());
                    if (in_array($extension, ['png', 'jpg'])) {
                        $image = 'logo.' . $extension;
                        $file->move(SYSTEM_SETTINGS_IMAGE, $image);
                    } else {
                        throw new Exception('Invalid File Uploaded ! Please upload either png or jpg file', 400);
                    }
                }
                $conditions[] = ['column' => ['group' => 'site', 'key' => 'mail'], 'value' => $email];
                $conditions[] = ['column' => ['group' => 'site', 'key' => 'address'], 'value' => $location];
                $conditions[] = ['column' => ['group' => 'site', 'key' => 'app_name'], 'value' => $app_name];
                $conditions[] = ['column' => ['group' => 'site', 'key' => 'website'], 'value' => $website];
                $conditions[] = ['column' => ['group' => 'site', 'key' => 'phone'], 'value' => $phone];
                $conditions[] = ['column' => ['group' => 'site', 'key' => 'timezone'], 'value' => $timezone];
                $conditions[] = ['column' => ['group' => 'site', 'key' => 'currency'], 'value' => $currency];
                $conditions[] = ['column' => ['group' => 'site', 'key' => 'curr_position'], 'value' => $curreny_position];
                $conditions[] = ['column' => ['group' => 'site', 'key' => 'discount'], 'value' => $discount];
                if (!empty($image)) {
                    $conditions[] = ['column' => ['group' => 'site', 'key' => 'logo'], 'value' => $image];
                }
                foreach ($conditions as $condition) {
                    $this->updateSetting($condition);
                }
                Cache::forget(CACHE_PARAM_SETTINGS);
                $email = Setting::param('mail', 'username');
                $mail_password = Setting::param('mail', 'password');
                $mail_address = Setting::param('mail', 'address');
                $mail_name = Setting::param('mail', 'name');
                $port = Setting::param('mail', 'port');
                $host = Setting::param('mail', 'host');
                $driver = Setting::param('mail', 'driver');

                return Response::json(['status' => 'SUCCESS', 'code' => 200, 'data' => ['email' => $email, 'mail_password' => $mail_password, 'mail_address' => $mail_address, 'mail_name' => $mail_name, 'port' => $port, 'host' => $host, 'driver' => $driver,]]);
            } catch (Exception $e) {
                return Response::json(['status' => 'FAILURE', 'code' => $e->getCode(), 'msg' => $e->getMessage()]);
            }

        }

        /**
         * Add Basic Settings
         */
        public function postMail()
        {
            try {
                if (!$this->isCsrfAccepted())
                    throw new Exception('Invalid request parameters', 401);
                $email = Input::get('mail_id', '');
                $mail_password = Input::get('mail_password', '');
                $mail_address = Input::get('from_address', '');
                $mail_name = Input::get('from_name', '');
                $port = Input::get('port', '');
                $host = Input::get('host', '');
                $driver = Input::get('driver', '');
                if (!empty($email))
                    $conditions[] = ['column' => ['group' => 'mail', 'key' => 'username'], 'value' => $email];
                if (!empty($mail_password))
                    $conditions[] = ['column' => ['group' => 'mail', 'key' => 'password'], 'value' => $mail_password];
                if (!empty($mail_address))
                    $conditions[] = ['column' => ['group' => 'mail', 'key' => 'address'], 'value' => $mail_address];
                if (!empty($mail_name))
                    $conditions[] = ['column' => ['group' => 'mail', 'key' => 'name'], 'value' => $mail_name];
                if (!empty($port))
                    $conditions[] = ['column' => ['group' => 'mail', 'key' => 'port'], 'value' => $port];
                if (!empty($host))
                    $conditions[] = ['column' => ['group' => 'mail', 'key' => 'host'], 'value' => $host];
                if (!empty($driver))
                    $conditions[] = ['column' => ['group' => 'mail', 'key' => 'driver'], 'value' => $driver];
                if (!empty($conditions)) {
                    foreach ($conditions as $condition) {
                        $this->updateSetting($condition);
                    }
                }
                Cache::forget(CACHE_PARAM_SETTINGS);

                return Response::json(['status' => 'SUCCESS', 'code' => 200, 'data' => "Your Preferences are updated"]);
            } catch (Exception $e) {
                return Response::json(['status' => 'FAILURE', 'code' => $e->getCode(), 'msg' => $e->getMessage()]);
            }

        }

        /**
         * Update payment related details
         * @return mixed
         */
        public function postPayment()
        {
            try {
                if (!$this->isCsrfAccepted())
                    throw new Exception('Invalid request parameters', 401);
                $pay_mode = Input::get('payment', '');
                $transaction_mode = Input::get('transaction', 'TEST');
                $params = Input::get("params", []);
                if (!empty($pay_mode)) {
                    $conditions = [['column' => ['group' => 'payment', 'key' => 'mode'], 'value' => $pay_mode], ['column' => ['group' => 'payment', 'key' => 'type'], 'value' => $transaction_mode]];
                }
                if (!empty($conditions)) {
                    foreach ($conditions as $condition) {
                        $this->updateSetting($condition);
                    }
                }
                Cache::forget(CACHE_PARAM_SETTINGS);
                // Update Param Settings
                foreach ($params as $key => $param) {
                    $payment_setting = PaymentGatewaySetting::where('gateway_id', '=', $pay_mode)->where('key', '=', $key)->first();
                    $payment_setting->value = $param;
                    $payment_setting->save();
                }

                return Response::json(['status' => 'SUCCESS', 'code' => 200, 'data' => "Your Preferences are updated"]);
            } catch (Exception $e) {
                return Response::json(['status' => 'FAILURE', 'code' => $e->getCode(), 'msg' => $e->getMessage()]);
            }
        }

        /**
         * Add User as admin
         * @return mixed
         */
        public function postUser()
        {
            try {
                if (!$this->isCsrfAccepted())
                    throw new Exception('Invalid request parameters', 401);
                $name = Input::get('name', '');
                $email = Input::get('email', '');
                $password = Input::get('password', '');
                $admin = Admin::where('email', '=', $email)->first();
                $user = null;
                if (is_null($admin)) {
                    $admin = new Admin;
                    $admin->name = $name;
                    $admin->email = $email;
                    $admin->admin_type = AdminType::SUPER_ADMIN();
                    $admin->created_by = 1;
                    $admin->created_at = date('Y-m-d H:i:s');
                } else {
                    $user = $admin->user_details()->first();
                }
                $status = $admin->save();
                if ($status && is_null($user)) {
                    $user = new User();
                    $user->email = $name;
                    $user->password = Hash::make($password);
                    $user->user_type_id = UserType::ADMIN();
                    $user->user_status = UserStatus::ACTIVE();
                    $user->user_id = $admin->id;
                    $user->created_by = 1;
                    $user->created_at = date('Y-m-d H:i:s');
                } else {
                    $user->password = Hash::make($password);
                }
                $user->save();

                return Response::json(['status' => 'SUCCESS', 'code' => 200, 'data' => "User has been created"]);

            } catch (Exception $e) {
                return Response::json(['status' => 'FAILURE', 'code' => $e->getCode(), 'msg' => $e->getMessage()]);

            }
        }

        /**
         * Update Settings Table
         * @param $parameters
         */
        protected function updateSetting($parameters)
        {
            $setting = Setting::where('is_active', '=', 1);
            foreach ($parameters['column'] as $column => $value) {
                $setting->where($column, '=', $value);
            }
            $setting_first = $setting->first();
            $setting_first->value = $parameters['value'];
            $setting_first->save();

        }
    }
