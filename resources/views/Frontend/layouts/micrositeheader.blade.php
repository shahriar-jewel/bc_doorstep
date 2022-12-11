     <!--  <header>
        <nav id="utilityHeader" class="utilityHeader">
            <ul>
                <li class="about-bk">
                    <a href="#">About <em>BK</em><sup>&reg;</sup></a>
                </li>
                
                <li class="find-loc">
                    <a href="#">Find Your <em>BK</em><sup>&reg;</sup> Location</a>
                </li>
                @if (Route::has('login'))
                <li>
                    @auth
                    <a class="dropdown-item" href="#">{{ Auth::user()->name }}</a>
                    @else
                    <a class="dropdown-item" href="{{ route('login') }}">Login</a>
                    @endauth
                </li>
                @endif
            </ul>
        </nav>
        
    </header> -->





<script type="text/javascript" src="https://capp-cdn.labs.bka.sh/scripts/webview_bridge.js"></script>

<div id="mylightbox20" class="lightbox">

            
            <div class="row">

                <span>
                    <img id="bkash_btn" class="featherlight-close" onclick="window.webViewJSBridge.goBackHome('BURGERKING')" src="{{ asset('FrontendCSSJS/img/arrow.png') }}" style="margin-left: 25%;">
                </span>
              
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <button id="bkash_btn" class="featherlight-close" type="button"
onclick="window.webViewJSBridge.goBackHome('BURGERKING')"
style="position: fixed;left: 0;bottom: 0;width: 100%;height: 8%;font-size:
18px;border-radius: 0px;margin-top: 2%;
color: white!important;width: 100%;height: 50px;text-align:
left;background-color: #E2136E;border-color: #E2136E;" >
Back to bKash App Home<img src="https://capp-cdn.labs.bka.sh/images/arrow.svg" style="float: right;margin-top: 1%;
padding-right: 1%;"></button>






                </div>
                
           
        </div>
    </div>


    <header>
        <div  id="mainHeader" class="container-fluid mainHeader" style="margin-left:0 margin-right:0;margin-top: -10px; padding:0">
            <div style="max-width:1000px; margin-left:auto; margin-right:auto;">
                <div class="row">        
                    <div class="col-md-12 col-sm-12 col-xs-12">

                         <div class="col-md-4 col-sm-4 col-xs-4 main-logo">
                                          <img src="{{ asset('FrontendCSSJS/img/menuicon.png') }}" class="img-responsive .main-logo-img" data-featherlight='#mylightbox20' style="width: 35px;height: 45px;padding-top: 20px;">  
                        </div> 

                           <div class="col-md-2 col-sm-2 col-xs-4 main-logo" 
                             style="padding-top: 7px">
                             <a href="{{ url('bkashmicrosite') }}">
                             <img src="{{ asset('FrontendCSSJS/img/logo.png') }}" class="img-responsive center-block .main-logo-img" style="width:65px; height: 65px;" > </a>                
                        </div>                                                                  

                        <!-- <div class="m-menu-icon" id="" style="padding-left: -2px;"> 
                            <a href="#"> <img src="{{ asset('FrontendCSSJS/img/backtobkash.png') }}" style="max-width:50px;height: 35px;float: right; margin-right: 10px; margin-top: 20px;" class="img-responsive" id=""> </a></div> -->

                          

                        <style> 
                            .mybuttons >ul{ width:120%}
                            .mybuttons >ul > li{width:auto; margin-left:-2px}
                        </style>

                        <div class="col-md-4 col-sm-4 col-xs-4" style="padding-left: 40px;">
                                         <!-- <a href="#"> <img src="{{ asset('FrontendCSSJS/img/backtobkashfinal.png') }}" class="img-responsive " style="width: 70px;height: 60px;padding-top: 15px;"> </a> --> 
                        </div>
                </div>

            </div>


        </div>
    </div>

    <style>
        .m-menu { list-style-type:none; border-bottom:1px solid brown; padding:10px 0 7px 0;}
    </style>


    <!-- +++++++++++=========================== -->
   


    <!-- +++++++++++=========================== -->

    <script>

        $("#mob-view").hide();
        $("#m-menu-close").hide();

        $( "#m-mob")
        .on( "click", function() {
          $("#mob-view").show();
          $("#m-menu-icon").hide();
          $("#m-menu-close").show();

      });

        $( "#m-menu-close")
        .on( "click", function() {
            $("#mob-view").slideUp();
            $("#m-menu-close").hide();
            $("#m-menu-icon").show();

        }) ;       
    </script>  


</header>
