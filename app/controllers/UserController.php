<?php

    class UserController extends BaseController
    {

        /**
         * API to obtain available User Type Other Than Admin
         */
        public function anyObtainUserType()
        {
            // Model To Obtain User Type
            $user_type = UserType::where('user_type', '!=', 'admin')->get();
            foreach ($user_type as $type) {
                $type_array[$type->id] = $type->user_type;
            }
            $response_array = array(array('result' => array('status' => 'success', 'msg' => $user_type)));

            return Response::json($response_array);
        }

        /**
         *
         * @param int $is_Web
         * @return mixed
         */
        public function anyCreateUser($is_Web = 0)
        {
            if (!$this->isCsrfAccepted()) {
                return Response::make(['status' => 'FAILURE', 'msg' => 'Invalid Request made'], 401);

            }
            $email = Input::get('email', '');
            $phone = Input::get('phone', '');
            $address = Input::geT('address','');
            $password = Input::get('password', '');
            $confirm_password = Input::get('confirm_password', '');
            $user_type = Input::get('user_type', '');
            if (User::where('email', '=', $email)->count() == 0) {
                //check if password == confirm password(not needed for mobile), then proceed the following
                $digits = 4;
                $randomValue = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
                switch (intval($user_type)) {
                    case (UserType::MEDICAL_PROFESSIONAL())://med
                        if ($is_Web) {
                            $name = Input::get('user_name', '');
                            $medProf = new MedicalProfessional;
                            $medProf->prof_mail = $email;
                            $medProf->prof_phone = $phone;
                            $medProf->prof_address = $address;
                            $medProf->prof_first_name = $name;
                            $medProf->prof_created_on = date('Y-m-d H:i:s');
                            $medProf->prof_updated_on = date('Y-m-d H:i:s');
                            $medProf->save();
                            $userId = $medProf->id;
                        } else {
                            $medProf = new MedicalProfessional;
                            $medProf->prof_mail = $email;
                            $medProf->prof_phone = $phone;
                            $medProf->prof_address = $address;
                            $medProf->prof_created_on = date('Y-m-d H:i:s');
                            $medProf->prof_updated_on = date('Y-m-d H:i:s');
                            $medProf->save();
                            $userId = $medProf->id;
                        }
                        break;
                    case (UserType::CUSTOMER())://cust
                        if ($is_Web) {
                            $name = Input::get('user_name', '');
                            $customer = new Customer;
                            $customer->mail = $email;
                            $customer->phone = $phone;
                            $customer->address = $address;
                            $customer->first_name = $name;
                            $customer->created_at = date('Y-m-d H:i:s');
                            $customer->save();
                            $userId = $customer->id;
                        } else {
                            $customer = new Customer;
                            $customer->mail = $email;
                            $customer->phone = $phone;
                            $customer->address = $address;
                            $customer->created_at = date('Y-m-d H:i:s');
                            $customer->save();
                            $userId = $customer->id;
                        }
                        break;
                }//switch
                $user = new User;
                $user->email = $email;
                $user->password = Hash::make($password);
                $user->phone = $phone;
                $user->user_type_id = $user_type;
                $user->user_id = $userId;
                $user->security_code = $randomValue;
                $user->save();
                $postData = array(
                    array(
                        'result' => array(
                            'status' => 'success'
                        )
                    )
                );
                $path = base_path() . '/public/images/prescription/' . $email;
                File::makeDirectory($path, $mode = 0777, true, true);
                try {
                    if ($is_Web == 0) {
                        Mail::send('contact.display', array('code' => $randomValue), function ($message) use ($email) {
                            $message->to($email)->subject('Activate Account');
                        });
                    } else {
                        Mail::send('emails.register', array('name' => $name, 'user_name' => $email, 'pwd' => $password, 'code' => $randomValue), function ($message) use ($email) {
                            $message->to($email)->subject('Activate Account');
                        });
                    }

                } catch (Exception $e) {
                    return Response::make(['status' => 'FAILURE', 'msg' => 'Some techinical issues has occured'], 500);
                }

            }//if
            else {
                $postData = array(
                    array(
                        'result' => array(
                            'status' => 'existing'
                        )
                    )
                );
            }//else
            return Response::json($postData);


        }

        /**
         * Update User Details
         * @param int $isWeb
         * @return mixed
         */
        public function postUpdateDetailsUser($isWeb = 0)
        {
            if (!$this->isCsrfAccepted()) {
                $result = array(array('result' => array('status' => 'failed')));

                return Response::json($result);
            }
            if ($isWeb) {
                $email = Auth::user()->email;
                $user_type = Auth::user()->user_type_id;
                $first_name = Input::get('first_name', '');
                $last_name = Input::get('last_name');
            } else {
                $email = Input::get('email', '');
                $user_type = intval(Input::get('user_type', '3'));
                $first_name = Input::get('first_name', '');
                $last_name = Input::get('last_name', '');

            }
            $address = Input::get('address', '');
            $pincode = Input::get('pincode', '');
            $phone = Input::get('phone', '');
            switch ($user_type) {
                case 2:
                    $medicalProfDetails = array('prof_first_name' => $first_name,
                        'prof_last_name' => $last_name,
                        'prof_address' => $address,
                        'prof_phone' => $phone,
                        'prof_pincode' => $pincode
                    );
                    $affectedRows = MedicalProfessional::where('prof_mail', '=', $email)->update($medicalProfDetails);
                    break;
                case 3:
                    $customerDetails = array('first_name' => $first_name,
                        'last_name' => $last_name,
                        'address' => $address,
                        'phone' => $phone,
                        'pincode' => $pincode
                    );
                    $affectedRows = Customer::where('mail', '=', $email)->update($customerDetails);
                    break;
            }
            if (count($affectedRows) == 1) {
                $result = array(array('result' => array('status' => 'success')));
            } else {
                $result = array(array('result' => array('status' => 'failed')));
            }

            return Response::json($result);
        }

        /**
         * User Login
         * @param int $isWeb
         * @return mixed
         */
        public function anyUserLogin($isWeb = 0)
        {
            if (!$this->isCsrfAccepted())
                $result = array(array('result' => array('status' => 'failure')));
            else {
                $email = Input::get('email', '');
                $password = Input::get('password', '');
                if ($isWeb) {
                    //$status='active';
                    $status = DB::table('users')->select('user_status as status')->where('email', '=', $email)->first();
                    if (!empty($status)) {
                        if ($status->status == UserStatus::PENDING()) {
                            $result = array(array('result' => array('status' => $status)));
                            Session::put('user_password', $password);
                        } elseif ($status->status == UserStatus::ACTIVE()) {
                            if (Auth::attempt(array('email' => $email, 'password' => $password))) {
                                Session::put('user_id', $email);
                                if (Session::get('medicine') != "") {
                                    $result = array(array('result' => array('status' => 'success', 'page' => 'yes')));
                                } else {
                                    $result = array(array('result' => array('status' => 'success', 'page' => 'no')));
                                }
                            } else {
                                $result = array(array('result' => array('status' => 'failure')));
                            }
                        }
                    } else {
                        $result = array(array('result' => array('status' => 'failure')));
                    }

                } else {
                    if (Auth::attempt(array('email' => $email, 'password' => $password))) {
                        $status = User::where('email', '=', $email)->first()->status;
                        $result = array(array('result' => array('status' => $status)));
                        Session::put('user_id', $email);
                    } else {
                        $result = array(array('result' => array('status' => 'failure')));
                    }
                }
            }

            return Response::json($result);


        }

        /**
         * Active user account
         * @return mixed
         */
        public function anyActivateAccount()
        {
            $email = Input::get('email', '');
            $user = User::where('email', '=', $email)->first();
            $sec_code = Input::get('security_code', '');
            $securityCode = $user->security_code;
            if (str_is($securityCode, $sec_code)) {
                $updatedValues = array('status' => 'active');
                User::where('email', '=', $email)->update($updatedValues);
                $pass = Session::get('user_password');
                Auth::attempt(array('email' => $email, 'password' => $pass));
                Session::put('user_id', $email);
                $result = array(array('result' => array('status' => 'success')));

            } else {
                $result = array(array('result' => array('status' => 'failure')));
            }

            return Response::json($result);
        }

        /**
         * function to activate the user registration from web
         * @param $code
         * @return mixed
         */
        public function anyWebActivateAccount($code)
        {
            $user = User::where('security_code', '=', $code)->first();
            if (count($user)) {
                $updatedValues = array('user_status' => UserStatus::ACTIVE());
                User::where('security_code', '=', $code)->update($updatedValues);

                return Redirect::to('/?msg=success');
            } else {
                return Redirect::to('/?msg=failed');
            }
        }

        /**
         * Get User Details
         * @return mixed
         */
        public function anyUserDetails()
        {
            $email = Input::get('email', '');
            $user = User::where('email', '=', $email)->first();
            if ($user != null) {
                if ($user->user_type_id == 3) {
                    $customer = Customer::where('mail', '=', $email)->first();
                    $Details = array('first_name' => $customer->first_name,
                        'last_name' => $customer->last_name,
                        'address' => $customer->address,
                        'phone' => $customer->phone,
                        'type_user' => "3",
                        'pincode' => $customer->pincode
                    );
                } else if ($user->user_type_id == 2) {
                    $professional = MedicalProfessional::where('prof_mail', '=', $email)->first();
                    $Details = array('first_name' => $professional->prof_first_name,
                        'last_name' => $professional->prof_last_name,
                        'address' => $professional->prof_address,
                        'phone' => $professional->prof_phone,
                        'type_user' => "2",
                        'pincode' => $professional->prof_pincode
                    );
                }
                $result = array(array('result' => array('status' => 'success', 'msg' => $Details)));
            } else {
                $result = array(array('result' => array('status' => 'failure')));
            }

            //$result = array(array('result'=>$Details));
            return Response::json($result);
        }

        /**
         * Reset Password
         * @return mixed
         */
        public function anyResetPassword()
        {
            $email = Input::get('email', '');
            if (Input::has('email') && Input::has('security_code') && Input::has('new_password')) {
                $security_code = Input::get('security_code');
                $password = Input::get('new_password');
                $confirm_password = Input::get('confirm_password');
                $user = User::where('email', '=', $email)->where('security_code', '=', $security_code)->first();
                if (!is_null($user)) {
                    $user->password = Hash::make($password);
                    $user->save();
                    $result = array(array('result' => array('status' => 'success')));
                } else {
                    return Response::make(['msg' => 'No User Found'], 401);
                }
            } else {
                if (User::where('email', '=', $email)->count() == 1) {
                    $digits = 4;
                    $randomValue = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
                    $updatedValues = array('security_code' => $randomValue);
                    $user = User::where('email', '=', $email)->update($updatedValues);
                    Mail::send('emails.reset_password', array('code' => $randomValue), function ($message) use ($email) {
                        $message->to($email)->subject('Activate Account');
                    });
                    $result = array(array('result' => array('status' => 'reset_success')));
                } else {
                    return Response::make(['msg' => 'No User Found'], 404);
                }

            }

            return Response::json($result);
        }

        /**
         * Check out username
         */
        public function getCheckUserName()
        {
            $current_mail = Input::get('u_name');
            $regex = "^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$^";
            if (preg_match($regex, $current_mail)) {
                $name = DB::table('users')->where('email', $current_mail)->pluck('email');
                if (count($name) > 0) {
                    echo 0; //email exist
                } else {
                    echo 1; //new email
                }
            } else {
                echo 2;
            }

        }

        /**
         * Account Page
         * @return mixed
         */
        public function getAccountPage()
        {
            $user_type = Auth::user()->user_type_id;
            switch ($user_type) {
                case (UserType::MEDICAL_PROFESSIONAL()):  //for medical professionals
                    return View::make('users.account_page', array('user_data' => Auth::user()->professional));
                    break;
                case (UserType::CUSTOMER()):  //for customers
                    return View::make('users.account_page', array('user_data' => Auth::user()->customer));
                    break;
            }
        }

        /**
         * Change Password
         * @return int
         */
        public function anyChangePassword()
        {
            $old_password = Input::get('old_password');
            $new_password = Input::get('new_password');
            $re_password = Input::get('re_password');
            $pass = Hash::make($new_password);
            $current_password = Auth::user()->password;
            $name = Auth::user()->customer->first_name;
            if (Hash::check($old_password, $current_password)) {
                if ($new_password == $re_password) {
                    Auth::user()->password = $pass;
                    $updt = Auth::user()->save();
                    if ($updt) {
                        Mail::send('emails.change_password', array('name' => $name), function ($message) {
                            $message->to(Auth::user()->email)->subject('Your ' . Setting::param('site', 'app_name')['value'] . ' password has been changed');
                        });

                        return 1;  ///password updated
                    } else {
                        return 3;  ///password could't updated
                    }
                } else {
                    return 2; ///password missmatch
                }

            } else {
                return 0;  ///old password error
            }

        }

        /**
         * Store profile pic
         */
        public function anyStoreProfilePic()
        {
            if (!$this->isCsrfAccepted())
                return 0;
            $email = Auth::user()->email;
            $path = base_path() . '/public/images/prescription/' . $email . '/';
            $fname = Input::file('file')->getClientOriginalName();
            $ext = Input::file('file')->getClientOriginalExtension();
            $path_from = Input::file('file')->getRealPath();
            $newName = "profile_pic";
            $realpath = $path . "/" . $fname;
            // open an image file
            $img = Image::make($path_from);
            // now you are able to resize the instance
            $img->resize(200, 200);
            // finally we save the image as a new file
            $img->save($path . '/' . $newName);

            return Redirect::back();

        }

        /**
         * Contact Email
         * @return int
         */
        public function anyContactUs()
        {
            if (!$this->isCsrfAccepted())
                return 0;
            $client_name = Input::get('name');
            $client_mail = Input::get('email');
            $client_msg = Input::get('msg');
            $mail_id = Setting::param('site', 'mail')['value'];
            Mail::send('emails.customer_query', array('client_name' => $client_name, 'client_mail' => $client_mail, 'client_msg' => $client_msg), function ($message) use ($mail_id) {
                $message->to($mail_id)->subject('Customer Query');
            });
            if (count(Mail::failures()) > 0) {
                $errors = 0; //Failed to send email, please try again
                return $errors;
            } else {
                return 1;
            }

        }

        /**
         * Check the login status
         * @return mixed
         */
        public function getCheckSession()
        {
            if (Auth::check()) {
                $login = 1;
            } else {
                $login = 0;
            }

            return Response::json($login);
        }

        /**
         * API for mobile devices to save or login if they are using facebook to login
         * Parameters : email,first name, lastname and facebook id
         */
        public function postFacebookLogin()
        {
            try {
                $data = Input::all();
                // Check Form Variable Is Empty
                if (empty($data) || $this->isFormVariableEmpty($data, []))
                    return Response::json(['status' => 0, 'msg' => 'Some Fields Are Empty']);
                $email = $data['email'];
                $fb = $data['facebook_id'];
                $first_name = $data['first_name'];
                $last_name = $data['last_name'];
                // Get Mechanic Count
                try {
                    $count = User::where('email', '=', $email)->select('id', 'user_type_id', 'user_id')->first();
                    if (count($count) > 0) {
                        if ($count->user_type_id == 3) {
                            $count = Customer::where('mail', '=', $email)->where('facebook_id', '=', $fb)->count();
                            if ($count > 0) {
                                $id = $count->id;
                                Auth::loginUsingId($id);

                                //$this->clearSession();
                                return Response::json(['status' => 1, 'msg' => 'Success']);
                            } else {
                                $status = Customer::where('id', '=', $count->user_id)->update(array('facebook_id' => $fb, 'updated_on' => date('Y-m-d H:i:s')));
                                if ($status) {
                                    $id = $count->id;
                                    Auth::loginUsingId($id);

                                    //$this->clearSession();
                                    return Response::json(['status' => 1, 'msg' => 'Success']);
                                } else {
                                    return Response::json(['status' => 0, 'msg' => 'Facebook id updation failed']);
                                }
                            }
                        } else if ($count->user_type_id == 2) {
                            return Response::json(['status' => 0, 'msg' => 'Email Already Exists']);
                        }
                    } else {
                        // Insert Details
                        $obj = new Customer();
                        $obj->first_name = $first_name;
                        $obj->last_name = $last_name;
                        $obj->mail = $email;
                        $obj->facebook_id = $fb;
                        $obj->created_on = date('Y-m-d H:i:s');
                        $obj->updated_on = date('Y-m-d H:i:s');
                        $obj->save();
                        // Get User Id
                        $user_id = $obj->id;
                        //Create a security code
                        $digits = 4;
                        $randomValue = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
                        $obj1 = new User();
                        $obj1->email = $email;
                        $obj1->user_type_id = 3;
                        $obj1->security_code = $randomValue;
                        $obj1->user_id = $user_id;
                        $obj1->created_on = date('Y-m-d H:i:s');
                        $obj1->updated_on = date('Y-m-d H:i:s');
                        $status = $obj1->save();
                        if ($status) {
                            Auth::loginUsingId($obj1->$obj1);

                            return Response::json(['status' => 1, 'msg' => 'Success']);
                        } else {
                            return Response::json(['status' => 0, 'msg' => 'User Registration Failed']);
                        }
                    }
                } catch (Exception $e) {
                    throw new Exception('INTERNAL SERVER ERROR:' . $e->getMessage(), 500);
                }

            } catch (Exception $e) {
                throw new Exception('INTERNAL SERVER ERROR:' . $e->getMessage(), 500);
            }
        }

    }
