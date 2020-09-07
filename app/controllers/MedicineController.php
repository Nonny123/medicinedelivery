<?php
    define('CACHE_PARAM_MEDICINE', 'medicines');
    define('CURRENCY_BEFORE', 'BEFORE');
    define('CURRENCY_AFTER', 'AFTER');
    date_default_timezone_set("Asia/Calcutta");

    class MedicineController extends BaseController
    {

        /**
         * Store Prescription
         * @param int $isWeb
         * @return mixed
         */
        public function anyStorePrescription($isWeb = 0)
        {
            if (!$this->isCsrfAccepted()) {
                Session::flash('flash_message', 'Invalid File Request ');
                Session::flash('flash_type', 'alert-danger');
            }
            if ($isWeb) {
                if (Auth::check()) {
                    $email = Session::get('user_id');
                    $user_type = Auth::user()->user_type_id;
                    $path = base_path() . '/public/images/prescription/' . $email . '/';
                    if (Input::hasFile('file')) {
                        $file_name = time();
                        $ext = Input::file('file')->getClientOriginalExtension();
                        // If Invalid Extension
                        if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
                            Session::flash('flash_message', 'Invalid file uploaded, Please upload jpg or png images');
                            Session::flash('flash_type', 'alert-danger');

                            return Redirect::back();
                        }
                        $fname = Input::file('file')->getClientOriginalName();
                        $file_name = time();
                        $file_name .= $file_name . $fname;
                        Input::file('file')->move($path, $file_name);
                        $newName = "thumb_" . $file_name . $fname;
                        $prescription = new Prescription;
                        $user_id = Auth::user()->id;
                        $prescription->path = $file_name;
                        $prescription->created_at = date('Y-m-d H:i:s');
                        $prescription->user_id = $user_id;
                        $prescription->created_by = $user_id;
                        $prescription->save();
                        $realpath = $path . "/" . $file_name;
                        // open an image file
                        $img = Image::make($realpath);
                        // now you are able to resize the instance
                        $img->resize(60, 60);
                        // finally we save the image as a new file
                        $img->save($path . '/' . $newName);
                        $current_medicines = SessionsData::select('medicine_id', 'medicine_count')->where('user_id', '=', $email)->get();
                        if (count($current_medicines) > 0) {
                            $pres_id = $prescription->id;
                            $invoice = new Invoice;
                            $invoice->pres_id = $pres_id;
                            $invoice->user_id = $user_id;
                            $invoice->created_at = date('Y-m-d h:i:s');
                            $invoice->created_by = $user_id;
                            $invoice->save();
                            $invoice_id = $invoice->id;
                            foreach ($current_medicines as $medicine) {
                                $medicine_details = Medicine::medicines($medicine['medicine_id']);
                                $total_discount = $medicine_details['discount'] * $medicine['medicine_count'];
                                $total_price = ($medicine_details['mrp'] * $medicine['medicine_count']) - $total_discount;
                                $itemList = new ItemList;
                                $itemList->invoice_id = $invoice_id;
                                $itemList->medicine = $medicine['medicine_id'];
                                $itemList->quantity = $medicine['medicine_count'];
                                $itemList->unit_price = $medicine_details['mrp'];
                                $itemList->discount_percentage = $medicine_details['discount'];
                                $itemList->discount = $total_discount;
                                $itemList->total_price = $total_price;
                                $itemList->created_at = date('Y-m-d H:i:s');
                                $itemList->created_by = $user_id;
                                $itemList->save();
                            }

                        }
                        $data['email'] = $email;
                        $name = "";
                        if ($user_type == UserType::CUSTOMER()) {
                            $name = Auth::user()->customer->first_name;
                        } elseif ($user_type == UserType::MEDICAL_PROFESSIONAL()) {
                            $name = Auth::user()->professional->prof_first_name;
                        }
                        Mail::send('emails.prescription_upload', array('name' => $name), function ($message) use ($data) {
                            $message->to($data['email'])->subject('New prescription uploaded to ' . Setting::param('site', 'app_name')['value']);
                        });
                        DB::table('sessions')->where('user_id', '=', $email)->delete();
                        Session::flash('flash_message', '<b>Success !</b> Your prescription uploaded successfully. Please track the status in MY PRESCRIPTIONS.');
                        Session::flash('flash_type', 'alert-success');

                        return Redirect::back();


                    } else {
                        Session::flash('flash_message', 'Please select a file to upload');
                        Session::flash('flash_type', 'alert-danger');

                        return Redirect::back();
                    }
                } else {
                    Session::flash('flash_message', '<b>Sorry !</b> Please login first');
                    Session::flash('flash_type', 'alert-danger');

                    return Redirect::back();
                }


            } else {
                $email = Input::get('email', '');
                $prescription = Input::get('prescription', '');
                $path = base_path() . '/public/images/prescription/' . $email . '/';
                $date = new DateTime();
                $file_name = $date->getTimestamp();
                $img = str_replace('data:image/png;base64,', '', $prescription);
                if (file_put_contents($path . $file_name, base64_decode($img))) {
                    $prescription = new Prescription;
                    $user_id = User::where('email', '=', $email)->first()->id;
                    $prescription->path = $file_name;
                    $prescription->created_at = date('Y-m-d H:i:s');
                    $prescription->user_id = $user_id;
                    $prescription->created_by = $user_id;
                    $prescription->save();
                    $prescription_thumb = Input::get('prescription_thumb', '');
                    $img_thumb = str_replace('data:image/png;base64,', '', $prescription_thumb);
                    file_put_contents($path . $file_name . '_thumb', base64_decode($img_thumb));
                    $result = array(array('result' => array('status' => 'success')));
                    $cart_length = intval(Input::get('cart_length', 0));
                    if ($cart_length > 0) {
                        $pres_id = $prescription->id;//24
                        $invoice = new Invoice;
                        $invoice->pres_id = $pres_id;
                        $invoice->date_created = date('Y-m-d');
                        $invoice->save();
                        $invoice_id = $invoice->id;//5
                        for ($i = 0; $i < $cart_length; $i++) {
                            $itemList = new ItemList;
                            $itemList->item_name = Input::get('item_name' . $i, null);
                            $itemList->qty = Input::get('quantity' . $i, null);
                            // $itemList->item_name = Input::get('item_name' . $i, null);
                            $itemList->unit_price = Input::get('price' . $i, null);
                            $itemList->invoice_number = $invoice_id;
                            $itemList->item_code = Input::get('item_code' . $i, null);
                            $itemList->save();
                        }

                    }
                } else {
                    $result = array(array('result' => array('status' => 'failure')));
                }
                $data['email'] = $email;
                $name_array = DB::table('customer')->select('cust_first_name')->where('cust_mail', '=', $email)->first();
                $name = $name_array->cust_first_name;
                Mail::send('emails.prescription_upload', array('name' => $name), function ($message) use ($data) {
                    $message->to($data['email'])->subject('New prescription uploaded to ' . Setting::param('site', 'app_name')['value']);
                });

                return Response::json($result);
            }
        }

        /**
         * Get ORders
         * @return mixed
         */
        public function getMyOrder()
        {
            if (!Auth::check())
                return Redirect::to('/');
            $email = Session::get('user_id');
            $path = URL . '/public/images/prescription/' . $email . '/';
            $user_id = Auth::user()->id;
            $invoices = Invoice::where('shipping_status', '=', ShippingStatus::SHIPPED())->get();

            return View::make('/users/my_order', array('invoices' => $invoices, 'email' => $email));

            // return View::make('/users/my_order');
        }

        /**
         * Create Prescription List
         */
        public function createPrescriptionList($invoice)
        {
            $medicines = Medicine::medicines();
            $items = [];
            foreach ($invoice->cartList() as $cart) {
                $items[] = ['id' => $cart->id,
                    'item_id' => $cart->medicine,
                    'item_code' => $medicines[$cart->medicine]['item_code'],
                    'item_name' => $medicines[$cart->medicine]['item_name'],
                    'unit_price' => $cart->unit_price,
                    'discount_percent' => $cart->discount_percentage,
                    'discount' => $cart->discount,
                    'quantity' => $cart->quantity,
                    'total_price' => $cart->total_price
                ];
            }
            $details = [
                'id' => $invoice->id,
                'invoice' => $invoice->invoice,
                'sub_total' => $invoice->sub_total,
                'discount' => $invoice->discount,
                'tax' => $invoice->tax,
                'shipping' => $invoice->shipping,
                'total' => $invoice->total,
                'created_on' => $invoice->created_at,
                'cart' => $items,
                'shipping_status' => $invoice->shipping_status,
            ];

            return $details;
        }

        /**
         * Get Prescription List
         * @param int $is_category
         * @return mixed
         */
        public function getMyPrescription($is_category = 0)
        {
            if (!Auth::check())
                return Redirect::to('/');
            $email = Session::get('user_id');
            $path = URL . '/public/images/prescription/' . $email . '/';
            $user_id = Auth::user()->id;
            $invoices = Invoice::where('user_id', '=', $user_id)->get();
            $prescriptions = Prescription::select('i.*', 'prescription.status', 'prescription.path', 'prescription.id as pres_id', 'prescription.created_at as date_added')->where('prescription.user_id', '=', $user_id)
                ->leftJoin('invoice as i', 'i.pres_id', '=', 'prescription.id')
                ->whereIn('i.payment_status', [PayStatus::PENDING(), 0]);
            $responses = [];
            switch ($is_category) {
                case (PrescriptionStatus::VERIFIED()):
                    $prescriptions = $prescriptions->where('status', '=', PrescriptionStatus::VERIFIED());
                    break;
                case(PrescriptionStatus::UNVERIFIED()):
                    $prescriptions = $prescriptions->where('status', '=', PrescriptionStatus::UNVERIFIED());
                    break;
                default:
                    break;
            }
            $results = $prescriptions->get();
            foreach ($results as $result) {
                $items = [];
                $medicines = Medicine::medicines();
                if (!is_null($result->id) || !empty($result->id)) {
                    $carts = ItemList::where('invoice_id', '=', $result->id)->get();
                    foreach ($carts as $cart) {
                        $items[] = ['id' => $cart->id,
                            'item_id' => $cart->medicine,
                            'item_code' => $medicines[$cart->medicine]['item_code'],
                            'item_name' => $medicines[$cart->medicine]['item_name'],
                            'unit_price' => $cart->unit_price,
                            'discount_percent' => $cart->discount_percentage,
                            'discount' => $cart->discount,
                            'quantity' => $cart->quantity,
                            'total_price' => $cart->total_price
                        ];
                    }
                }
                $details = [
                    'id' => (is_null($result->id)) ? 0 : $result->id,
                    'invoice' => (is_null($result->invoice)) ? 0 : $result->invoice,
                    'sub_total' => (is_null($result->sub_total)) ? 0 : $result->sub_total,
                    'discount' => (is_null($result->discount)) ? 0 : $result->discount,
                    'tax' => (is_null($result->tax)) ? 0 : $result->tax,
                    'shipping' => (is_null($result->shipping)) ? 0 : $result->shipping,
                    'total' => (is_null($result->total)) ? 0 : $result->total,
                    'created_on' => (is_null($result->date_added)) ? 0 : $result->date_added,
                    'cart' => $items,
                    'shipping_status' => (is_null($result->shipping_status)) ? 0 : $result->shipping_status,
                    'pres_status' => $result->status,
                    'invoice_status' => is_null($result->status_id) ? 0 : $result->status_id,
                    'path' => $result->path
                ];
                $responses[] = $details;
            }
            $payment_mode = Setting::select('value')->where('group', '=', 'payment')->where('key', '=', 'mode')->first();

            return View::make('/users/my_prescription', array('prescriptions' => $responses, 'email' => $email, 'cat' => $is_category, 'payment_mode' => $payment_mode->value));
        }

        /**
         * Get the paid prescription by logined user
         * @return mixed
         */
        public function getPaidPrescription()
        {
            if (!Auth::check())
                return Redirect::to('/');
            // Prescriptions
            $email = Session::get('user_id');
            $path = URL . '/public/images/prescription/' . $email . '/';
            $user_id = Auth::user()->id;
            $invoices = Invoice::where('status_id', '=', InvoiceStatus::PAID())->whereIn('shipping_status', array(0, ShippingStatus::NOTSHIPPED()))->get();

            return View::make('/users/paid_prescription', array('invoices' => $invoices, 'email' => $email, 'cat' => 0));
        }

        /**
         * Get Prescription Thumb
         * @return mixed
         */
        public function anyGetPrescriptionThumb()
        {
            //yadu@webandcrafts.com
            $email = Input::get('email', null);
            // $email= "yadu@webandcrafts.com";
            if ($email != null) {
                //$path = base_path() . '/public/images/prescription/' . $email . '/';
                $path = url() . '/public/images/prescription/' . $email . '/';
                try {
                    $user_id = User::where('email', '=', $email)->first()->id;
                    $prescription = Prescription::where('user_id', '=', $user_id)->orderBy('id', 'desc')->get();
                    $i = 0;
                    foreach ($prescription as $presLink) {
                        //$prescriptionLink[$i++]=array('link'=>$presLink->path.'_thumb','status_pres'=>$presLink->status);
                        $filename = $presLink->path;
                        ////
                        if (strcmp($presLink->status, 'active') == 0 || strcmp($presLink->status, 'shipped') == 0) {
                            $j = 0;
                            $itemArray = array();
                            $invoice = Invoice::where('pres_id', '=', $presLink->id)->first();
                            $itemList = ItemList::where('invoice_number', '=', $invoice->id)->get();
                            foreach ($itemList as $eachItemList) {
                                $itemArray[$j++] = array('MedName' => $eachItemList->item_name, 'Qty' => $eachItemList->qty, 'Price' => $eachItemList->unit_price, 'Item_code' => $eachItemList->item_code);
                            }
                            $invoice_number = $invoice->id;

                        } else {
                            $itemArray = array();
                            $invoice_number = null;
                        }
                        $inv = Invoice::where('id', '=', $invoice_number)->first();
                        $shipping = 0;
                        if (!is_null($inv['shipping'])) {
                            $shipping = $inv['shipping'];
                        }
                        $discount = 0;
                        $medicines = Medicine::medicines();
                        $item = ItemList::where('invoice_number', '=', $invoice_number)->get();
                        foreach ($item as $itemList) {
                            foreach ($medicines as $medItem) {
                                if ($medItem['data'] == $itemList->item_code) {
                                    $discount += $medItem['discount'] * $itemList->qty * $itemList->unit_price / 100;
                                    break;
                                }
                            }

                        }
                        $prescriptionLink[$i++] = array('link' => $path . $filename . '_thumb', 'status_pres' => $presLink->status, 'date' => date('m-d-Y', $filename), 'medname' => $itemArray, 'invoice_no' => $invoice_number, 'shipping' => $shipping, 'discount' => $discount, 'pres_id' => $presLink->id);

                    }
                    $result = array(array('result' => array('status' => 'success', 'images' => $prescriptionLink)));
                } catch (Exception $e) {
                    $result = array(array('result' => array('status' => 'failure')));

                }
            } else {
                $result = array(array('result' => array('status' => 'failure')));
            }

            return Response::json($result);
        }

        /**
         * Load Medicine List
         * @return mixed
         */
        public function anyLoadMedicine()
        {
            header("Access-Control-Allow-Origin: *");
            $medicineName = Input::get('medicine', '');
            $medicine = Medicine::where('item_name', 'LIKE', $medicineName . '%')->take(4)->get();
            $i = 0;
            if ($medicine->count() > 0) {
                foreach ($medicine as $med) {
                    $medicineNameArray[$i] = array("id" => $i + 1, "name" => $med->item_name, 'mrp' => substr($med->mrp, 0, 4), 'exp' => $med->expdt, 'item_code' => $med->item_code);
                    $i++;
                }
                $result = array(array('result' => array('status' => 'sucess', 'msg' => $medicineNameArray)));
            } else {
                $result = array(array('result' => array('status' => 'failure')));
            }

            return Response::json($result);

        }

        public function anyLoadMedicineWeb($isWeb = 0)
        {
            header("Access-Control-Allow-Origin: *");
            if ($isWeb) {
                $key = Input::get('term', '');
            } else {
                $key = Input::get('n', '');
            }
            $medicines = Medicine::medicines();
            if (!empty($key)) {
                $medicines = array_filter($medicines, function ($medicine) use ($key) {
                    $medTemp = $this->stringClean($medicine['item_name']);
                    $keyTemp = $this->stringClean($key);
                    if ((strpos(strtolower($medicine['item_name']), strtolower($key)) === 0
                            || strpos(strtolower($medTemp), strtolower($key)) === 0
                            || strpos(strtolower($medTemp), strtolower($keyTemp)) === 0
                        ) && $medicine['is_delete'] == 0
                    )
                        return true;
                    else
                        return false;
                });


            }
            if ($isWeb) {
                $json = [];
                foreach ($medicines as $data) {
                    $json[] = array(
                        'value' => $data['item_name'],
                        'label' => $data['item_name'],
                        'item_code' => $data['item_code'],
                    );
                }

                return Response::json($json);

            } else {
                $medicines = array_slice($medicines, 0, 4);
                $result = array(array('result' => array('status' => 'success', 'msg' => $medicines)));

                return Response::json($result);
            }


        }

        /**
         * Clean String Parameter
         */
        function stringClean($string)
        {
            return preg_replace('/[-" "`*().]/', '', $string);
        }

        /**
         * Load Alternate Medicines
         * @return mixed
         */
        public function anyLoadSubMedicine()
        {
            header("Access-Control-Allow-Origin: *");
            $med_name = Input::get('n', '');
            $med_id = Input::get('id', '');
            $medicines = Medicine::medicines();
            $key = Medicine::medicines($med_id);
            if (!empty($key['composition'])) {
                if ($key['composition'] != "Not available") {
                    $medicines = array_filter($medicines, function ($medicine) use ($key, $med_name) {
                        if ((strcmp($medicine['composition'], $key['composition']) == 0) && ($medicine['item_name'] != $med_name) && $medicine['is_delete'] == 0) {
                            return true;
                        } else {
                            return false;
                        }
                    });
                    $medicines = array_slice($medicines, 0, 5);
                    foreach ($medicines as &$value) {
                        $value['mrp'] = Setting::currencyFormat($value['mrp']);
                    }
                    $result = array(array('result' => array('status' => 'success', 'price' => Setting::currencyFormat($key['mrp']), 'msg' => $medicines)));
                } else {
                    $result = array(array('result' => array('status' => 'failure')));
                }
            } else {
                $result = array(array('result' => array('status' => 'failure')));
            }

            return Response::json($result);

        }

        /**
         * Update Medicine cart list
         * @return mixed
         */
        public function anyUpdateBuyMedicine()
        {
            $updatedRows = 0;
            $deletedRow = 0;
            header("Access-Control-Allow-Origin: *");
            $deleted_length = intval(Input::get('deleted_length', 0));
            if ($deleted_length > 0) {
                $invoice_number = Input::get('invoice_number', '');
                for ($i = 0; $i < $deleted_length; $i++) {
                    $toBeDeleted = Input::get('item_code' . $i, null);
                    try {
                        $rowTobeDeleted = ItemList::where('invoice_number', '=', $invoice_number)->where('item_code', '=', $toBeDeleted)->first();
                        if ($rowTobeDeleted != null)
                            $deletedRow = $rowTobeDeleted->delete();
                    } catch (Exception $e) {
                    }
                }

            }
            if ($deletedRow > 0)
                $result = array(array('result' => array('status' => 'success')));
            else
                $result = array(array('result' => array('status' => 'none')));

            return Response::json($result);
        }

        /**
         * Update cart list
         * @return mixed
         */
        public function anyUpdateBuy()
        {
            $updatedRows = 0;
            $deletedRow = 0;
            header("Access-Control-Allow-Origin: *");
            $deleted_length = intval(Input::get('deleted_length', 0));
            if ($deleted_length > 0) {
                $invoice_number = Input::get('invoice_number', '');
                for ($i = 0; $i < $deleted_length; $i++) {
                    $toBeDeleted = Input::get('item_code' . $i, null);
                    try {
                        $rowTobeDeleted = ItemList::where('invoice_number', '=', $invoice_number)->where('item_code', '=', $toBeDeleted)->first();
                        if ($rowTobeDeleted != null)
                            $deletedRow = $rowTobeDeleted->delete();
                    } catch (Exception $e) {
                    }
                }
            }
            if ($deletedRow > 0)
                $result = array(array('result' => array('status' => 'success')));
            else
                $result = array(array('result' => array('status' => 'none')));

            return Response::json($result);
        }

        /**
         * Update A New Medicine Request
         * @return mixed
         */
        public function anyAddMedicine()
        {
            $name = Input::get('name', '');
            $oldMed = NewMedicine::where('name', '=', $name)->get();
            if ($oldMed->count() > 0) {
                $newCount = array('count' => $oldMed->first()->count + 1, 'updated_at' => date('Y-m-d H:i:s'));
                $affectedRows = NewMedicine::where('name', '=', $name)->update($newCount);
                $who = new NewMedicineEmail;
                $who->email = Input::get('email', '');
                $who->request_id = $oldMed->first()->id;
                $who->created_at = date('Y-m-d H:i:s');
                $who->save();
            } else {
                $newMed = new NewMedicine;
                $newMed->name = $name;
                $newMed->count = 1;
                $newMed->created_at = date('Y-m-d H:i:s');
                $newMed->save();
                $who = new NewMedicineEmail;
                $who->email = Input::get('email', '');
                $who->request_id = $newMed->id;
                $who->created_at = date('Y-m-d H:i:s');
                $who->save();
            }
            $result = array(array('result' => array('status' => 'success')));

            return Response::json($result);
        }

        /**
         * Get Prescription Image
         * @return mixed
         */
        public function postGetPresImg()
        {
            $pres_id = Input::get('pres_id');
            $u = User::join('prescription', 'prescription.user_id', '=', 'users.id')->where('id', '=', $pres_id)->first();
            $path = url() . '/public/images/prescription/' . $u->email . '/' . $u->path;
            $result = array(array('result' => array('status' => 'success', 'link' => $path)));

            return Response::json($result);
        }

        /**
         * Get Medicine Details Search option
         * @param $serched_medicine
         * @return mixed
         */
        public function getMedicineDetail($searched_medicine)
        {
            $med_info = Medicine::select('*')
                ->where('item_code', '=', $searched_medicine)
                ->get();
            if (count($med_info) > 0) {
                return View::make('users.medicine_detail', array('med_info' => $med_info));
            } else {
                return Redirect::back()->withErrors(['Sorry no more search results available']);
            }

        }

        /**
         * Get User Cart
         * @return mixed
         */
        public function getMyCart()
        {
            $email = Session::get('user_id');
            $current_orders = DB::table('sessions')->where('user_id', '=', $email)->get();

            return View::make('/users/my_cart', array('current_orders' => $current_orders));

        }

        /*
         * remove item from cart
         * deletes row from 'sessions'  table
         * */
        public function anyRemoveFromCart($item_id)
        {
            DB::table('sessions')->where('id', '=', $item_id)->delete();

            return Redirect::back()->withErrors(['msg', 'Item has been removed']);

        }

        /*
         * View item information
         * */
        public function anyViewItemInfo($item_code)
        {
            $item_details = DB::table('medicine')
                ->where('item_code', '=', $item_code)
                ->get();
            $email = Session::get('user_id');
            $current_orders = DB::table('sessions')
                ->where('user_id', '=', $email)
                ->get();

            return View::make('/users/my_cart', array('current_orders' => $current_orders, 'item_details' => $item_details));
        }

        /*
         * make user orders
         * stores or updates each orders to sessions table
         * */
        public function  anyAddCart($is_web = 0)
        {
            if (!$this->isCsrfAccepted()) {
                return 0;
            }
            $medicine = (Session::get('medicine') == "") ? Input::get('medicine') : Session::get('medicine');
            $med_quantity = (Session::get('med_quantity') == "") ? Input::get('med_quantity') : Session::get('med_quantity');
            $med_mrp = (Session::get('med_mrp') == "") ? Input::get('hidden_selling_price') : Session::get('med_mrp');
            $item_code = (Session::get('item_code') == "") ? Input::get('hidden_item_code') : Session::get('item_code');
            $item_id = (Session::get('item_id') == "") ? Input::get('id') : Session::get('item_id');
            Session::put('medicine', $medicine);
            Session::put('med_quantity', $med_quantity);
            Session::put('med_mrp', $med_mrp);
            Session::put('item_code', $item_code);
            Session::put('item_id', $item_id);
            $email = "";
            if (Auth::check()) {
                $email = Session::get('user_id', '');
                $medicine_exist = DB::table('sessions')->select('medicine_name')->where('user_id', '=', $email)->where('medicine_name', '=', $medicine)->get();
                if (count($medicine_exist) > 0) {
                    $increment = DB::table('sessions')->increment('medicine_count', $med_quantity);
                    if ($increment) {
                        Session::forget('medicine');
                        Session::forget('med_quantity');
                        Session::forget('med_mrp');
                        Session::forget('item_code');
                        Session::forget('item_id');
                        if ($is_web == 1) {
                            return Redirect::to("medicine/my-cart");
                        } else {
                            return "updated";
                        }
                    }

                } else {
                    $insert = DB::table('sessions')->insert(array('medicine_id' => $item_id, 'medicine_name' => $medicine, 'medicine_count' => $med_quantity, 'user_id' => $email, 'unit_price' => $med_mrp, 'item_code' => $item_code));
                    if ($insert) {
                        //return "updated";
                        Session::forget('medicine');
                        Session::forget('med_quantity');
                        Session::forget('med_mrp');
                        Session::forget('item_code');
                        Session::forget('item_id');
                        if ($is_web == 1) {
                            return Redirect::to("my-cart");
                        } else {
                            return "inserted";
                        }
                    }
                }


            } else {
                return 0;
            }

        }

        /**
         * Update Cart
         */
        public function anyUpdateCart()
        {
            if (!$this->isCsrfAccepted())
                return 0;
            // Update Item
            $item_code = Input::get('item_code');
            $new_qty = Input::get('new_qty');
            $email = Session::get('user_id');
            $qty_updt = DB::table('sessions')
                ->where('user_id', '=', $email)
                ->where('item_code', '=', $item_code)
                ->update(array('medicine_count' => $new_qty));
            if ($qty_updt) {
                echo 1;
            } else {
                echo 0;
            }

        }

        /**
         * Download Prescription
         * @param $file_name
         * @return mixed
         */
        public function anyDownloading($file_name)
        {
            $email = Session::get('user_id');
            $pathToFile = base_path() . '/public/images/prescription/' . $email . '/' . $file_name;

            return Response::download($pathToFile);

        }

        /**
         * @param $invoice
         * @return mixed
         * render the view of payment with payment details
         */
        public function anyMakePayment($invoice)
        {
            // If User Authenticated
            if (!Auth::check())
                return Redirect::to('/');
            // Get Invoice
            $invoiceDetails = Invoice::find($invoice);
            // If Invoice Is Not Present
            if (is_null($invoice))
                return Redirect::to('/paid-prescription');
            $data = array();
            $email = Session::get('user_id');
            $user = Auth::user();
            $type = $user->user_type_id;
            if ($type == UserType::CUSTOMER()) {
                $user_info = Customer::find($user->user_id);
                $phone = $user_info->phone;
                $fname = $user_info->first_name;
                $lname = $user_info->last_name;
                $address = $user_info->address;
            } elseif ($type == UserType::MEDICAL_PROFESSIONAL()) {
                $user_info = MedicalProfessional::find($user->user_id);
                $phone = $user_info->prof_phone;
                $fname = $user_info->prof_first_name;
                $lname = $user_info->prof_last_name;
                $address = $user_info->prof_address;
            }
            $data = array();
            $item_name = "";
            $i = 0;
            foreach ($invoiceDetails->cartList() as $cart) {
                $item_name .= Medicine::medicines($cart->medicine)['item_name'];
                $item_name .= " ,";

            }
            $total = $invoiceDetails->total;
            $data['amount'] = $total;
            $data['email'] = $email;
            $data['phone'] = $phone;
            $data['firstname'] = $fname;
            $data['lname'] = $lname;
            $data['address'] = $address;
            $data['invoice'] = $invoiceDetails->invoice;
            $data['id'] = $invoice;
            $data['productinfo'] = $item_name;

            return View::make('/users/payment', array('posted' => $data));

        }

        /**
         * @param $invoice
         * @return mixed
         * render the view of payment with payment details
         */
        public function anyMakePaypalPayment($invoice)
        {
            // If User Authenticated
            if (!Auth::check())
                return Redirect::to('/');
            // Get Invoice
            $invoiceDetails = Invoice::find($invoice);
            // If Invoice Is Not Present
            if (is_null($invoice))
                return Redirect::to('/paid-prescription');
            $data = array();
            $email = Session::get('user_id');
            $user = Auth::user();
            $type = $user->user_type_id;
            if ($type == UserType::CUSTOMER()) {
                $user_info = Customer::find($user->user_id);
                $phone = $user_info->phone;
                $fname = $user_info->first_name;
                $lname = $user_info->last_name;
                $address = $user_info->address;
            } elseif ($type == UserType::MEDICAL_PROFESSIONAL()) {
                $user_info = MedicalProfessional::find($user->user_id);
                $phone = $user_info->prof_phone;
                $fname = $user_info->prof_first_name;
                $lname = $user_info->prof_last_name;
                $address = $user_info->prof_address;
            }
            $data = array();
            $item_name = "";
            $i = 0;
            foreach ($invoiceDetails->cartList() as $cart) {
                $item_name .= Medicine::medicines($cart->medicine)['item_name'];
                $item_name .= " ,";

            }
            $total = $invoiceDetails->total;
            $data['amount'] = $total;
            $data['email'] = $email;
            $data['phone'] = $phone;
            $data['firstname'] = $fname;
            $data['lname'] = $lname;
            $data['address'] = $address;
            $data['invoice'] = $invoiceDetails->invoice;
            $data['id'] = $invoice;
            $data['productinfo'] = $item_name;

            return View::make('/users/paypal_payment', array('posted' => $data));

        }

        /**
         * URL for success payment
         * @param $invoice
         */
        public function anyPaySuccess($invoice)
        {
            $transaction_id = Input::get('payuMoneyId', '');             // Save Return Transaction Id of Payment Gateway
            // Update Invoice
            $invoice = Invoice::find($invoice);
            $invoice->status_id = InvoiceStatus::PAID();
            $invoice->payment_status = PayStatus::SUCCESS();
            $invoice->transaction_id = $transaction_id;
            $invoice->updated_at = date('Y-m-d H:i:s');
            $invoice->updated_by = Auth::user()->id;
            $invoice->save();
            // User
            $user_detail = $invoice->getUser;
            $type = $user_detail->user_type_id;
            // Send Paid Mail
            if ($type == UserType::CUSTOMER()) {
                $user = Customer::select('mail', 'first_name')->find($user_detail->user_id);
                $user_email = $user->mail;
                $user_name = $user->first_name;
            } elseif ($type == UserType::MEDICAL_PROFESSIONAL()) {
                $user = MedicalProfessional::select('prof_mail as mail', 'prof_first_name as first_name')->find($user_detail->user_id);
                $user_email = $user->mail;
                $user_name = $user->first_name;
            }
            Mail::send('emails.paid', array('name' => $user_name), function ($message) use ($user_email) {
                $message->to($user_email)->subject('Your payment received at ' . Setting::param('site', 'app_name')['value']);
            });

            return View::make('/users/payment_success');
        }

        /**
         * URL for success payment from paypal
         * @return mixed
         */
        public function anyPaypalSuccess()
        {
            session_start();
            session_destroy();
            $invoice = Input::get('pay_id', '');
            $transaction_id = Input::get('transaction_id', '');
            if ($transaction_id != abs(crc32($invoice))) {
                session_start();
                session_destroy();

                return View::make('/users/payment_failed');
            }
            $invoice = Invoice::where('invoice', '=', $invoice)->first();
            $invoice->status_id = InvoiceStatus::PAID();
            $invoice->payment_status = PayStatus::SUCCESS();
            $invoice->transaction_id = $transaction_id;
            $invoice->updated_at = date('Y-m-d H:i:s');
            $invoice->updated_by = Auth::user()->id;
            $invoice->save();
            // User
            $user_detail = $invoice->getUser;
            $type = $user_detail->user_type_id;
            // Send Paid Mail
            if ($type == UserType::CUSTOMER()) {
                $user = Customer::select('mail', 'first_name')->find($user_detail->user_id);
                $user_email = $user->mail;
                $user_name = $user->first_name;
            } elseif ($type == UserType::MEDICAL_PROFESSIONAL()) {
                $user = MedicalProfessional::select('prof_mail as mail', 'prof_first_name as first_name')->find($user_detail->user_id);
                $user_email = $user->mail;
                $user_name = $user->first_name;
            }
            Mail::send('emails.paid', array('name' => $user_name), function ($message) use ($user_email) {
                $message->to($user_email)->subject('Your payment received at ' . Setting::param('site', 'app_name')['value']);
            });

            return View::make('/users/payment_success');
        }

        /**
         * make an invoice paid by admin
         * @param $invoice
         */
        public function anyAdminPaySuccess($invoice)
        {
            // Update Invoice
            $invoice = Invoice::find($invoice);
            $invoice->status_id = InvoiceStatus::PAID();
            $invoice->payment_status = PayStatus::SUCCESS();
            $invoice->updated_at = date('Y-m-d H:i:s');
            $invoice->updated_by = Auth::user()->id;
            $invoice->save();
            // User
            $user_detail = $invoice->getUser;
            $type = $user_detail->user_type_id;
            // Send Paid Mail
            if ($type == UserType::CUSTOMER()) {
                $user = Customer::select('mail', 'first_name')->find($user_detail->user_id);
                $user_email = $user->mail;
                $user_name = $user->first_name;
            } elseif ($type == UserType::MEDICAL_PROFESSIONAL()) {
                $user = MedicalProfessional::select('prof_mail as mail', 'prof_first_name as first_name')->find($user_detail->user_id);
                $user_email = $user->mail;
                $user_name = $user->first_name;
            }
            Mail::send('emails.paid', array('name' => $user_name), function ($message) use ($user_email) {
                $message->to($user_email)->subject('Your payment received at ' . Setting::param('site', 'app_name')['value']);
            });

            return Redirect::to('/admin/load-active-prescription');
        }

        /**
         * URL for failed payment
         * @param $invoice
         */
        public function anyPayFail($invoice)
        {
            return View::make('/users/payment_failed');
        }

        /**
         * URL for Failed payment
         */
        public function anyPaypalFail()
        {
            session_start();
            session_destroy();

            return View::make('/users/payment_failed');
        }

        /*
         * View item information
         * */
        public function getMedicineData()
        {
            $mid = Input::get('id');
            $medicine = Medicine::medicines($mid);

            return Response::json($medicine);
        }

        /**
         * Name search in medicine list
         * @return mixed
         */
        public function getMedicineListFromName()
        {
            $name = Input::get('name');
            $order = Input::get('ord', 'ASC');
            if ($name != "")
                $medicines = Medicine::select('id', 'item_name as name', 'batch_no', 'manufacturer as mfg', 'group', 'expiry as exp', 'item_code', 'selling_price as mrp', 'composition')->where('item_name', 'LIKE', $name . "%")->orderBy('composition', $order)->where('is_delete', '=', 0)->paginate(30);
            else
                $medicines = Medicine::select('id', 'item_name as name', 'batch_no', 'manufacturer as mfg', 'group', 'expiry as exp', 'item_code', 'selling_price as mrp', 'composition')->where('item_name', 'LIKE', $name . "%")->orderBy('composition', $order)->where('is_delete', '=', 0)->paginate(30);

            return Response::json(['medicines' => $medicines->getCollection(), 'link' => $medicines->links()->render()]);
        }

        /**
         * Add new medicine for web
         * @return mixed
         */
        public function postAddNewMedicine()
        {
            $name = Input::get('name');
            $user_id = 0;
            $email = 'Not Available';
            if (Auth::check()) {
                $email = Auth::user()->email;
                $user_id = Auth::user()->id;
            }
            $oldMed = NewMedicine::where('name', '=', $name)->get();
            if ($oldMed->count() > 0) {
                $newCount = array('count' => $oldMed->first()->count + 1, 'updated_at' => date("Y-m-d H:i:s"));
                $affectedRows = NewMedicine::where('name', '=', $name)->update($newCount);
                $who = new NewMedicineEmail;
                $who->email = $email;
                $who->request_id = $oldMed->first()->id;
                $who->user_id = $user_id;
                $who->created_at = date('Y-m-d H:i:s');
                $status = $who->save();
            } else {
                $newMed = new NewMedicine;
                $newMed->name = $name;
                $newMed->count = 1;
                $newMed->created_at = date("Y-m-d H:i:s");
                $newMed->save();
                $who = new NewMedicineEmail;
                $who->email = $email;
                $who->request_id = $newMed->id;
                $who->user_id = $user_id;
                $who->created_at = date("Y-m-d H:i:s");
                $status = $who->save();
            }

            return Response::json(['status' => $status]);
        }

        /**
         * Upload Bulk Medicine List
         */
        public function postUpload()
        {
            try {
                if (!$this->isCsrfAccepted())
                    throw new Exception('FORBIDDEN', 403);
                if (!Input::hasFile('file'))
                    throw new Exception('BAD REQUEST', 400);
                $file = Input::file('file');
                $extension = strtolower($file->getClientOriginalExtension());
                if (!in_array($extension, ['xls', 'xlsx'])) {
                    throw new Exception('Invalid File Uploaded ! Please upload either xls or xlsx file', 400);
                }
                Excel::selectSheetsByIndex(0)->load($file, function ($reader) {
                    // Getting all results
                    $content = $reader->get();
                    $results = [];
                    $available_medicines = Medicine::select('item_name')->get()->toArray();
                    $available_medicines = $array = array_column($available_medicines, 'item_name');;
                    foreach ($content as $result) {
                        if (in_array($result->item_name, $available_medicines))
                            continue;
                        $results[] = ['item_code' => ((isset($result->item_code) && empty($result->item_code)) ? NULL : $result->item_code),
                            'item_name' => ((isset($result->item_name) && empty($result->item_name)) ? NULL : $result->item_name),
                            'batch_no' => ((isset($result->batch_no) && empty($result->batch_no)) ? NULL : $result->batch_no),
                            'quantity' => ((isset($result->quantity) && empty($result->quantity)) ? NULL : $result->quantity),
                            'cost_price' => ((isset($result->cost_price) && empty($result->cost_price)) ? NULL : $result->cost_price),
                            'purchase_price' => ((isset($result->purchase_price) && empty($result->purchase_price)) ? NULL : $result->purchase_price),
                            'rack_number' => ((isset($result->rack) && empty($result->rack)) ? NULL : $result->rack),
                            'selling_price' => ((isset($result->mrp) && empty($result->test)) ? NULL : $result->mrp),
                            'expiry' => ((isset($result->expiry) && empty($result->expiry)) ? NULL : $result->expiry),
                            'tax' => ((isset($result->tax) && empty($result->tax)) ? NULL : $result->tax),
                            'composition' => ((isset($result->composition) && empty($result->composition)) ? NULL : $result->composition),
                            'discount' => ((isset($result->discount) && empty($result->discount)) ? NULL : $result->discount),
                            'manufacturer' => ((isset($result->manufactured_by) && empty($result->manufactured_by)) ? NULL : $result->manufactured_by),
                            'marketed_by' => ((isset($result->marketed_by) && empty($result->marketed_by)) ? NULL : $result->marketed_by),
                            'group' => ((isset($result->group) && empty($result->group)) ? NULL : $result->group)];
                    }
                    Medicine::insert($results);
                });

                return Response::json('success', 200);


            } catch (Exception $e) {
                return Response::json(['msg' => $e->getMessage()], $e->getCode());
            }
        }

    }

