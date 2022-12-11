<section id="backTotop">
<div id="node-101" class="node node-node-blocks clearfix">
 

<div class="content">
    

  <header class="container-fluid utility-header">
    <div class="content">
        <nav>
            <ul>
                <!--  <li class="location"><a href="#"><i class="icon icon_pindrop-orange"></i>Find Your <em>BK</em><sup>®</sup> Location</a></li>-->
                <!-- <li><a href="#">About <em>BK</em><sup>®</sup></a></li> -->
           
              
            </ul>
        </nav>
    </div>
</header>
<header class="container-fluid main-header">
    <div class="content">
        <div class="logoNavHolder clearfix">
            <a href="{{ url('/') }}" class="logo">
              <i class="icon icon_logo-main" style="background-image: url({{asset('WebsiteCSSJS/img/bk-logo.png')}})"> </i>
            </a> 
            <a class="mobileMenu">
                <i class="menu-icon"><span></span><span></span><span></span></i>
                <i class="icon icon_close-white"></i>
            </a>
        </div>
        <nav id="mainNav">          
            <ul class="mainNav">
                <li>
                    <a href="{{url('real-good-food')}}" >
                        <span class="menuItem-small">Real Good</span>
                        <span class="menuItem-medium" >Food</span>

                       <!--  <i class="icon icon_plus-orange"></i>
                        <i class="icon icon_minus-orange"></i> -->
                    </a>
                   <!-- <ul class="subNav clearfix">
                        <li><a href="#">WHOPPER</a></li>
                        <li><a href="#">FLAME GRILLED BEEF</a></li>
                        <li>
                            <a href="#">
                                CHICKEN
                            </a>
                        </li>
                        <li><a href="#">FISH</a></li>
                        <li><a href="#">SIDES</a></li>
                        <li><a href="#">BEVERAGE</a></li>
                        <li><a href="#">DESSERTS</a></li>
                   </ul> --> 
                </li>
                <li>
                    <a href="{{ url('delivery') }}">
                        <span class="menuItem-small">Online</span>
                        <span class="menuItem-medium">Delivery</span>
                    </a>
                </li>

                <li class="hasForm location-search">
                    <a href="{{url('location')}}" >
                        <span class="menuItem-small">Your <em>BK</em><sup>®</sup></span>
                      <!--  <span class="menuItem-medium">Locator<i class="icon icon_pindrop-header "></i></span>-->
                        
                          <span class="menuItem-medium">Locator<i class="fa fa-map-marker icon icon_pindrop-header" aria-hidden="true"></i></span>
                    </a>
                   <!--   <form class="formArea" action="/locations" method="GET">
                      <input type="text" class="navInput" name="field_geofield_distance[origin]" placeholder="Enter Your Location" /><button class="navInputSubmit" type="submit"><i class="icon icon_pindrop-white"></i></button>
                     </form> -->
                </li>

               <!-- <li>
                    <a href="#">
                        <span class="menuItem-small">Online</span>
                        <span class="menuItem-medium">Order</span>
                    </a>
                </li> -->

                <li class="utility-menu">
                    <a href="#">About <em>BK</em><sup>®</sup></a>
                    <a href="#" >Careers</a>
                    <a href="#" >Contact <em>BK</em><sup>®</sup></a>
                </li>                        
            </ul>
        </nav>
    </div>    
</header>
   </div>
  
  
</div>
</section>