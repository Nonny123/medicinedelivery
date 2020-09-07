<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ Setting::param('site','app_name')['value'] }}</title>


    <link href="{{url()}}/assets/sass/styles.css?{{ date('Y-m-d h:i:s') }}" rel="stylesheet">
    <link href="{{url()}}/assets/stylesheets/smk-accordion.css?{{ date('Y-m-d h:i:s') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{url()}}/favicon.ico" type="image/x-icon">
    <link rel="icon" href="{{url()}}/favicon.ico" type="image/x-icon">

    {{--<link href="{{ URL::asset('sass/style2.css') }}" rel="stylesheet">--}}
    <script src="{{url()}}/assets/javascripts/jquery.min.js"></script>

    <link rel="stylesheet" href="{{url()}}/assets/javascripts/jquery-ui.css">
    <script src="{{url()}}/assets/javascripts/jquery-1.10.2.js"></script>
    <script src="{{url()}}/assets/javascripts/jquery-ui.js"></script>
    <script src="{{url()}}/assets/javascripts/smk-accordion.js"></script>
    {{--<script src="assets/js/jquery.form.js"></script>--}}


    <script type="text/javascript" src="{{url()}}/assets/javascripts/jquery.validate.min.js"></script>
</head>
<body>
<div id="wrapper">
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand menu-cross menu-toggle">
                <span class="icons-bar"></span>
                <span class="icons-bar"></span>
                <span class="icons-bar"></span>
            </li>
            @if (Auth::check() && Auth::user()->user_type_id != UserType::ADMIN())
            <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ URL::to('my-cart') }}">My cart</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="{{URL::to('my-prescription')}}">My prescriptions</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="{{URL::to('paid-prescription')}}">Awaiting shipping</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ URL::to('my-order') }}">Shipped orders</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="{{URL::to('account-page')}}">Profile</a></li>
            <li role="presentation" class="divider"></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ URL::to('logout') }}">Log out</a></li>
             @else
            <li class="animated ripple" data-color="#7C829D">
                <a href="#" class="loginModal">Login</a>
            </li>

            <li class="animated ripple" data-color="#7C829D">
                <a href="#" class="regModal">Register</a>
            </li>
            @endif
            <li class="animated ripple" data-color="#7C829D">
                <a href="{{ URL::to('about')}}">About Us</a>
            </li>
            <li  class="animated ripple" data-color="#7C829D">
                <a href="{{ URL::to('contact')}}">Contact Us</a>
            </li>
            <li  class="animated ripple" data-color="#7C829D">
                <a href="{{ URL::to('help-desk')}}">Help Desk</a>
            </li>
        </ul>
    </div>
    <!-- /#sidebar-wrapper -->
    <div id="page-content-wrapper">
        <div class="container">
            <header>
                <nav>
                    <ul class="nav nav-pills pull-right register-menu">
                         @if (Auth::check() && Auth::user()->user_type_id != UserType::ADMIN())
                         <div class="dropdown">
                             <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown"><?php if(Auth::user()->user_type_id==UserType::CUSTOMER()) {  echo Auth::user()->customer->first_name; } else { echo Auth::user()->professional->prof_first_name;}?>
                             <span class="caret"></span></button>
                             <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ URL::to('my-cart') }}">My cart</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="{{URL::to('my-prescription')}}">My prescriptions</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="{{URL::to('paid-prescription')}}">Awaiting shipping</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ URL::to('my-order') }}">Shipped orders</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="{{URL::to('account-page')}}">Profile</a></li>
                                <li role="presentation" class="divider"></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ URL::to('logout') }}">Log out</a></li>
                             </ul>
                           </div>

                         {{--<li><a class="register-btn ripple" href="{{ URL::to('logout') }}" data-color="#7C829D">Logout</a></li>--}}
                         @else
                        <li><a href="#" id="loginModal" class="loginModal">LOGIN</a></li>
                        <li><a class="register-btn ripple regModal1" href="#" data-color="#7C829D" id="regModal1">REGISTER</a></li>
                         @endif


                    </ul>
                    <ul class="nav nav-pills pull-right user-icon">
                        <li class="menu-toggle" >
                            <span class="icons-bar"></span>
                            <span class="icons-bar"></span>
                            <span class="icons-bar"></span>
                        </li>
                        <li class="user-img">

                        </li>
                    </ul>
                    <ul class="nav nav-pills pull-left">
                        <li><a href="{{ URL::to('/')}}"><img height="40" width="183" src="{{ SYSTEM_IMAGE_URL.Setting::param('site','logo')['value'] }}" alt="{{ Setting::param('site','app_name')['value'] }}"></a></li>
                    </ul>
                    <ul class="nav nav-pills pull-left about-menu">


                        <li><a href='{{ URL::to('about')}}'>About us</a></li>
                        <li><a href='{{ URL::to('contact')}}'>Contact us</a></li>
                        <!--<li><a href="FAQ.php">FAQ</a></li>-->
                    </ul>
                    <div class="clear"></div>
                </nav>
            </header>
        </div>