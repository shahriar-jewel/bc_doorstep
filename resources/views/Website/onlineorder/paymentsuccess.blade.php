@extends('Website.layouts.manage')
@section('extra_css')
<style type="text/css">
    .order__details{background: #FFEBD7; margin-top: 100px !important}

   
 body{font-family: 'BlockBeCnPro', Arial, Helvetica, sans-serif;}
 .menu__title{font-size: 35px; padding-top: 40px;padding-bottom: 0px;color: #323231}
 .register{color: #323231;font-size: 32px !important;}
 .search {
  width: 100%;
  position: relative;
  display: flex;
   padding-top: 45px;
   padding-bottom: 45px;
}

.searchTerm {
  width: 100%;
  border: none;

  padding: 15px;
  
  border-radius: 10px;
  outline: none;
  color: #9DBFAF;
  
}

.searchTerm:focus{
  color: #00B4CC;
}
::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
  color: #d9d9d9;
  opacity: 1; /* Firefox */
}

:-ms-input-placeholder { /* Internet Explorer 10-11 */
  color: #d9d9d9;
}

::-ms-input-placeholder { /* Microsoft Edge */
  color: #d9d9d9;
}

.food__menu__container{

  
}

.menu__name{
  padding-top: 40px; font-size: 30px; padding-left: 10px
}

.menu__price{
  text-align: right;
  font-size: 25px;
  padding-top: 20px;
}

.menu__btn{
  background-color: #ed7800 !important; color:white !important;
}

.order__bag{
  margin-top: -50px;
  margin-bottom: 20px;
}

.order__details__title, .order__details__price{
 color: #fff;
 padding-top: 35px;
 font-size: 30px;
}

.row-container{
  background: #FFEBD7;
}
.order__details__img{
  margin-top: 40px; 
  margin-bottom: 20px;
}

.menu__details{

  font-size: 23px;

}

.right__margin{
  padding-right: 30px;
}

body{
  background: #FCF1EB;
}
</style>

@endsection
@section('content')

<section style="background: #FCF1EB;">

  <div class="content" >
    <div class="container-fluid" >
      <div class="content  order__details" style="background: #FFEBD7;margin-top: 60px !important; ">
        <div class="row"  style="background: #F08B21; border-radius: 15px !important" >
           <div class="col-md-1"></div>
           <div class="col-md-7"><div class="order__details__title" 
                style="text-transform: uppercase;padding-top: 15px;padding-bottom: 15px"> Order Confirmation</div></div>
         
        </div>
      </div>
    </div>
  </div>

  
  <div class="content" >
    <div class="container-fluid" >
      <div class="content  order__details" style="background: #FFEBD7; margin-top: 50px !important;margin-bottom: 50px; ">
     <div class="row" style="padding-top: 30px; padding-bottom: 30px">
        
<div class="col-md-1"> </div> 
          <div class="col-md-10"> 
            
            <ul style="font-size: 23px">
              <li>Your order has been confirmed !</li><br>
              <li>Order Number : @if(!empty($ordernumber)){{ $ordernumber }}@endif</li>
              <li>Outlet : @if(!empty($branchname)){{ $branchname }}@endif</li>
              <li>Date : @if(!empty($created_at)){{ $created_at }}@endif</li>
              <li>Subtotal : BDT @if(!empty($orderTotal)){{ number_format($orderTotal,2) }}@endif</li>
              <li>
            Payment Method : {{ $paymentmethod=='1'?'Cash':($paymentmethod=='3'?'bKash':'No Payment') }}
          </li>
            </ul>

          </div> 
     <div class="col-md-1"> </div> 
      </div>

       <div class="row" style="padding-top: 30px; padding-bottom: 60px;font-size: 20px" >
        
<div class="col-md-1"> </div> 
          <div class="col-md-10"> 
            
           Thank you for placing order.
          </div> 
     <div class="col-md-1"> </div> 
      </div>
    </div>
  </div>
</div>


<section style="background: #FCF1EB; ">
<div class="content" style="">

  <div class="container-fluid" style="background: #61342C">
    <div class="content" >
        <div class="row" style="">
        
        <div class="col-md-12 text-center" style="margin-top: 15px;margin-bottom: 15px">
           
              <a href="{{ url('delivery') }}" style="font-size: 30px;">
               Back To Home
              </a>

              <div class="text-center" style="color: #ED7901">We are delivering 11 AM to 10.30
                   <span style="font-size: 15px"></span>PM only</div>
        </div>
        
        
    </div>
  </div>

    

</div>


  </div>
</div>

</section>

@endsection
@section('extra_js')

@endsection