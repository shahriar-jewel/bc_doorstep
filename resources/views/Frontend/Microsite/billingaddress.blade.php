@extends('Frontend.layouts.manage')
@section('content')
​
<style type="text/css">
	.vertical-center {
	min-height: 100% !important;  /* Fallback for browsers do NOT support vh unit */
	min-height: 92vh  !important;
	/*overflow-y: scroll !important; */
	/* overflow: unset; */
	/* position: fixed;*/

	/*border: 2px solid #EE7700;*/
    margin-top: -40px;
	display: flex  !important;
	align-items: center;

}
​
.form-control{
	height: 40px !important;
	padding: 8px 12px !important;
}
</style>
​<body style="background: url({{ asset('FrontendCSSJS/img/bg.png') }}); background-size: cover !important; background-repeat: no-repeat; ">
	<div class=""> 
	​
		<div class="container" >
			<div class="menuBox" 
				style="background: #FFE8CC;margin-right: 15px;border-radius:20px;margin-top: 0px;">
			​
				<div style=" margin-right: 15px" class="row">
					<div class="col-xs-12" style="text-transform: uppercase;color: #4C4C4C">
						<h2 style="padding-left: 15px;">Delivery Details</h2>
					</div>

			     </div>


			​
			​
				<div class="row" >
				

					<div class="col-md-12 col-sm-12 col-xs-12">
						<div  style="margin-top:-30px">
							<form action="{{ url('bkashmicrosite/customerorderinfo') }}" method="post" 
							      id="customerdata">
								{{ csrf_field() }}
								​
								​                            <input type="hidden" name="orderdata" value="" id="orderdata">
								<input type="hidden" name="ordertotal" value="{{ $orderTotal }}" id="ordertotal">
								<input type="hidden" name="ordersubtotal" value="{{ $orderSubTotal }}" id="ordersubtotal">
								<input type="hidden" name="deliverycharge" value="{{ $deliverycharge }}" id="deliverycharge">

							
						<div class="col-md-12 col-sm-12 col-xs-12" style="background: #FFE8CC;margin-bottom: 5px;">
									<input type="text" name="name" id="name" class="form-control" placeholder="Full Name" 
									style="margin-top:3px;border:1px solid #000" />
						</div>

						<div class="col-md-12 col-sm-12 col-xs-12"
							style="background: #FFE8CC;margin-bottom: 5px;">
							<input type="text" name="contactno" id="contactno" class="form-control" placeholder="Mobile Number" style="margin-top:3px;border:1px solid #000" required="" />
						</div>

						<div class="col-md-12 col-sm-12 col-xs-12" style="background: #FFE8CC;margin-bottom: 3px;">
							<input type="text" name="email" id="email" class="form-control" placeholder="Email Address" style="border:1px solid #000;margin-top:3px;" />
						</div>
								​
								​
						<div class="col-md-12 col-sm-12 col-xs-12"
								style="background: #FFE8CC;margin-bottom: 3px;">
								<textarea type="text" name="address" value="" id="address" class="form-control" placeholder="Address" readonly="" 
								style="margin-top:4px;border:1px solid #000" ></textarea>
						</div>


				<input type="hidden" id="zonename" value="<?php echo Session::get('MyZoneName'); ?>" name="">
							​

						<div class="col-md-12 col-sm-12 col-xs-12"
							style="margin-top:3px;background: #FFE8CC;padding-bottom: 35px;border-bottom-left-radius:  20px;border-bottom-right-radius:  20px;">
							<textarea type="text" name="specialinstruction" id="specialinstruction" class="form-control" placeholder="Special Instruction" style="margin-top:3px;border:1px solid #000" required="" ></textarea>
						</div>

						

					</div> 
					​

				</div>

			</div>
		</div>
	​
	</div>

​

<div class="container" style="bottom:0;width:100%; z-index:1; background: url({{ asset('FrontendCSSJS/img/footer.png') }});background-size: cover !important;
                   background-repeat: no-repeat; position: fixed;border-right: 2px solid #EE7700;border-left: 2px solid #EE7700;border-bottom: 2px solid #EE7700; margin-right:0px !important">

	<div class="row">
		​
		<div class="col-md-4 col-sm-4 col-xs-4"></div>
		​
		<div class="col-md-4 col-sm-4 col-xs-4" style="padding-left: 0px; padding-right: 0px;">
			<a href="#" style="">
				<img src="{{ asset('FrontendCSSJS/img/placeorder.png') }}" class="img-responsive" style=";
				margin-top: 20px;margin-bottom: 20px;" onclick="$('#customerdata').submit()">
			</a>
		</div>
		<div class="col-md-4 col-sm-4 col-xs-4"></div>
	</div>
	
</div>
</form>
</div>
</body>
<script src="{{ asset('sweetalert.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#orderdata').val(sessionStorage.getItem('shopping­cart­items'));
		console.log(sessionStorage.getItem('shopping­cart­items'));
	})
</script>

​
<script type="text/javascript">
	$(document).ready(function(){
		$('#customerdata').submit(function(e){
			
			var name = $('#name').val();
			var address = document.getElementById('address').value;
			var contact = $('#contactno').val();
			

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
     
        $(document).ready(function () { 
            var obj = JSON.parse(sessionStorage.getItem('shippingaddress'));
        if ( obj != null) { 
        	var zonename = $('#zonename').val();
        	var shippingaddress = 'Flat : '+obj[0].flatno+', '+'House : '+obj[0].houseno+', '+'Road/Block : '+obj[0].roadno+', '+zonename
            $('#address').val(shippingaddress);
            
        }     
    }); 
</script>

@endsection