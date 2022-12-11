@extends('Website.layouts.manage')
@section('content')


<section class="container-fluid " >


 <div class="row content">
     <!-- <div class="content text-center">4C4C4C
     
      <h1 class="sectionTitle "><span>Menu</span></h1> -->
      <h1 class="sectionTitle menuTitle" style="margin-top: 30px;margin-bottom: 50px;">
        <!--<span style="background-color: #4C4C4C; color: #ffffff; padding: 10px 25px; ">MENU</span>-->

        <img src="{{ asset('WebsiteCSSJS/img/menu.png') }}" class="img-responsive center-block" />
      </h1>
    </div>

    <div class="row content">
      @if(!empty($gnrl_foods))
      @foreach($gnrl_foods as $gnrl_food)
      <div class="col-xs-6 col-sm-4 food-category chicken">
        <a class="inner" href="#">
          <div class="imgWrap">
            <img src="{{ asset('upload/menu/thumbnail_images/'. $gnrl_food['originalpicture']) }}" />
          </div>
          @if($gnrl_food['foodname'] == 'Whopper')
          <div class="" style="margin-top: 15px">
            <img src="{{ asset('WebsiteCSSJS/img/whopperburger.png') }}" class="img-responsive center-block" /> 
          </div>
          @else
          <div class="title">
            <span style="color:{{ $gnrl_food['foodnamecolor'] }};text-transform: uppercase;"> {{ $gnrl_food['foodname'] }}  </span>
         </div>
         @endif
       </a>
      </div>
     @endforeach
     @endif

      <!-- <div class="col-xs-6 col-sm-4 food-category burgers">
        <a class="inner" href="#">
          <div class="imgWrap">
            <img src="{{ asset('WebsiteCSSJS/menu/img/flame-grilled-beef/big-beef.png') }}" />
          </div>

          <div class="title">
           <span style="color: #6E3C2E"> FLAME-GRILLED BEEF  </span>
         </div>
       </a>
     </div>

     <div class="col-xs-6 col-sm-4 food-category kids">
      <a class="inner" href="#">
        <div class="imgWrap">
          <img src="{{ asset('WebsiteCSSJS/menu/img/chicken/ChickN-Crisp.png') }}" />
        </div>

        <div class="title">
          <span style="color: #ED7700"> CHICKEN</span>
        </div>
      </a>
    </div>

    <div class="col-xs-6 col-sm-4 food-category kingsmelt">
      <a class="inner" href="#">
        <div class="imgWrap">
          <img src="{{ asset('WebsiteCSSJS/menu/img/fish/fish.png') }}" />
        </div>

        <div class="title">
          <span style="color: #0072D3"> FISH </span>
        </div>
      </a>
    </div>

    <div class="col-xs-6 col-sm-4 food-category bk-classic">
      <a class="inner" href="#">
        <div class="imgWrap">
          <img src="{{ asset('WebsiteCSSJS/menu/img/sides/fries.png') }}" />
        </div>

        <div class="title">
          <span style="color: #F7A700"> SIDES </span>
        </div>
      </a>
    </div>
        
        <div class="col-xs-6 col-sm-4 food-category hot">
          <a class="inner" href="#">
            <div class="imgWrap">
              <img src="{{ asset('WebsiteCSSJS/menu/img/beverages/beverages.png') }}" />   </div>

              <div class="title">
                <span style="color: #A2007C"> BEVERAGES  </span>
              </div>
            </a>
          </div>
          <div class="col-xs-6 col-sm-4 food-category sweets">
            <a class="inner" href="#">
              <div class="imgWrap">
                <img src="{{ asset('WebsiteCSSJS/menu/img/desserts/desserts.png') }}" />   </div>

                <div class="title">
                  <span style="color: #003D75"> DESSERTS </span>
                </div>
              </a>
            </div> -->

          </div>


        </section>  


        @endsection