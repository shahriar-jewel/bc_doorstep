@extends('Frontend.layouts.manage')
@section('content')
<style type="text/css">
    body{
        border: 2px solid #ED7700;
        background-color: #ffefdb !important; 
        font-family:'BlockBerth' !important;
    }
</style>
      <div class="main-slider">

        <!-- Example row of columns -->
        <div style="min-height: 50px; overflow:hidden;"> 
          <!-- Jssor Slider Begin --> 
          <!-- To move inline styles to css file/block, please specify a class name for each element. --> 

          <div id="slider1_container" style="display: none; position: relative;
          width: 1800px; height: 760px; overflow: hidden;"> 
          <!-- Loading Screen -->
          <div u="loading" style="position: absolute; top: 0px; left: 0px;">
              <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block;
              top: 0px; left: 0px; width: 100%; height: 100%;"> </div>
              <div style="position: absolute; display: block; background: url(FrontendCSSJS/img/loading.html) no-repeat center center;
              top: 0px; left: 0px; width: 100%; height: 100%;"> </div>
          </div>

          <!-- Slides Container -->
          <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 1800px; height: 760px; overflow: hidden;">

            <div>
                <a href="#">  
                    <img u="image" src2="FrontendCSSJS/img/main-slider/whopper-feast-new.jpg" alt="Whopper Burger" width="100%" />
                </a>
            </div>

            <div>
                <a href="#">  
                    <img u="image" src2="FrontendCSSJS/img/main-slider/kings-treat-399-slider.jpg" alt="King's Treat for one person" width="100%" />
                </a>
            </div>

            <div>
                <a href="#">  
                    <img u="image" src2="FrontendCSSJS/img/main-slider/kings-sreat-749-slider.jpg" alt="King's Treat meal for two persons" width="100%" />
                </a>
            </div>

            <div>
                <a href="#">  
                    <img u="image" src2="imageFolder/Banner-BK-1800.jpg" alt="King's Treat meal for two persons" width="100%" />
                </a>
            </div>


        </div>

        <!--#region Bullet Navigator Skin Begin --> 
        <!-- Help: http://www.jssor.com/development/slider-with-bullet-navigator-jquery.html -->
        <style>
            /* jssor slider bullet navigator skin 21 css */
                /*
                .jssorb21 div           (normal)
                .jssorb21 div:hover     (normal mouseover)
                .jssorb21 .av           (active)
                .jssorb21 .av:hover     (active mouseover)
                .jssorb21 .dn           (mousedown)
                */
                .jssorb21 {
                    position: absolute;
                }
                .jssorb21 div, .jssorb21 div:hover, .jssorb21 .av {
                    position: absolute;
                    /* size of bullet elment */
                    width: 19px;
                    height: 19px;
                    text-align: center;
                    line-height: 19px;
                    color: white;
                    font-size: 12px;
                    background: url(FrontendCSSJS/img/b21bk.png) no-repeat;
                    overflow: hidden;
                    cursor: pointer;
                }
                .jssorb21 div { background-position: -5px -5px; }
                .jssorb21 div:hover, .jssorb21 .av:hover { background-position: -35px -5px; }
                .jssorb21 .av { background-position: -65px -5px; }
                .jssorb21 .dn, .jssorb21 .dn:hover { background-position: -95px -5px; }
            </style>
            <!-- bullet navigator container -->
            <div u="navigator" class="jssorb21" style="bottom: 0px; right: 6px;"> 
              <!-- bullet navigator item prototype -->
              <div u="prototype"></div>
          </div>
          <!--#endregion Bullet Navigator Skin End --> 

          <!--#region Arrow Navigator Skin Begin --> 
          <!-- Help: http://www.jssor.com/development/slider-with-arrow-navigator-jquery.html -->
          <style>
            /* jssor slider arrow navigator skin 21 css */
                /*
                .jssora21l                  (normal)
                .jssora21r                  (normal)
                .jssora21l:hover            (normal mouseover)
                .jssora21r:hover            (normal mouseover)
                .jssora21l.jssora21ldn      (mousedown)
                .jssora21r.jssora21rdn      (mousedown)
                */
                .jssora21l, .jssora21r {
                    display: block;
                    position: absolute;
                    /* size of arrow element */
                    width: 55px;
                    height: 55px;
                    cursor: pointer;
                    background: url(FrontendCSSJS/img/a11.png) center center no-repeat;
                    overflow: hidden;
                }
                .jssora21l { background-position: -3px -33px; }
                .jssora21r { background-position: -63px -33px; }
                .jssora21l:hover { background-position: -123px -33px; }
                .jssora21r:hover { background-position: -183px -33px; }
                .jssora21l.jssora21ldn { background-position: -243px -33px; }
                .jssora21r.jssora21rdn { background-position: -303px -33px; }
            </style>
            <!-- Arrow Left --> 
            <span u="arrowleft" class="jssora21l" style="top: 123px; left: 8px;"> </span> 
            <!-- Arrow Right --> 
            <span u="arrowright" class="jssora21r" style="top: 123px; right: 8px;"> </span> 
            <!--#endregion Arrow Navigator Skin End -->
            <!-- <a style="display: none" href="http://www.jssor.com">Bootstrap Slider</a> -->
        </div>
        <!-- Jssor Slider End --> 
    </div>
</div>


<div class="container-fluid bk-join">
    <div class="row">
        <div class="bk-join-main" >
            <h1 > <span>  JOIN THE <em> BK </em> <sup> &reg; </sup><br> </span> <span style="margin-left:-20px" > FAN KINGDOM</span> </h1>  
            <div class="col-xs-10 col-sm-10 col-md-10 col-sm-offset-1 ">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <a href="" target="_blank">
                        <i style="font-size:50px; color:white" class="fa"> &#xf230;  </i>
                    </a>
                </div>  
                
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <a href="" target="_blank">
                        <i style="font-size:50px; color:white" class="fa">  &#xf099;  </i>
                    </a>
                </div>  
                
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <a href="" target="_blank">
                        <i style="font-size:50px; color:white" class="fa">  &#xf030;  </i>  
                    </a>
                </div>  
            </div>
            <style>



            </style>
            
            <div class="col-xs-12 col-sm-12 col-md-12 taste-buds"> follow your taste buds </div>    
        </div>
    </div>
</div>

<div class="homePageMap">
    <div class="mainMap">

        <div class="swatch">
            <h4 class="title"> find a restaurant </h2>

                <div id="searchDivHomePage" style="width:210px; margin-left:auto; margin-right:auto;">
                    <form width="100%" role="search" style="margin-right:10px; margin-top:20px;" action="https://bkpakistan.com/home/get-map.php" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Enter your city" id="searchRes" name="searchRes" style=" width:160px; border:2px solid #ed7800; border-radius:0;float:left">
                            <button type="submit" class="btn btn-default" style="border:1px solid #ed7800; color:white; background-color:#ed7800; border-radius:0">
                                <span class="glyphicon glyphicon-map-marker"> </span>
                            </button>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>


    <div class="ourStoryBg">
        <div class="ourStoyInnerDiv">
            <h1 class="ourStoryTitle"> SINCE 1954 </h1>
            <P class="storyContent"> 60 years of our flame-grilled,<br>
            freshly prepared tradition goes into every order. </P>
            

            <div style="padding-bottom:15px">
                <center>
                    <a href="food-quality.html" style="margin-left: auto; margin-right:auto; max-width:160px">
                        <img src="FrontendCSSJS/img/prep_to_order/see-our-story.png" class="img-responsive" style="max-width:140px; margin-bottom:15px">
                    </a>
                </center>
            </div>          
        </div>
    </div>


    <div class="HomeMadeToOrder">
        <div class="madeToOrder">
            <h1 class="ourStoryTitle"> MADE TO ORDER </h1>
            <P class="storyContent"> Every WHOPPER<sup>&reg;</sup> Sandwich is,<br>
            made to order. </P>
            
            <div style="padding-bottom:15px">
                <center>
                    <a href="prepared-to-order.html" style="margin-left: auto; margin-right:auto; max-width:160px">
                        <img src="FrontendCSSJS/img/prep_to_order/take-a-look.png" class="img-responsive" style="max-width:140px; margin-bottom:15px">
                    </a>
                </center>
            </div>
        </div>
    </div>
@endsection