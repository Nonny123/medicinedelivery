
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
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css" type="text/css" />
   <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.2.js"></script>
  <!--[if lt IE 9]>
    <script src="js/ie/html5shiv.js"></script>
    <script src="js/ie/respond.min.js"></script>
    <script src="js/ie/excanvas.js"></script>
  <![endif]-->
  

  
</head>
 
<body class="">
  <section class="vbox">
    <header class="bg-white header header-md navbar navbar-fixed-top-xs box-shadow">
      <div class="navbar-header aside-md dk">
        <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen" data-target="#nav">
          <i class="fa fa-bars"></i>
        </a>
        <a href="{{ url() }}" class="navbar-brand">
          <img style="margin-top:15px" src="{{SYSTEM_IMAGE_URL.Setting::param('site','logo')['value'] }}" class="m-r-sm" alt="scale">
        </a>
        <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".user">
          <i class="fa fa-cog"></i>
        </a>
      </div>

      <form  class="navbar-form navbar-left input-s-lg m-t m-l-n-xs hidden-xs" role="search">
        <div id='searchTop' class="form-group">
          <div class="input-group">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-sm bg-white b-white btn-icon"><i class="fa fa-search"></i></button>
            </span>
            <input id="searchField" type="text" class="form-control input-sm no-border" placeholder="Search...">            
          </div>
        </div>
      </form>
      <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user user" >
        <li class="hidden-xs">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" >
            <i class="fa fa-envelope-o"></i>
            
            <span id='todaysCount' class="badge badge-sm up bg-danger " style="display: inline-block;"></span>
              <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.2.js"></script>
                       	<script>
                        	var not = '<?php echo URL::to('admin/today-pres-dash'); ?>';
				$(document).ready(function(e){
				$.ajax({
							   type: "GET",
							   url : not,
							   dataType: 'json',
							   success: function (data) {
									$('#notif').html(data.notif);
									$('#todaysCount').html(data.todaysCount);
									}
					});
				});
	      </script>
	      
          </a>
          <section class="dropdown-menu aside-xl animated flipInY " >
          
            <section class="panel bg-white scrollable padder"  style='max-height:430px;'>
             
              <div id="notif">
                
              </div>
              
			
            </section>
          </section>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <span class="thumb-sm avatar pull-left">
            </span>  <?php Auth::user()->email;?> <b class="caret"></b>
          </a>
          <ul class="dropdown-menu animated fadeInRight">            
            <li>
              <a href="{{url()}}/logout"  >Logout</a>
            </li>
            <li>
              <a href="{{url()}}/system-setup"  >Settings</a>
            </li>
            <li>
              <a href="{{url()}}/cache"  >Clear System Cache</a>
            </li>
          </ul>
        </li>
      </ul>      
    </header>
    <section>
      <section class="hbox stretch">
        <!-- .aside -->
        <aside class="bg-black aside-md hidden-print" id="nav">          
          <section class="vbox">
            <section class="w-f scrollable">
              <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="10px" data-railOpacity="0.2">
                <div class="clearfix wrapper dk nav-user hidden-xs">
                  <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <span class="hidden-nav-xs clear">
                        <span class="block m-t-xs">
                          <strong class="font-bold text-lt"> <?php echo Auth::user()->email;?></strong> 
                          <b class="caret"></b>
                        </span>
                      </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">                      
                      <li>
                        <a href="{{url()}}/logout">Logout</a>
                      </li>
                    </ul>
                  </div>
                </div>                


                <!-- nav -->                 
                <nav class="nav-primary hidden-xs">
                  <div class="text-muted text-sm hidden-nav-xs padder m-t-sm m-b-sm"></div>
                  <ul class="nav nav-main" data-ride="collapse">
                    <li id="dash"  class="active">
                      <a href="{{url()}}/admin/dashboard" class="auto">
                        <i class="fa fa-fw fa-dashboard">
                        </i>
                        <span class="font-bold">Dashboard</span>
                      </a>
                    </li>
                    <li id="users" >
                      <a href="#" class="auto">
                        <span class="pull-right text-muted">
                          <i class="fa fa-arrow-down"></i>
                        </span>
                        <i class="fa fa-users"></i>
                        <span class="font-bold">Users</span>
                      </a>
                      <ul class="nav dk">
                        <li >
                          <a href="{{url()}}/admin/load-customers" class="auto">
                             <i class="fa fa-user"></i>

                            <span>Customers</span>
                          </a>
                        </li>
                        <li >
                          <a href="{{url()}}/admin/load-medicalprof" class="auto">
                            <i class="fa fa-user-md"></i>

                            <span>Medical Professionals</span>
                          </a>
                        </li>

                      </ul>
                    </li>
                    <li id="medicine">
                      <a href="{{url()}}/admin/load-medicines" class="auto">
                        <i class="fa fa-fw fa-hospital-o">
                        </i>
                        <span class="font-bold">Medicine List</span>
                      </a>
                    </li>
                    <li id="requested">
                      <a href="{{url()}}/admin/load-new-medicines" class="auto">
                        <i class="fa fa-fw  fa-user-md"></i>
                        <span class="font-bold">Requested Medicines List</span>
                      </a>
                    </li>
                    <li id="presc">
                      <a href="#" class="auto">
                        <span class="pull-right text-muted">
                          <i class="fa fa-arrow-down"></i>
                        </span>
                        <i class="fa fa-bars"></i>
                        <span class="font-bold">Prescriptions</span>
                      </a>
                      <ul class="nav dk">

                        <li >
                          <a href="{{url()}}/admin/load-pending-prescription" class="auto">
                            <i class="fa fa-user-md"></i>
                            <span>Unverified Prescriptions</span>
                          </a>
                        </li>
                        <li >
                          <a href="{{url()}}/admin/load-active-prescription" class="auto">
                            <i class="fa fa-credit-card"></i>

                            <span>Verified Prescriptions</span>
                          </a>
                        </li>
                        <li >
                          <a href="{{url()}}/admin/load-paid-prescription" class="auto">
                            <i class="fa fa-paperclip"></i>
                            <span>Paid Prescriptions</span>
                          </a>
                        </li>
                        <li >
                          <a href="{{url()}}/admin/load-shipped-prescription" class="auto">
                            <i class="fa fa-truck"></i>
                            <span>Shipped Prescriptions</span>
                          </a>
                        </li>
                        <li >
                          <a href="{{url()}}/admin/load-deleted-prescription" class="auto">
                             <i class="fa fa-th-list"></i>
                            <span>Deleted Prescriptions</span>
                          </a>
                        </li>
                        <li >
                          <a href="{{url()}}/admin/load-all-prescription" class="auto">
                             <i class="fa fa-th-list"></i>
                            <span>All Prescriptions</span>
                          </a>
                        </li>
                      </ul>
                    </li>
                    
                    
                  </ul>
                  
                </nav>
                <!-- / nav -->
              </div>
            </section>
            
            <footer class="footer hidden-xs no-padder text-center-nav-xs">
              <a href="{{url()}}/logout"  class="btn btn-icon icon-muted btn-inactive pull-right m-l-xs m-r-xs hidden-nav-xs">
                <i class="i i-logout"></i>
              </a>
              <a href="#nav" data-toggle="class:nav-xs" class="btn btn-icon icon-muted btn-inactive m-l-xs m-r-xs">
                <i class="i i-circleleft text"></i>
                <i class="i i-circleright text-active"></i>
              </a>
            </footer>
          </section>
        </aside>
        <!-- /.aside -->
