@extends('Frontend.layouts.manage')
@section('content')

<style>
.container2 {
  position: relative;
  width: 100%;
 /* max-width: 400px;*/
}
.container2 img {
 /* width: 100%;
  height: auto;*/
  width: 100px;
    height: auto;
    margin-top: 60px !important;
}
.container2 .btn {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  background-color: transparent;
  color: white;
  font-size: 16px;
  padding: 12px 24px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
  text-align: center;
}

.font-details{
    font-family: 'BlockBerth' !important;
    font-size: 16px;
}

.cover-back{
    background: #FFE8CC;
    border-radius: 20px;
    margin-top: 27%;
}

.btn.active.focus, .btn.active:focus, .btn.focus, .btn:active.focus, .btn:active:focus, .btn:focus {
    outline: none !important;
    outline: 0px auto -webkit-focus-ring-color !important;
    outline-offset: 0px !important;
    }

body,html{

}
</style>
​<script type="text/javascript" src="https://capp-cdn.labs.bka.sh/scripts/webview_bridge.js"></script>

​<body>


<div class="container-fluid menuBox" style="background-color: #faeede; margin-top: -30px; border: 2px solid #EE7700;height: 80vh">
    <div class="cover-back">
        <div style=" margin-right: 15px" class="row">
                    <div class="col-xs-12" style="text-transform: uppercase;color: #4C4C4C">
                        <h2 style="padding-left: 15px;">Order Confirmation</h2>
                    </div>

                 </div>
    <div class="row">
          <div class="col-md-2 col-sm-2 col-xs-1"></div>
          <div class="col-md-2 col-sm-2 col-xs-10">
          <h2 style="padding-left: 0px;font-size: 20px;">Your order has been confirmed !</h2>
    
    </div>
    <div class="col-md-2 col-sm-2 col-xs-1"></div>
</div>

 
    <div class="row" style=" "><br>
        <!-- <div class="col-md-3 col-sm-3 col-xs-3"> -->
            <span class="pull-left">
                <img src="{{ asset('FrontendCSSJS/img/blackdot.png') }}" class="img-responsive" 
                      style="padding-right: 20px; margin-top: 6px;margin-left: 50px;">
            </span>
       <!--  </div> -->
       <!--  <div class="col-md-8 col-sm-8 col-xs-8"> -->
           <span class="pull-left">
            <p class="font-details">Order Number :  @if(!empty($ordernumber)){{ $ordernumber }}@endif </p>
        </span>
       <!--  </div> -->
    </div>

    <div class="row">
        <span class="pull-left">
                <img src="{{ asset('FrontendCSSJS/img/blackdot.png') }}" class="img-responsive" 
                style="padding-right: 20px;margin-top: 6px;margin-left: 50px;">
        </span>
       <span class="pull-left">
            <p class="font-details">Outlet :  @if(!empty($branchname)){{ $branchname }}@endif</p>
        </span>
    </div>

    <div class="row">
        <span class="pull-left">
                <img src="{{ asset('FrontendCSSJS/img/blackdot.png') }}" class="img-responsive" 
                style="padding-right: 20px;margin-top: 6px;margin-left: 50px;">
        </span>
       <span class="pull-left">
            <p class="font-details">Date :  @if(!empty($created_at)){{ $created_at }}@endif </p>
        </span>
    </div>

    <div class="row">
        <span class="pull-left">
                <img src="{{ asset('FrontendCSSJS/img/blackdot.png') }}" class="img-responsive" 
                style="padding-right: 20px;margin-top: 6px;margin-left: 50px;">
        </span>
       <span class="pull-left">
            <p class="font-details">Sub Total :  @if(!empty($total)){{ number_format($total,2) }}@endif </p>
        </span>
    </div>

    <div class="row">
        <span class="pull-left">
                <img src="{{ asset('FrontendCSSJS/img/blackdot.png') }}" class="img-responsive" 
                style="padding-right: 20px;margin-top: 6px;margin-left: 50px;">
        </span>
       <span class="pull-left">
            <p class="font-details">Payment Method :  bKash </p>
        </span>
    </div>

   <div class="row" style="margin-left: 40px;margin-right: auto;padding-bottom: 35px;padding-right: 40px;    
    ">
    <p class="font-details">Thank you for placing order.</p>
</div>
​
​</div>
</div>
​
 <button id="bkash_btn" type="button"
onclick="window.webViewJSBridge.goBackHome('BURGERKING')"
style="position: fixed;left: 0;bottom: 0;width: 100%;height: 8%;font-size:
18px;border-radius: 0px;margin-top: 2%;
color: white!important;width: 100%;height: 50px;text-align:
left;background-color: #E2136E;border-color: #E2136E;" >
Back to bKash App Home<img src="https://capp-cdn.labs.bka.sh/images/arrow.svg" style="float: right;margin-top: 1%;
padding-right: 1%;"></button>

</body>
​
​
​
@endsection