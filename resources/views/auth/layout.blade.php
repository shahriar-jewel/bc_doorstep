<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <title>Admin Panel Login</title>
        @include('auth.header')
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body class="login">
        <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
        <div class="menu-toggler sidebar-toggler">
        </div>
        <!-- END SIDEBAR TOGGLER BUTTON -->
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="{{ url('#') }}">
            <img src="{{ url('assets/admin/layout/img/login.png') }}" alt="{{ config('app.name') }}"/>
            <!-- <b style="font-size: 28px;color: #FFF;">{{ config('app.name') }}</b> -->
            </a>
        </div>
        <!-- END LOGO -->
        <div class="content">
            @yield('content')
        </div>
        <div class="copyright">
            {{ date("Y") }} © B-trac Solutions Ltd.
        </div>
        @include('auth.footer') 
    </body>
    <!-- END BODY -->
</html>

