<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reset</title>
  <link rel="stylesheet" href="{{url()}}/assets/adminFiles/css/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="{{url()}}/assets/adminFiles/css/animate.css" type="text/css" />
  <link rel="stylesheet" href="{{url()}}/assets/adminFiles/css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="{{url()}}/assets/adminFiles/css/icon.css" type="text/css" />
  <link rel="stylesheet" href="{{url()}}/assets/adminFiles/css/font.css" type="text/css" />
  <link rel="stylesheet" href="{{url()}}/assets/adminFiles/css/app.css" type="text/css" />
</head>


<body class="">

  <div id="content" class="m-t-lg wrapper-md animated fadeInUp" style="height:700px">    
    <div class="container aside-xl" style="background-color:#E6E6E6;border-radius: 5px;">
      <section class="m-b-lg">
        <header class="wrapper text-center">
          <strong>Reset Admin password</strong>
        </header>
        <?php 
	 if(Session::has('message')){?>
	<div style="color: red"><h4> <?php echo Session::get('message');?> </h4></div>
	<?php }?>
	<div style="">
        <form method="POST" action="reset-password" accept-charset="UTF-8"><input name="_token" type="hidden" value="ZRuhWP3ZLqRqSYEGSZy0Yww761tQFAgYxbDPeKJK" >
          <div class="list-group">
            <div class="list-group-item">
              <input type="email" placeholder="Email" class="form-control no-border" name="email">
            </div>
          </div>
          <button type="submit" class="btn btn-lg btn-primary btn-block">Submit</button>
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
        <small>{{ Setting::param('site','app_name')['value'] }}, An Online Medical Store<br>&copy; <?php echo date('y')?></small>
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
