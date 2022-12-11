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
  /*width: 100px;
    height: auto;*/
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
  padding: 12px 0px;
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
    /*margin-top: 22%;*/
}

.btn.active.focus, .btn.active:focus, .btn.focus, .btn:active.focus, .btn:active:focus, .btn:focus {
    outline: none !important;
    outline: 0px auto -webkit-focus-ring-color !important;
    outline-offset: 0px !important;
    }

    .vertical-center {
    min-height: 100% !important;  /* Fallback for browsers do NOT support vh unit */
    min-height: 100vh  !important;
    /*overflow-y: scroll !important; */
    /* overflow: unset; */
    /* position: fixed;*/

    /* border: 2px solid #EE7700; */

    /* margin-top: -40px; */
    display: flex  !important;
    align-items: center;

}
</style>

<script src="https://scripts.sandbox.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout-sandbox.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
​<body style="background-color: #FBF2E9 !important;
             border-right:2px solid #ee7700; border-left: 2px solid #ee7700; ">

      <div class="">
        <div class="container-fluid menuBox" style="height: 87vh;">
            <div class="cover-back">
                <div class="row">
                    <div class="col-md-1 col-sm-1 col-xs-1"></div>
                    <div class="col-md-1 col-sm-1 col-xs-10">
                        <h2 style="padding-left: 0px;">Order Summary</h2>
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-1"></div>
                </div>


 
                <div class="row"><br/>
                    <span class="pull-left">
                        <img src="{{ asset('FrontendCSSJS/img/blackdot.png') }}" class="img-responsive" 
                             style="padding-right: 20px; margin-top: 6px;margin-left: 50px;">
                    </span>
      
                    <span class="pull-left">
                        <p class="font-details">Order Number :
                          @if(!empty($ordernumber)){{ $ordernumber }}@endif 
                        </p>
                    </span>
      
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
                        <p class="font-details">Date :  @if(!empty($created_at)){{ $created_at }}@endif</p>
                    </span>
                </div>

                <div class="row">
                   <span class="pull-left">
                            <img src="{{ asset('FrontendCSSJS/img/blackdot.png') }}" class="img-responsive" 
                                 style="padding-right: 20px;margin-top: 6px;margin-left: 50px;">
                    </span>
                    <span class="pull-left">
                        <p class="font-details">Sub Total : BDT @if(!empty($orderTotal)){{ number_format($orderTotal,2) }}@endif</p>
                    </span>
                </div>
                
                <div class="row">
                    <span class="pull-left">
                            <img src="{{ asset('FrontendCSSJS/img/blackdot.png') }}" class="img-responsive" 
                            style="padding-right: 20px;margin-top: 6px;margin-left: 50px;">
                    </span>
                    <span class="pull-left">
                        <p class="font-details">Payment Method : bKash</p>
                    </span>
                </div>
​
                <div class="row" 
                     style="margin-left: 40px;margin-right: auto;padding-bottom: 35px;padding-right: 40px;">
                    <p class="font-details">
                        Please click the below button to pay with bKash for order confirmation
                    </p>
                </div>
            </div>
        </div>
​
        <div class="col-md-12 col-sm-12 col-xs-12" 
            style="bottom:0;width:99.5%;
                z-index:1; background: url({{ asset('FrontendCSSJS/img/footer.png') }});
                   background-size: cover !important;
                   background-repeat: no-repeat;position: fixed;border-right: 2px solid #EE7700;border-bottom: 2px solid #EE7700">
            <div class="row">
​
        <div class="col-md-4 col-sm-4 col-xs-4"></div>

        <div class="col-md-4 col-sm-4 col-xs-4" style="padding-left: 0px; padding-right: 0px;">
            <div class="container2">
                
                <button class="btn" id="bKash_button">
                    <img src="{{ asset('FrontendCSSJS/img/paynow.png') }}" style="height:37px !important; width:130px !important;
                     margin-bottom:5px" class="img-responsive">
                </button>
            </div>
        </div>

        <div class="col-md-4 col-sm-4 col-xs-4"></div>
    </div>
    <div class="row">
    
  
         <p style="color: #EE7700;font-family: 'BlockBerth';text-align: center; padding-top:30px; ">We are delivering 11 am to 9:45 pm only.</p>
        

    </div>



    
</div>
</body>
​<script type="text/javascript">
    bKash.init({
        paymentMode: 'checkout',
        paymentRequest: { amount: "{{$orderTotal}}", intent: 'sale' , temporderid:'{{$temporderid}}',_token: "{{ csrf_token() }}" },

        createRequest: function (request) {

            console.log('=> createRequest (request) :: ');
            console.log(request);
            console.log('Processing ...');

            $.ajax({
                url: "{{ url('bkashapi/create_payment') }}",
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
                    window.location.href = "{{ url('bkashmicrosite/paymentcancel/') }}";
                }
            });

        },
        executeRequestOnAuthorization: function () {
            console.log('=> executeRequestOnAuthorization');
            $.ajax({
                url: "{{ url('bkashapi/execute_payment') }}",
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
                            window.location.href = "{{ url('bkashmicrosite/paymentsuccess/'.$temporderid) }}";
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
​
​
@endsection