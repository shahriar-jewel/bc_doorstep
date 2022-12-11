      <header>
        <nav id="utilityHeader" class="utilityHeader">
            <ul>
                <li class="about-bk">
                    <a href="about-bk.html">About <em>BK</em><sup>&reg;</sup></a>
                </li>
                
                <li class="find-loc">
                    <a href="get-map.html">Find Your <em>BK</em><sup>&reg;</sup> Location</a>
                </li>
                <!-- @if (Route::has('login'))
                <li>
                    @auth
                    <a class="dropdown-item" href="">{{ Auth::user()->name }}</a>
                    @else
                    <a class="dropdown-item" href="{{ route('login') }}">Login</a>
                    @endauth
                </li>
                @endif -->
            </ul>
        </nav>
        
    </header>
    <header>
        <div  id="mainHeader" class="container-fluid mainHeader" style="margin-left:0 margin-right:0; padding:0">
            <div style="max-width:1000px; margin-left:auto; margin-right:auto;">
                <div class="row">        
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-2 col-sm-2 col-xs-2 main-logo">
                            <a href="{{ url('/') }}"> <img src="{{ asset('FrontendCSSJS/img/logo.png') }}" class="img-responsive .main-logo-img" > </a>                
                        </div>                                                                  



                        <div class="m-menu-icon" id="m-menu-icon"> <a href="#"> <img src="{{ asset('FrontendCSSJS/img/menu.png') }}" style="max-width:50px;" class="img-responsive" id="m-mob"> </a></div>
                        <div class="m-menu-close" id="m-menu-close"> <a href="#"> <img src="{{ asset('FrontendCSSJS/img/close.png') }}" style="max-width:45px; margin-top:-7px" class="img-responsive" id="m-mob2"> </a></div>

                        <style> 
                            .mybuttons >ul{ width:120%}
                            .mybuttons >ul > li{width:auto; margin-left:-2px}
                        </style>




                        <div class="col-md-9 col-sm-9 col-xs-9 mybuttons">

                            <ul class="col-md-12 col-sm-12 col-xs-12" style="margin-left:-35px;">
                                <li>
                                    <a href="#" class="my-link">
                                        <span class="menu-small" id="menu-small"> Online </span>
                                        <span class="menu-big" id="menu-big"> ORDER </span>
                                    </a>
                                </li>
                                <li style=" margin-right:0px;">
                                    <a href="#" class="my-link">
                                        <span class="menu-small" id="menu-small"> Real Good </span>
                                        <span class="menu-big" id="menu-big"> Food </span>
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="my-link">
                                        <span class="menu-small" id="menu-small"> Get Fresh </span>
                                        <span class="menu-big" id="menu-big"> Offers </span>

                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="my-link">
                                        <span class="menu-small" id="menu-small"> Your <em> BK </em> <sup>&reg; </sup>  </span>
                                        <span class="menu-big" id="menu-big" > Locator  </span>                             
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="my-link">
                                        <span class="menu-small" id="menu-small"> Site </span>
                                        <span class="menu-big" id="menu-big"> Search </span>


                                    </a>
                                </li>

                            <!--<li>
                                <a href="bkdelivers" class="my-link">
                                    <span class="menu-small" id="menu-small"> Online </span>
                                    <span class="menu-big" id="menu-big"> ORDER </span>
                                
                                    
                                </a>
                            </li>-->
                            
                        </ul>

                    </div>
                </div>

            </div>


        </div>
    </div>

    <style>
        .m-menu { list-style-type:none; border-bottom:1px solid brown; padding:10px 0 7px 0;}
    </style>


    <!-- +++++++++++=========================== -->
    <div id="mob-view" class="mob-view">
        <div class="mob-menu"> 
            <ul> 
                <li class="m-menu"> <a href="#"> Order </a> </li>
                <li class="m-menu"> <a href="#"> Food  </a> </li>
                <li class="m-menu"> <a href="#"> Offers </a> </li>
                <li class="m-menu"> <a href="#"> Locator </a> </li>
                <li class="m-menu"> <a href="#"> Search </a> </li>
                
            </ul>
        </div>
        <p class="about-bk-small "> <a href="#"> About <em>BK</em><sup>&reg;</sup> </a> &nbsp; &nbsp; <a href="#"> <em>BK</em><sup>&reg;</sup> For Kids </a>  </p> 
    </div>


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
