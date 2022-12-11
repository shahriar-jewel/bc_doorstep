@extends('Frontend.layouts.manage')
@section('content')
<div class="container-fluid menuBox">
	<h1 style="margin-left:10px"> Hi User</h1>
	<h1> </h1>
	<div class="row">
		<div id="myBasket">
			<div class="col-md-8 col-sm-8 col-xs-12 wrap">
				<table class="table order-history-cont">
					<thead style="background-color: #ffd199">
						<tr>
							<th  width="50%">Item</th>
							<th  width="20%">Quantity</th>
							<th width="18%">Price</th>
							<th width="2%">Remove</th>
						</tr>
					</thead>
					<tbody>
						@if(!empty($allOrderInput))
						@foreach($allOrderInput as $OrderInput)
						<tr> 
							<td>
								<b>{{ $OrderInput->foodname }}</b> <br>No toppings yet<br>
							</td> 
							<td> 	
										
								<form action="#" method="post" id="cartForm329364" style="color:black;" autocomplete="off">
									<select style="color:black">
										<option value="1">1</option>
										<option value="{{ $OrderInput->qty }}" selected>{{ $OrderInput->qty }}</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>							
									</select>
								</form> 
							</td>
							<td> 
								{{ $OrderInput->foodprice }}
							</td>
							<td> 
								<a href="#" onclick="RemoveDealFromBasket('1465', '41653806')"> <span class="removeIcon" title="remove this item?"> X </span> </a> 
							</td>					
						</tr>
						@endforeach
						@endif							
						
						<tr class="sub-total" style="background-color: #ffe8cc">
							<th class="sub-total" colspan="4" scope="row" style="color:black; text-align: right">Sub Total Rs.
							219</th>
						</tr>
						<tr class="sub-total" style="background-color:">
							<th class="sub-total" colspan="4" scope="row" style="color:black; text-align: right">Tax (0 % ) Rs. 
							0</th>
						</tr>
						<tr class="sub-total" style="background-color: #ffd199">
							<th class="sub-total" colspan="4" scope="row" style="color:black; text-align: right"> Total Rs.
							219</th>
						</tr>		
					</tbody>
				</table>
				<!--. BK Coupon portion -->
				<div class="col-md-12 col-sm-12 col-xs-12"> 
					<div id="cpnDiv">
						<form method="post" action="">
							<p class="center"> Enter your coupon code (if any).</p>
							<div class="col-md-offset-2 col-md-6 col-sm-6 col-xs-6 col-xs-offset-2">
								<input type="text" name="cpnCode" placeholder="Enter Your Coupon Code" class="form-control"> 
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4" >
								<input type="submit" value="Submit" class="btn btn-danger"> 
							</div>
						</form>
						<P> 
							<div class="col-md-offset-2 col-md-6 col-sm-6 col-xs-6 col-xs-offset-2">
								<center>
									<span style="color:red">  <span>
									</center>
								</div>

							</P>
						</div>
					</div>
					<form method="post" action="">
						<div class="col-md-12 col-sm-12 col-xs-12"> 



							<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12 col-xs-offset-0 terms" style="margin-top:10px">

								<input type="button" value="Please Login or Register" id="submit" class="btn btn-danger btn-block" />


							</div>
						</div>

					</form>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-12">
					<div class="login" id="loginDiv" style="margin-top:-10px">
						<form action="{{ url('customer-order/create') }}">
							{{ csrf_field() }}
							<div class="col-md-6 col-sm-6 col-xs-6">

								<h4> Login </h4> 
							</div>

							<input type="hidden" name="orderdata" value="{{ json_encode($allOrderInput,TRUE)}}" id="orderdata">

							<div class="col-md-12 col-sm-12 col-xs-12">
								<input type="text" name="emailaddress" id="emailaddress" class="form-control" placeholder="example@gmail.com">
							</div>

							<div class="col-md-12 col-sm-12 col-xs-12">
								<input type="password" name="password" id="password" class="form-control" placeholder="*****" style="margin-top:2px">
							</div>

							<div class="col-md-12 col-sm-12 col-xs-12">
								<input type="submit" name="submit" id="submit" class="btn btn-block" value="Login" style="margin-top:2px">
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12">
							</div>

						</form>
					</div> 



					<div class="register" id="regDiv">

						<form action="reg.php" method="post">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<h4> Register </h4> 
							</div>

							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" name="fname" id="fname" class="form-control" placeholder="First name" style="margin-top:2px">
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" name="lname" id="lastname" class="form-control" placeholder="Last name" style="margin-top:2px">
							</div>

							<div class="col-md-12 col-sm-12 col-xs-12">
								<input type="text" name="emailaddress" id="email" class="form-control" placeholder="email" style="margin-top:2px">
							</div>


							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="password" name="password" id="password" class="form-control" placeholder="password" style="margin-top:2px">
							</div>

							<div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 3px; margin-bottom: 3px">

								<select name="city" class="form-control js-example-basic-single" id="city" onchange="citySelectDrop()">
									<option value="1"> Karachi </option>	
									<option value="3"> Lahore </option>	
									<option value="4"> Faisalabad </option>	
									<option value="5"> Multan </option>	
									<option value="6"> Quetta </option>	
									<option value="7"> Rawalpindi </option>	
									<option value="8"> Hyderabad </option>	
									<option value="9"> Peshawar </option>	
									<option value="10"> Wah Cantt </option>	
								</select>

							</div>

							<div class="col-md-12 col-sm-12 col-xs-12" id="areadiv">
								<input required type="text" name="area" id="area" class="form-control" placeholder="area">
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<input required type="text" name="address" id="address" class="form-control" placeholder="home address" style="margin-top:4px">
							</div>

							<div class="col-md-12 col-sm-12 col-xs-12">
								<input required type="text" name="phone" id="phone" class="form-control" placeholder="Mobile No" style="margin-top:2px" pattern="[0-9]{11}" title="Valid Mobile No">
							</div>

							<div class="col-md-12 col-sm-12 col-xs-12">
								<input type="submit" name="submit" id="submit" class="btn btn-block" value="Register" style="margin-top:2px">			 
							</div>
						</form>
					</div> 


					<!-- If user is logged in display the order history OR User Information of the user -->
				</div>

				<script type="text/javascript">
					function citySelectDrop() {
						$("#areaSelect").html('<option>Loading...</option>');
						var city = $('#city option:selected').attr('value');
						$.ajax({
							url:"changesCity.php",  
							type:"POST",
							data:"city="+city,
							success:function(content) {
								$('#areadiv').html(content);
								$('.js-example-basic-single').select2();

								$("#area").select2();	

							}
						});
					}

				</script>

				<script type="text/javascript">
					$( document ).ready(function() {
						citySelectDrop();
					});

				</script>
			</div>

		</div>
		<div>
			
		</div>


	</div>
	@endsection