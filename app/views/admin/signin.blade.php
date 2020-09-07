<!DOCTYPE html>
<html lang="en" class="app">
<head>  
  <meta charset="utf-8" />
  <title>{{ Setting::param('site','app_name')['value'] }}</title>
  <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
  <link rel="stylesheet" href="{{url()}}/assets/adminFiles/css/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="{{url()}}/assets/adminFiles/css/animate.css" type="text/css" />
  <link rel="stylesheet" href="{{url()}}/assets/adminFiles/css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="{{url()}}/assets/adminFiles/css/icon.css" type="text/css" />
  <link rel="stylesheet" href="{{url()}}/assets/adminFiles/css/font.css" type="text/css" />
  <link rel="stylesheet" href="{{url()}}/assets/adminFiles/css/app.css" type="text/css" />
    <!--[if lt IE 9]>
    <script src="{{url()}}/js/ie/html5shiv.js"></script>
    <script src="{{url()}}/js/ie/respond.min.js"></script>
    <script src="{{url()}}/js/ie/excanvas.js"></script>
  <![endif]-->
</head>
<body class="">
   <?php if(Auth::user()){
     header('Location: admin/dashboard');
exit;
   }?>
  <div id="content" class="m-t-lg wrapper-md animated fadeInUp" style="height:700px">
    <div class="container aside-xl" >
      <section class="m-b-lg">
        <header class="wrapper text-center">
          <strong>Admin Login</strong>
        </header>

	<div style="">
	        @if ( Session::has('flash_message') )
                <div class="alert {{ Session::get('flash_type') }}">
                    <h5 style="text-align: center">{{ Session::get('flash_message') }}</h5>
                </div>
            @endif
        <form method="POST" action="{{url()}}/admin/login" accept-charset="UTF-8">

        {{Form::token()}}

          <div class="list-group">
            <div class="list-group-item">
              <input type="text" placeholder="Email" class="form-control no-border" name="email" required="required">
            </div>
            <div class="list-group-item">
               <input type="password" placeholder="Password" class="form-control no-border" name="password" required="required">
            </div>
            <div class="list-group-item">
               <img src="{{Captcha::url();}}">
            </div>
            <div class="list-group-item">
            <input type="text" placeholder="Captcha" class="form-control no-border" name="captcha" required="required">
            </div>
          </div>
          <button type="submit" class="btn btn-lg btn-primary btn-block" style="color:#7C829D">Sign in</button>
          <div class="text-center m-t m-b"><a href="admin/reset"><small>Forgot password?</small></a></div>
          <div class="line line-dashed"></div>
        </form>
       </div>
      </section>
    </div>
  </div>
  <!-- footer -->
  <footer id="footer">
    <div class="text-center padder">
      <p>
        <small>{{ Setting::param('site','app_name')['value'] }}, An Online Medical Store<br>&copy; <?php echo date("Y"); ?></small>
      </p>
    </div>
  </footer>
  <!-- / footer -->
  <script src="{{url()}}/assets/adminFiles/js/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="{{url()}}/assets/adminFiles/js/bootstrap.js"></script>
  <!-- App -->
  <script src="{{url()}}/assets/adminFiles/js/app.js"></script>
  <script src="{{url()}}/assets/adminFiles/js/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="{{url()}}/assets/adminFiles/js/app.plugin.js"></script>
</body>
</html>
