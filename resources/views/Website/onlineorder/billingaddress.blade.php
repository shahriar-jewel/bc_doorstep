@extends('Website.layouts.manage')
@section('extra_css')
<style type="text/css">
  .order__details{background: #FFEBD7; margin-top: 100px !important}


  body , .form-control{font-family: 'BlockBeCnPro', Arial, Helvetica, sans-serif;}


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

  .order__details__title, .order__details__price{
   color: #fff;
   padding-top: 35px;
   font-size: 30px;
   font-family: 'BlockBeCnPro', Arial, Helvetica, sans-serif;

 }

 body{
  background: #FCF1EB;
}
.img__order{width: 200px; margin-top: 8px; margin-bottom: 8px}
</style>

<style type="text/css">
  @media only screen and (max-width: 768px) {
    /*.img__oder{width: 150px; margin-top: 8px; margin-bottom: 8px}*/
    .order__details__title{
      font-size: 18px !important;
      font-family: 'BlockBeCnPro', Arial, Helvetica, sans-serif;
    }
    .content{
      margin-left: 15px;
      margin-right: 15px
    }
  }

</style>
@endsection
@section('content')
<section style="background: #FCF1EB;">
  <div class="content" >
    <div class="container-fluid" >
      <div class="content  order__details" 
      style="background: #FFEBD7;margin-top: 40px !important ">
      <div class="row"  style="background: #F08B21; border-radius: 15px !important" >
       <div class="col-md-1 col-xs-1"></div>
       <div class="col-md-7 col-xs-11">
        <div class="order__details__title"
        style="padding-top: 15px;padding-bottom: 15px"> DELIVERY DETAILS</div></div>
      </div>
    </div>
  </div>
</div>
<form action="{{ url('customerorderinfo') }}" method="post" 
id="customerdata">
{{ csrf_field() }}
<div class="content" >
  <div class="container-fluid" >
   <input type="hidden" name="orderdata" value="" id="orderdata">
   <input type="hidden" name="ordertotal" value="{{ $orderTotal }}" id="ordertotal">
   <input type="hidden" name="total_discountamount" value="{{ $total_discountamount }}" id="total_discountamount">
   <input type="hidden" name="ordersubtotal" value="{{ $orderSubTotal }}" id="ordersubtotal">
   <input type="hidden" name="deliverycharge" value="{{ $deliverycharge }}" id="deliverycharge">
   <input type="hidden" id="zonename" value="<?php echo Session::get('MyZoneName'); ?>" name="">

   <div class="content  order__details" style="background: #FFEBD7; margin-top: 30px !important;margin-bottom: 50px; ">
     <div class="row" style="padding-top: 30px" >
      <div class="col-md-1 col-xs-1"> </div> 
      <div class="col-md-10 col-xs-10" style="background: #FFE8CC;margin-bottom: 5px;">
        <input type="text" name="name" id="name" class="form-control" placeholder="Full Name" 
        style="margin-top:3px;" />
      </div>
      <div class="col-md-1 col-xs-1"> </div> 
    </div> 
    <div class="row" >
      <div class="col-md-1 col-xs-1"> </div> 
      <div class="col-md-10 col-xs-10" style="background: #FFE8CC;margin-bottom: 5px;">
        <input type="text" name="contactno" id="contactno" class="form-control" placeholder="Mobile No" 
        style="margin-top:3px;" />
        @if ($errors->has('contactno'))
        <span class="help-block">
         {{ $errors->first('contactno') }}
       </span>
       @endif
     </div>
     <div class="col-md-1 col-xs-1"> </div> 
   </div> 
   <div class="row" >
  <div class="col-md-1 col-xs-1"> </div> 
  <div class="col-md-10 col-xs-10" style="background: #FFE8CC;margin-bottom: 5px;">
   <select class="form-control select2" id="paymentmethod" name="paymentmethod">
     <option  value="" disabled selected >PLEASE SELECT PAYMENT METHOD</option>
     <option value="1">Cash On Delivery</option>
     <!-- <option value="2">Card</option> -->
     <option value="3">bKash</option>
   </select>
   @if ($errors->has('paymentmethod'))
   <span class="help-block">
     {{ $errors->first('paymentmethod') }}
   </span>
   @endif
 </div>
 <div class="col-md-1 col-xs-1"> </div> 
</div>
   <div class="row" >
    <div class="col-md-1 col-xs-1"> </div> 
    <div class="row">
      <div class="col-md-5 col-xs-5" style="background: #FFE8CC;margin-bottom: 5px;">
      <input type="text" name="houseno" id="houseno" class="form-control" placeholder="House No." 
      style="margin-top:3px;" />
   </div>
   <div class="col-md-5 col-xs-5" style="background: #FFE8CC;margin-bottom: 5px;">
      <input type="text" name="roadno" id="roadno" class="form-control" placeholder="Road No." 
      style="margin-top:3px;" />
   </div>
    </div>
   <div class="col-md-1 col-xs-1"> </div> 
 </div> 
 <div class="row" >
  <div class="col-md-1 col-xs-1"> </div> 
  <div class="col-md-10 col-xs-10" style="background: #FFE8CC;margin-bottom: 5px;">
    <textarea rows="3"  placeholder="Delivery address" name="address" id="address" style="width: 100%; border: none !important; padding-left: 15px" readonly=""> </textarea> 
  </div>
  <div class="col-md-1 col-xs-1"> </div> 
</div>
 
<div class="row"  style="padding-bottom: 30px">
  <div class="col-md-1 col-xs-1"> </div> 
  <div class="col-md-10 col-xs-10" style="background: #FFE8CC;margin-bottom: 5px;">
    <input type="text" name="specialinstruction" id="specialinstruction" class="form-control" placeholder="Special Instructions" 
    style="margin-top:3px;" />
  </div>
  <div class="col-md-1 col-xs-1"> </div> 
</div> 
</div>
</div>
</div>
</form>
<section style="background: #FCF1EB; ">
  <div class="content" style="">
    <div class="container-fluid" style="background: #61342C">
      <div class="content" >
        <div class="row" style="margin-top: 15px;margin-bottom: 15px">
         <div class="col-md-3 col-xs-3" > </div> 
         <div class="col-md-6 col-xs-6" style="">
           <!-- input type="text" name="" style="width: 100%; text-align: center;" placeholder="ROAD NO" > -->
           <a href="" onclick="return false" style=" ">
            <img src="{{ asset('FrontendCSSJS/img/placeorder.png') }}" class="img-responsive center-block img__order" 
            onclick="$('#customerdata').submit()">
          </a>
        </div>
        <div class="col-md-3 col-xs-3" > </div>
      </div>
    </div>
  </div>
</div>

</section>
@endsection
@section('extra_js')
<script src="{{ asset('sweetalert.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#orderdata').val(sessionStorage.getItem('shopping­cart­items'));
    console.log(sessionStorage.getItem('shopping­cart­items'));
  })
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#customerdata').submit(function(e){

      var name = $('#name').val();
      var address = document.getElementById('address').value;
      var contact = $('#contactno').val();
      var paymentmethod = $('#paymentmethod').val();

      if($('#paymentmethod').val() == null)
      {
        swal({
          title: "Enter Payment method!",
          icon: "info",
          button: "OK!",
        });
        e.preventDefault();
      }
      

      if(name == '')
      {
        swal({
          title: "Enter your name!",
          icon: "info",
          button: "OK!",
        });
        e.preventDefault();
      }
      else if(address == '')
      {
        swal({
          title: "Enter your address!",
          icon: "info",
          button: "OK!",
        });
        e.preventDefault();
      }
      else if(contact == '')
      {
        swal({
          title: "Enter your mobile number!",
          icon: "info",
          button: "OK!",
        });
        e.preventDefault();
      }
      else if($('#houseno').val() == '')
      {
        swal({
          title: "Enter your house number!",
          icon: "info",
          button: "OK!",
        });
        e.preventDefault();
      }
      else if($('#roadno').val() == '')
      {
        swal({
          title: "Enter your road number!",
          icon: "info",
          button: "OK!",
        });
        e.preventDefault();
      }



      if(name != '')
      {
        if(name.length > 50)
        {
          swal({
            title: "Your name not more than 50 characters long !",
            icon: "info",
            button: "OK!",
          });
          e.preventDefault();
        }
      }


      if(contact != '')
      {
        if(isNaN(contact))
        {
          swal({
            title: "Enter numeric mobile number!",
            icon: "info",
            button: "OK!",
          });
          e.preventDefault();
        }

        else if(contact.length<11)
        {
          swal({
            title: "Enter 11 digits mobile number!",
            icon: "info",
            button: "OK!",
          });
          e.preventDefault();
        }
        else if(contact.length>11)
        {
          swal({
            title: "Mobile number must be 11 digits!",
            icon: "info",
            button: "OK!",
          });
          e.preventDefault();
        }
        
      }

      
      
    })
  })
</script>

<script type="text/javascript">

  // $(document).ready(function () { 
  //   var obj = JSON.parse(sessionStorage.getItem('shippingaddress'));
  //   if ( obj != null) { 
  //     var zonename = $('#zonename').val();
  //     var shippingaddress = 'House : '+obj[0].houseno+', '+'Road : '+obj[0].roadno+', '+zonename
  //     $('#address').val(shippingaddress);

  //   }     
  // }); 

  $(document).ready(function(){
    $('#houseno, #roadno').on('keyup',function(){
       var zonename = $('#zonename').val();
       var houseno = $('#houseno').val();
       var roadno = $('#roadno').val();
       if(houseno == ''){
          houseno = ' null';
       }
       if(roadno == ''){
        roadno = ' null';
       }
       var shippingaddress = 'House : '+houseno+', '+'Road : '+roadno+', '+zonename;
       $('#address').val(shippingaddress);
    })
  });
</script>
@endsection