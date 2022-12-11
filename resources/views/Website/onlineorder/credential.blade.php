@extends('Website.layouts.manage')
@section('extra_css')
<style type="text/css">
  .order__details{background: #FFEBD7; margin-top: 100px !important}

  body{font-family: 'BlockBeCnPro', Arial, Helvetica, sans-serif;}
  .order__details__block{
   background: #FFEBD7;margin-top: 60px !important;
 }

 .order__details__title, .order__details__price{
   color: #fff;
   padding-top: 35px;
   font-size: 30px !important;
 }

 .ul{
  font-size : 23px;
}

ul{
  list-style-type: none;
}


.order__details__img{
  margin-top: 40px; 
  margin-bottom: 20px;
}


.order__details__title{
  text-transform: uppercase;padding-top: 15px;padding-bottom: 15px
}


body{
  background: #FCF1EB;
}

.img__paynow{
  width: 150px;
  margin-top: 5px;
  margin-bottom: 5px;
}

ul{
  font-size: 23px;
}

@media only screen and (max-width: 768px) {
  .txt{
    margin-left: 10px !important;
  }
  .order__details__block{
    background: #FFEBD7;margin-top: 60px !important;
  }
  .order__details__title{
   font-size: 18px !important;
   padding-left: 15px;
 }
 ul{
  font-size: 16px;
  margin-left: 10px;}
  .ul{
    font-size: 16px;
    padding-left: 10px;
  }
  .content__sm{
    margin-left: 15px;
    margin-right: 15px;
  }
  .img__paynow{
    width: 110px;
    margin-top: 5px;
    margin-bottom: 5px;
  }

}
</style>


@endsection
@section('content')

<section style="background: #FCF1EB;">
 <div class="content__sm" >
  <div class="container-fluid" >
    <div class="content  order__details order__details__block" style=" ">
      <div class="row"  style="background: #F08B21; border-radius: 15px !important" >
       <div class="col-md-1 col-xs-1"></div>
       <div class="col-md-7 col-md-11"><div class="order__details__title">
         ORDER SUMMARY
       </div></div>

     </div>
   </div>
 </div>
</div>
<div class="content content__sm" >
  <div class="container-fluid" >
    <div class="content  order__details" style="background: #FFEBD7; margin-top: 50px !important;margin-bottom: 50px; ">
     <div class="row" style="padding-top: 30px; padding-bottom: 30px" >
      <div class="col-md-1 "> </div> 
      <div class="col-md-10 col-xs-10 co-xs-offset-1"> 
        <ul>
          <li>Order Number : @if(!empty($ordernumber)){{ $ordernumber }}@endif</li>
          <li>Outlet : @if(!empty($branchname)){{ $branchname }}@endif</li>
          <li>Date : @if(!empty($created_at)){{ $created_at }}@endif</li>
          <li>Order Total : BDT @if(!empty($actualPrice)){{ number_format($actualPrice,2) }}@endif</li>
          <li>Discount : BDT @if(!empty($total_discountamount)){{ number_format($total_discountamount,2) }}@endif</li>
          <li>Total (After discount) : BDT @if(!empty($orderTotal)){{ number_format($orderTotal,2) }}@endif</li>
          <li>
            Payment Method : {{ $paymentmethod=='1'?'Cash':($paymentmethod=='3'?'bKash':'No Payment') }}
          </li>
        </ul>
      </div> 
      <div class="col-md-1 col-xs-1"> </div> 
    </div>
    <div class="row row__click" style="" >
      <div class="col-md-1 "> </div> 
      <div class="col-md-10 col-xs-10 ul co-xs-offset-1"> 
       Please click the below button to pay with {{ $paymentmethod=='1'?'Cash':($paymentmethod=='3'?'bKash':'No Payment') }} for order confirmation
     </div> 
     <div class="col-md-1 "> </div> 
   </div><br>
 </div>
</div>
</div>
<section style="background: #FCF1EB; ">
  <div class="content" style="">
    <div class="container-fluid" style="background: #61342C">
      <div class="content" >
        <div class="row" style="">
          <div class="col-xs-1"> </div>
          <div class="col-md-12 col-xs-10  " style="margin-top: 15px;margin-bottom: 15px">
            @if($paymentmethod=='1')
            <a href="#" onclick="return false;" style=" ">
              <img id="cash_button" data-temporderid="{{ $temporderid }}" src="{{ asset('FrontendCSSJS/img/placeorder.png') }}" 
              class="img-responsive center-block img__paynow" >
            </a>
            @elseif($paymentmethod=='3')
            <a href="#" onclick="return false;" style=" ">
              <img id="bKash_button" src="{{ asset('FrontendCSSJS/img/paynow.png') }}" 
              class="img-responsive center-block img__paynow" >
            </a>
            @endif
            <div class="text-center txt" style="color: #ED7901">We are delivering from 11 AM to 
             <span style="font-size: 15px">10.30</span> PM only</div>
           </div>
           <div class="col-xs-1"> </div>
         </div>
       </div>
     </div>
   </div>
 </section>
 @endsection
 @section('extra_js')
 <script src="https://scripts.sandbox.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout-sandbox.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 <script type="text/javascript">
  bKash.init({
    paymentMode: 'checkout',
    paymentRequest: { amount: "{{$orderTotal}}", intent: 'sale' , temporderid:'{{$temporderid}}',_token: "{{ csrf_token() }}" },

    createRequest: function (request) {

      console.log('=> createRequest (request) :: ');
      console.log(request);
      console.log('Processing ...');

      $.ajax({
        url: "{{ url('bkashwebapi/create_payment') }}",
        type: 'POST',
        contentType: 'application/json',
        data:  JSON.stringify(request),
        dataType: 'json',
        success: function (data) {
          console.log('got data from create  ..');
          console.log('data ::=>');
          console.log(data);
                    // data = JSON.parse(data);
                    if (data && data.paymentID != null) {
                      paymentID = data.paymentID;
                      invoiceNo = data.merchantInvoiceNumber;
                      bKash.create().onSuccess(data);
                    } else {
                      if (data.message != null) {
                        swal("Payment failed", data.message, "error");
                      }else{
                        swal("Payment failed", data.errorMessage, "error");
                      }
                        bKash.create().onError();//run clean up code
                      }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                    // alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    swal("Payment failed", "An error has occured during execute", "error");
                    bKash.create().onError();//run clean up code
                    // window.location.href = "{{ url('paymentcancel/') }}";
                  }
                });

    },
    executeRequestOnAuthorization: function () {
      console.log('=> executeRequestOnAuthorization');
      $.ajax({
        url: "{{ url('bkashwebapi/execute_payment') }}",
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({"paymentID": paymentID,"invoiceNo":invoiceNo,temporderid:'{{$temporderid}}', _token: "{{ csrf_token() }}"}),

        success: function (edata) {

          console.log('got data from execute  ..');
          console.log('data ::=>');
          console.log(edata);
          edata = JSON.parse(edata);
          if (edata && edata.paymentID != null) {
                        bKash.execute().onError();//run clean up code
                        // swal("success", "Payment is successful", "success");
                        swal({
                          title: 'Success',
                          text: 'Payment is successful',
                          icon: "success",
                          confirmButtonText: 'OK'
                        }).then(() => {
                          window.location.href = "{{ url('paymentsuccess/'.$temporderid) }}";
                        });
                      }else {
                        swal("Payment failed", edata.errorMessage, "error");
                        bKash.execute().onError();//run clean up code
                        // window.location.href = "{{ url('bkashmicrosite/paymentcancel/') }}";
                      }
                    },
                    error: function () {
                      swal("Payment failed", "An error has occured during execute", "error");
                    bKash.execute().onError();//run clean up code
                    // window.location.href = "{{ url('bkashmicrosite/paymentcancel/') }}";
                  }
                });

    },
    onClose : function () {
            //define what happens if the user closes the pop up window
            swal("Cancel", "Payment canceled", "error");
            // window.location.href = "{{ url('bkashmicrosite/paymentcancel/') }}";
            //your code goes here
          }
        });
      </script>


      <script type="text/javascript">
        $(document).ready(function(){
          $('#cash_button').on('click',function(){
           $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
          });
           var button = $(this);
           var temporderid = button.attr("data-temporderid");
           var url = '{{ url('cashondelivery') }}';
           swal({
            title: "Are you sure to place order ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
           .then((e) => {
            if (e) {

              $.ajax({
                url: url,
                method:'POST',
                data:{temporderid : temporderid},
                dataType : "json",
                success:function(data){ 
                  console.log(data);
                },

              })
              swal({
                title: 'Success',
                text: 'Order Placed Successfully',
                icon: "success",
                confirmButtonText: 'OK'
              }).then(() => {
                window.location.href = "{{ url('paymentsuccess/'.$temporderid) }}";
              });
            } 
            else {
              swal("Order Not Placed !", {
                icon: "info",
              });
            }
          });
         })
        })
      </script>
      @endsection