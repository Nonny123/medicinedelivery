<?php
    define('CACHE_PARAM_MEDICINE_A', 'medicines_a');
    define('URL', url());
    define('INVOICE_PREFIX', 'INV_');

    /**
     * Class AdminController
     * Basic Funcationalities related to Admin Module
     */
    class AdminController extends BaseController
    {

        public function __construct()
        {

        }

        public function getShowlogin()
        {
            return View::make('admin.signin');
        }

        /**
         * Login Functionality
         * @return mixed Render View
         */
        public function anyLogin()
        {
            // Validation Rules
            $rules = array('captcha' => array('required', 'captcha'));
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {                  // Failure
                Session::flash('flash_message', '<b>Sorry !</b> Captcha Mismatch');
                Session::flash('flash_type', 'alert-danger');

                return Redirect::to('/admin-login');
            } else {
                if(!$this->isCsrfAccepted())
                    return Redirect::back()->withErrors(['Invalid Request']);
                                              // Success
                $email = Input::get('email', '');
                $password = Input::get('password', '');
                // Check if credientials work
                if (Auth::attempt(array('email' => $email, 'password' => $password, 'user_type_id' => UserType::ADMIN(), 'user_status' => UserStatus::ACTIVE()), true)) {          // SUCCESS
                    return Redirect::to('/admin/dashboard');
                } else {                                                                                                                    // FAILURE
                    Session::flash('flash_message', '<b>Sorry !</b> Invalid Login Credentials');
                    Session::flash('flash_type', 'alert-danger');

                    return Redirect::to('/admin-login');
                }
            }

        }

        /**
         * View Admin Dashboard
         * @return mixed
         */
        public function getDashboard()
        {
            return View::make("admin.dashboard");
        }

        /**
         * Logout Functionality
         * @return mixed
         */
        public function getLogout()
        {
            Auth::logout();

            return Redirect::to('admin');
        }

        /**
         * Load Medicine List
         * @return mixed
         */
        public function getLoadMedicines()
        {
            header("Access-Control-Allow-Origin: *");
            $medicines = Medicine::select
            ('id', 'item_name as name', 'batch_no', 'manufacturer as mfg', 'group', 'expiry as exp', 'item_code', 'selling_price as mrp',
                'composition')->where('is_delete', '=', 0)->orderBy('item_name', 'ASC')->paginate(30);

            return View::make('admin.medicinelist')->with('medicines', $medicines);

        }

        /**
         * Load Customer List
         * @return mixed
         */
        public function getLoadCustomers()
        {
            header("Access-Control-Allow-Origin: *");
            $customers = Customer::where('is_delete', '!=', 1)->paginate(30);

            return View::make('admin.customerlist')->with('customers', $customers);

        }

        /**
         * Load Medical Professionals
         * @return mixed
         */
        public function getLoadMedicalprof()
        {
            header("Access-Control-Allow-Origin: *");
            $mprof = MedicalProfessional::where('prof_is_delete', '!=', 1)->paginate(30);

            return View::make('admin.mproflist')->with('mprof', $mprof);

        }

        /**
         * Load Prescription List
         * @return mixed
         */
        public function getLoadPrescription()
        {
            header("Access-Control-Allow-Origin: *");
            $email = Input::get('email', '');
            $status = Input::get('status', '');
            $pres = Prescription::select('prescription.status', 'email', 'path', 'id as pres_id')->join('users', 'users.id', '=', 'prescription.user_id');
            if (!empty($email)) {
                $pres->where('email', 'LIKE', $email . '%');
            }
            if (!empty($status)) {
                if ($status == 'DESC') {
                    $pres->orderBy('prescription.status', 'desc');
                } else {
                    $pres->orderBy('prescription.status', 'asc');
                }
            }
            $tbody = "";
            $data = $pres->paginate(30);
            $i = 1;
            foreach ($pres->get() as $press) {
                $inv = Invoice::select('status', 'id')->where('pres_id', '=', $press->pres_id)->first();
                if ($press->status == 'shipped') {
                    $buttonDisable = 'disabled';
                    $dropDown = 'Yes';
                    $inv_no = 'EZ' . (1000000 + $inv['id']);
                } else if ($press->status == 'pending') {
                    $dropDown = 'Please select';
                    $buttonDisable = 'disabled';
                    $inv_no = '';
                } else {
                    $dropDown = 'Please select';
                    $buttonDisable = 'enabled';
                    $inv_no = '';
                }
                if ($inv['status'] === NULL) {
                    $paid = "<i class='fa fa-times'  style='color:#DF0101'></i>";
                } else {
                    $paid = "<i class='fa fa-check'  style='color:#01DF01'></i>";
                }
                $tbody .= "<tr><td>" . $i++ . "</td><td>" . $press->email . "</td><td>" . date('m-d-Y', strtotime($press->path)) . "</td><td>" . $paid . "</td><td><div class='btn-group m-r'>
                          <button data-toggle='dropdown' class='btn btn-sm btn-default dropdown-toggle'" . $buttonDisable . ">
                            <span class='dropdown-label' data-placeholder='Please select'>" . $dropDown . "</span>
                            <span class='caret'></span>
                          </button>
                          <ul class='dropdown-menu dropdown-select'>
                              <li class='' ><a href='' onclick='updatePaidStatus(" . $press->pres_id . ")'" . "><input  type='checkbox' name='d-s-c-2'>Yes</a></li>
                          </ul>
                        </div></td><td>" . $press->status . "</td>
		    	<td><a class='btn btn-s-md btn-info btn-rounded' href='" . URL . "/admin/pres-edit/" . $press->pres_id . "' >Edit</a>&nbsp;&nbsp;&nbsp;<a class='btn btn-s-md btn-danger btn-rounded' href='admin/pres-delete/" . $press->pres_id . "'>Delete</a></td><td><a class='text-info' href='/demo/admin/load-invoice/" . $inv['id'] . "'>" . $inv_no . "</a></td> </tr>";
            }

            return Response::json(['tbody' => $tbody, 'paginate' => $data->links()->render()]);
        }

        /**
         * Load Paid Prescription List
         * @return mixed
         */
        public function getLoadPrescriptionPaid()
        {
            header("Access-Control-Allow-Origin: *");
            $email = Input::get('email', '');
            $status = Input::get('status', '');
            $pres = Prescription::select('prescription.status', 'email', 'path', 'id as pres_id')->join('users', 'users.id', '=', 'prescription.user_id');
            if (!empty($email)) {
                $pres->where('email', 'LIKE', $email . '%');
            }
            if (!empty($status)) {
                if ($status == 'DESC') {
                    $pres->orderBy('prescription.status', 'desc');
                } else {
                    $pres->orderBy('prescription.status', 'asc');
                }
            }
            $tbody = "";
            $data = $pres->paginate(30);
            $i = 1;
            foreach ($pres->get() as $press) {
                $inv = Invoice::select('status', 'id')->where('pres_id', '=', $press->pres_id)->first();
                if ($inv['status'] == 'paid' && $press->status == 'active') {
                    //$paid="<i class='fa fa-check'  style='color:#DF0101'></i>";
                    if ($press->status == 'shipped') {
                        $buttonDisable = 'disabled';
                        $dropDown = 'Yes';
                        $inv_no = 'EZ' . (1000000 + $inv['id']);
                    } else if ($press->status == 'pending') {
                        $dropDown = 'Please select';
                        $buttonDisable = 'disabled';
                        $inv_no = '';
                    } else {
                        $dropDown = 'Please select';
                        $buttonDisable = 'enabled';
                        $inv_no = '';
                    }
                    $paid = "<i class='fa fa-check'  style='color:#01DF01'></i>";
                    $tbody .= "<tr><td>" . $i++ . "</td><td>" . $press->email . "</td><td>" . date('m-d-Y', $press->path) . "</td><td>" . $paid . "</td><td><div class='btn-group m-r'>
                          <button data-toggle='dropdown' class='btn btn-sm btn-default dropdown-toggle'" . $buttonDisable . ">
                            <span class='dropdown-label' data-placeholder='Please select'>" . $dropDown . "</span>
                            <span class='caret'></span>
                          </button>
                          <ul class='dropdown-menu dropdown-select'>
                              <li class='' ><a href='' onclick='updatePaidStatus(" . $press->pres_id . ")'" . "><input  type='checkbox' name='d-s-c-2'>Yes</a></li>
                          </ul>
                        </div></td><td>" . $press->status . "</td>
		    	<td><a class='btn btn-s-md btn-info btn-rounded' href='" . URL . "/admin/pres-edit/" . $press->pres_id . "' >Edit</a>&nbsp;&nbsp;&nbsp;<a class='btn btn-s-md btn-danger btn-rounded' href='admin/pres-delete/" . $press->pres_id . "'>Delete</a></td><td><a class='text-info' href='" . url() . "/admin/load-invoice/" . $inv['id'] . "'>" . $inv_no . "</a></td> </tr>";
                }

            }

            return Response::json(['tbody' => $tbody, 'paginate' => $data->links()->render()]);
        }

        /**
         * Shipped Prescription List
         * @return mixed
         */
        public function getLoadPrescriptionShipped()
        {
            header("Access-Control-Allow-Origin: *");
            $email = Input::get('email', '');
            $status = Input::get('status', '');
            $pres = Prescription::select('prescription.status', 'email', 'path', 'id as pres_id')->join('users', 'users.id', '=', 'prescription.user_id')->where('prescription.status', '=', 'shipped');
            if (!empty($email)) {
                $pres->where('email', 'LIKE', $email . '%');
            }
            if (!empty($status)) {
                if ($status == 'DESC') {
                    $pres->orderBy('prescription.status', 'desc');
                } else {
                    $pres->orderBy('prescription.status', 'asc');
                }
            }
            $tbody = "";
            $data = $pres->paginate(30);
            $i = 1;
            foreach ($pres->get() as $press) {
                $inv = Invoice::select('status', 'id')->where('pres_id', '=', $press->pres_id)->first();
                if ($press->status == 'shipped') {
                    $buttonDisable = 'disabled';
                    $dropDown = 'Yes';
                    $inv_no = 'EZ' . (1000000 + $inv['id']);
                } else if ($press->status == 'pending') {
                    $dropDown = 'Please select';
                    $buttonDisable = 'disabled';
                    $inv_no = '';
                } else {
                    $dropDown = 'Please select';
                    $buttonDisable = 'enabled';
                    $inv_no = '';
                }
                if ($inv['status'] === NULL) {
                    $paid = "<i class='fa fa-times'  style='color:#DF0101'></i>";
                } else {
                    $paid = "<i class='fa fa-check'  style='color:#01DF01'></i>";
                }
                $tbody .= "<tr><td>" . $i++ . "</td><td>" . $press->email . "</td><td>" . date('m-d-Y', $press->path) . "</td><td>" . $paid . "</td><td><div class='btn-group m-r'>
                          <button data-toggle='dropdown' class='btn btn-sm btn-default dropdown-toggle'" . $buttonDisable . ">
                            <span class='dropdown-label' data-placeholder='Please select'>" . $dropDown . "</span>
                            <span class='caret'></span>
                          </button>
                          <ul class='dropdown-menu dropdown-select'>
                              <li class='' ><a href='' onclick='updatePaidStatus(" . $press->pres_id . ")'" . "><input  type='checkbox' name='d-s-c-2'>Yes</a></li>
                          </ul>
                        </div></td><td>" . $press->status . "</td>
		    	<td><a class='btn btn-s-md btn-info btn-rounded' href='" . URL . "/admin/pres-edit/" . $press->pres_id . "' >Edit</a>&nbsp;&nbsp;&nbsp;<a class='btn btn-s-md btn-danger btn-rounded' href='admin/pres-delete/" . $press->pres_id . "'>Delete</a></td><td><a class='text-info' href='" . url() . "/admin/load-invoice/" . $inv['id'] . "'>" . $inv_no . "</a></td> </tr>";

            }

            return Response::json(['tbody' => $tbody, 'paginate' => $data->links()->render()]);
        }

        /**
         * To be paid Prescription list
         * @return mixed
         */
        public function getLoadPrescriptionToBePaid()
        {
            header("Access-Control-Allow-Origin: *");
            $email = Input::get('email', '');
            $status = Input::get('status', '');
            $pres = Prescription::select('prescription.status', 'email', 'path', 'id as pres_id')->join('users', 'users.id', '=', 'prescription.user_id')->where('prescription.status', '=', 'pending');
            if (!empty($email)) {
                $pres->where('email', 'LIKE', $email . '%');
            }
            if (!empty($status)) {
                if ($status == 'DESC') {
                    $pres->orderBy('prescription.status', 'desc');
                } else {
                    $pres->orderBy('prescription.status', 'asc');
                }
            }
            $tbody = "";
            $data = $pres->paginate(30);
            $i = 1;
            foreach ($pres->get() as $press) {
                $inv = Invoice::select('status', 'id')->where('pres_id', '=', $press->pres_id)->first();
                if ($press->status == 'shipped') {
                    $buttonDisable = 'disabled';
                    $dropDown = 'Yes';
                    $inv_no = 'EZ' . (1000000 + $inv['id']);
                } else if ($press->status == 'pending') {
                    $dropDown = 'Please select';
                    $buttonDisable = 'disabled';
                    $inv_no = '';
                } else {
                    $dropDown = 'Please select';
                    $buttonDisable = 'enabled';
                    $inv_no = '';
                }
                if ($inv['status'] === NULL) {
                    $paid = "<i class='fa fa-times'  style='color:#DF0101'></i>";
                    $tbody .= "<tr><td>" . $i++ . "</td><td>" . $press->email . "</td><td>" . date('m-d-Y', strtotime($press->path)) . "</td><td>" . $paid . "</td><td><div class='btn-group m-r'>
                          <button data-toggle='dropdown' class='btn btn-sm btn-default dropdown-toggle'" . $buttonDisable . ">
                            <span class='dropdown-label' data-placeholder='Please select'>" . $dropDown . "</span>
                            <span class='caret'></span>
                          </button>
                          <ul class='dropdown-menu dropdown-select'>
                              <li class='' ><a href='' onclick='updatePaidStatus(" . $press->pres_id . ")'" . "><input  type='checkbox' name='d-s-c-2'>Yes</a></li>
                          </ul>
                        </div></td><td>" . $press->status . "</td>
		    	<td><a class='btn btn-s-md btn-info btn-rounded' href='" . URL . "/admin/pres-edit/" . $press->pres_id . "' >Details</a>&nbsp;&nbsp;&nbsp;<a class='btn btn-s-md btn-danger btn-rounded' href='admin/pres-delete/" . $press->pres_id . "'>Delete</a></td><td><a class='text-info' href='/demo/admin/load-invoice/" . $inv['id'] . "'>" . $inv_no . "</a></td> </tr>";
                }
            }

            return Response::json(['tbody' => $tbody, 'paginate' => $data->links()->render()]);
        }

        /**
         * Update invoice status
         * @param $pid
         */
        public function getUpdateInvoiceStatus($pid)
        {
            $presStatus = (array('status' => 'shipped'));
            Prescription::where('id', '=', $pid)->update($presStatus);
            $in = Invoice::where('pres_id', '=', $pid)->first();
            $id = $in['id'];
            $inv = Invoice::select('date_created')->where('id', '=', $id)->first();
            $findTo = DB::table('invoice')->join('prescription', 'prescription.id', '=', 'invoice.pres_id')->join('users', 'users.id', '=', 'prescription.user_id')->where('invoice.id', '=', $id)->first();
            $userType = intval($findTo->user_type_id);
            if ($userType == 2) {
                $mprof = MedicalProfessional::select('prof_first_name', 'prof_last_name', 'prof_address', 'prof_phone', 'prof_mail', 'prof_pincode')->where('prof_id', '=', $findTo->user_id)->first();
                $detail = array('fname' => $mprof->prof_first_name, 'lname' => $mprof->prof_last_name, 'addr' => $mprof->prof_address, 'ph' => $mprof->prof_phone, 'mail' => $mprof->prof_mail, 'pin' => $mprof->prof_pincode);
            } else if ($userType == 3) {
                $cust = Customer::select('cust_first_name', 'cust_last_name', 'cust_address', 'cust_phone', 'cust_mail', 'cust_pincode')->where('cust_id', '=', $findTo->user_id)->first();
                $detail = array('fname' => $cust->cust_first_name, 'lname' => $cust->cust_last_name, 'addr' => $cust->cust_address, 'ph' => $cust->cust_phone, 'mail' => $cust->cust_mail, 'pin' => $cust->cust_pincode);

            }
            $tbody = "";
            $i = 1;
            $item = ItemList::where('invoice_number', '=', $id)->get();
            $total = 0;
            $shipping = Invoice::where('id', '=', $id)->first()->shipping;
            if (empty($shipping))
                $shipping = 0;
            $total += $shipping;
            $discount = 0;
            $medicines = Medicine::medicines();
            foreach ($item as $itemList) {
                $total += $itemList->qty * $itemList->unit_price;
                foreach ($medicines as $medItem) {
                    if ($medItem['data'] == $itemList->item_code) {
                        $discount += $medItem['discount'] * $itemList->qty * $itemList->unit_price / 100;
                        break;
                    }
                }
                $tbody .= "<tr>
				    <td>" . $i++ . "</td>
				    <td>" . $itemList->item_name . "</td>
				    <td>" . $itemList->qty . "</td>
				    <td>₹" . $itemList->unit_price . "</td>
				    <td>₹" . $itemList->qty * $itemList->unit_price . "</td>
		        	 </tr>";
            }
            $tbody .= "<tr>
		            <td colspan='4' class='text-right no-border'><strong>Shipping</strong></td>
		            <td>₹" . $shipping . "</td>
		          </tr>
		  	  <tr>
		            <td colspan='4' class='text-right no-border'><strong>Sub Total</strong></td>
		            <td><strong>₹" . $total . "</strong></td>
		          </tr>

		          <tr>
		            <td colspan='4' class='text-right no-border'><strong>Discount</strong></td>
		            <td>₹" . $discount . "</td>
		          </tr>
		          <tr>
		            <td colspan='4' class='text-right no-border'><strong>Total</strong></td>
		            <td><strong>₹" . ($total - $discount) . "</strong></td>
		          </tr>";
            $email = $detail['mail'];
            try {
                Mail::send('emails.invoice', array("id" => 'EZ' . (1000000 + $id), 'date' => $inv['date_created'], 'details' => $detail, 'orderDate' => $findTo->path, 'invID' => $id, 'tbody' => $tbody), function ($message) use ($email) {
                    $message->to($email)->subject('Invoice');
                });

            } catch (Exception $e) {
                $e->getMessage();
            }
        }

        /**
         * Delete Medicine List
         * @param $id
         * @return mixed
         */
        public function getMedicineDelete($id)
        {
            $medicine = Medicine::find($id);
            $medicine->is_delete = 1;
            $medicine->save();
            Cache::forget(CACHE_PARAM_MEDICINE);

            return Redirect::to('admin/load-medicines');
        }

        /**
         * Load Invoice
         * @param $id
         * @return mixed
         */
        public function getLoadInvoice($id)
        {
            $invoice = Invoice::find($id);
            $userType = intval($invoice->getUser->user_type_id);
            if ($userType == UserType::MEDICAL_PROFESSIONAL()) {
                $mprof = MedicalProfessional::select('prof_first_name', 'prof_last_name', 'prof_address', 'prof_phone', 'prof_mail', 'prof_pincode')->find($invoice->getUser->user_id);
                $detail = array('fname' => $mprof->prof_first_name, 'lname' => $mprof->prof_last_name, 'addr' => $mprof->prof_address, 'ph' => $mprof->prof_phone, 'mail' => $mprof->prof_mail, 'pin' => $mprof->prof_pincode);
            } else if ($userType == UserType::Customer()) {
                $cust = Customer::select('first_name', 'last_name', 'address', 'phone', 'mail', 'pincode')->find($invoice->getUser->user_id);
                $detail = array('fname' => $cust->first_name, 'lname' => $cust->last_name, 'addr' => $cust->address, 'ph' => $cust->phone, 'mail' => $cust->mail, 'pin' => $cust->pincode);
            }
            $status = InvoiceStatus::statusName($invoice->status_id);

            return View::make('admin.loadinv', array("id" => $invoice->invoice, 'date' => $invoice->created_at, 'details' => $detail, 'orderDate' => $invoice->created_at, 'status' => InvoiceStatus::statusName($invoice->status_id), 'invID' => $id,));
        }

        /**
         * List Invoice items
         * @param $id
         * @return mixed
         */
        public function getLoadInvoiceItems($id)
        {
            $tbody = "";
            $i = 1;
            $invoice = Invoice::find($id);
            $items = $invoice->cartList();
            $total = 0;
            if (empty($shipping))
                $shipping = 0;
            //$total += $shipping;
            $discount = 0;
            foreach ($items as $itemList) {
//                dd($itemList);
                $medicine = Medicine::medicines($itemList->medicine);
                $tbody .= "<tr>
				    <td>" . $i++ . "</td>
				    <td>" . $medicine['item_name'] . "</td>
				    <td class='text-right'>" . $itemList->quantity . "</td>
				    <td class='text-right'>" . number_format($itemList->unit_price, 2) . "</td>
				    <td class='text-right' >" . number_format($itemList->quantity * $itemList->unit_price, 2) . "</td>
				    <td class='text-right'>" . number_format($itemList->discount_percentage, 2) . "</td>
				    <td class='text-right'>" . number_format($itemList->discount, 2) . "</td>
				    <td class='text-right'>" . number_format($itemList->total_price, 2) . "</td>
		        	 </tr>";
            }
            $tbody .= "
		  	        <tr>
		            <td colspan='7' class='text-right no-border'><strong>Price Total</strong></td>
		            <td class='text-right'><strong>" . Setting::currencyFormat($invoice->sub_total) . "</strong></td>
		          </tr>
		          <tr>
		            <td colspan='7' class='text-right no-border'><strong>Discount</strong></td>
		            <td class='text-right'>" . Setting::currencyFormat($invoice->discount) . "</td>
		          </tr>
		          <tr>
		            <td colspan='7' class='text-right no-border'><strong>Shipping</strong></td>
		            <td class='text-right'>" . Setting::currencyFormat($invoice->shipping) . "</td>
		          </tr>
		          <tr>
		            <td colspan='7' class='text-right no-border'><strong>Total</strong></td>
		            <td class='text-right'><strong>" . Setting::currencyFormat($invoice->total) . "</,2)strong></td>
		          </tr>";

            return Response::json(['tbody' => $tbody]);

        }

        /**
         * Customer Delete
         * @param $cust_id
         * @return mixed
         */
        public function getCustomerDelete($cust_id)
        {
            $customer = Customer::find($cust_id);
            $user = $customer->user();
            // Customer Save
            $customer->is_delete = 1;
            $customer->save();
            // User Save
            $user->user_status = UserStatus::INACTIVE();
            $user->save();

            return Redirect::to('admin/load-customers');
        }

        /**
         * Medical Professional Delete
         * @param $prof_id
         * @return mixed
         */
        public function getMprofDelete($prof_id)
        {
            $medicalProfessional = MedicalProfessional::find($prof_id);
            $user = $medicalProfessional->user();
            // Professional Save
            $medicalProfessional->prof_is_delete = 1;
            $medicalProfessional->save();
            // User Save
            $user->user_status = UserStatus::INACTIVE();
            $user->save();

            return Redirect::to('admin/load-medicalprof');
        }

        /**
         * Add Medicine Screen
         * @return mixed
         */
        public function getAddMed()
        {
            return View::make("admin.addmedicine");
        }

        /**
         * Edit Medicine Screen
         * @param $id
         * @return mixed
         */
        public function getMedicineEdit($id)
        {
            $medicine = Medicine::where('id', '=', $id)->get()->first();

            return View::make("admin.addmedicine")->with('details', $medicine);
        }

        /**
         * Password reset
         * @return mixed
         */
        public function getReset()
        {
            return View::make("admin.reset");
        }

        /**
         * Admin reset password
         * @param $md
         * @return mixed
         */
        public function getAdminResetPassword($md)
        {
            return View::make("admin.reset-reset-password", array("md" => $md));
        }

        /**
         * Prescription Edit
         * @param $pres_id
         * @param $status
         * @return mixed
         */
        public function getPresEdit($pres_id, $status)
        {
            $pres = Prescription::find($pres_id);
            $invoice = $pres->getInvoice;
            if (!is_null($invoice) && ($invoice->status_id == InvoiceStatus::PAID() && $status == PrescriptionStatus::UNVERIFIED())) {
                return Redirect::to('admin/pres-edit/' . $pres_id . '/0');
            }
            $shipping = 0;
            $medicines = Medicine::medicines();
            $setting = Setting::param('site', 'discount')['value'];
            $discounts = floatval(Setting::param('site', 'discount')['value']);
            $items = [];
            $invoice_id = 0;
            if (!is_null($invoice)) {
                $invoice_id = $invoice->id;
                $items_list = ItemList::where('invoice_id', '=', $invoice_id)->where('is_removed', '=', 0)->get();
                $items = [];
                foreach ($items_list as $item) {
                    $items[] = [
                        'cart_id' => $item->id,
                        'item_id' => $item->medicine,
                        'item_name' => $item->medicine_details()->item_name,
                        'unit_price' => $item->unit_price,
                        'discount' => $item->discount,
                        'unit_disc' => $item->discount_percentage,
                        'total_price' => $item->total_price,
                        'quantity' => $item->quantity,
                        'item_code' => $item->medicine_details()->item_code
                    ];
                }
                $shipping = $invoice->shipping;
            }

            return View::make("admin.presedit", array("shipping" => $shipping, "pres_id" => $pres_id, "email" => $pres->getUser->email, "path" => $pres->path, 'items' => $items, 'invoice_id' => $invoice_id, 'discount' => $discounts, 'status' => $status));
        }

        /**
         * Update Invoice
         * @return mixed
         */
        public function postUpdateInvoice()
        {
            if(!$this->isCsrfAccepted())
                return Redirect::back()->withErrors(['Invalid Request']);

            $got = Input::all();
            $sub_total = $discount = $total_price = $overall_discount = $shipping = 0;
            $overall_discount = Input::get('overall_disc', 0.00);
            $shipping = Input::get('shipping', 0.00);
            $prescription = Prescription::find($got['pres_id']);
            $type = $prescription->getUser->user_type_id;
            $user_id = $prescription->getUser->id;
            // Check if Cart Is Not Empty
            if (empty($got['item_code1'])) {
                return Redirect::back()->withErrors(['No items added to the cart']);
            }
            if (!empty($got['invoice_id'])) {       // If Invoice Already Exists
                $i = 1;
                $items = ItemList::where('invoice_id', '=', $got['invoice_id'])->get();
                while ($i <= $got['itemS']) {
                    $discount += $got['discount' . $i];
                    $sub_total += $got['total_price' . $i];
                    $alreadyIn = 0;
                    foreach ($items as $item) {     // Update already Existings Cart
                        if ($got['item_code' . $i] == $item->medicine) {
                            $itemUpdate = ['quantity' => $got['qty' . $i],
                                'unit_price' => $got['pricee' . $i],
                                'total_price' => $got['total_price' . $i],
                                'discount_percentage' => $got['unit_discount' . $i],
                                'discount' => $got['discount' . $i],
                                'updated_at' => date('Y-m-d H:i:s'),
                                'updated_by' => Auth::user()->id
                            ];
                            ItemList::where('invoice_id', '=', $got['invoice_id'])->where('medicine', '=', $got['item_code' . $i])->update($itemUpdate);
                            $alreadyIn = 1;
                            break;
                        }
                    }
                    if ($alreadyIn == 0) {
                        $newItem = new ItemList;
                        $newItem->invoice_id = $got['invoice_id'];
                        $newItem->medicine = $got['item_code' . $i];
                        $newItem->quantity = $got['qty' . $i];
                        $newItem->unit_price = $got['pricee' . $i];
                        $newItem->total_price = $got['total_price' . $i];
                        $newItem->discount_percentage = $got['unit_discount' . $i];
                        $newItem->discount = $got['discount' . $i];
                        $newItem->created_at = date('Y-m-d H:i:s');
                        $newItem->created_by = Auth::user()->id;
                        $newItem->save();
                    }
                    $i++;
                }
                // Calculate Total Price of Invoice
                $total_price = $sub_total + $shipping - $overall_discount;
                $invoice = Invoice::find($got['invoice_id']);
                $invoice->invoice = INVOICE_PREFIX . (10000 + $got['invoice_id']);
                $invoice->updated_at = date("Y-m-d H:i:s");
                $invoice->sub_total = $sub_total;
                $invoice->total = $total_price;
                $invoice->shipping = $shipping;
                $invoice->discount = $overall_discount;
                $invoice->updated_by = Auth::user()->id;
                $invoice->updated_at = date('Y-m-d H:i:s');
                $invoice->save();

            } else {
                //while($i<=$got['itemS']){
                $i = 1;
                $invoice = new Invoice;
                $invoice->pres_id = $got['pres_id'];
                $invoice->user_id = $user_id;
                $invoice->created_at = date("Y-m-d H:i:s");
                $invoice->created_by = Auth::user()->id;
                $invoice->save();
                while ($i <= $got['itemS']) {
                    // Calculate Prices
                    $sub_total += $got['sub_total' . $i];
                    $discount += $got['discount' . $i];
                    $total_price += $got['total_price' . $i];
                    // Add Items
                    $newItem = new ItemList;
                    $newItem->invoice_id = $invoice->id;
                    $newItem->medicine = $got['item_code' . $i];
                    $newItem->quantity = $got['qty' . $i];
                    $newItem->unit_price = $got['pricee' . $i];
                    $newItem->total_price = $got['total_price' . $i];
                    $newItem->discount_percentage = $got['unit_discount' . $i];
                    $newItem->discount = $got['discount' . $i];
                    $newItem->created_at = date('Y-m-d H:i:s');
                    $newItem->created_by = Auth::user()->id;
                    $newItem->save();
                    $i++;

                }
                $total_price = $sub_total + $shipping - $overall_discount;
                // Update Other Columns
                $invoice->invoice = INVOICE_PREFIX . (10000 + $invoice->id);
                $invoice->sub_total = $sub_total;
                $invoice->total = $total_price;
                $invoice->shipping = $shipping;
                $invoice->discount = $overall_discount;
                $invoice->save();
            }
            // To Delete Items From Cart
            if (isset($got['todelete']) && !empty($got['todelete'])) {
                $todelete = explode(",", $got['todelete']);
                foreach ($todelete as $item) {
                    ItemList::where('invoice_id', '=', $invoice->id)->where('medicine', '=', $item)->update(['is_removed' => 1]);
                }
            }
            // Select User Types
            if ($type == UserType::CUSTOMER()) {
                $user = Customer::find($prescription->getUser->user_id);
                $user_email = $user->mail;
                $user_name = $user->first_name;
            } elseif ($type == UserType::MEDICAL_PROFESSIONAL()) {
                $user = MedicalProfessional::find($prescription->getUser->user_id);
                $user_email = $user->prof_mail;
                $user_name = $user->prof_first_name;
            }
            // Save Prescription Status
            $prescription->status = PrescriptionStatus::VERIFIED();
            $prescription->updated_by = Auth::user()->id;
            $prescription->updated_at = date('Y-m-d H:i:s');
            $status = $prescription->save();
            // Send Mail
            Mail::send('emails.verify', array('name' => $user_name), function ($message) use ($user_email) {
                $message->to($user_email)->subject('Your prescription verified by ' . Setting::param('site', 'app_name')['value']);
            });

            return Redirect::to("/admin/load-all-prescription");
        }

        /**
         * Change Admin Password
         * @return mixed
         */
        public function anyAdminChangePassword()
        {
            $email = Input::get('email');
            $md = Input::get('mdofemail');
            if ($md != md5($email)) {
                return Redirect::to("admin/admin-reset-password/" . $md)->with('passwordError', 'Token Mismatch');
            } else {
                $edit = array('password' => Hash::make(Input::get('password')));
                User::where('email', '=', $email)->update($edit);

                return Redirect::to("admin");
            }
        }

        /**
         * Password Reset
         * @return mixed
         */
        public function postResetPassword()
        {
            $email = Input::get('email');
            if (Admin::where('email', '=', $email)->count() == 0) {
                return Redirect::to("admin/reset")->with('message', 'You are not an Admin');
            } else {
                Mail::send('admin.forgotusername', array('email' => $email, 'email' => $email), function ($message) use ($email) {
                    $message->to($email)->subject('Forgot Admin Password');
                });

                return Redirect::to("admin/reset")->with('message', 'Please Check your email');
            }
        }

        /**
         * Get Dashboard Notification
         * @return mixed
         */
        public function getTodayPresDash()
        {
            // Get Pending Prescription List
            $pres = Prescription::select('prescription.status', 'prescription.created_at', 'email', 'path', 'prescription.id as pres_id')
                ->join('users', 'users.id', '=', 'prescription.user_id')
                ->where('prescription.status', '=', PrescriptionStatus::UNVERIFIED())
                ->where('prescription.is_delete', '=', 0)
                ->orderBy('prescription.id', 'DESC')
                ->where('path', '>=', strtotime('today midnight'));                                                     // Path is saved as time stamp.
            $i = 0;
            $notif = '<div class="panel-heading b-b">

		         <strong>You have ' . $pres->count() . ' new Prescription(s)</strong>
		         </div>';
            foreach ($pres->get() as $press) {
                if ($press->status == 'active' || $press->status == 'shipped' || $press->status == 'paid') {
                    $status = 'label label-info';
                    $url_status = 0;
                } else {
                    $status = "";
                    $url_status = 1;
                }
                $date = "";
                if ($press->path != "") {
                    $date = date("h:i A", strtotime($press->created_at));
                } else
                    if ($press->status == 'shipped')
                        $status = 'label bg-success';
                    else
                        $status = 'label bg-danger';
                $notif .= "
			  <a href='../admin/pres-edit/$press->pres_id/$url_status'>
			  <div class='panel-heading b-b'>
				 <span class='media-body block m-b-none' >" .
                    $press->email . "</br>"
                    . "<small class='text-muted'>" . $date . "</small>
				 </span>
				 <span class='" . $status . "'>" . ucfirst($press->status) . "</span>
			   </div>
			 </a>";
            }

            return Response::json(['notif' => $notif, 'todaysCount' => $pres->count()]);
        }

        /**
         * Get Dashboard Details
         * @return mixed
         */
        public function getDashOrd()
        {
            $shipping = DB::table('invoice')->select(DB::raw('count(*) as shipped'))->where('shipping_status', '=', ShippingStatus::SHIPPED());
            $paid = DB::table('invoice')->select(DB::raw('count(*) as paid'))->where('status_id', '=', InvoiceStatus::PAID())->whereIn('shipping_status', [0, ShippingStatus::NOTSHIPPED()]);
            $customer = DB::table('customer')->select(DB::raw('count(*) as customer'))->where('is_delete', '=', 0);
            $counts = DB::table('ed_professional')->select(DB::raw('count(*) as count'))->where('prof_is_delete', '=', 0)->unionAll($shipping)->unionAll($customer)->unionAll($paid)->get();

            return Response::json(['prof' => $counts[0]->count, 'shipped' => $counts[1]->count, 'cust' => $counts[2]->count, 'tobe' => $counts[3]->count]);
        }

        /**
         * Get Dashboard details
         * @return mixed
         */
        public function getDashDetail()
        {
            // Get Details Count
            $medicine = DB::table('medicine')->select(DB::raw('COUNT(*) as count'))->where('is_delete', '=', 0);
            $active_user = DB::table('users')->select(DB::raw('COUNT(*) as count'))->where('user_status', '<>', UserStatus::INACTIVE());
            $counts = DB::table('prescription')->select(DB::raw('COUNT(*) as count'))->where('status', '=', PrescriptionStatus::VERIFIED())->unionAll($medicine)->unionAll($active_user)->get();
            $rev = $mr = $disc_total = 0.0;
            $sales_details = Invoice::select(DB::raw("count(*) as total_sales,SUM(total) as total_revenue,(SELECT count(*) as monthly_sales FROM invoice where created_at BETWEEN '" . date('Y-m-01 00:00:00') . "' AND NOW() AND status_id = " . InvoiceStatus::PAID() . ") as monthly_count,(SELECT SUM(total) as monthly_revenue FROM invoice where created_at BETWEEN '" . date('Y-m-01 00:00:00') . "' AND NOW() AND status_id = " . InvoiceStatus::PAID() . ") as monthly_revenue"))
                ->where('status_id', '=', InvoiceStatus::PAID())->first();

            return Response::json(['pres' => $counts[0]->count,
                'med' => $counts[1]->count,
                'user' => $counts[2]->count,
                'rev' => is_null($sales_details->total_revenue) ? Setting::currencyFormat(0.00) : Setting::currencyFormat($sales_details->total_revenue),
                'mp' => is_null($sales_details->monthly_count) ? 0 : $sales_details->monthly_count,
                'mr' => is_null($sales_details->monthly_revenue) ? Setting::currencyFormat(0.00) : Setting::currencyFormat($sales_details->monthly_revenue)]);
        }

        /**
         * Add New Medicines
         * @return mixed
         */
        public function postNewMed()
        {
            if (!$this->isCsrfAccepted())
                return Redirect::to('admin/add-med')->with('message', 'Bad Request');


            $input = Input::all();
            if ($input['id'] == "") {
                $medicine = new Medicine;
                $medicine->item_code = $input['item_code'];
                $medicine->item_name = $input['item_name'];
                $medicine->batch_no = $input['batch_no'];
                $medicine->quantity = $input['quantity'];
                $medicine->cost_price = $input['cost_price'];
                $medicine->purchase_price = $input['purchase_price'];
                $medicine->rack_number = $input['rack_number'];
                $medicine->selling_price = $input['selling_price'];
                $medicine->expiry = date('Y-m-d', strtotime($input['expiry']));
                $medicine->tax = $input['tax'];
                $medicine->composition = $input['composition'];
                $medicine->discount = $input['discount'];
                $medicine->manufacturer = $input['manufacturer'];
                $medicine->group = $input['group'];
                $medicine->save();

            } else {
                $edit = array('item_code' => $input['item_code'],
                    'item_name' => $input['item_name'],
                    'batch_no' => $input['batch_no'],
                    'quantity' => $input['quantity'],
                    'cost_price' => $input['cost_price'],
                    'purchase_price' => $input['purchase_price'],
                    'rack_number' => $input['rack_number'],
                    'selling_price' => $input['selling_price'],
                    'expiry' => date('Y-m-d', strtotime($input['expiry'])),
                    'tax' => $input['tax'],
                    'discount' => $input['discount'],
                    'manufacturer' => $input['manufacturer'],
                    'group' => $input['group'],
                    'composition' => $input['composition']
                );
                $affectedRows = Medicine::where('id', '=', $input['id'])->update($edit);
            }
            // Clear Cache for the medicine...
            Cache::forget(CACHE_PARAM_MEDICINE);

            return Redirect::to('admin/load-medicines');

        }

        /**
         * Load Medicines List
         * @return mixed
         */
        public function anyLoadMedicineWeb()
        {
            header("Access-Control-Allow-Origin: *");
            $key = Input::get('query', '');
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
            $medicines = array_slice($medicines, 0, 10);
            $result = array('suggestions' => $medicines);

            return Response::json($result);
        }

        /**
         * Clean url functions
         * @param $string
         * @return mixed
         */
        function stringClean($string)
        {
            return preg_replace('/[-" "`*().]/', '', $string);
        }

        /**
         * Get all prescriptions
         * @return mixed
         */
        public function anyAllPrescription()
        {
            $data = DB::table('prescription')->select('prescription.status', 'users.email', 'prescription.path', 'prescription.pres_id', 'invoice.status', 'invoice.id')
                ->leftjoin('users', 'users.id', '=', 'prescription.user_id')
                ->leftjoin('invoice', 'invoice.pres_id', '=', 'prescription.pres_id')
                ->where('prescription.user_id', '<>', "")
                ->where('prescription.is_delete', '=', 0)
                ->paginate(30);

            return View::make('admin.prescriptionlist', ['pres' => $data]);
        }

        /**
         * Load paid prescriptions for admin side
         * @return mixed
         */
        public function anyLoadPaidPrescription()
        {
            $data = DB::table('prescription')->select('prescription.created_at as created_date', 'prescription.status', 'users.email', 'prescription.path', 'prescription.id as pres_id', 'invoice.status_id as in_status', 'invoice.id', 'invoice.invoice', 'invoice.created_at as date_created', 'invoice.shipping_status')
                ->leftjoin('users', 'users.id', '=', 'prescription.user_id')
                ->leftjoin('invoice', 'invoice.pres_id', '=', 'prescription.id')
                ->where('prescription.user_id', '<>', "")
                ->where('invoice.status_id', '=', InvoiceStatus::PAID())
                ->where('prescription.is_delete', '=', 0)
                ->orderBy('prescription.pres_id', 'DESC')
                ->paginate(30);

            return View::make('admin.paid_prescription_list', ['pres' => $data]);
        }

        /**
         * Load paid prescriptions for admin side
         * @return mixed
         */
        public function anyLoadActivePrescription()
        {
            $data = DB::table('prescription')->select('prescription.created_at as created_date', 'prescription.status', 'users.email', 'prescription.path', 'prescription.id as pres_id', 'invoice.status_id as in_status', 'invoice.id', 'invoice.invoice', 'invoice.created_at as date_created')
                ->leftjoin('users', 'users.id', '=', 'prescription.user_id')
                ->leftjoin('invoice', 'invoice.pres_id', '=', 'prescription.id')
                ->where('prescription.user_id', '<>', "")
                ->where('prescription.status', '=', PrescriptionStatus::VERIFIED())
                ->where('invoice.status_id', '!=', InvoiceStatus::PAID())
                ->where('prescription.is_delete', '=', 0)
                ->orderBy('prescription.id', 'DESC')
                ->paginate(30);

            return View::make('admin.active_prescription_list', ['pres' => $data]);
        }

        /**
         * Load paid prescriptions for admin side
         * @return mixed
         */
        public function anyLoadPendingPrescription()
        {
            $data = Prescription::select('prescription.created_at as created_date', 'prescription.status', 'users.email', 'prescription.path', 'prescription.id as pres_id', 'invoice.status_id as in_status', 'invoice.id', 'invoice.created_at as date_created')->where('prescription.is_delete', ' = ', 0)->where('prescription.status', '=', PrescriptionStatus::UNVERIFIED())
                ->leftjoin('users', 'users.id', '=', 'prescription.user_id')
                ->leftjoin('invoice', 'invoice.pres_id', '=', 'prescription.id')
                ->orderBy('prescription.id', 'DESC')
                ->paginate(30);

            return View::make('admin.pending_prescription_list', ['pres' => $data]);
        }

        /**
         * Make an order shipped from admin side
         * @param $pres_id
         * @return mixed
         */
        public function anyShipOrder($pres_id)
        {
            $prescription = Prescription::find($pres_id);
            $invoice = $prescription->getInvoice;
            $userDetails = $prescription->getUser;
            // Save Invoice Details
            $invoice->shipping_status = ShippingStatus::SHIPPED();
            $invoice->updated_at = date('Y-m-d H:i:s');
            $invoice->updated_by = Auth::user()->id;
            $invoice->save();
            // Send Mail
            $type = $userDetails->user_type_id;
            if ($type == UserType::CUSTOMER()) {
                $user = Customer::find($userDetails->user_id);
                $user_email = $user->mail;
                $user_name = $user->first_name;
            } elseif ($type == UserType::MEDICAL_PROFESSIONAL()) {
                $user = MedicalProfessional::find($userDetails->user_id);
                $user_email = $user->prof_mail;
                $user_name = $user->prof_first_name;
            }
            Mail::send('emails.shipped', array('name' => $user_name), function ($message) use ($user_email) {
                $message->to($user_email)->subject('Your item shipped from ' . Setting::param('site', 'app_name')['value']);
            });

            return Redirect::to('admin/load-paid-prescription');
        }

        /**
         * Load paid prescriptions for admin side
         * @return mixed
         */
        public function anyLoadShippedPrescription()
        {
            $data = DB::table('prescription')->select('prescription.created_at as created_date', 'prescription.status', 'users.email', 'prescription.path', 'prescription.id as pres_id', 'invoice.status_id as in_status', 'invoice.id', 'invoice.created_at as date_created', 'invoice')
                ->leftjoin('users', 'users.id', '=', 'prescription.user_id')
                ->leftjoin('invoice', 'invoice.pres_id', '=', 'prescription.id')
                ->where('prescription.user_id', '<>', "")
                ->where('invoice.shipping_status', '=', ShippingStatus::SHIPPED())
                ->where('prescription.is_delete', '=', 0)
                ->orderBy('prescription.id', 'DESC')
                ->paginate(30);

            return View::make('admin.shipped_prescription_list', ['pres' => $data]);
        }

        /**
         * Load all prescriptions
         * @return mixed
         */
        public function anyLoadAllPrescription()
        {
            $data = DB::table('prescription')->select('prescription.created_at as created_date', 'prescription.status', 'users.email', 'prescription.path', 'prescription.id as pres_id', 'invoice.status_id as in_status', 'invoice.id', 'invoice.created_at as date_created', 'invoice', 'shipping_status')
                ->leftjoin('users', 'users.id', '=', 'prescription.user_id')
                ->leftjoin('invoice', 'invoice.pres_id', '=', 'prescription.id')
                ->where('prescription.user_id', '<>', "")
                ->where('prescription.is_delete', '=', 0)
                ->orderBy('prescription.id', 'DESC')
                ->paginate(30);

            return View::make('admin.all_prescription_list', ['pres' => $data]);
        }

        /**
         * Load Deleted prescriptions
         * @return mixed
         */
        public function anyLoadDeletedPrescription()
        {
            $data = DB::table('prescription')->select('prescription.created_at as created_date', 'prescription.status', 'users.email', 'prescription.path', 'prescription.id as pres_id', 'invoice.status_id as in_status', 'invoice.id', 'invoice.created_at as date_created', 'invoice')
                ->leftjoin('users', 'users.id', '=', 'prescription.user_id')
                ->leftjoin('invoice', 'invoice.pres_id', '=', 'prescription.id')
                ->where('prescription.user_id', '<>', "")
                ->where('prescription.is_delete', '=', 1)
                ->orderBy('prescription.id', 'DESC')
                ->paginate(30);

            return View::make('admin.deleted_prescription_list', ['pres' => $data]);
        }

        /**
         * Delete a particular prescription
         * @param $pres_id
         */
        public function anyPresDelete($pres_id, $status)
        {
            try {
                if (!Auth::check())
                    throw new Exception('UNAUTHORISED : User not logged in ', 401);
                $pay_success2 = DB::table('prescription')->where('id', '=', $pres_id)->update(array('is_delete' => 1, 'updated_at' => date('Y-m-d H:i:s')));
                // If Save is Success
                if ($pay_success2)
                    return Response::json(['status' => 'SUCCESS', 'msg' => 'Prescription Deleted Successfully'], 200);

            } catch (Exception $e) {
                return Response::json(['status' => 'FAILURE', 'msg' => $e->getMessage()], $e->getCode());
            }
        }

        /**
         * Publish one customer
         * @param $id
         * @return mixed
         */
        public function getUserChangeStatus($id)
        {
            $user = User::where('user_id', '=', $id)->where('user_type_id', '=', UserType::CUSTOMER());
            $user->update(array('user_status' => UserStatus::ACTIVE()));

            return Redirect::to('admin/load-customers');
        }

        /**
         * Publish one professional
         * @param $id
         * @return mixed
         */
        public function getProfChangeStatus($id)
        {
            $user = User::where('user_id', '=', $id)->where('user_type_id', '=', UserType::MEDICAL_PROFESSIONAL());
            $user->update(array('user_status' => UserStatus::ACTIVE()));

            return Redirect::to('admin/load-medicalprof');
        }

        /**
         * Load Prescription by user email search
         * @return mixed
         */
        public function getLoadPresEmail()
        {
            $email = Input::get('email');
            $status = Input::get('status');
            if ($email != "")
                $pres = DB::table('prescription')
                    ->select('prescription.created_at as created_date', 'prescription.id as pres_id', 'users.email', 'invoice.invoice', 'invoice.shipping_status')
                    ->join('users', 'users.id', '=', 'prescription.user_id')
                    ->leftJoin('invoice', 'invoice.pres_id', '=', 'prescription.id')
                    ->where('users.email', 'like', $email . '%')
                    ->where('prescription.is_delete', '=', 0)
                    ->orderBy('prescription.id', 'DESC');
            else
                $pres = DB::table('prescription')
                    ->select('prescription.created_at as created_date', 'prescription.id as pres_id', 'users.email', 'invoice.invoice', 'invoice.shipping_status')
                    ->join('users', 'users.id', '=', 'prescription.user_id')
                    ->leftJoin('invoice', 'invoice.pres_id', '=', 'prescription.id')
                    ->where('prescription.is_delete', '=', 0)
                    ->orderBy('prescription.id', 'DESC');
            switch ($status) {
                case 'paid':
                    $pres->where('invoice.status_id', '=', InvoiceStatus::PAID());
                    break;
                case 'unverified':
                    $pres->where('prescription.status', '=', PrescriptionStatus::UNVERIFIED());
                    break;
                case 'verified':
                    $pres->where('prescription.status', '=', PrescriptionStatus::VERIFIED());
                    break;
            }

            return Response::json($pres->get());
        }

        /**
         * load deleted prescriptions based on email
         * @return mixed
         */
        public function getLoadDeletedPresEmail()
        {
            $email = Input::get('email');
            $status = Input::get('status');
            if ($email != "")
                $pres = DB::table('prescription')
                    ->select('prescription.created_at as created_date', 'prescription.id as pres_id', 'users.email')
                    ->join('users', 'users.id', '=', 'prescription.user_id')
                    ->where('users.email', 'like', $email . '%')
                    ->where('prescription.is_delete', '=', 1)
                    ->orderBy('prescription.id', 'DESC')
                    ->get();
            else
                $pres = DB::table('prescription')
                    ->select('prescription.created_at as created_date', 'prescription.id as pres_id', 'users.email')
                    ->join('users', 'users.id', '=', 'prescription.user_id')
                    ->where('prescription.is_delete', '=', 1)
                    ->orderBy('prescription.id', 'DESC')
                    ->get();

            return Response::json($pres);
        }

        /**
         * load deleted prescriptions based on email
         * @return mixed
         */
        public function getLoadAllPresEmail()
        {
            $email = Input::get('email');
            $status = Input::get('status');
            if ($email != "")
                $pres = DB::table('prescription')
                    ->select('prescription.created_at as created_date', 'prescription.status as pstatus', 'prescription.id as pres_id', 'users.email', DB::raw('IF(invoice IS NULL,"",invoice) as invoice'), 'invoice.status_id', 'shipping_status as s_status', DB::raw('IF(s_s.name IS NULL,"NOT SHIPPED",s_s.name) as ship_status'), DB::raw('IF(i_s.name IS NULL,"Invoice Not Created",i_s.name) as invoice_status'), 'p_s.name as pres_status')
                    ->join('users', 'users.id', '=', 'prescription.user_id')
                    ->leftJoin('invoice', 'invoice.pres_id', '=', 'prescription.id')
                    ->leftJoin('invoice_status as i_s', 'i_s.id', '=', 'invoice.status_id')
                    ->leftJoin('prescription_status as p_s', 'p_s.id', '=', 'prescription.status')
                    ->leftJoin('shipping_status as s_s', 's_s.id', '=', 'invoice.shipping_status')
                    ->where('users.email', 'like', $email . '%')
                    ->where('prescription.is_delete', '=', 0)
                    ->orderBy('prescription.id', 'DESC')
                    ->get();
            else
                $pres = DB::table('prescription')
                    ->select('prescription.created_at as created_date', 'prescription.status as pstatus', 'prescription.id as pres_id', 'users.email', DB::raw('IF(invoice IS NULL,"",invoice) as invoice'), 'invoice.status_id', 'shipping_status as s_status', DB::raw('IF(s_s.name IS NULL,"NOT SHIPPED",s_s.name) as ship_status'), DB::raw('IF(i_s.name IS NULL,"Invoice Not Created",i_s.name) as invoice_status'), 'p_s.name as pres_status')
                    ->join('users', 'users.id', '=', 'prescription.user_id')
                    ->leftJoin('invoice', 'invoice.pres_id', '=', 'prescription.id')
                    ->leftJoin('invoice_status as i_s', 'i_s.id', '=', 'invoice.status_id')
                    ->leftJoin('prescription_status as p_s', 'p_s.id', '=', 'prescription.status')
                    ->leftJoin('shipping_status as s_s', 's_s.id', '=', 'invoice.shipping_status')
                    ->where('prescription.is_delete', '=', 0)
                    ->orderBy('prescription.id', 'DESC')
                    ->get();

            return Response::json($pres);
        }

        /**
         * load requested medicines for admin panel
         * @return mixed
         */
        public function getLoadNewMedicines()
        {
            $medicine_list = NewMedicine::where('is_delete', '=', 0)->orderBy('id', 'DESC')->paginate(30);

            return View::make('admin.new_medicine_list', ['pres' => $medicine_list]);
        }

        /**
         * Get the email list who requested a particular medicine
         * @return mixed
         */
        public function getNewMedicineEmail()
        {
            $med = Input::get('med');
            $list = NewMedicineEmail::where('request_id', '=', $med)->groupBy('email')->get();

            return Response::json($list);
        }

        /**
         * Delete a requested medicine from back end
         * @param $mid
         * @return mixed
         */
        public function getDeleteNewMedicine($mid)
        {
            $medicine = NewMedicine::find($mid);
            $medicine->is_delete = 1;
            $medicine->save();

            return Redirect::to('admin/load-new-medicines');
        }
    }
