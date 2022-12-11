@extends('Frontend.layouts.manage')
@section('content')
<div class="container-fluid menuBox" style="overflow:hidden">
	<div class="row">
		<!-- <div style="position:fixed" id="smallMenuIcon"> <h1> <a href="#" id="smallArrow"> > </a> </h1> </div> -->
		<center> 
			<h1 > BK&reg; DELIVERS </h1> <input type="button" id="removesession" value="clcik" name=""> <hr>
		</center>
		
		<div class="col-md-2 col-sm-2 col-xs-12 menuBoxLeft">
			<div class="letMenuInner" id="CategorySection"> 
				<H2> <b> MENU  </b> </h2> 
					@if(!empty($categories))
					@foreach($categories as $category)
					<li class="cartMenuLists"> 
						<a href="#{{ $category->CategoryID }}" class="Category" data-categoryid="{{ $category->CategoryID }}" style="text-decoration:none"> 	
							<span style="font-family:BlockBerth; color:black; font-size:16px" > {{ $category->CategoryName }} </span>
						</a> 
					</li>	
					@endforeach
					@endif
				</div> 
			</div>

			<div class="col-md-10 col-sm-10 col-xs-12 productBoxCenter">


				<div id="mylightbox204" class="lightbox">
					<form id="DealForm204" method="post" action="https://bkpakistan.com/home/bkdelivers"> 
						<div class="" style="clear:both; text-align:center"><h2> RAMADAN DEAL 1 </h2> </div>
						<div class="col-md-6 col-sm-6 col-xs-12 box">
							<p style="margin:0px; margin-top:10px">
								Side Items													
							</p>
							<Select class="form-control" name="dealSizeName[]" id="dealSizeName262963">
								<option value="262963"> 
									Tempura Nuggets		
								</option>

							</Select>	
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12 box">
							<p style="margin:0px; margin-top:10px">
								Baverages													
							</p>
							<Select class="form-control" name="dealSizeName[]" id="dealSizeName262964">
								<option value="262964"> 
									Mountain Dew		
								</option>
								<option value="262965"> 
									7up		
								</option>
								<option value="262966"> 
									Pepsi		
								</option>
								<option value="262967"> 
									Mirinda		
								</option>

							</Select>	
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12"> <hr>
							<h1 class="center"> Addons <small> (optional) </small> </h1>
							<h4 class="center"> Add Regular Drink and Fries For Just Rs.150 only </h4>
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 col-sm-offset-3">
								<SELECT class="form-control" name="adons" >
									<option value=""> Select Drink </option>
									?	
									<option value=" 1821" > Pepsi </option>
									?	
									<option value=" 1822" > Mirinda </option>
									?	
									<option value=" 1823" > Mountain Dew </option>
									?	
									<option value=" 1824" > 7-up Diet </option>
									?	
									<option value=" 1825" > Pepsi Diet </option>
								</SELECT>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-6 add2CartWrapper">
							<input type="submit" name="DealSubmit" class="btn btn-block btn-danger" Value="CHECKOUT"> 
						</div>
					</form>
				</div>

					<!-- <div class="col-md-12 col-sm-12 col-xs-12"> <a name="Cat1"> </a>
						<img src="public/FrontendCSSJS/img/delivery/slider/bk-special-offers.png" class="img img-responsive" style="text-align:center; width:100%">
					</div>

					<div class="col-md-12 col-sm-12 col-xs-12 pContainer">

						<div class="col-md-3 col-sm-3 col-xs-12 wrap">
							<div class="col-md-12 col-sm-12 col-xs-12 ">
								<img src="public/FrontendCSSJS/img/delivery/products/ramadan-deal-1.jpg" class="img img-responsive" style="width:auto">
							</div>

						</div>

						<div class="col-md-9 col-sm-9 col-xs-12">

							<div class="col-md-9 col-sm-9 col-xs-12 pNameNdiscription">
								<h4> <b> Ramadan Deal 1 </b> </h4>
								<p>  6 Pcs Nuggets and 1 small Drink  </p>		
							</div>

							<div class="col-md-3 col-sm-3 col-xs-12 wrap" style="float:right" >
								<div class="col-md-12 col-sm-12 col-xs-6 priceWrapper">
									<h4 style="color:black" class="pPRICE">  <b> Rs. 219 </b> </h4>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-6 add2CartWrapper">
									<input type="button" id="ad2cart" name="ad2cart" class="btn add2Cart" value="Add To Cart" data-featherlight="#mylightbox204" style="background-color: #ed7800; color:white"> 
								</div>


								<div id="mylightbox204" class="lightbox">
									<form id="DealForm204" method="post" action="https://bkpakistan.com/home/bkdelivers"> 
										<div class="" style="clear:both; text-align:center"><h2> RAMADAN DEAL 1 </h2> </div>
										<div class="col-md-6 col-sm-6 col-xs-12 box">
											<p style="margin:0px; margin-top:10px">
											Side Items													
										</p>
											<Select class="form-control" name="dealSizeName[]" id="dealSizeName262963">
												<option value="262963"> 
													Tempura Nuggets		
												</option>

											</Select>	
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12 box">
											<p style="margin:0px; margin-top:10px">
											Baverages													
										</p>
											<Select class="form-control" name="dealSizeName[]" id="dealSizeName262964">
												<option value="262964"> 
													Mountain Dew		
												</option>
												<option value="262965"> 
													7up		
												</option>
												<option value="262966"> 
													Pepsi		
												</option>
												<option value="262967"> 
													Mirinda		
												</option>

											</Select>	
										</div>
										<div class="col-md-12 col-sm-12 col-xs-12"> <hr>
											<h1 class="center"> Addons <small> (optional) </small> </h1>
											<h4 class="center"> Add Regular Drink and Fries For Just Rs.150 only </h4>
											<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 col-sm-offset-3">
												<SELECT class="form-control" name="adons" >
													<option value=""> Select Drink </option>
													?	
													<option value=" 1821" > Pepsi </option>
													?	
													<option value=" 1822" > Mirinda </option>
													?	
													<option value=" 1823" > Mountain Dew </option>
													?	
													<option value=" 1824" > 7-up Diet </option>
													?	
													<option value=" 1825" > Pepsi Diet </option>
												</SELECT>
											</div>
										</div>
										<div class="col-md-12 col-sm-12 col-xs-6 add2CartWrapper">
										<input type="submit" name="DealSubmit" class="btn btn-block btn-danger" Value="CHECKOUT"> 
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-md-12 col-xs-12"> <hr> </div>
				</div>	 -->









				<div class="FoodMenuSection" id="FoodMenuSection">



					<!-- <div class="col-md-12 col-sm-12 col-xs-12"> <a name="Cat9"> </a>
						<img src="public/FrontendCSSJS/img/delivery/slider/budget_bites.jpg" class="img img-responsive" style="text-align:center; width:100%">
					</div> -->

					<!-- <div class="col-md-12 col-sm-12 col-xs-12 pContainer">

						<div class="col-md-3 col-sm-3 col-xs-12 wrap">
							<div class="col-md-12 col-sm-12 col-xs-12 ">
								<img src="public/FrontendCSSJS/img/delivery/products/FrenchFries.jpg" class="img img-responsive" style="width:auto">
							</div>
						</div>
						<div class="col-md-9 col-sm-9 col-xs-12">

							<div class="col-md-9 col-sm-9 col-xs-12 pNameNdiscription">
								<h4> <b> French Fries </b> </h4>
								<p>  fgfdgdfgd  </p>		
							</div>
							<div class="col-md-3 col-sm-3 col-xs-12 wrap" style="float:right" >
								<div class="col-md-12 col-sm-12 col-xs-6 priceWrapper">
									<h4 style="color:black" class="pPRICE">  <b> Rs. 150 </b> </h4>
								</div>


								<div class="col-md-12 col-sm-12 col-xs-6 add2CartWrapper">
									<input type="button" id="ad2cart" name="ad2cart" class="btn add2Cart" style="background-color: #ed7800; color:white" value="Add To Cart" onclick='updateCart("491")'> 
								</div>
							</div>
						</div>
						<div class="col-sm-12 col-md-12 col-xs-12"> <hr> </div>
					</div> -->

				</div>








				<!-- <div class="col-md-12 col-sm-12 col-xs-12 pContainer">
					
					<div class="col-md-3 col-sm-3 col-xs-12 wrap">
						<div class="col-md-12 col-sm-12 col-xs-12 ">
							<img src="public/FrontendCSSJS/img/delivery/products/SpicyCrispyChicken.jpg" class="img img-responsive" style="width:auto">
						</div>

					</div>
					
					<div class="col-md-9 col-sm-9 col-xs-12">

						<div class="col-md-9 col-sm-9 col-xs-12 pNameNdiscription">
							<h4> <b> Spicy Crispy Chicken </b> </h4>
							<p>  Serves 1  </p>		
						</div>

						<div class="col-md-3 col-sm-3 col-xs-12 wrap" style="float:right" >
							<div class="col-md-12 col-sm-12 col-xs-6 priceWrapper">
								<h4 style="color:black" class="pPRICE">  <b> Rs. 245 </b> </h4>
							</div>

							<div class="col-md-12 col-sm-12 col-xs-6 add2CartWrapper">
								<input type="button" id="ad2cart" name="ad2cart" class="btn add2Cart" style="background-color: #ed7800; color:white" value="Add To Cart" onclick='updateCart("452")'> 
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-md-12 col-xs-12"> <hr> </div>
				</div> -->







			</div>


		</div>
		
	</div>

	<br> <br>
	<div class="col-md-6 col-sm-12 col-xs-12 cartBoxRight" style="position:fixed; bottom:0;width:100%; z-index:1; background-color:silver">
		<div class="col-md-6 col-sm-6 col-xs-6">

			<form method="post" action="{{ url('customer-order') }}" style="background-color:silver">
				{{ csrf_field() }}
				<h2>
					<input type="hidden" name="orderdata" id="orderdata">
					<input type="submit" value="CHECKOUT" class="btn btn-block bottomBtns btn-lg" id="bottomBtns" >
				</h2>
			</form>

		</div>
		<h2>
			<div  class="col-md-6 col-sm-6 col-xs-6" style="background-color:silver" id="bottomBtns">
				<input type="button" value="BDT. 0" class="btn btn-block subtotal" id="bottomBtns">
			</div>
		</h2>
	</div>


	<script type="text/javascript">
		$('#CategorySection').on('click',".Category", function(){
			$.ajaxSetup({
				headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
			});
			var button = $(this);
			var categoryid = button.data("categoryid");

			var url = '{{ url('categorywiseFoodMenuSection') }}';
			$.ajax({
				url: url,
				method:'POST',
				data:{id: categoryid},
				dataType : "json",
				success:function(data){
					if(data == 'nodata')
					{
						$('#FoodMenuSection').html('<span><h1>NO FOOD FOUND !</h1></span>');
					}
					else
					{
						$('#FoodMenuSection').html(data['HTML']);
					}

      // console.log(data);
  },
  error:function(error){
  	console.log(error);

  	swal({
  		title: "Data Not Saved!",
  		text: "You clicked the button!",
  		icon: "error",
  		button: "Aww yiss!",
  		className: "myClass",
  	});
  }
})

		})
	</script>

	<script type="text/javascript">
		$(document).ready(function(){
			$.ajaxSetup({
				headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
			});
			var url = '{{ url('categorywiseFoodMenuSection') }}';
			$.ajax({
				url: url,
				method:'POST',
				data:{id: '1000'},
				dataType : "json",
				success:function(data){
					if(data == 'nodata')
					{
						$('#FoodMenuSection').empty();
					}
					else
					{
						$('#FoodMenuSection').html(data['HTML']);
					}

      // console.log(data);
  },
  error:function(error){
  	console.log(error);

  	swal({
  		title: "Data Not Saved!",
  		text: "You clicked the button!",
  		icon: "error",
  		button: "Aww yiss!",
  		className: "myClass",
  	});
  }
})

		})
	</script>



	<script type="text/javascript">
		$(document).ready(function(){
			if(sessionStorage.mycart)
			{
				mycart= JSON.parse(sessionStorage.getItem('mycart'));

				ddd= JSON.parse(sessionStorage.getItem('amount'));
				$('.subtotal').val('BDT. '+ddd);
				$('#orderdata').val(sessionStorage.getItem('mycart'));
				mycart.forEach(function(dt){
					    
						$(".cart-item-qty"+dt.foodid).html(dt.qty);
						console.log($('.cart-item-qty'+dt.foodid).html(dt.qty));
					})
			}
		})
	</script>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#FoodMenuSection').on('click','.btn-add-to-cart', function(){

				var button = $(this);
				var id = button.attr("data-FoodID");
				var picture = button.attr("data-Picture");
				var name = button.attr("data-FoodName");
				var detail = button.attr("data-FoodDetail");
				var price = button.attr("data-Price");
				var quantity = button.attr("data-Quantity");
				var sum = 0;
				var exist = 0;

				var item = {
					foodid : id,
					foodpicture : picture,
					foodname : name,
					fooddetail : detail,
					foodprice : price,
					qty : quantity,
				};

				if(sessionStorage.mycart)
				{
					mycart= JSON.parse(sessionStorage.getItem('mycart'));

					mycart.forEach(function(dt){
						if(dt.foodid == item['foodid'])
						{
							exist = 1;
							dt['qty']++;
							var cartqty = dt['qty'];
							$('.cart-item-qty'+dt.foodid).html(cartqty);
						}
						sum = Number(sum) + (Number(dt['foodprice']) * Number(dt['qty']));
					})
					if(exist == 1)
					{
						var aa = Number(sum);
						sessionStorage.setItem('amount', JSON.stringify(aa));
					}
					else
					{
						var cartqty = item['qty'];
						$('.cart-item-qty'+item['foodid']).html(cartqty);
						
						var aa = Number(sum) + Number(item['foodprice']);
						sessionStorage.setItem('amount', JSON.stringify(aa));
					}
                    $('.subtotal').val('Loading...');
					setTimeout(function() {
						$('.subtotal').val('BDT. '+aa);
					}, 1000);

				}
				else{
					mycart = [];
					 $('.subtotal').val('Loading...');
					 var cartqty = item['qty'];
					 $('.cart-item-qty'+item['foodid']).html(cartqty);
					setTimeout(function() {
						$('.subtotal').val('BDT. '+item['foodprice']);
					}, 1000);
					
				}

				if(exist == 0)
				{
					mycart.push(item);
				}
				sessionStorage.setItem('mycart', JSON.stringify(mycart));
				$('#orderdata').val(sessionStorage.getItem('mycart'));

			})
		})
	</script>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#removesession').on('click',function(){
				sessionStorage.removeItem('mycart');
				sessionStorage.removeItem('amount');
				timer();
			})
		})
	</script>

	
	@endsection