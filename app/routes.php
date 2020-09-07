<?php

    /*
    |--------------------------------------------------------------------------
    | Application Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register all of the routes for an application.
    | It's a breeze. Simply tell Laravel the URIs it should respond to
    | and give it the Closure to execute when that URI is requested.
    |
    */
    // Home Page
    Route::get('/test', function () {
        $admin = Admin::find(1);
        var_dump($admin->user_details()->first());
    });
    Route::get('/', function () {
        Setting::settings();

        return View::make('users.index');
    });
    // Configuration Screen
    Route::get('/system-setup', function () {
        return View::make('install.index');
    });
    // Cache Clear
    Route::get('/cache', function () {
        Cache::flush();

        return Redirect::back();
    });
    // Logout
    Route::any('logout', function () {
        Auth::logout();

        return Redirect::to('/');
    });
    // About US Page
    Route::get('/about', function () {
        return View::make('/users/about');
    });
    // Contact Us
    Route::get('/contact', function () {
        return View::make('/users/contact');
    });
    // Help Desk
    Route::get('/help-desk', function () {
        return View::make('/users/help_desk');
    });
    Route::get('/success', function () {
        return View::make('/users/payment_success');
    });
    Route::get('/failure', function () {
        return View::make('/users/payment_failed');
    });
    // My Cart
    Route::get('/my-cart', 'MedicineController@getMyCart');
    Route::get('/my-prescription/{option?}', 'MedicineController@getMyPrescription');
    Route::get('/paid-prescription', 'MedicineController@getPaidPrescription');
    Route::get('/my-order', 'MedicineController@getMyOrder');
    Route::get('/medicine-detail/{item_code}', 'MedicineController@getMedicineDetail');
    Route::get('/account-page', 'UserController@getAccountPage');
    // Implicit Controllers
    Route::controller('user', 'UserController');
    Route::controller('medicine', 'MedicineController');
    Route::controller('admin', 'AdminController');
    Route::controller('setting', 'SettingController');
    /*
    |--------------------------------------------------------------------------
    | Admin Related Pages
    |--------------------------------------------------------------------------
    |
    | All Admin Accessible Pages
    |
    */
    Route::any('load-prescription', function () {
        return View::make('admin.prescriptionlist');
    });
    Route::any('load-prescription', function () {
        return View::make('admin.prescriptionlist');
    });
    Route::any('load-prescription-paid', function () {
        return View::make('admin.prescriptionlistPaid');
    });
    Route::any('load-prescription-shipped', function () {
        return View::make('admin.prescriptionlistShipped');
    });
    Route::any('load-prescription-to-be-paid', function () {
        return View::make('admin.prescriptionlistToBePaid');
    });
    Route::get('admin-login', function () {
        return View::make('admin.signin');
    });
    App::missing(function ($exception) {
        return Response::view('admin.missing', array(), 404);
    });
    /*
    |--------------------------------------------------------------------------
    | Set Up Database Related Migrations / Seeding
    |--------------------------------------------------------------------------
    |
    | Basic Installion of App
    |
    */
    Route::post('/create-db', function () {
        $database = Input::get('name');
        $username = Input::get('username');
        $password = Input::get('password');
        $host = "localhost";
        try {
            $session_token = Session::token();
            $input_token = Input::get('_token');
            if ($session_token != $input_token)
                throw new Exception ('Invalid Request Acceess', 500);

            $dbh = new PDO("mysql:host=$host", $username, $password);
            $status = $dbh->exec("CREATE DATABASE `$database`;");
            if (!$status) {
                $error_info = $dbh->errorInfo();
                throw new PDOException('Database already exists', $error_info[1]);
            } else {
                $file = app_path() . '/config/database.php';
                $file_status = File::exists($file);
                if ($file_status) {
                    $file_content = File::get($file, '');
                    $file_content = str_replace('DB_NAME', $database, $file_content);
                    $file_content = str_replace('DB_USER', $username, $file_content);
                    $file_content = str_replace('DB_PASS', $password, $file_content);
                    File::put($file, $file_content);
                }

                return Response::json(['status' => "SUCCESS", 'msg' => 'Database created. Setting Up Basic Functions, Please be patient...'], 201);
            }


        } catch (PDOException $e) {
            return Response::json(['status' => 'FAILURE', 'code' => $e->getCode()], 500);
        }
    });
    /**
     * Run Migrations
     */
    Route::post('/run-migration', function () {
        try {
            define('STDIN', fopen("php://stdin", "r"));
            Artisan::call('migrate', ['--quiet' => true, '--force' => true]);

            return Response::json(['status' => "SUCCESS", 'msg' => 'Database Migrated Successfully'], 201);

        } catch (Exception $e) {
            return Response::json(['status' => 'FAILURE', 'code' => $e->getCode()]);
        }
    });
    /**
     * Seeding Database
     */
    Route::post('/run-seeder', function () {
        try {
            define('STDIN', fopen("php://stdin", "r"));
            Artisan::call('db:seed', ['--quiet' => true, '--force' => true]);

            return Response::json(['status' => "SUCCESS", 'msg' => 'Database Seeded Successfully'], 201);

        } catch (Exception $e) {
            return Response::json(['status' => 'FAILURE', 'code' => $e->getCode()]);
        }
    });
