@extends('Website.layouts.manage')
@section('content')
<section >
  <div class="slideshow-container" style="">

    <!-- <div class="mySlides">
 
  <img src="{{ asset('WebsiteCSSJS/img/familybanner.png') }}" class="img-slider img-cover" style=" background-size: cover;margin-top: -10px; width: 100vw;">
 
</div>

<div class="mySlides">
 
  <img src="{{ asset('WebsiteCSSJS/img/familybanner2.png') }}" class="img-slider img-cover" style=" background-size: cover;margin-top: -10px; width: 100vw;">
 
</div> -->



<div class="mySlides">
 
  <img src="{{ asset('WebsiteCSSJS/img/ramadanOffer-01.jpg') }}" class="img-slider img-cover" style=" background-size: cover;margin-top: -10px; width: 100vw;">
 
</div>

<div class="mySlides">
 
  <img src="{{ asset('WebsiteCSSJS/img/ramadanOffer-02.jpg') }}" class="img-slider img-cover" style=" background-size: cover;margin-top: -10px; width: 100vw;">
 
</div>

<div class="mySlides">
 
  <img src="{{ asset('WebsiteCSSJS/img/ramadanOffer-03.jpg') }}" class="img-slider img-cover" style=" background-size: cover;margin-top: -10px; width: 100vw;">
 
</div>

<div class="mySlides">
 
  <img src="{{ asset('WebsiteCSSJS/img/ramadanOffer-04.jpg') }}" class="img-slider img-cover" style=" background-size: cover;margin-top: -10px; width: 100vw;">
 
</div>

    <div class="mySlides">
 
  <img src="{{ asset('WebsiteCSSJS/img/BANNER-Whopper-offer.png') }}" class="img-slider img-cover" style=" background-size: cover;margin-top: -10px; width: 100vw;">
 
</div>

<div class="mySlides">
 
  <img src="{{ asset('WebsiteCSSJS/img/banner1.jpg') }}" class="img-slider img-cover" style=" background-size: cover;margin-top: -10px; width: 100vw;">
 
</div>

<div class="mySlides">
 
  <img src="{{ asset('WebsiteCSSJS/img/banner3.jpg') }}" class="img-slider img-cover" style=" background-size: cover; margin-top: -10px; width: 100vw; ">
 
</div>

<div class="mySlides">
  
  <img src="{{ asset('WebsiteCSSJS/img/banner4.jpg') }}"  class="img-slider img-cover" style=" background-size: cover; margin-top: -10px; width: 100vw;">
  
</div>
<div style="text-align:center; " class="dot-position">
  <!-- <span class="dot"></span> 
  <span class="dot"></span> --> 
  <span class="dot"></span> 
  <span class="dot"></span>
  <span class="dot"></span>
  <span class="dot"></span> 
  <span class="dot"></span> 
  <span class="dot"></span> 
  <span class="dot"></span> 
  <span class="dot"></span> 
</div>
</div>
</section>

<section class="container-fluid homeSocial" >
     
  
  <div  class="homeSocialCover">
    
    <section class="container-fluid homeSocial" >

      <div class="col-sm-12">

        <h3 class="title">
          <span class="top">Take a break</span> 
          <span class="bot">From boredom</span>
        </h3>
        <h4 class="subtitle">swipe it, flip it, share it</h4>

      </div>

    </section> 

  </div>

 
</section>  




<div class="container" style="margin-top: 30px; margin-bottom: 30px;">
    <div class="row">
      <div class="col-md-12 ">
        <div class="overlay">
      </div>

        <div class="responsive">
          <div  style="margin-right: 15px;">
            <img class="img-al" src="{{ asset('WebsiteCSSJS/img1/1.jpg') }}" alt="" style="border: 6px solid #ed7800" />
          </div>
          <div  style="margin-right: 15px;">
            <img class="img-al" src="{{ asset('WebsiteCSSJS/img1/2.jpg') }}" alt="" style=" border: 6px solid #ed7800"/>
          </div>
          <div  style="margin-right: 15px;">
            <img class="img-al" src="{{ asset('WebsiteCSSJS/img1/offer.png') }}" alt=""  style=" border: 6px solid #ed7800"/>
          </div>
          <div style="margin-right: 15px;">
            <img class="img-al" src="{{ asset('WebsiteCSSJS/img1/3.jpg') }}" alt="" style=" border: 6px solid #ed7800" />
          </div>
          <div style="margin-right: 15px; ">
            <img class="img-al" src="{{ asset('WebsiteCSSJS/img1/5.jpg') }}" alt="" style="border: 6px solid #ed7800"/>
          </div>
          <div style="margin-right: 15px; ">
            <img class="img-al" src="{{ asset('WebsiteCSSJS/img1/1.jpg') }}" alt="" style=" border: 6px solid #ed7800"/>
          </div>
          <div style="margin-right: 15px; ">
            <img class="img-al" src="{{ asset('WebsiteCSSJS/img1/2.jpg') }}" alt="" style=" border: 6px solid #ed7800"/>
          </div>
          <div style="margin-right: 15px;">
            <img class="img-al" src="{{ asset('WebsiteCSSJS/img1/3.jpg') }}" alt="" style=" border: 6px solid #ed7800"/>
          </div>
        </div>
        
        <div class="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        </div>
        <div class="next1">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        </div>
        
      </div>
    </div>
  </div>

<section>
     <!-- <div class="pac-card" id="pac-card">
      <div>
        <div id="title" style="font-family: 'fs_sammyregular', Arial, Helvetica, sans-serif">
          Search a restaurant
        </div>
        <div id="type-selector" class="pac-controls">

        </div>
        <div id="strict-bounds-selector" class="pac-controls">
        
        </div>
      </div>
      <div id="pac-container">
        <input id="pac-input" type="text" class="swatch"
            placeholder="Enter a location" >
      </div>
    </div> -->
    <div id="map"></div>
    <!-- <div id="infowindow-content">
      <img src="" id="place-icon">
      <span id="place-name"  class="title"></span><br>
      <span id="place-address"></span>
    </div> -->

</section>

<div class="form-group" style="margin-top: 0px !important; margin-bottom:0px !important">

    <div class="col-md-3">
        <input type="hidden" class="form-control" value="23.810102" name="lat" id="lat" >
    </div>

    <div class="col-md-3">
        <input type="hidden" class="form-control" value="90.409016" name="lng" id="lng" >
    </div>
</div>



<section>
  <div class="content">
    <section class="container-fluid ourStory">
      <div class="row content">
        <h3 class="title">
          <span>SINCE 1954</span>
        </h3>
        <h4 class="subtitle">60 years of our flame-grilled,<br> freshly prepared tradition goes into every order.</h4>
          <!-- <a href="#" class="bk-btn">
            <img src="{{ asset('WebsiteCSSJS/img/read.png') }}" />
          </a> -->
      </div>
    </section>  
  </div>
</section>

<!-- <div class="content">
    
 <section class="container-fluid bkCallouts" style="">
  <div class="row content">


    <div class="col-xs-6 col-sm-3">
       
          <a class="bk-btn" href="#" target="_blank">
            <img src="{{ asset('WebsiteCSSJS/img/bk-careers.png') }}" class="img-responsive" />
          </a>
          
    </div>

    <div class="col-xs-6 col-sm-3">
       
          <a class="bk-btn" href="#" target="_blank">
            <img src="{{ asset('WebsiteCSSJS/img/bk-news.png') }}" class="img-responsive" />
          </a>
          
    </div>

     <div class="col-xs-6 col-sm-3">
       
          <a class="bk-btn" href="#" target="_blank">
            <img src="{{ asset('WebsiteCSSJS/img/bk-offers.png') }}" class="img-responsive" />
          </a>
          
     </div>

     <div class="col-xs-6 col-sm-3">
       
          <a class="bk-btn" href="#" target="_blank">
            <img src="{{ asset('WebsiteCSSJS/img/contact-bk.png') }}" class="img-responsive" />
          </a>
          
     </div>

  </section>
</div> -->
@endsection