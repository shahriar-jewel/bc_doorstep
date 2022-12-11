@extends('common.layout')
@section('extra_css')
<style type="text/css">
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
	 .select2-container--default .select2-selection--single {
    background-color: #fff;
    border: 1px solid #d2d6de;
    border-radius: 4px;
     }
     .select2-container .select2-selection--single {
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    height: 34px;
    user-select: none;
    -webkit-user-select: none;
    }

	</style>
	@endsection


	@section('content')
	<div class="page-content">
		
		<!-- BEGIN PAGE HEADER-->
		<h3 class="page-title">
			Order <small>create and edit</small>
		</h3>
		<div class="page-bar" style="background-color: #eeeeee">
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

		
		<div class="portlet box">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-user"></i> <span style="color: grey;font-weight: 400">Member Information</span>
				</div>
			</div>
			<div class="portlet-body form form-horizontal">
				@include('common.alert')
				<form class="form-horizontal" action="{{ route('order.store') }}" method="post" role="form" id="orderSubmit" autocomplete="off">
					{{ csrf_field() }}
					<div class="form-body" id="customerSection">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-6">
									<div class="form-group">
										<div class="col-md-12">
											<label class="col-md-3 control-label ">Member ID</label>
											<div class="col-md-9 {{ $errors->has('member_id') ? 'has-error' : '' }}">
												<div class="input-group">
													<input type="text" class="form-control" name="member_id" placeholder="Search member using member id" id="member_id">
													<span class="input-group-btn">
														<button class="btn blue" id="searchMemberBtn" type="button"><i class="fa fa-search"></i></button>
													</span>
												</div>
												@if ($errors->has('member_id'))
												<span class="help-block has-error">
													<strong>{{ $errors->first('member_id') }}</strong>
												</span>
												@endif
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<label class="col-md-3 control-label ">Member Name</label>
											<div class="col-md-9 {{ $errors->has('name') ? 'has-error' : '' }}">
												<input class="form-control" name="name" id="name" placeholder="Enter member name" readonly="">

												@if ($errors->has('name'))
												<span class="help-block has-error">
													<strong>{{ $errors->first('name') }}</strong>
												</span>
												@endif
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<label class="col-md-3 control-label ">Mobile Number</label>
											<div class="col-md-9 {{ $errors->has('contactno') ? 'has-error' : '' }}">
												<input class="form-control" name="contactno" id="contactno" placeholder="Enter mobile number" readonly="">

												@if ($errors->has('contactno'))
												<span class="help-block has-error">
													<strong>{{ $errors->first('contactno') }}</strong>
												</span>
												@endif
											</div>
										</div>
									</div>

									<div class="form-group">
										<div class="col-md-12">
											<label class="col-md-3 control-label ">Member Image</label>
											<div class="col-md-9">
												<div class="fileinput-new thumbnail">
													<img src="{{ asset('imageFolder/avatar.png') }}" alt="preview" style="width: 100px" id="preview-image" />
												</div>
											</div>
										</div>
									</div>

								</div>

								<div class="col-md-6">
									<div class="form-group">
										<div class="col-md-12">
											<label class="col-md-3 control-label ">Delivery Zone</label>
											<div class="col-md-9 {{ $errors->has('zone') ? 'has-error' : '' }}">
												<select class="form-control select2" style="width: 100%" name="zone" id="zoneid">
													<option value="">- - - select delivery zone - - -</option>
													@if(!empty($allDeliveryzone))
													@foreach($allDeliveryzone as $zoneid => $zonename)
													<option value="{{ $zoneid }}">{{ $zonename }}</option>
													@endforeach
													@endif
												</select>

												@if ($errors->has('zone'))
												<span class="help-block has-error">
													<strong>{{ $errors->first('zone') }}</strong>
												</span>
												@endif
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<label class="col-md-3 control-label ">Table/Room No</label>
											<div class="col-md-9 {{ $errors->has('tableid') ? 'has-error' : '' }}">
												<select class="form-control select2" style="width: 100%" name="tableid" id="tableid">
													<option value="">- - - select table/room - - -</option>
													@if(!empty($tables))
													@foreach($tables as $key => $table)
													<option value="{{ $table->tableid }}">{{ $table->tablename }}</option>
													@endforeach
													@endif
												</select>

												@if ($errors->has('tableid'))
												<span class="help-block has-error">
													<strong>{{ $errors->first('tableid') }}</strong>
												</span>
												@endif
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<label class="col-md-3 control-label ">Payment Method</label>
											<div class="col-md-9 {{ $errors->has('paymentmethod') ? 'has-error' : '' }}">
												<select class="form-control select2me" style="width: 100%" name="paymentmethod">
													<option value="">- - - Select - - -</option>
													<option value="1">Cash Card</option>
													<option value="2">Card</option>
													<option value="3">Credit</option>
												</select>

												@if ($errors->has('paymentmethod'))
												<span class="help-block has-error">
													<strong>{{ $errors->first('paymentmethod') }}</strong>
												</span>
												@endif
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<label class="col-md-3 control-label ">Special Instruction</label>
											<div class="col-md-9 {{ $errors->has('specialinstruction') ? 'has-error' : '' }}">
												<textarea class="form-control" rows="3" id="specialinstruction" name="specialinstruction" placeholder="special instruction (if any)"></textarea> 
											</div>
										</div>
									</div>
								<input type="hidden" name="orderdata" value="" id="orderdata">
								<input type="hidden" name="ordersubtotal" value="" id="ordersubtotal">
								<input type="hidden" name="ordertotal" value="" id="ordertotal">
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="portlet box" style="background-color: #eeeeee">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-cutlery"></i> <span style="color: grey;font-weight: 400;">Food Category</span> 
						</div>
					</div>
					<div class="portlet-body " style="max-height: 280px !important;">
						<div class="form-body">
							<div class="row" >
								<div class="categorysection" id="categorysection">

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-8">
				<div class="portlet box" style="background-color: #eeeeee">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-cutlery"></i> <span style="color: grey;font-weight: 400;">Food Menu</span> 
						</div>
					</div>
					<div class="portlet-body">
						@include('common.alert')
						<div class="form-body" >
							<div id="foodMenuSection">
								<div id=''> <h3 class='categoryTitle' >Click On Category & Get Food!</h3></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="portlet box" style="background-color: #eeeeee">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-shopping-cart"></i> <span style="color: grey;font-weight: 400;">Cart</span> 
						</div>
						<div class="actions">
							<button type="button" class="btn btn-sm btn-default btn-clear-cart">Clear</button>
						</div>
					</div>
					<div class="portlet-body">
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
									<div class="col-md-12" id="hidden" align="center">
										<button type="submit" class="btn green" onclick="$('#orderSubmit').submit()">Submit Order</button>
										<!-- <button type="reset" class="btn btn-sm red">Clear</button> -->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- END PAGE CONTENT-->
		</div>
		@endsection

		@section('extra_js')
		
		<script src="{{ asset('sweetalert.js') }}"></script>

		<script type="text/javascript">
			$(document).ready(function(){
				$.ajaxSetup({
                 headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
                });
				$('#searchMemberBtn').on('click', function() {
				var memb_id = $('#member_id').val();
				$('#searchMemberBtn').find('i').attr('class','fa fa-spinner fa-spin');
				$.ajax({
					url :"{{ url('ajax/searchmemberbyid') }}",
					method : "POST",
					data:{member_id: memb_id},
					dataType : "json",
					success:function(resultData){
						if( resultData.msg && resultData.msg=='success' && resultData.data ){
							$('#searchMemberBtn').find('i').attr('class','fa fa-search');
							var _data = resultData.data;
							$('#member_id').val(_data.member_id);
							$('#name').val(_data.name);
							$('#contactno').val(_data.mobile);
							$('#preview-image').attr('src',_data.image);
						}else if( resultData.msg && resultData.msg=='nodata' ){
							$('#searchMemberBtn').find('i').attr('class','fa fa-search');
							$('#name').val('');
							$('#contactno').val('');
							$('#preview-image').attr('src','{{ asset('imageFolder/avatar.png') }}');
							swal({
								title: "Member Not Found!",
								icon: "info",
								button: "OK!",
							});
						}
					},
					error:function(data){
						console.log(data)
					}
				});
			});
		})

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
	 	var kitchenid = button.data("kitchenid");           
	 	var quantity = 1;         

	 	var item = {             
	 		id: id,             
	 		name: name,             
	 		price: price,                         
	 		quantity: quantity,     
	 		kitchenid: kitchenid     
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

				htmlString += "</div>"
				htmlString += "<div class='col-md-12'>"
				htmlString += "<button type='button' class='btn btn-xs btn-circle red btn-item-add ' data-itemindex='"+index+"' ><i class='fa fa-plus'></i></button>"
				htmlString += "<span class='cart-item-qty' > "+ item.quantity +" </span>"
				htmlString += "<button type='button' class='btn btn-xs btn-circle btn-item-remove' data-itemindex='"+index+"'><i class='fa fa-minus'></i></button>"
				htmlString += "<span class='cart-item-price'>"+ item.price * item.quantity +" Tk</span>"
				htmlString += "</div>" 
				htmlString += "</div>"
				htmlString += "<hr>"
				htmlString += "</div>";
				$("#cart-item-holder:last").append(htmlString);

				subTotal += (item.price * item.quantity);
			});      
			Total = parseFloat(subTotal);   

			updateShoppingCartPrice(subTotal,Total);
		}else{
			$(".cart-item").remove();        
			$('.empty-cart').show();
		}   

		$('#orderdata').val(sessionStorage.getItem('shopping­cart­items'));
		$('#ordersubtotal').val(subTotal);
		$('#ordertotal').val(Total);
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
			var url = '{{ url('ajax/allcategory') }}';
				$.ajax({
					url :url,
					method : "get",
					data:{},
					dataType : "json",
					success:function(data)
					{
						$('#categorysection').empty();
						data.forEach(function(dt){
							var BasePath = 'upload/menu/thumbnail_images/';
							var Path = BasePath.concat(dt.originalpicture);
							var urr = '{{ asset(':id') }}';
							urr = urr.replace(':id',Path);
							var category = '<div class="col-md-1">'+
							'<img class="cat" data-container="body" data-toggle="popover" data-placement="top" data-trigger="hover" data-content="'+dt.name+'" data-id="'+dt.categoryid+'" src="'+urr+'" alt="preview" id="preview-image" style="width: 80px;height: 50px;cursor:pointer" />'+
							'<span><b>'+dt.name+'</b></span>'+
							'</div>';
							$('#categorysection').append(category);
							$("[data-toggle=popover]").popover();
						});
					}
				});
	});
</script>
<script type="text/javascript">
	$.ajaxSetup({
                 headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
                });
	$('#categorysection').on('click','.cat', function() {
		var branchID = $('#branchid').val();
		var button = $(this);
		var categoryID = button.attr("data-id");
		
		$.ajax({
			method: "POST",
			url: "{{ url('ajax/menubybranch') }}",
			dataType: "json",
			data: { _token: "{{ csrf_token() }}" ,category_id : categoryID }
		}).done(function( resultData ) {
            
			if( resultData.msg && resultData.msg=='success' && resultData.data && resultData.data.length > 0 ) {
				var _data = resultData.data;
				$('#foodMenuSection').html(_data);
				$('#catid').val(categoryID);
				// activatePopover();
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
		$('#hidden').on('click',function(){
			$(this).hide();
		})
	})
</script>
@endsection