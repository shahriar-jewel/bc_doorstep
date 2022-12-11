<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <title>{{ config('app.name') }} Admin Panel</title>
        @include('common.header')
        @yield('extra_css')
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body class="page-header-fixed page-quick-sidebar-over-content page-sidebar-fixed">
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            @include('common.topmenu')
        </div>
        <!-- END HEADER   -->
        <div class="clearfix"></div>
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            @include('common.sidemenu')
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
            @yield('content')
            <div>
            <!-- END CONTENT -->   
        </div>
        <!-- END PAGE CONTENT -->
        
        @include('common.footer') 
        @yield('extra_js')
    </body>
    <!-- END BODY -->
</html>

