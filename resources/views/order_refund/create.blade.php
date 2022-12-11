@extends('common.layout')
@section('extra_css')
<style type="text/css">
	/*div.checker {
    	margin-top: 2px;
    	margin-left: -2px;
    	}*/
	/*
	 * select2 ajax search markup css
	 */
	 .select2-result-repository{padding-top:4px;padding-bottom:3px}
	 .select2-result-repository__avatar{float:left;width:60px;margin-right:10px}
	 .select2-result-repository__avatar img{width:100%;height:auto;border-radius:2px}
	 .select2-result-repository__meta{margin-left:70px}
	 .select2-result-repository__title{color:black;font-weight:700;word-wrap:break-word;line-height:1.1;margin-bottom:4px}
	 .select2-result-repository__mobile,.select2-result-repository__stargazers{margin-right:1em}
	 .select2-result-repository__mobile,.select2-result-repository__stargazers,.select2-result-repository__home{display:inline-block;color:#aaa;font-size:11px}
	 .select2-result-repository__description{font-size:13px;color:#777;margin-top:4px}.select2-results__option--highlighted .select2-result-repository__title{color:white}
	 .select2-results__option--highlighted .select2-result-repository__mobile,.select2-results__option--highlighted .select2-result-repository__stargazers,.select2-results__option--highlighted .select2-result-repository__description,.select2-results__option--highlighted .select2-result-repository__home{color:#c6dcef}
	/*
	 * end select2 ajax search markup css
	 */
	 .menuItem{
	 	border: 1px solid;
	 	border-color: #dadcdc;
	 	margin: 10px 0 10px 0 !important ;
	 	/*padding-bottom: 10px;*/
	 }
	 .topmenuItemSection{
	 	border-bottom: 1px solid;
	 	border-color: #dadcdc;
	 	padding-bottom: 5px;
	 }
	 .topmenuItemSection .title{
	 	font-weight: 700;
	 }
	 .itemSection{
	 	padding-top: 5px;
	 	/*padding-bottom: 5px;*/
	 }
	 .itemImage{
	 	width: 80px; height: 60px;
	 }
	 .itemImage>img {
	 	max-width:100%;max-height:100%; 
	 }

	 .cart-item-holder{
	 	padding: 10px 15px 10px 15px ;		
	 }
	 .cart-price-holder{
	 	padding: 10px 15px 10px 15px ;	
	 	border-top: 1px dashed;	
	 }
	 .cart-price-holder .value{
	 	text-align: right;
	 	font-weight: 700;
	 }
	 .cart-total-price{
	 	border: 1px solid;
	 	background-color: #dadada;
	 }
	 .cart-item-title-holder{
	 	margin-bottom: 3px;
	 }
	 .cart-item-title{
	 	font-weight: 700;
	 	margin-bottom: 0px;
	 }
	 .cart-item-addon{
	 	padding: 0px 0px 0px 15px; 
	 	margin-bottom: 0px; 
	 	font-size: 12px;
	 }
	 .cart-item-qty{
	 	padding-left: 5px ;
	 	padding-right: 5px;
	 }
	 .cart-item-price{
	 	font-weight: 700;
	 	float: right;
	 } 

	</style>
	@endsection


	@section('content')
	<div class="page-content">
		
		<!-- BEGIN PAGE HEADER-->
		<h3 class="page-title">
			Order <small>create and edit</small>
		</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<i class="fa fa-dashboard"></i>
					<a href="{{ route('dashboard.index') }}">Dashboard</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="{{ route('order.index') }}">Order</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">Add New</a>
				</li>
			</ul>
		</div>
		<!-- END PAGE HEADER-->
		<!-- BEGIN PAGE CONTENT-->

		<div class="row">
			<div class="col-md-12">
				<div class="portlet box green-haze ">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-user"></i> Customer Info
						</div>
					</div>
					<div class="portlet-body form form-horizontal">
						@include('common.alert')
						<form class="form-horizontal" action="{{ route('order.store') }}" method="post" role="form" id="customerForm">
							{{ csrf_field() }}
							<div class="form-body" id="customerSection">

								<!-- <div class="form-group" >
									<div class="col-md-6">
										<label class="col-md-3 control-label ">Search</label>
										<div class="col-md-9 {{ $errors->has('cuscontactno') ? 'has-error' : '' }}">
											<select class="form-control search-customer-data-ajax" name="searchCustomer" id="searchCustomer" >
											</select>
										</div>
									</div>
								</div> -->

								<div class="form-group">
									<div class="col-md-6">
										<label class="col-md-3 control-label ">Search</label>
										<div class="col-md-9 {{ $errors->has('cuscontactno') ? 'has-error' : '' }}">
											<input class="form-control" name="customerphone" id="customerphone" placeholder="Enter phone number">
											
											@if ($errors->has('cuscontactno'))
											<span class="help-block has-error">
												<strong>{{ $errors->first('cuscontactno') }}</strong>
											</span>
											@endif
										</div>
									</div>

									<div class="col-md-7">
										<label class="col-md-5 control-label " id="cusauth"> </label>
									</div>
								</div>


								<input type="hidden" name="address_type" id="address_type" value="">

								<div class="form-group" style="display: none;">
									<div class="col-md-6">
										<label class="col-md-3 control-label ">custo id</label>
										<div class="col-md-9 {{ $errors->has('cuscontactno') ? 'has-error' : '' }}">
											<input class="form-control" name="customerid" id="customerid">
											
											@if ($errors->has('cuscontactno'))
											<span class="help-block has-error">
												<strong>{{ $errors->first('cuscontactno') }}</strong>
											</span>
											@endif
										</div>
									</div>
								</div>
								
								<div class="form-group" >
									<div class="col-md-6">
										<label class="col-md-3 control-label ">Mobile Number</label>
										<div class="col-md-9 {{ $errors->has('cuscontactno') ? 'has-error' : '' }}">
											<input class="form-control" name="cuscontactno" id="cuscontactno">
											
											@if ($errors->has('cuscontactno'))
											<span class="help-block has-error">
												<strong>{{ $errors->first('cuscontactno') }}</strong>
											</span>
											@endif
										</div>
									</div>

									<div class="col-md-6">
										<label class="col-md-3 control-label ">Customer Name</label>
										<div class="col-md-9 {{ $errors->has('cusname') ? 'has-error' : '' }}">
											<input type="text" name="cusname" id="cusname" class="form-control" placeholder="Customer Name">
											@if ($errors->has('cusname'))
											<span class="help-block has-error">
												<strong>{{ $errors->first('cusname') }}</strong>
											</span>
											@endif
										</div>
									</div>
								</div>

								<div class="form-group" id="custaddress" style="display: none;"> 
									<div class="col-md-6">
										<label class="col-md-3 control-label ">Delivery Address</label>
										<div class="col-md-9">
											<textarea class="form-control" name="address" id="address" placeholder="Address"></textarea> 
											
										</div>
									</div>
								</div>

								

								<div class="form-group" >
									<div class="col-md-6">
										<label class="col-md-3 control-label ">Addresses</label>
										<div class="col-md-9 {{ $errors->has('address') ? 'has-error' : '' }}">

											<table class="table table-striped table-bordered table-hover" id="sample_1">
												<tbody>
													<tr>
														<td>
															<select class="form-control select2me" name="cusaddress" id="cusaddress">
																<option value="">- - - Select - - -</option>
															</select>
														</td>
														<td><a style="color: blue;" href="#" class="addRow Scroll"><i class="fa fa-plus"></i></a></td>
													</tr>
													@if ($errors->has('address'))
													<span class="help-block has-error">
														<strong>{{ $errors->first('address') }}</strong>
													</span>
													@endif

												</tbody>
											</table>
										</div>
									</div>
									<div class="col-md-6">
										<label class="col-md-3 control-label ">Special Instruction</label>
										<div class="col-md-9 {{ $errors->has('specialinstruction') ? 'has-error' : '' }}">
											<textarea class="form-control" id="specialinstruction" name="specialinstruction" placeholder="Write comments if you are alergic to something. eg: no mayo, no onion, etc."></textarea> 
											@if ($errors->has('specialinstruction'))
											<span class="help-block has-error">
												<strong>{{ $errors->first('specialinstruction') }}</strong>
											</span>
											@endif
										</div>
									</div>
								</div>

								
								<input type="hidden" name="orderdata" value="" id="orderdata">
								<input type="hidden" name="ordersubtotal" value="" id="ordersubtotal" >
								<input type="hidden" name="ordertotal" value="" id="ordertotal" >
								<input type="hidden" name="orderdlfee" value="" id="orderdlfee" >
								<input type="hidden" name="discount" value="" id="discount" >
							</div>
							<!-- </form> -->
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="portlet box green-haze ">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-search-plus"></i> Create New Order
							</div>
						</div>
						<div class="portlet-body form form-horizontal">
							@include('common.alert')
							<!-- <form class="form-horizontal" action="#" method="post" role="form"> -->
								{{-- csrf_field() --}}
								<div class="form-body">

									<div class="form-group" >
										<div class="col-md-4">
											<label class="col-md-2 control-label ">Location</label>
											<div class="col-md-10 {{ $errors->has('location') ? 'has-error' : '' }}">
												<select class="form-control select2me" name="location" id="locid">
													<option value="">-select a location-</option>
													@foreach ($allDeliveryzone as $zoneid => $zonename )
													<option value="{{ $zoneid }}" >
														{{ $zonename }}
													</option>
													@endforeach
												</select>

												@if ($errors->has('location'))
												<span class="help-block has-error">
													<strong>{{ $errors->first('location') }}</strong>
												</span>
												@endif
											</div>
										</div>

										<div class="col-md-4">
											<label class="col-md-2 control-label ">Branch</label>
											<div class="col-md-10 {{ $errors->has('branch') ? 'has-error' : '' }}">
												<select class="form-control select2" name="branch" id="branchid">
													<option value="">-select a branch-</option>
												</select>

												@if ($errors->has('branch'))
												<span class="help-block has-error">
													<strong>{{ $errors->first('branch') }}</strong>
												</span>
												@endif
											</div>
										</div>
										<div class="col-md-4">
											<label class="col-md-5 control-label ">Payment Method</label>
											<div class="col-md-7 {{ $errors->has('branch') ? 'has-error' : '' }}">
												<select class="form-control select2me" name="paymentmethod" id="paymentmethod" required="">
													<option value="">- - - Select - - -</option>
													<option value="1">Cash On Delivery</option>
													<option value="2">Card On Delivery</option>
													<option value="3">Cash On bKash</option>
												</select>
											</div>
										</div>

										<!-- categoryid for searching food -->
										<input type="hidden" name="catid" id="catid" value="">
										
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>


			<div class="row">
				<div class="col-md-12">
					<div class="portlet box green-haze ">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cutlery"></i> Food Category 
							</div>
						</div>
						<div class="portlet-body " style="max-height: 280px !important; overflow: auto;">
							<div class="form-body" >
								<div class="row" >
									<div class="mycategorysection" id="mycategorysection">

										

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>



			<div class="row">
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-5 pull-right">
							<input type="text" placeholder="Enter search key" name="SearchFood" id="SearchFood" class="form-control pull-right">
						</div>
					</div>
					<div class="portlet box green-haze">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cutlery"></i> Food Menu 
							</div>
						</div>
						<div class="portlet-body ">
							@include('common.alert')
							<div class="form-body" >
								<div id="foodMenuSection">
								<!-- <h3>FLAME-GRILLED BURGERS</h3>
								<div class="row menuItem">
									<div class="topmenuItemSection col-md-12">
										<h4 class="title">Creamy Double Cheeseburger</h4>
										<p>flame-grilled beef topped with juicy tomatoes, fresh lettuce, creamy mayonnaise, ketchup, crunchy pickles, and sliced white onions on a soft sesame seed bun</p>
									</div>

									<div class="itemSection col-md-12" >
										<div class="col-md-2 col-sm-2 col-xs-2 itemImage" >
											<img src="http://www.placehold.it/80x60/EFEFEF/AAAAAA&amp;text=no+image" alt="preview" id="preview-image" />
										</div>
										<div class="col-md-4 col-sm-4 col-xs-4"><strong>Creamy Double Cheeseburger</strong></div>
										<div class="col-md-2 col-sm-2 col-xs-2"><strong>1:1</strong></div>
										<div class="col-md-3 col-sm-3 col-xs-3"><strong>349.00 Tk</strong></div>
										<div class="col-md-1 col-sm-1 col-xs-1" align="right">
											<button type="button" class="btn btn-sm red">Add</button>
										</div>
									</div>
									
									<div class="itemSection col-md-12" >
										<div class="col-md-2 col-sm-2 col-xs-2 itemImage" >
											<img src="http://www.placehold.it/80x60/EFEFEF/AAAAAA&amp;text=no+image" alt="preview" id="preview-image" />
										</div>
										<div class="col-md-4 col-sm-4 col-xs-4"><strong>Creamy Double Cheeseburger</strong></div>
										<div class="col-md-2 col-sm-2 col-xs-2"><strong>1:1</strong></div>
										<div class="col-md-3 col-sm-3 col-xs-3"><strong>349.00 Tk</strong></div>
										<div class="col-md-1 col-sm-1 col-xs-1" align="right">
											<button type="button" class="btn btn-sm red">Add</button>
										</div>
									</div>

									<div class="itemSection col-md-12" >
										<div class="col-md-2 col-sm-2 col-xs-2 itemImage" >
											<img src="http://www.placehold.it/80x60/EFEFEF/AAAAAA&amp;text=no+image" alt="preview" id="preview-image" />
										</div>
										<div class="col-md-4 col-sm-4 col-xs-4"><strong>Creamy Double Cheeseburger</strong></div>
										<div class="col-md-2 col-sm-2 col-xs-2"><strong>1:1</strong></div>
										<div class="col-md-3 col-sm-3 col-xs-3"><strong>349.00 Tk</strong></div>
										<div class="col-md-1 col-sm-1 col-xs-1" align="right">
											<button type="button" class="btn btn-sm red">Add</button>
										</div>
									</div>

								</div> -->
								
								<!-- <h3>CHICKEN</h3>
								<div class="row menuItem">
									<div class="topmenuItemSection col-md-12">
										<h4 class="title">Whopper</h4>
										<p>flame-grilled beef topped with juicy tomatoes, fresh lettuce, creamy mayonnaise, ketchup, crunchy pickles, and sliced white onions on a soft sesame seed bun</p>
									</div>
									<div class="itemSection col-md-12" >
										<div class="col-md-2 col-sm-2 col-xs-2 itemImage" >
											<img src="http://www.placehold.it/80x60/EFEFEF/AAAAAA&amp;text=no+image" alt="preview" id="preview-image" />
										</div>
										<div class="col-md-4 col-sm-4 col-xs-4"><strong>Whopper</strong></div>
										<div class="col-md-2 col-sm-2 col-xs-2"><strong>1:1</strong></div>
										<div class="col-md-3 col-sm-3 col-xs-3"><strong>349.00 Tk</strong></div>
										<div class="col-md-1 col-sm-1 col-xs-1" align="right">
											<button type="button" class="btn btn-sm red">Add</button>
										</div>
									</div>
								</div> -->

							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="portlet box green-haze ">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-shopping-cart"></i> Cart 
						</div>
						<div class="actions">
							<button type="button" class="btn btn-sm btn-default btn-clear-cart">Clear</button>
						</div>
					</div>
					<div class="portlet-body ">
						<div class="form-body cart-container">
							<div class="cart-item-holder" id="cart-item-holder" >
								<span id="shopping-cart-annimation"></span>
								<div class="empty-cart {{ $errors->has('orderdata') ? 'has-error' : '' }}" >
									@if ($errors->has('orderdata'))
									<span class="help-block has-error">
										<strong>Select Food Then submit</strong>
									</span>
									@endif
									Cart is empty
								</div>
								<!-- <div class="cart-item" >
									<div class="row">
										<div class="col-md-12 cart-item-title-holder" >
											<p class="cart-item-title">Whopper</p>
											<p class="cart-item-addon">+Add Cheese</p>
											<p class="cart-item-addon">+Add Extra Chicken Paty</p>
											<p class="cart-item-addon">+Add Cheese</p>
											<p class="cart-item-addon">+Add Cheese</p>
										</div>
										<div class="col-md-12">
											<button type="button" class="btn btn-xs btn-circle red"><i class="fa fa-plus"></i></button>
											<span class="cart-item-qty" >1</span>
											<button type="button" class="btn btn-xs btn-circle "><i class="fa fa-minus"></i></button>
											<span class="cart-item-price">300 Tk</span>
										</div> 
									</div>
									<hr>
								</div>
								
								<div class="cart-item">
									<div class="row"> 
										<div class="col-md-12 cart-item-title-holder" >
											<p class="cart-item-title">Whopper</p>
											<p class="cart-item-addon">No topping</p>
										</div>
										<div class="col-md-12">
											<button type="button" class="btn btn-xs btn-circle red"><i class="fa fa-plus"></i></button>
											<span class="cart-item-qty" >1</span>
											<button type="button" class="btn btn-xs btn-circle "><i class="fa fa-minus"></i></button>
											<span class="cart-item-price">300 Tk</span>
										</div> 
									</div>
									<hr>
								</div> -->




<!-- 
								<div class="row">
									<div class="col-md-12 cart-item-title-holder" >
										<p class="cart-item-title">Whopper</p>

										<div class="row">

											<div class="col-md-6">
												<p class="cart-item-addon">+Add Tender crisp patty</p>
											</div>
											<div class="col-md-6">
												<button type="button" class="btn btn-xs btn-circle red"><i class="fa fa-plus"></i></button>
												<span class="cart-item-qty" >1</span>
												<button type="button" class="btn btn-xs btn-circle "><i class="fa fa-minus"></i></button>
											</div>

										</div>
									</div>
									<div class="col-md-12">
										<button type="button" class="btn btn-xs btn-circle red"><i class="fa fa-plus"></i></button>
										<span class="cart-item-qty" >1</span>
										<button type="button" class="btn btn-xs btn-circle "><i class="fa fa-minus"></i></button>
										<span class="cart-item-price">300 Tk</span>
									</div> 
								</div>
								<hr> -->
								

								




							</div>
							<div class="cart-price-holder" id="cart-price-holder" >
								<div class="row static-info">
									<div class="col-md-5 name">
										Sub Total:
									</div>
									<div class="col-md-7 value" id="cart-sub-total">
										0.00 Tk
									</div>
								</div>
								<div class="row static-info">
									<div class="col-md-5 name">
										Discount
									</div>
									<div class="col-md-7 value" id="cart-discount">
										0.00 Tk
									</div>
								</div>
								<div class="row static-info">
									<div class="col-md-5 name">
										Delivery Fee:
									</div>
									<div class="col-md-7 value" id="cart-deliveryfee" >
										0.00 Tk
									</div>
								</div>
								<div class="row static-info">
									<div class="col-md-5 name">
										Service Charge:
									</div>
									<div class="col-md-7 value" id="cart-service-charge" >
										0.00 Tk
									</div>
								</div>

								<div class="row static-info cart-total-price" >
									<div class="col-md-5 name">
										Total:
									</div>
									<div class="col-md-7 value" id="cart-total-price">
										0.00 Tk
									</div>
								</div>

							</div>
						</div>

						<div class="form-actions">
							<div class="row">
								<!-- <div class="col-md-offset-3 col-md-9" align="center"> -->
									<div class="col-md-12" align="center">
										<button type="submit" class="btn green" onclick="$('#customerForm').submit()">Submit Order</button>
										<!-- <button type="reset" class="btn btn-sm red">Clear</button> -->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade topping-modal" id="basic" tabindex="-1" role="basic" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title" align="center"><strong>Toppings</strong></h4>
						</div>
						<div class="modal-body">
							<p><strong>Add On </strong> <span class="max-addon" >Max:8</span>|<span class="min-addon">Min:0</span>|<span class="addon-option">Optional</span></p>
							<div class="row" id="addon-holder">

							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn default" data-dismiss="modal">Close</button>
							<button type="button" class="btn red btn-modal-add-to-cart" data-itemid="" data-itemname="" data-maxtopping="" data-mintopping="" data-topping-required="" >Add to Cart</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			<!-- /.modal -->

			<!-- END PAGE CONTENT-->
		</div>
		@endsection

		@section('extra_js')
		
		<script src="{{ asset('sweetalert.js') }}"></script>

		<script type="text/javascript">

			$('#searchCustomer').on('change', function() {
				var cusID = this.value;
				$.ajax({
					method: "POST",
					url: "{{ url('ajax/searchcustomerbyid') }}",
					dataType: "json",
					data: { _token: "{{ csrf_token() }}" , cus_id : cusID }
				}).done(function( resultData ) {
					if( resultData.msg && resultData.msg=='success' && resultData.data ) {
						var _data = resultData.data;
						$('#cuscontactno').val(_data.mobile);
						$('#cusname').val(_data.name);
						$('#cusaddress').val(_data.address);
					} else if( resultData.msg && resultData.msg=='nodata' ) {
						$('#cuscontactno').val("");
						$('#cusname').val("");
						$('#cusaddress').val("");
					}
				});
			});

			$(".search-customer-data-ajax").select2({
				ajax: {
		// method:"POST",
		url: "{{ url('ajax/searchcustomer') }}",
		dataType: 'json',
		delay: 250,
		data: function (params) {
			return {
			    q: params.term, // search term
			    page: params.page
			};
		},
		processResults: function (data, page) {
		      // parse the results into the format expected by Select2.
		      // since we are using custom formatting functions we do not need to
		      // alter the remote JSON data
		      return {
		      	results: data.items
		      };
		  },
		    // cache: true
		},
		placeholder: 'Search for customer',
		minimumInputLength: 5,
		escapeMarkup: function (markup) { 
			return markup; 
		}, // let our custom formatter work
		templateResult: formatRepo,
		templateSelection: formatRepoSelection
	});
			function formatRepo (repo) {
				if (repo.loading) {
					return repo.text;
				}

				var markup = "<div class='select2-result-repository clearfix'>" +
				"<div class='select2-result-repository__avatar'><img src='https://placehold.it/60x60?text=no%20image' /></div>" +
				"<div class='select2-result-repository__meta'>" +
				"<div class='select2-result-repository__title'>"+repo.name+"</div>";


				markup += "<div class='select2-result-repository__statistics'>" +
				"<div class='select2-result-repository__mobile'><i class='fa fa-phone'></i>"+repo.mobile+"</div>" +
		// "<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> Stars</div>" +

		"<div class='select2-result-repository__home'><i class='fa fa-home'></i>"+repo.address+"</div>" +
		"</div>" +
		"</div></div>";

		return markup;
	}
	function formatRepoSelection (repo) {
		return repo.name || repo.text;
	}


	$('#locid').on('change', function() {
		clearCart();
		$('#mycategorysection').empty();
		var locID = this.value;
		$.ajax({
			method: "POST",
			url: "{{ url('ajax/branchbylocation') }}",
			dataType: "json",
			data: { _token: "{{ csrf_token() }}" , loc_id : locID }
		}).done(function( resultData ) {
	    	// console.log(resultData);

	    	if( resultData.msg && resultData.msg=='success' && resultData.data && resultData.data.length > 0 ) {
	    		var _data = resultData.data;
	    		var _optValue = "<option value='' >-select a branch-</option>";
	    		for( var i=0; i<resultData.data.length; i++ ) {
	    			_optValue+= '<option value="'+resultData.data[i].branchid+'">'+resultData.data[i].branchname+'</option>';
	    		}
	    		$('#branchid').val(_optValue).trigger('change');
	    		$('#branchid').find('option').remove().end().append(_optValue);
	    	} else if( resultData.msg && resultData.msg=='nodata' ) {
	    		$('#branchid').val("").trigger('change');
	    		$('#branchid').find('option').remove();
	    	}
	    });
	});

	



	function activatePopover(){
		$('[data-toggle="popover"]').popover(); 
	}

</script>

<script type="text/javascript">

	var shoppingCartItems = [];     
	$(document).ready(function () { 
		var obj = JSON.parse(sessionStorage.getItem('shopping­cart­items'));
		// console.log(obj);
		if ( obj != null) { 
			// shoppingCartItems = JSON.parse(sessionStorage["shopping­cart­items"].toString());
			shoppingCartItems = obj;
		} 
		displayShoppingCartItems();     
	}); 

	function addToCartAnnimation(e){
		// console.log(e);
		var id = $(e).data("itemid");
		var cart = $('#shopping-cart-annimation');
		var imgtodrag = $('#'+id).find("img").eq(0);
		if (imgtodrag) {
			var imgclone = imgtodrag.clone()
			.offset({
				top: imgtodrag.offset().top,
				left: imgtodrag.offset().left
			})
			.css({
				'opacity': '0.5',
				'position': 'absolute',
				'height': '150px',
				'width': '150px',
				'z-index': '100'
			})
			.appendTo($('body'))
			.animate({
				'top': cart.offset().top + 10,
				'left': cart.offset().left + 10,
				'width': 75,
				'height': 75
			}, 1000, 'easeInOutExpo');

			setTimeout(function () {
				cart.effect("shake", {
					times: 2
				}, 200);
			}, 1500);

			imgclone.animate({
				'width': 0,
				'height': 0
			}, function () {
				$(this).detach()
			});
		}
	}

	/*
	 * Add to cart function from Menu. 
	 * function for adding Item to cart. If there is no topping with the food then 'btn-add-to-cart' will execute. 
	 */
	 $("#foodMenuSection").on('click','.btn-add-to-cart',function () { 

	 	addToCartAnnimation(this);

	 	var button = $(this);  
	 	var id = button.data("itemid");  
	 	var name = button.data("itemname");  
	 	var price = button.data("itemprice");           
	 	var quantity = 1;    
	 	var topping = button.data("topping");     

	 	var item = {             
	 		id: id,             
	 		name: name,             
	 		price: price,             
	 		totalprice: price,             
	 		quantity: quantity,
	 		topping: topping     
	 	};         
	 	var exists = false;    

	 	if (shoppingCartItems.length > 0) {            
	 		$.each(shoppingCartItems, function (index, value) { 
	 			if (value.id == item.id) {            
	 				value.quantity++;
	 				exists = true;                     
	 				return false;                 
	 			}             
	 		});         
	 	}  

	 	if (!exists) {             
	 		shoppingCartItems.push(item);         
	 	} 

	 	sessionStorage.setItem('shopping­cart­items', JSON.stringify(shoppingCartItems));
	 	displayShoppingCartItems();    
	 });


	/*
	 * 
	 * function for adding toppings to modal. 
	 *
	 */
	 $("#foodMenuSection").on('click','.btn-add-topping',function () { 
	 	var button = $(this);  
	 	var topping 		= button.data("topping");  
	 	var minaddon 		= button.data("mintopping");   
	 	var maxaddon 		= button.data("maxtopping");   
	 	var addonrequired 	= button.data("topping-required");   
	 	var addon = "";
	 	if (addonrequired == 1) {
	 		addon = 'Required';
	 	}else{
	 		addon = 'Optional';
	 	}

	 	$(".btn-modal-add-to-cart").data("maxtopping",maxaddon);
	 	$(".btn-modal-add-to-cart").data("mintopping",minaddon);
	 	$(".btn-modal-add-to-cart").data("topping-required",addonrequired);
	 	$(".btn-modal-add-to-cart").data("itemid",button.data("itemid"));
	 	$(".btn-modal-add-to-cart").data("itemname",button.data("itemname"));
	 	$(".btn-modal-add-to-cart").data("itemprice",button.data("itemprice"));


	 	var htmlString = "";
	 	$.each(topping, function (index, value) {
	 		htmlString += "<div class='col-md-6'>";
	 		htmlString += "<label><input type='checkbox' value='"+value.foodid+"' name='addon[]' required='required' data-addonname='"+value.foodname+"' data-addonprice='"+value.price+"'> Add "+value.foodname+" ( "+value.price+" Tk )</label>"
	 		htmlString += "</div>"
	 	});

	 	$("#addon-holder").html(htmlString);
	 	$(".max-addon").html("Max : "+maxaddon);
	 	$(".min-addon").html("Min : "+minaddon);
	 	$(".addon-option").html(addon);

	 });

	/*
	 * Add to cart function from Modal . 
	 */
	 $(".topping-modal").on('click','.btn-modal-add-to-cart',function () { 

	 	addToCartAnnimation(this);

	 	var button = $(this);  
	 	var minaddon 		= button.data("mintopping");   
	 	var maxaddon 		= button.data("maxtopping");   
	 	var addonrequired 	= button.data("topping-required") ; 
	 	var id = button.data("itemid");  
	 	var name = button.data("itemname");  
	 	var price = button.data("itemprice");           
	 	var pricewithaddon = button.data("itemprice");           
	 	var quantity = 1;    

	 	var addonCount = document.querySelectorAll('input[name="addon[]"]:checked').length;
		// var checkboxes = document.getElementsByName("addon");
		if(addonCount < minaddon && addonrequired == 1 ){
			alert('Select '+minaddon+' at least');
			return ;
		}else if(addonCount > maxaddon){
			alert('You can select maximum '+maxaddon+' item !');
			return ;
		}
		var topping = [];
		$("input[name='addon[]']:checked").each ( function() {
			var toppingItem = {
				addonid 	: $(this).val(),
				name 		: $(this).data('addonname'),
				price 		: $(this).data('addonprice'),
				toppingqty  : 1,
				flag        : 0,
			};
			topping.push(toppingItem);
			pricewithaddon += parseFloat($(this).data('addonprice'));
		});

		var item = {             
			id: id,             
			name: name,             
			price: price,             
			totalprice: pricewithaddon,             
			quantity: quantity,
			topping: topping     
		};       

		var exists = false;    

		if (shoppingCartItems.length > 0) {            
			$.each(shoppingCartItems, function (index, value) { 
				if (value.id == item.id) {   
					if ( checkTopping(topping,value.topping) ){
						value.quantity++;
						exists = true;                     
						return false;                 
					}
				}             
			});         
		}  

		if (!exists) {             
			shoppingCartItems.push(item);         
		} 

		sessionStorage.setItem('shopping­cart­items', JSON.stringify(shoppingCartItems));
		displayShoppingCartItems();   
		$('.topping-modal').modal("hide");

	});

	 function checkTopping(firstArr,secondArr){
	 	var firstlen 	= firstArr.length;
	 	var secondlen 	= secondArr.length;
	 	var exists = false;

	 	if (firstlen == 0 && secondlen == 0 ) { return true; }
	 	if (firstlen != secondlen) { 
	 		return false ; 
	 	}else{
	 		$.each(firstArr, function (firstArrindex, firstArrvalue) { 
	 			exists = false;
	 			$.each(secondArr, function (secondArrindex, secondArrvalue) { 
	 				if (firstArrvalue.addonid == secondArrvalue.addonid) {
	 					exists = true ;
	 					return false;
	 				}
	 			});
	 			if (!exists) {
	 				return false;
	 			}

	 		});
	 	}

	 	if ( exists ) {
	 		return true;
	 	}else{
	 		return false;
	 	}
	 }


	 $("#cart-item-holder").on('click','.btn-item-add',function () { 
	 	var button = $(this);  
	 	var indexid = button.data("itemindex");  

	 	if (shoppingCartItems.length > 0) {            
	 		$.each(shoppingCartItems, function (index, value) { 
	 			if (index == indexid) {            
	 				value.quantity++;                     
	 				return false;                 
	 			}             
	 		});         
	 	}  

	 	sessionStorage.setItem('shopping­cart­items', JSON.stringify(shoppingCartItems));
	 	displayShoppingCartItems();    
	 });


	 $("#cart-item-holder").on('click','.btn-topping-add',function () { 
	 	var button = $(this);  
	 	var totaladdonprice = 0;
	 	var price = 0;
	 	var toppingindexid = button.data("toppingindex");  
	 	var indexid = button.data("itemindex");

	 	if (shoppingCartItems.length > 0) {            
	 		$.each(shoppingCartItems, function (index, item) { 
	 			
	 			if (index == indexid) {            
	 				$.each(item.topping, function(toppingIndex,toppingValue){

	 					if (toppingIndex == toppingindexid) {            
	 						toppingValue.toppingqty++;
	 						                     
	 						// return false;                 
	 					}  
                       price = toppingValue.toppingqty * toppingValue.price;
                       totaladdonprice += price;

	 				});  
	 				item.totalprice = item.price + totaladdonprice;              
	 			}   
	 		});         
	 	}  

	 	sessionStorage.setItem('shopping­cart­items', JSON.stringify(shoppingCartItems));
	 	displayShoppingCartItems();    
	 });


	 $("#cart-item-holder").on('click','.btn-item-remove',function () { 
	 	var button = $(this);  
	 	var indexid = button.data("itemindex");  
	 	var tmp = sessionStorage.getItem('shopping­cart­items');
	 	shoppingCartItems = JSON.parse(tmp);
	 	if (shoppingCartItems.length > 0) {            
	 		$.each(shoppingCartItems, function (index, value) { 
	 			if (index == indexid) {            
	 				value.quantity--; 
	 				if (value.quantity <= 0 ) {
				    	// delete shoppingCartItems[index] ;
				    	Array.prototype.remove = function(index){
				    		this.splice(index,1);
				    	}
				    	shoppingCartItems.remove(index) ; 
				    }                    
				    return false;                 
				}             
			});
	 	}  

	 	sessionStorage.setItem('shopping­cart­items', JSON.stringify(shoppingCartItems));
	 	displayShoppingCartItems();    
	 });


	 $("#cart-item-holder").on('click','.btn-topping-remove',function () { 
	 	var button = $(this);  
	 	var toppingindexid = button.data("toppingindex"); 
	 	var indexid = button.data("itemindex"); 
	 	var totaladdonprice = 0;
	 	var price = 0;

	 	if (shoppingCartItems.length > 0) {            
	 		$.each(shoppingCartItems, function (index, item) { 

	 			if (index == indexid) {            
	 				$.each(item.topping, function(toppingIndex,toppingValue){
	 					if (toppingIndex == toppingindexid) {            
	 						toppingValue.toppingqty--;   
	 						if (toppingValue.toppingqty <= 0 ) {
				    	// delete shoppingCartItems[index] ;
				    	Array.prototype.remove = function(toppingIndex){
				    		this.splice(toppingIndex,1);
				    		
				    	}
				    	item.topping.remove(toppingIndex); 
				    }                   
				    // return false;                 
				}  
				price = toppingValue.toppingqty * toppingValue.price;
                totaladdonprice += price;
			});    
			item.totalprice = item.price + totaladdonprice;           
	 			} 

	 		});         
	 	}  

	 	sessionStorage.setItem('shopping­cart­items', JSON.stringify(shoppingCartItems));
	 	displayShoppingCartItems();    
	 });


	 $(".btn-clear-cart").click(function () {         
	 	clearCart();
	 });     


	 function clearCart(){
	 	shoppingCartItems = [];         
	 	sessionStorage.removeItem('shopping­cart­items');
		// sessionStorage.setItem('shopping­cart­items', JSON.stringify(shoppingCartItems));
		$("#cart-item-holder").find(".cart-item").remove();     
		$('.empty-cart').show();
		$('#orderdata').val(sessionStorage.getItem('shopping­cart­items'));
		updateShoppingCartPrice(0,0);
	}


	
	function displayShoppingCartItems() {      

		var cartobject = JSON.parse(sessionStorage.getItem('shopping­cart­items'));
		var subTotal = 0;
		var Total = 0;
		var deliveryCharge = sessionStorage["deliveryFee"];
		var discount = sessionStorage["discount"];
		if (sessionStorage["shopping­cart­items"] != null && cartobject.length > 0 ) { 
			$('.empty-cart').hide();
			shoppingCartItems =  JSON.parse(sessionStorage.getItem('shopping­cart­items')); 
			$("#cart-item-holder").find(".cart-item").remove();     
			// $("#cart-item-holder").html("");     
			$.each(shoppingCartItems, function (index, item) {                 
				var htmlString = "";                 
				htmlString += "<div class='cart-item'>"
				htmlString += "<div class='row'>" 
				htmlString += "<div class='col-md-12 cart-item-title-holder' >"
				htmlString += "<p class='cart-item-title'>"+ item.name +"</p>"

				if (item.topping.length > 0) {
					$.each(item.topping, function(toppingIndex,toppingValue){

						htmlString += "<div class='row'>"
						htmlString += "<div class='col-md-6'>"
						htmlString += "<p class='cart-item-addon'>+ Add "+toppingValue.name+"</p>";
						htmlString += "</div>"
						htmlString += "<div class='col-md-6'>"
						htmlString += "<button type='button' class='btn btn-xs btn-circle red btn-topping-add' data-toppingindex='"+toppingIndex+"' data-itemindex='"+index+"' ><i class='fa fa-plus'></i></button>"
						htmlString += "<span class='cart-item-qty' > "+ toppingValue.toppingqty +" </span>"
						htmlString += "<button type='button' class='btn btn-xs btn-circle btn-topping-remove' data-toppingindex='"+toppingIndex+"' data-itemindex='"+index+"'><i class='fa fa-minus'></i></button>"
						htmlString += "</div>"
						htmlString += "</div>";
                        
					});
				}else{
					htmlString += "<p class='cart-item-addon'>No topping</p>"
				}

				htmlString += "</div>"
				htmlString += "<div class='col-md-12'>"
				htmlString += "<button type='button' class='btn btn-xs btn-circle red btn-item-add ' data-itemindex='"+index+"' ><i class='fa fa-plus'></i></button>"
				htmlString += "<span class='cart-item-qty' > "+ item.quantity +" </span>"
				htmlString += "<button type='button' class='btn btn-xs btn-circle btn-item-remove' data-itemindex='"+index+"'><i class='fa fa-minus'></i></button>"
				htmlString += "<span class='cart-item-price'>"+ item.totalprice * item.quantity +" Tk</span>"
				htmlString += "</div>" 
				htmlString += "</div>"
				htmlString += "<hr>"
				htmlString += "</div>";
				$("#cart-item-holder:last").append(htmlString);

				subTotal += (item.totalprice * item.quantity);
			});      
			Total = parseFloat(subTotal) + parseFloat(deliveryCharge) - parseFloat(discount);   

			updateShoppingCartPrice(subTotal,Total);
		}else{
			$(".cart-item").remove();        
			$('.empty-cart').show();
		}   

		$('#orderdata').val(sessionStorage.getItem('shopping­cart­items'));
		$('#ordersubtotal').val(subTotal);
		$('#ordertotal').val(Total);
		$('#orderdlfee').val(deliveryCharge);
		$('#discount').val(discount);
	} 

	function updateShoppingCartPrice(subTotal,Total){
		$("#cart-sub-total").text(subTotal.toFixed(2)+" Tk");
		$("#cart-total-price").text(Total.toFixed(2)+" Tk");
	}

	// clearCart();
</script>




<script type="text/javascript">
	$(document).ready(function ()
	{
		$('input[id="customerphone"]').on('keyup',function(){
			var customerphone = $(this).val();
			var url = '{{ url('autoloadcustomerbyphone') }}';
			
			if(customerphone != '' && (customerphone.substr(0,11).length == 11))
			{
				$.ajax({
					url :url,
					method : "get",
					data:{CustomerPhone: customerphone},
					dataType : "json",
					success:function(data)
					{

						if(data != 'no data')
						{
							$('select[id="cusaddress"]').empty();
							$('#cuscontactno').val('');
							$('#customerid').val('');
							$('#cusname').val('');
							$('#cusauth').html('');
							

							$('#customerid').val(data['customerdata'].customerid);
							$('#cuscontactno').val(data['customerdata'].contactno);
							$('#cusname').val(data['customerdata'].name);

							
							if(data['customerdata'].cusauth == 'R')
								$('#cusauth').html('<span style="color:green;"><b>Real Customer</b></span>');
							else
								$('#cusauth').html('<span style="color:red;"><b>Fraud Customer</b></span>');


							$("#cusaddress").append('<option>- - - Select - - -</option>');

							data['customeraddresses'].forEach(function(dt){
								$('select[id="cusaddress"]').append('<option value="'+ dt.address +'">'+ dt.address +'</option>');
							});

							// console.log(data['customerdata']);
							// console.log(data['customeraddresses']);
						}
						else if((customerphone.substr(0,11).length == 11) && data == 'no data')
						{
							swal({
								title: "Customer Not Found!",
								icon: "info",
								button: "Cancel!",
							});
							$('input[id="customerid"]').empty();
							document.getElementById('customerid').value = '';
							$('select[id="cusaddress"]').empty();
							$('#cuscontactno').val('');
							$('#cusname').val('');
							$('#cusauth').html('');
						}
					}
				});
			}
			else
			{
				
				$('input[id="customerid"]').val('');
				$('select[id="cusaddress"]').empty();
				$('#cuscontactno').val('');
				$('#cusname').val('');
				$('#cusauth').html('');
				
			}
		});
	});
</script>





<script type="text/javascript">
	$(document).ready(function ()
	{
		$('select[id="searchCustomer"]').on('change',function(){
			var customerid = $(this).val();
			var url = '{{ url('customeraddresses') }}';
			if(customerid)
			{
				$.ajax({
					url :url,
					method : "get",
					data:{CustomerID: customerid},
					dataType : "json",
					success:function(data)
					{
						$('select[id="cusaddress"]').empty();
						$("#cusaddress").append('<option>- - - Select - - -</option>');
						
						data.forEach(function(dt){
							$('select[id="cusaddress"]').append('<option value="'+ dt.address +'">'+ dt.address +'</option>');
						});
					}
				});
			}
			else
			{
				$('select[id="cusaddress"]').empty();
			}
		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function ()
	{
		$('select[id="branchid"]').on('change',function(){
			var branchid = $(this).val();
			var url = '{{ url('brachwisecategory') }}';
			if(branchid)
			{
				$.ajax({
					url :url,
					method : "get",
					data:{BranchID: branchid},
					dataType : "json",
					success:function(data)
					{
						// $('select[id="categoryid"]').empty();
						// $("#categoryid").append('<option>- - - Select - - -</option>');
						// data.forEach(function(dt){
						// 	$('select[id="categoryid"]').append('<option value="'+ dt.categoryid +'">'+ dt.name +'</option>');
						// });
						$('#mycategorysection').empty();
						data.forEach(function(dt){

							var BasePath = 'imageFolder/';
							var Path = BasePath.concat(dt.picture);
							var urr = '{{ asset(':id') }}';
							urr = urr.replace(':id',Path);

							var categ = '<div class="col-md-1">'+
							'<img class="cat" data-container="body" data-toggle="popover" data-placement="top" data-trigger="hover" data-content="'+dt.name+'" data-id="'+dt.categoryid+'" src="'+urr+'" alt="preview" id="preview-image" style="width: 80px;height: 50px;cursor:pointer" />'+
							'<span><b>'+dt.name+'</b></span>'+
							'</div>';
							$('#mycategorysection').append(categ);
							$("[data-toggle=popover]").popover();
						});
					}
				});
			}
			else
			{
				$('select[id="categoryid"]').empty();
			}
		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$('.addRow').on('click',function(){
			$('#cusaddress').val("").trigger('change');
			document.getElementById("custaddress").style.display = '';
			$('#address_type').val('N');
			document.getElementById('address').value = '';
			
		})
	})
</script>

<script type="text/javascript">
	$('#mycategorysection').on('click','.cat', function() {
		var branchID = $('#branchid').val();
		var button = $(this);
		var categoryID = button.attr("data-id");
		
		$.ajax({
			method: "POST",
			url: "{{ url('ajax/menubybranch') }}",
			dataType: "json",
			data: { _token: "{{ csrf_token() }}" , branch_id : branchID,category_id : categoryID }
		}).done(function( resultData ) {

			if( resultData.msg && resultData.msg=='success' && resultData.data && resultData.data.length > 0 ) {
				var _data = resultData.data;
				var _dfee = resultData.delfee;
				var _discount = resultData.discount;

				$('#foodMenuSection').html(_data);

				$('#catid').val(categoryID);

				$('#cart-deliveryfee').html(_dfee.toFixed(2)+" Tk");
				$('#cart-discount').html(_discount.toFixed(2)+" Tk");
				sessionStorage.setItem('deliveryFee',_dfee );
				sessionStorage.setItem('discount',_discount );
				activatePopover();
			} else if( resultData.msg && resultData.msg=='nodata' ) {
				$('#foodMenuSection').empty();
				$('#foodMenuSection').append('No Food Found');
				$('#cart-deliveryfee').html("0.00 Tk");
				$('#cart-discount').html("0.00 Tk");
				sessionStorage.removeItem('deliveryFee');
				sessionStorage.removeItem('discount');
			}

		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#SearchFood').on('keyup',function(){
			var SearchString = $(this).val();
			var branchID = $('#branchid').val();
			var categoryID = $('#catid').val();


			$.ajax({
				method: "POST",
				url: "{{ url('searchfood') }}",
				dataType: "json",
				data: { _token: "{{ csrf_token() }}" , branch_id : branchID,category_id : categoryID,search_string : SearchString }
			}).done(function( resultData ) {

				if( resultData.msg && resultData.msg=='success' && resultData.data && resultData.data.length > 0 ) {
				var _data = resultData.data;
				var _dfee = resultData.delfee;
				var _discount = resultData.discount;

				$('#foodMenuSection').html(_data);

				$('#cart-deliveryfee').html(_dfee.toFixed(2)+" Tk");
				$('#cart-discount').html(_discount.toFixed(2)+" Tk");
				sessionStorage.setItem('deliveryFee',_dfee );
				sessionStorage.setItem('discount',_discount );
				activatePopover();
			} else if( resultData.msg && resultData.msg=='nodata' ) {
				$('#foodMenuSection').empty();
				$('#foodMenuSection').append('No Food Found');
				$('#cart-deliveryfee').html("0.00 Tk");
				$('#cart-discount').html("0.00 Tk");
				sessionStorage.removeItem('deliveryFee');
				sessionStorage.removeItem('discount');
			}

			});


		})
	})
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#cusaddress').on('change',function(){
			
			document.getElementById('address').value = $(this).val();
			$('#address_type').val('O');
		})
	})
</script>


@endsection