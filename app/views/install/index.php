<html>
<head>
<title>Basic Configuration</title>
<script src="<?php echo url(); ?>/assets/javascripts/jquery-1.10.2.js"></script>
<script src="<?php echo url(); ?>/assets/javascripts/jquery-ui.js"></script>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<style>
@import url(https://fonts.googleapis.com/css?family=Roboto:300);

.login-page {
    width: 360px;
    padding: 8% 0 0;
    margin: auto;
}

input:focus, input:active, a:focus, a:active, button:focus, button:active {
    border: 0 !important;
    outline: 0 !important;

}

.paymode_div {
    margin-top: 0px !important;
}

/*a:focus, a:active,*/
/*button::-moz-focus-inner,*/
/*input[type="reset"]::-moz-focus-inner,*/
/*input[type="button"]::-moz-focus-inner,*/
/*input[type="submit"]::-moz-focus-inner,input[type="radio"]::-moz-focus-inner,input[type="checkbox"]::-moz-focus-inner,input::-moz-focus-inner,*/
/*select::-moz-focus-inner,*/
/*input[type="file"] > input[type="button"]::-moz-focus-inner {*/
/*border: 0;*/
/*outline : 0;*/
/*}*/
ul {
    list-style-type: none;
}

.payment_class {
    display: none;
}

.radio img {
    height: 30px;
}

.radio input {
    width: 10px !important;
    margin-right: 10px !important;
    position: relative !important;

}

.form {
    /* position: relative; */
    /* z-index: 1; */
    /* background: #FFFFFF; */
    max-width: 360px;
    margin: 0 auto;
    /* padding: 45px; */
    text-align: center;
    /* box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24); */
}

.form input, select {
    font-family: "Roboto", sans-serif;
    outline: 0;
    background: #f2f2f2;
    width: 100%;
    border: 0;
    margin: 0 0 15px;
    padding: 10px;
    box-sizing: border-box;
    font-size: 14px;
}

.form button {
    font-family: "Roboto", sans-serif;
    text-transform: uppercase;
    outline: 0;
    background: #4CAF50;
    width: 100%;
    border: 0;
    padding: 15px;
    color: #FFFFFF;
    font-size: 14px;
    -webkit-transition: all 0.3 ease;
    transition: all 0.3 ease;
    cursor: pointer;
}

.form button:hover, .form button:active, .form button:focus {
    background: #43A047;
}

.form .message {
    margin: 15px 0 0;
    color: #b3b3b3;
    font-size: 12px;
}

.form {
    text-align: left !important;
}

.form .message a {
    color: #4CAF50;
    text-decoration: none;
}

.form .register-form {
    display: block;
}

.container {
    position: relative;
    z-index: 1;
    /*max-width: 300px;*/
    margin: 0 auto;
}

.container:before, .container:after {
    content: "";
    display: block;
    clear: both;
}

.container .info {
    margin: 50px auto;
    text-align: center;
}

.container .info h1 {
    margin: 0 0 15px;
    padding: 0;
    font-size: 36px;
    font-weight: 300;
    color: #1a1a1a;
}

.container .info span {
    color: #4d4d4d;
    font-size: 12px;
}

.container .info span a {
    color: #000000;
    text-decoration: none;
}

.container .info span .fa {
    color: #EF3B3A;
}

body {
    background: #76b852; /* fallback for old browsers */
    background: -webkit-linear-gradient(right, #76b852, #8DC26F);
    background: -moz-linear-gradient(right, #76b852, #8DC26F);
    background: -o-linear-gradient(right, #76b852, #8DC26F);
    background: linear-gradient(to left, #76b852, #8DC26F);
    font-family: "Roboto", sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

#loading_class_gif {
    background: url('<?php echo url(); ?>/assets/images/loader.gif') center no-repeat;
    width: 100%;
    height: 20px;
}

/*= wizard css =*/
.form-wizard {
    float: left;
    width: 100%;
    margin: auto;
    padding: 8% 0 0;
}

.form-wizard li.active {
    position: relative;
    z-index: 1;
}

.wizard-heading {
    float: left;
    width: 100%;
    padding: 10px 15px;
    background-color: #fafafa;
    margin-bottom: 1px;
    box-sizing: border-box;
    font-size: 18px;
    color: #4c4c4c;
    text-transform: uppercase;
    transition: 0.3s;
}

.wizard-content {
    display: none;
    float: left;
    width: 100%;
    background-color: #fff;
    box-shadow: 0 8px 8px #d2d2d2;
    padding: 15px;
    box-sizing: border-box;
}

li:first-child .wizard-content {
    display: block;
}

.wizard-content p {
    margin-bottom: 15px;
    font-size: 15px;
    line-height: 26px;
    color: #4c4c4c;
}

.btn-green {
    color: #fff;
    float: right;
    border: 0;
    padding: 7px 10px;
    min-width: 92px;
    z-index: 1;
    cursor: pointer;
    font-size: 14px;
    text-transform: uppercase;
    background-color: #5fba57;
    border-radius: 3px;
    border-bottom: 3px solid #289422;
    position: relative;
    transition: 0.3s;
}

.btn-green:before {
    content: "";
    width: 100%;
    height: 0;
    border-radius: 3px;
    z-index: -1;
    position: absolute;
    left: 0;
    bottom: 0;
    background-color: #289422;
    transition: 0.3s;
}

.btn-green:hover:before {
    height: 100%;
}

.wizard-heading span {
    float: right;
    background-image: url(<?php echo url(); ?>/assets/images/wizard-icons.png);
    background-repeat: no-repeat;
}

.icon-user {
    width: 20px;
    height: 18px;
    background-position: 0 -40px;
    margin-top: 4px;
}

.icon-location {
    width: 15px;
    height: 20px;
    background-position: -22px -42px;
    margin-top: 4px;
}

.icon-summary {
    width: 20px;
    height: 20px;
    background-position: -39px -42px;
    margin-top: 4px;
}

.icon-mode {
    width: 20px;
    height: 16px;
    background-position: -61px -34px;
    margin-top: 6px;
}

.active .wizard-heading {
    background-color: #43A047;
    color: #fff;
    margin-bottom: 0;
}

.active .icon-user {
    background-position: 0 0;
}

.active .icon-location {
    background-position: -22px 0;
}

.active .icon-summary {
    background-position: -39px 0;
}

.active .icon-mode {
    background-position: -61px 0;
}

.completed .wizard-heading {
    color: #447294;
    position: relative;
    padding: 10px 15px 10px 36px;
    cursor: pointer;
    transition: 0.3s;
}

.completed .wizard-heading:before {
    content: "✓";
    color: #fff;
    text-align: center;
    font-size: 15px;
    font-weight: bold;
    position: absolute;
    left: -7px;
    top: 8px;
    width: 32px;
    padding: 4px 0;
    background-color: #447294;
    z-index: 99;
}

.completed .wizard-heading:after {
    content: "";
    position: absolute;
    top: 38px;
    left: -7px;
    border-left: 7px solid transparent;
    border-top: 5px solid #001e34;
}

.completed .icon-user {
    background-position: 0 -20px;
}

.completed .icon-location {
    background-position: -22px -21px;
}

.completed .icon-summary {
    background-position: -39px -21px;
}

.completed .icon-mode {
    background-position: -61px -17px;
}

/*= wizard end =*/
</style>
</head>
<body>
<div class="container">
<ul class="form-wizard">
<li class="active" id="database_tab">
    <div class="wizard-heading">
        1. Database Information
        <span class="icon-user"></span>
    </div>
    <div class="wizard-content">
        <p>Create your Database informations here</p>
        <input type="hidden" id="db_name"
               value="<?php echo $db = Config::get('database.connections.mysql.database'); ?>"/>

        <div class="form">
            <?php if ($db == 'DB_NAME') {
                // Define Variables
                $app_name = $logo = $email = $mail_password = $mail_address = $mail_name = $port = $host = $driver = $info_mail = $website = $address = $phone = $discount = $currency = $curr_pos = $transaction_type = $payment_mode = ["value" => "", "type" => ""];
            ?>
            <form id="create-db-form">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="text" class="required-input" placeholder="Database name" id="name" name="name"
                       required="required"/>
                <input type="text" class="required-input" placeholder="Mysql Root Username" id="username"
                       name="username"
                       required="required"/>
                <input type="text" placeholder="Mysql Root Password" id="password" name="password"
                       required="required"/>
            </form>
        </div>
        <button class="btn-green done" type="button" id="create_db">Create Database</button>
        </form>
        <?php
            } else {
            $app_name = Setting::param('site', 'app_name');
            $logo = Setting::param('site', 'logo');
            $info_mail = Setting::param('site', 'mail');
            $phone = Setting::param('site', 'phone');
            $website = Setting::param('site', 'website');
            $address = Setting::param('site', 'address');
            $currency = Setting::param('site', 'currency');
            $curr_pos = Setting::param('site', 'curr_position');
            $email = Setting::param('mail', 'username');
            $mail_password = Setting::param('mail', 'password');
            $mail_address = Setting::param('mail', 'address');
            $mail_name = Setting::param('mail', 'name');
            $port = Setting::param('mail', 'port');
            $host = Setting::param('mail', 'host');
            $driver = Setting::param('mail', 'driver');
            $discount = Setting::param('site', 'discount');
            $payment_mode = Setting::param('payment', 'mode');
            $transaction_type = Setting::param('payment', 'type');

        } ?>
    </div>
</li>
<li id="setting_tab">
    <div class="wizard-heading">
        2. Website Details
        <span class="icon-location"></span>
    </div>
    <div class="wizard-content">
        <p>Customize your App</p>

        <div class="website_errors">
            <div class="alert alert-danger" style="display: none"></div>
        </div>
        <div class="row">
            <div class="form pull-left col-lg-4 col-md-4">
                <form id="create-setting-form" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <label>App Name </label>
                    <input type="text" class="required-input" placeholder="App Name" id="app_name" name="name"
                           value="<?php echo $app_name['value']; ?>" required="required"/>
                    <label>Select Logo </label>
                    <input type="file" class="required-input" placeholder="Logo" id="logo" name="logo"
                           required="required"/>
                    <label>Website URL </label>
                    <input type="text" class="required-input" placeholder="Website url" id="website"
                           name="website"
                           value="<?php echo $website['value']; ?>" required="required"/>
                    <label>Address </label>
                    <input type="text" class="required-input" placeholder="Company location " id="location"
                           name="location"
                           value="<?php echo $address['value']; ?>" required="required"/>
                    <label>Info Mail : (Customer request will be sent to this mail)</label>
                    <input type="text" class="required-input" placeholder="Info Email " id="email" name="email"
                           value="<?php echo $info_mail['value']; ?>" required="required"/>
                    <label>Phone Number</label>
                    <input type="text" class="required-input" placeholder="Phone Number" id="phone" name="phone"
                           value="<?php echo $phone['value']; ?>" required="required"/>
                    <label>Currency</label>
                    <input type="text" class="required-input" placeholder="Currency to be displayed with amount"
                           id="currency" name="currency"
                           value="<?php echo $currency['value']; ?>" required="required"/>
                    <label>Currency Position (before /after the Amount)</label>
                    <select name="curreny_position">
                        <option value="BEFORE"
                            <?php if ($curr_pos['value'] == CURRENCY_BEFORE) echo "selected"; ?>> Before
                        </option>
                        <option value="AFTER" <?php if ($curr_pos['value'] == CURRENCY_AFTER) echo "selected"; ?>>
                            After
                        </option>
                    </select>
                    <label>Time Zone</label>
                    <select class="required-input" id="timezone" name="timezone">
                        <option value="UTC">UTC (default)</option>
                        <option value="Pacific/Midway">(GMT-11:00) Midway Island, Samoa</option>
                        <option value="America/Adak">(GMT-10:00) Hawaii-Aleutian</option>
                        <option value="Etc/GMT+10">(GMT-10:00) Hawaii</option>
                        <option value="Pacific/Marquesas">(GMT-09:30) Marquesas Islands</option>
                        <option value="Pacific/Gambier">(GMT-09:00) Gambier Islands</option>
                        <option value="America/Anchorage">(GMT-09:00) Alaska</option>
                        <option value="America/Ensenada">(GMT-08:00) Tijuana, Baja California</option>
                        <option value="Etc/GMT+8">(GMT-08:00) Pitcairn Islands</option>
                        <option value="America/Los_Angeles">(GMT-08:00) Pacific Time (US & Canada)</option>
                        <option value="America/Denver">(GMT-07:00) Mountain Time (US & Canada)</option>
                        <option value="America/Chihuahua">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
                        <option value="America/Dawson_Creek">(GMT-07:00) Arizona</option>
                        <option value="America/Belize">(GMT-06:00) Saskatchewan, Central America</option>
                        <option value="America/Cancun">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
                        <option value="Chile/EasterIsland">(GMT-06:00) Easter Island</option>
                        <option value="America/Chicago">(GMT-06:00) Central Time (US & Canada)</option>
                        <option value="America/New_York">(GMT-05:00) Eastern Time (US & Canada)</option>
                        <option value="America/Havana">(GMT-05:00) Cuba</option>
                        <option value="America/Bogota">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
                        <option value="America/Caracas">(GMT-04:30) Caracas</option>
                        <option value="America/Santiago">(GMT-04:00) Santiago</option>
                        <option value="America/La_Paz">(GMT-04:00) La Paz</option>
                        <option value="Atlantic/Stanley">(GMT-04:00) Faukland Islands</option>
                        <option value="America/Campo_Grande">(GMT-04:00) Brazil</option>
                        <option value="America/Goose_Bay">(GMT-04:00) Atlantic Time (Goose Bay)</option>
                        <option value="America/Glace_Bay">(GMT-04:00) Atlantic Time (Canada)</option>
                        <option value="America/St_Johns">(GMT-03:30) Newfoundland</option>
                        <option value="America/Araguaina">(GMT-03:00) UTC-3</option>
                        <option value="America/Montevideo">(GMT-03:00) Montevideo</option>
                        <option value="America/Miquelon">(GMT-03:00) Miquelon, St. Pierre</option>
                        <option value="America/Godthab">(GMT-03:00) Greenland</option>
                        <option value="America/Argentina/Buenos_Aires">(GMT-03:00) Buenos Aires</option>
                        <option value="America/Sao_Paulo">(GMT-03:00) Brasilia</option>
                        <option value="America/Noronha">(GMT-02:00) Mid-Atlantic</option>
                        <option value="Atlantic/Cape_Verde">(GMT-01:00) Cape Verde Is.</option>
                        <option value="Atlantic/Azores">(GMT-01:00) Azores</option>
                        <option value="Europe/Belfast">(GMT) Greenwich Mean Time : Belfast</option>
                        <option value="Europe/Dublin">(GMT) Greenwich Mean Time : Dublin</option>
                        <option value="Europe/Lisbon">(GMT) Greenwich Mean Time : Lisbon</option>
                        <option value="Europe/London">(GMT) Greenwich Mean Time : London</option>
                        <option value="Africa/Abidjan">(GMT) Monrovia, Reykjavik</option>
                        <option value="Europe/Amsterdam">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna
                        </option>
                        <option value="Europe/Belgrade">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague
                        </option>
                        <option value="Europe/Brussels">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
                        <option value="Africa/Algiers">(GMT+01:00) West Central Africa</option>
                        <option value="Africa/Windhoek">(GMT+01:00) Windhoek</option>
                        <option value="Asia/Beirut">(GMT+02:00) Beirut</option>
                        <option value="Africa/Cairo">(GMT+02:00) Cairo</option>
                        <option value="Asia/Gaza">(GMT+02:00) Gaza</option>
                        <option value="Africa/Blantyre">(GMT+02:00) Harare, Pretoria</option>
                        <option value="Asia/Jerusalem">(GMT+02:00) Jerusalem</option>
                        <option value="Europe/Minsk">(GMT+02:00) Minsk</option>
                        <option value="Asia/Damascus">(GMT+02:00) Syria</option>
                        <option value="Europe/Moscow">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
                        <option value="Africa/Addis_Ababa">(GMT+03:00) Nairobi</option>
                        <option value="Asia/Tehran">(GMT+03:30) Tehran</option>
                        <option value="Asia/Dubai">(GMT+04:00) Abu Dhabi, Muscat</option>
                        <option value="Asia/Yerevan">(GMT+04:00) Yerevan</option>
                        <option value="Asia/Kabul">(GMT+04:30) Kabul</option>
                        <option value="Asia/Yekaterinburg">(GMT+05:00) Ekaterinburg</option>
                        <option value="Asia/Tashkent">(GMT+05:00) Tashkent</option>
                        <option value="Asia/Kolkata">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
                        <option value="Asia/Katmandu">(GMT+05:45) Kathmandu</option>
                        <option value="Asia/Dhaka">(GMT+06:00) Astana, Dhaka</option>
                        <option value="Asia/Novosibirsk">(GMT+06:00) Novosibirsk</option>
                        <option value="Asia/Rangoon">(GMT+06:30) Yangon (Rangoon)</option>
                        <option value="Asia/Bangkok">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
                        <option value="Asia/Krasnoyarsk">(GMT+07:00) Krasnoyarsk</option>
                        <option value="Asia/Hong_Kong">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
                        <option value="Asia/Irkutsk">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
                        <option value="Australia/Perth">(GMT+08:00) Perth</option>
                        <option value="Australia/Eucla">(GMT+08:45) Eucla</option>
                        <option value="Asia/Tokyo">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
                        <option value="Asia/Seoul">(GMT+09:00) Seoul</option>
                        <option value="Asia/Yakutsk">(GMT+09:00) Yakutsk</option>
                        <option value="Australia/Adelaide">(GMT+09:30) Adelaide</option>
                        <option value="Australia/Darwin">(GMT+09:30) Darwin</option>
                        <option value="Australia/Brisbane">(GMT+10:00) Brisbane</option>
                        <option value="Australia/Hobart">(GMT+10:00) Hobart</option>
                        <option value="Asia/Vladivostok">(GMT+10:00) Vladivostok</option>
                        <option value="Australia/Lord_Howe">(GMT+10:30) Lord Howe Island</option>
                        <option value="Etc/GMT-11">(GMT+11:00) Solomon Is., New Caledonia</option>
                        <option value="Asia/Magadan">(GMT+11:00) Magadan</option>
                        <option value="Pacific/Norfolk">(GMT+11:30) Norfolk Island</option>
                        <option value="Asia/Anadyr">(GMT+12:00) Anadyr, Kamchatka</option>
                        <option value="Pacific/Auckland">(GMT+12:00) Auckland, Wellington</option>
                        <option value="Etc/GMT-12">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
                        <option value="Pacific/Chatham">(GMT+12:45) Chatham Islands</option>
                        <option value="Pacific/Tongatapu">(GMT+13:00) Nuku'alofa</option>
                        <option value="Pacific/Kiritimati">(GMT+14:00) Kiritimati</option>
                    </select>
                    <label>Default Discount Amount (this discount will be applied for each item)</label>
                    <input type="text" class="required-input" placeholder="Discount Amount"
                           id="discount" name="discount"
                           value="<?php echo $discount['value']; ?>"/>
            </div>
            <div class="col-lg-8">
                <h4>Preview</h4>

                <div>
                    <img id="logo_image"
                         src="<?php echo !empty($logo['value']) ? SYSTEM_IMAGE_URL . $logo['value'] : ''; ?>"/>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <?php if (!empty($app_name['value'])) { ?>
            <button class="btn-green" type="button" id="continue_to_mail">Continue</button>
        <?php } ?>
        <button class="btn-green" type="button" id="update_site">Update App</button>
        </form>
    </div>
</li>
<li id="email_tab">
    <div class="wizard-heading">
        3. Email Client
        <span class="icon-summary"></span>
    </div>
    <div class="wizard-content">
        <p>Configure your email configuration. This is mandatory for the system to work. </p>

        <div class="email_errors">
            <div class="alert alert-danger" style="display: none"></div>
        </div>
        <div class="form row" style="max-width: 600px">
            <form action="#" id="frmMailSettings">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="firstname">Mail Driver: </label>
                        <input type="text" class="form-control" id="driver" name="driver"
                               placeholder="Eg ., smtp,sendmail,mandrill"
                               value="<?php echo $driver['value'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Mail Id(Mail will be sent from this account)</label>
                        <input type="email" class="form-control" id="mail_id" name="mail_id"
                               placeholder="Mail Name" value="<?php echo $email['value'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="lastname">From Address</label>
                        <input type="email" class="form-control" id="from_address" name="from_address"
                               placeholder="From address" value="<?php echo $mail_address['value']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="text">Mail Port :</label>
                        <input type="text" class="form-control" id="port" name="port" placeholder="587"
                               value="<?php echo $port['value']; ?>">
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="email">Mail Host :</label>
                        <input type="text" class="form-control" id="host" name="host"
                               placeholder="smtp.gmail.com" value="<?php echo $host['value']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="mail_password" name="mail_password"
                               placeholder="Password" value="<?php echo $mail_password['value']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">From Name</label>
                        <input type="text" class="form-control" id="from_name" name="from_name"
                               placeholder="From Name" value="<?php echo $mail_name['value']; ?>">
                    </div>
                </div>
            </form>
        </div>
        <div class="clear"></div>
        <button class="btn-green" type="button" id="go_to_payment">Continue</button>
        <button class="btn-green" type="button" id="email_update">Update</button>
    </div>
</li>
<?php if ($db != 'DB_NAME') { ?>
    <li id="payment_tab">
        <div class="wizard-heading">
            4. Payment Mode
            <span class="icon-summary"></span>
        </div>
        <div class="wizard-content">
            <p> Configure your payment configuration . This is mandatory for the system to make payment . </p>

            <div class="payment_errors">
                <div class="alert alert-danger" style="display: none"></div>
            </div>
            <div class="form row" style="max-width: 600px">
                <form action="#" id="frmPaymentSettings">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <?php
                        $payment_gateways = PaymentGateway::all();
                        $gateway_setting_list = "";
                    ?>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="firstname">Select Payment Gateways: </label><br>

                            <div class="row" style="margin-left: 10px;">
                                <?php
                                    $gateway_divs = "";
                                    foreach ($payment_gateways as $gateway) {
                                        ?>
                                        <div class="radio col-xs-3 paymode_div">
                                            <input type="radio" name="pay_mode" class="pay_mode"
                                                   value="<?php echo $gateway->id ?>"
                                                   data-id="payment<?php echo $gateway->id; ?>"
                                                <?php if ($payment_mode['value'] == $gateway->id) { ?> checked <?php } ?>><img
                                                src="<?php echo url(); ?>/assets/images/<?php echo $gateway->image ?>"
                                                alt="<?php echo ucfirst($gateway->name); ?>"/>
                                        </div>

                                        <?php

                                        $gateway_setting = $gateway->settings();
                                        $gateway_setting_list = '<div class="payment_class" id="payment' . $gateway->id . '" style="display:' . (($payment_mode['value'] == $gateway->id) ? 'block' : 'none') . '">';
                                        foreach ($gateway_setting as $setting) {
                                            $gateway_setting_list .= '<div class="form-group"><label>' . ucfirst($gateway->name) . ' ' . $setting->description . ':</label>';
                                            switch ($setting->type) {
                                                case 'TEXT':
                                                case 'EMAIL':
                                                    $gateway_setting_list .= '<input type="' . $setting->type . '" class="form-control" name="' . $setting->key . '" placeholder="' . $setting->description . '" value="' . $setting->value . '" />';
                                                    break;
                                                case 'SELECT':
                                                    $data_set = unserialize($setting->dataset);
                                                    $gateway_setting_list .= '<select name="' . $setting->key . '">';
                                                    foreach ($data_set as $key => $value) {
                                                        $gateway_setting_list .= '<option value="' . $key . '" ' . ($setting->value == $key ? 'selected' : '') . '>"' . $value . '"(' . $key . ')</option>';
                                                    }
                                                    $gateway_setting_list .= '</select>';
                                                    break;
                                            }
                                            $gateway_setting_list .= '</div>';
                                        }
                                        $gateway_setting_list .= '</div>';
                                        $gateway_divs .= $gateway_setting_list;
                                    }

                                ?>
                            </div>
                            <label>Transaction Mode</label>
                            <select id="transaction_type" name="transaction_type">
                                <option
                                    value="TEST" <?php if ($transaction_type['value'] == 'TEST') echo "selected"; ?>>
                                    TESTING
                                </option>
                                <option
                                    value="LIVE" <?php if ($transaction_type['value'] == 'LIVE') echo "selected"; ?>>
                                    LIVE
                                </option>
                            </select>
                        </div>
                        <div class="clear"></div>
                        <?php echo $gateway_divs; ?>
                    </div>
                </form>
            </div>
            <div class="clear"></div>
            <button class="btn-green" type="button" id="go_to_admin">Continue</button>
            <button class="btn-green" type="button" id="payment_update">Update</button>
        </div>
    </li>
<?php } ?>
<li id="user_credientials">
    <div class="wizard-heading">
        5. Admin Creditenitals
        <span class="icon-mode"></span>
    </div>
    <div class="wizard-content">
        <p>Create the site admin here.</p>

        <div class="user_errors">
            <div class="alert alert-danger" style="display: none"></div>
        </div>
        <div class="form">
            <form id="create-admin-form">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <label>Email</label>
                <input type="email" class="required-input" placeholder="Admin's Email" id="admin_email" name="email"
                       value="" required="required"/>
                <label>User Name</label>
                <input type="text" class="required-input" placeholder="User name" id="admin_name" name="name"
                       value="" required="required"/>
                <label>password</label>
                <input type="password" class="required-input" placeholder="password" id="admin_password"
                       name="password"
                       required="required"/>
                <label>Reenter Password</label>
                <input type="password" class="required-input" placeholder="renter password" id="re_password"
                       name="re-password"
                       required="required"/>
                <button class="btn-green" type="button" id="create_user">Done</button>
            </form>
        </div>
    </div>
</li>
</ul>
</div>
</body>
<!-- Loader -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body" style="height: 100px">
                <p id="run_migrations" style="text-align: center"></p>

                <div id="loading_class_gif"></div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- loader Ends -->
</html>
<script type="text/javascript">
$(window).load(function () {
    // Image preview
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Preview Image
    $("#logo").change(function () {
        readURL(this);
        if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#logo_image').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);
        }
    });

})
$(document).ready(function ($e) {

    $('.pay_mode').click(function (e) {
        var elementId = $(this).data('id');
        $('.payment_class').hide();
        $('#' + elementId).show();

    });


    $('.form-wizard li .wizard-heading:not(:first)').click(function (e) {
        $(this).parent('li').removeClass('completed').addClass('active').find('.wizard-content').show();
        $(this).parent('li').prev('.form-wizard li').addClass('completed').removeClass('active').find('.wizard-content').hide()
        $(this).parent('li').nextAll('.form-wizard li').removeClass('active', 'completed').find('.wizard-content').hide()
    });

    $db = $('#db_name').val();
    if ($db != 'DB_NAME') {
        $('#database_tab').removeClass('active').addClass('completed').find('.wizard-content').hide();
        $('#setting_tab').removeClass('completed').addClass('active').find('.wizard-content').show();
    }

    /**
     * Continue to Mail
     */
    $('#continue_to_mail').click(function (e) {
        $('#setting_tab').removeClass('active').addClass('completed').find('.wizard-content').hide();
        $('#email_tab').removeClass('completed').addClass('active').find('.wizard-content').show();
    });

    $('#go_to_admin').click(function (e) {
        $('#payment_tab').removeClass('active').addClass('completed').find('.wizard-content').hide();
        $('#user_credientials').removeClass('completed').addClass('active').find('.wizard-content').show();
    });

    $('#go_to_payment').click(function (e) {
        $('#email_tab').removeClass('active').addClass('completed').find('.wizard-content').hide();
        $('#payment_tab').removeClass('completed').addClass('active').find('.wizard-content').show();

    });

    $('#update_site').click(function (e) {

        var fd = new FormData();
        var file_data = $('#logo').prop('files')[0]; // for multiple files
        fd.append("file", file_data);
        var other_data = $('#create-setting-form').serializeArray();
        $.each(other_data, function (key, input) {
            fd.append(input.name, input.value);
        });
        $.ajax({
            url: "setting/basic",
            data: fd,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function (e) {
                $('#myModal').modal('show');
                $('#run_migrations').html('Updating your preferences. Please wait !!! ');
            },
            statusCode: {
                500: function (data) {

                    $('.website_errors .alert').html(data.responseJson);
                }
            },
            success: function (data) {
                $values = data.data;
                if (data.code == 401 || data.code == 400 || data.code == 500) {
                    $('.website_errors .alert').html(data.msg).show();
                    $('#myModal').modal('hide');
                    setTimeout(function (e) {
                        $('.website_errors .alert').modal('hide');
                    }, 3000)

                    return false;
                }
                $('#mail_id').val($values.email.value);
                $('#mail_password').val($values.mail_password.value);
                $('#from_address').val($values.mail_address.value);
                $('#from_name').val($values.mail_name.value);
                $('#port').val($values.port.value);
                $('#host').val($values.host.value);
                $('#dirver').val($values.driver.value);
                $('#myModal').modal('show');
                $('#run_migrations').html('Your Prefernces are updated ! ');
                $('#setting_tab').removeClass('active').addClass('completed').find('.wizard-content').hide();
                $('#email_tab').removeClass('completed').addClass('active').find('.wizard-content').show();
                setTimeout(function (e) {
                    $('#myModal').modal('hide');
                }, 3000)

            }
        })

    });

    $('#email_update').click(function (e) {

        $is_empty = false;
        $('#frmMailSettings input').each(function (e) {
            if ($(this).val() == "")
                $is_empty = true;
        });

        if ($is_empty) {
            alert('Enter all fields as this is mandatory for site to work');
            return false;
        }

        $.ajax({
            url: "setting/mail",
            data: $('#frmMailSettings').serialize(),
            type: 'POST',
            beforeSend: function (e) {
                $('#myModal').modal('show');
                $('#run_migrations').html('Updating your preferences. Please wait !!! ');
            },
            success: function (data) {
                $values = data.data;
                if (data.code == 401 || data.code == 400 || data.code == 500) {
                    $('.email_errors .alert').html(data.msg).show();
                    $('#myModal').modal('hide');
                    setTimeout(function (e) {
                        $('.email_errors .alert').modal('hide');
                    }, 3000)

                    return false;
                }
                $('#run_migrations').html("Your preferences are updated !!");
                $('#myModal').modal('show');
                $('#email_tab').removeClass('active').addClass('completed').find('.wizard-content').hide();
                $('#payment_tab').removeClass('completed').addClass('active').find('.wizard-content').show();
                setTimeout(function (e) {
                    $('#myModal').modal('hide');
                }, 3000)

            }
        })

    });


    $('#payment_update').click(function (e) {
        var transaction = $('#transaction_type').val();
        $is_empty = false;
        if ($('.pay_mode:checked').val() == '') {
            $is_empty = true;
        } else {
            var elementId = $('.pay_mode:checked').val();
            var data = {};
            // Check if all inputs are filled ;
            $("#payment" + elementId + " input,#payment" + elementId + " select").each(function (e) {
                if ($(this).val() == "") {
                    $(this).css({border: '1px solid red'});
                    $is_empty = true;
                    return false;
                } else {
                    $(this).css({border: '0'});
                    data[$(this).attr('name')] = $(this).val();
                }
            });
        }

        if ($is_empty) {
            alert('Enter all fields as this is mandatory for site to work');
            return false;
        }

        $.ajax({
            url: "setting/payment",
            data: {
                payment: elementId,
                transaction: transaction,
                params: data,
                _token: $("#frmPaymentSettings input[name='_token']").val()
            },
            type: 'POST',
            dataType: 'JSON',
            beforeSend: function (e) {
                $('#myModal').modal('show');
                $('#run_migrations').html('Updating your preferences. Please wait !!! ');
            },
            success: function (data) {
                $values = data.data;
                if (data.code == 401 || data.code == 400 || data.code == 500) {
                    $('.payment_errors .alert').html(data.msg).show();
                    $('#myModal').modal('hide');
                    setTimeout(function (e) {
                        $('.payment_errors .alert').modal('hide');
                    }, 3000)
                    return false;
                }
                $('#run_migrations').html("Your preferences are updated !!");
                $('#myModal').modal('show');
                $('#payment_tab').removeClass('active').addClass('completed').find('.wizard-content').hide();
                $('#user_credientials').removeClass('completed').addClass('active').find('.wizard-content').show();
                setTimeout(function (e) {
                    $('#myModal').modal('hide');
                }, 3000)
            }
        });
    });

    $('#create_user').click(function (e) {
        var is_empty = false;
        $('#create-admin-form .required-input').each(function (e) {
            if ($(this).val() == "") {
                is_empty = true;
            }
        });

        if (is_empty) {
            alert('Required values are missing')
            return false;
        }

        if ($('#admin_password').val() !== $('#re_password').val()) {
            alert('password does not matach !!');
            return false;
        }
        $.ajax({
            url: "setting/user",
            data: $('#create-admin-form').serialize(),
            type: 'POST',
            beforeSend: function (e) {
                $('#myModal').modal('show');
                $('#run_migrations').html('Creating admin . Please wait !!! ');
            },
            success: function (data) {
                $values = data.data;
                if (data.code == 401 || data.code == 400 || data.code == 500) {
                    $('.user_errors .alert').html(data.msg).show();
                    $('#myModal').modal('hide');
                    setTimeout(function (e) {
                        $('.user_errors .alert').modal('hide');
                    }, 3000)

                    return false;
                }

                $('#run_migrations').html("User details have been updated !! You will be redirected to admin login");
                $('#myModal').modal('show');
                setTimeout(function (e) {
                    $('#myModal').modal('hide');
                    window.location.href = "admin-login";
                }, 3000);

            }
        })

    });
    $('#create_db').click(function (e) {
        e.preventDefault();
        var is_empty = false;
        $('#create-db-form .required-input').each(function (e) {
            if ($(this).val() == "") {
                is_empty = true;
            }
        });

        if (is_empty) {
            alert('Required values are missing')
            return false;
        }

        console.log($('#create-db-form').serialize());
        $.ajax({
            url: 'create-db',
            type: 'POST',
            data: $('#create-db-form').serialize(),
            dataType: 'json',
            statusCode: {
                500: function (data) {
                    var code = data.responseJSON.code;
                    switch (code) {
                        case 1045:
                            alert('Wrong Username/Password')
                            return false;
                        case 1007:
                            alert('Database already Exists');
                            return false;
                        case 1044:
                            alert('Access denied for the user !');
                            return false;
                    }
                }
            },
            success: function (data) {
                $('#run_migrations').html(data.msg);
                $('#myModal').modal('show');
                run_migrations();
            }

        })
    });
});

function run_migrations() {
    $.ajax({
        url: 'run-migration',
        type: 'POST',
        dataType: 'json',
        statusCode: {
            500: function (data) {

            }
        },
        success: function (data) {
            $('#run_migrations').html(data.msg);
            run_seeder();
        }

    })
}

function run_seeder() {
    $.ajax({
        url: 'run-seeder',
        type: 'POST',
        dataType: 'json',
        statusCode: {
            500: function (data) {

            }
        },
        success: function (data) {
            $('#run_migrations').html(data.msg);
            setTimeout(function (e) {
                $('#myModal').modal('hide');
                $('#database_tab').removeClass('active').addClass('completed').find('.wizard-content').hide();
                $('#setting_tab').removeClass('completed').addClass('active').find('.wizard-content').show();
            }, 2000);
//                run_seeder();

            window.location.reload();
        }

    })
}
</script>