<!DOCTYPE html>
<html>

<!-- Mirrored from bkBangladesh.com/home/index.php by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 16 May 2020 08:42:51 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>

    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window,document,'script',
                '../../connect.facebook.net/en_US/fbevents.js');
            fbq('init', '582039581914139'); 
            fbq('track', 'PageView');
        </script>
        <noscript>
            <img height="1" width="1" 
            src="https://www.facebook.com/tr?id=582039581914139&amp;ev=PageView&amp;noscript=1"/>
        </noscript>
        <!-- End Facebook Pixel Code -->

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <META NAME="Author" content="Burger King Bangladesh">
        <META NAME="Copyright" content="Burger King, Bangladesh"> 
        <meta http-equiv="Content-Type" content="text/html;">
        <meta http-equiv="Expires" content="Sat, 1 Jan 2019 00:00:00 GMT">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Cache-Control" content="no-cache">
        <meta name="revisit-after" content="3 days">
        <meta name="language" content="english">
        <meta name="category" content="Food">
        <meta name="classification" content="Fast Food">
        <meta name="robots" content="INDEX, FOLLOW, NOARCHIVE">
        <meta name="GOOGLEBOT" content="INDEX, FOLLOW, NOARCHIVE">
        <META NAME="Description" content="Order Burger online for fast Burger delivery or drop by for carryout. You may also contact Burger King  and find out about our catering services for your next big event.">
        <META NAME="Keywords" content="burger, meal, deal, drink, ice cream, testy, test is king, be your way, flame grilling"> 

        <!-- Facebook OG  -->
        <meta property="og:title" content="Burger King, Bangladesh" />
        <meta property="og:image:type" content="image/png" />
        <meta property="og:image:width" content="1200" />
        <meta property="og:image:height" content="630" />
        <meta property="og:image" content="http://www.bkBangladesh.com/home/images/bk_og.png" />
        <meta property="og:description" content="Order Burger online for fast Burger delivery or drop by for carryout."/>

        <!-- Twitter -->
        <meta name="twitter:card" content="photo" />
        <meta name="twitter:title" content="Burger King, Bangladesh" />
        <meta name="twitter:description" content="Order Burger online for fast Burger delivery or drop by for carryout." />

        <meta name="viewport" content="width=device-width, initial-scale=1">    

        <link type="text/css" rel="stylesheet" href="{{ asset('FrontendCSSJS/css/main_csscfe8.css?v=5.1') }}" media="all" /> 
        <link rel="stylesheet" type="text/css" href="{{ asset('FrontendCSSJS/css/bootstrap.min.css') }}">

        <link rel="shortcut icon" href="FrontendCSSJS/img/favicon.ico" type="image/vnd.microsoft.icon" />
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="{{ asset('FrontendCSSJS/maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css') }}">
        <title> BURGER KING&reg;  </title>
        <!-- jQuery library -->
        <script src="{{ asset('FrontendCSSJS/ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js') }}"></script>
        <!-- Latest compiled JavaScript -->
        <script src="{{ asset('FrontendCSSJS/maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js') }}"></script>

        <script src="{{ asset('FrontendCSSJS/js/jquery.min.js') }}"></script> 
        <script src="{{ asset('FrontendCSSJS/js/main7ef2.js?ver=1.5') }}"></script> 
        <script src="{{ asset('FrontendCSSJS/js/bootstrap.min.js') }}"></script> 


        <!-- Crunchify Scroll to Top Script -->

        <script>            
            jQuery(document).ready(function() {
                var offset = 220;
                var duration = 500;
                jQuery(window).scroll(function() {
                    if (jQuery(this).scrollTop() > offset) {
                        jQuery('.crunchify-top').fadeIn(duration);
                    } else {
                        jQuery('.crunchify-top').fadeOut(duration);
                    }
                });

                jQuery('.crunchify-top').click(function(event) {
                    event.preventDefault();
                    jQuery('html, body').animate({scrollTop: 0}, duration);
                    return false;
                })
            });
        </script>

    </head>

    <body>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-101938594-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-101938594-1');
      </script>

      <script type="text/javascript">
       function timer()
       {
          var time = 1

          setInterval( function() {

            time--;

            $('#time').html(time);

            if (time === 0) {

                location.reload();
            }    
        }, 1000 );
      }
  </script>

  <!-- Link to Back to Top Button -->             
  <a name="to-top"> </a>

<?php  
$_routeName = request()->route()->getName();
?>
@if($_routeName == 'bkashmicrosite')
  @include('Frontend.layouts.micrositeheader')
@else
@include('Frontend.layouts.header')
@endif

  <style type="text/css">
    @media all {
        .updateOrdserTH{background-color:#FFE4B5}
        .addtoCart{background-color:gold; float:left; margin-left:95px; margin-top:60px; color:black}
        .cartLists{list-style-type:none; float:left; clear:both;}
        .cartMenuLists{list-style-type:none; float:left; clear:both;}
        .wrap{height:auto}
        .add2CartWrapper{align:bottom; margin-top:40px;}
        .pContainer{background-color:white; padding:1px; margin:1px;margin-bottom:-15px;}
        .pNameNdiscription{margin-top:15px; font-size:18px}
        #bottomBtns{font-size:35px}
        .pPRICE{margin-top:25px;}
    }

    @media screen and (max-width: 768px) {
        .pNameNdiscription{ margin-top:0; font-size:14px}
        .add2CartWrapper{align:bottom; margin-top:12px}
        .wrap{height:auto;}
        .pPRICE{margin-top:10;}
        #bottomBtns{font-size:20px}
        .menuBoxLeft{display:none;}
    }

    .zoom {
        transition: transform .5s; /* Animation */
        margin: 0 auto;
    }
    .zoom:hover {
        transform: scale(1.10); 
    }
    ::-webkit-scrollbar {
        width: 8px;
        background-color: #c4c4c4;
    }
    @media (min-width: 1024px)
    ::-webkit-scrollbar {
        background-color: #C0C0C0 !important;
        border-radius: 0rem;
        width: 10px;
    }
    ::-webkit-scrollbar-thumb {
        border-radius: 1px;
        background: #6e6e70;
        -webkit-box-shadow: inset 0 0 0 transparent;
    }
    @media (min-width: 1024px)
    ::-webkit-scrollbar-thumb {
        background-color: #585858 !important;
        border-radius: 0rem;
    }
    ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 0 transparent;
        border-radius: 0;
    }
    @media (min-width: 1024px)
    ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3) !important;
        background-color: transparent;
        border-radius: 0rem;
    }
    .no-padding{
        padding: 0px !important;
    }

    .checkbox input[type="checkbox"]:checked+div>.checkboxShim {
        border: 2px solid #ec7801;
        background: #ec7801;
    }
    .checkbox input[type=checkbox]:checked+div>.checkboxShim {
        opacity: 1;
    }
    .checkbox label, .radio label {
        min-height: 20px;
        padding-left: 20px;
        margin-bottom: 0;
        font-weight: 400;
        cursor: pointer;
    }
    .checkbox .checkboxShim {
        border: 2px solid #6b412f;
        width: 32px;
        width: 2rem;
        height: 32px;
        height: 2rem;
        max-width: 32px;
        max-width: 2rem;
        opacity: .54;
        margin-right: 16px;
        margin-right: 1rem;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        -ms-flex-pack: center;
        justify-content: center;
    }
    .checkbox .checkboxShim .inside {
        background: #ec7801;
        border-color: #FFFFFF;
    }
    .checkbox .checkboxShim .inside {
        width: 8px;
        width: .5rem;
        height: 16px;
        height: 1rem;
        margin-top: -3.2px;
        margin-top: -.2rem;
        visibility: hidden;
        border-width: 2px;
        border-style: solid;
        border-right: none;
        border-bottom: none;
        transform: rotate(-140deg);
    }
    .checkbox input[type=checkbox]:checked+div>.checkboxShim .inside {
        visibility: visible;
    }
    @media only screen and (min-width: 1024px)
    <style>
    .menuView .search .filterContainer .checkbox span {
        font-size: 1.4rem;
    }

    .flex {

        display: flex;
    }

</style>

<link rel="stylesheet" type="text/css" href="{{ asset('FrontendCSSJS/css/lightBox.css') }}">
<link type="text/css" rel="stylesheet" href="{{ asset('FrontendCSSJS/css/featherlight.min.css') }}" title="Featherlight Styles" />
<link rel="stylesheet" type="text/css" href="{{ asset('FrontendCSSJS/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('FrontendCSSJS/cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css') }}">

@yield('content')

<link type="text/css" rel="stylesheet" href="{{ asset('FrontendCSSJS/css/footer.css') }}" media="all" /> 
<link rel="shortcut icon" href="FrontendCSSJS/img/favicon.ico" type="FrontendCSSJS/image/vnd.microsoft.icon" />
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" type="text/css" href="{{ asset('FrontendCSSJS/css/bootstrap.min.css') }}">
<!-- jQuery library -->
<script src="{{ asset('FrontendCSSJS/ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js') }}"></script>
<!-- Latest compiled JavaScript -->
<script src="{{ asset('FrontendCSSJS/maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js') }}"></script>



<?php  
$_routeName = request()->route()->getName();
?>
@if($_routeName == 'bkashmicrosite')
  @include('Frontend.layouts.micrositefooter')
@else
@include('Frontend.layouts.footer')
@endif


</body>

<!-- Mirrored from bkBangladesh.com/home/index.php by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 16 May 2020 08:42:51 GMT -->
</HTML>

<script type="text/javascript" src="{{ asset('FrontendCSSJS/ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('FrontendCSSJS/js/main.js') }}"></script>

<script>
    $(document).ready(function(){

        $(function () {
            $(window).scroll(function () {
                if ($(this).scrollTop() > 100) {
                    $('#back-top').fadeIn();
                } else {
                    $('#back-top').fadeIn();
                }
            });
        });
    });
</script>

<script src="{{ asset('FrontendCSSJS/js/main968d.js') }}"></script> 

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug --> 

<!--/ pupup box --> 
<script src="{{ asset('FrontendCSSJS/js/jquery-1.7.0.min.js') }}"></script> 
<script src="{{ asset('FrontendCSSJS/js/featherlight.min.js') }}" type="text/javascript" charset="utf-8"></script> 

<!-- Bootstrap core JavaScript
    ================================================== --> 
    <!-- Placed at the end of the document so the pages load faster --> 
    <script src="{{ asset('FrontendCSSJS/js/jquery.min.js') }}"></script> 
    <script src="{{ asset('FrontendCSSJS/js/bootstrap.min.js') }}"></script> 
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug --> 
    <script src="{{ asset('FrontendCSSJS/js/ie10-viewport-bug-workaround.js') }}"></script> 

    <!-- jssor slider scripts--> 
    <!-- use jssor.js + jssor.slider.js instead for development --> 
    <!-- jssor.slider.mini.js = (jssor.js + jssor.slider.js) --> 
    <script type="text/javascript" src="{{ asset('FrontendCSSJS/js/jssor.slider.mini.js') }}"></script> 
    <script type="text/javascript" src="{{ asset('FrontendCSSJS/js/slider.js') }}"></script> 

    <script src="{{ asset('AdminCSSJS/assets/js/vendor/sweetalert.js') }}"></script>

    <script>
        $("a").css("outline","0" );
    </script>   

    <script>
        checkWidth();
    </script>