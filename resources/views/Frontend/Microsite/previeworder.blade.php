@extends('Frontend.layouts.manage')
@section('content')
<style type="text/css">

	.order{
		font-family: 'BlockBerth';
		color: #fff;
		font-size: 20px
	}
	.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
		/*padding: 8px;*/
		line-height: 1.42857143;
		vertical-align: top;

		/*border-bottom: 8px solid #ddd !important;*/
	}

	.order__details, .font{
		font-family: 'BlockBerth';
		color: #fff;
	/*	padding-top: 10px;*/

		
	}


	.order-details-text{
		padding-top: 10px;
	}

	.font-size{
		font-size: 15px;
		font-family: 'BlockBerth';
	}

	.container_order{
		background: #ED7700;
		margin-top: 10px;
		padding-top: 10px 10px;
		border-radius: 10px;
	}
	.add-extra{
		color:#4c4c4c;
	}
	#cart-total-price{
		font-family: 'BlockBerth' !important;
	}
	.order__items{
		padding-top: 15px;
	}

	.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
		/*border: 0px !important;*/
	}
     
    
	
</style>


<body  style="background: url({{ asset('FrontendCSSJS/img/bg.png') }}) ;background-size: cover !important;border-right: 2px solid #ee7700;">
<div class="container-fluid menuBox" style="margin-top: -10px;border-right:1px solid #ee7700;">
	
	<center> 
		<h2 style="font-size: 25px;padding-bottom: 10px;
		color: #4C4C4C; margin-top: 0px; padding-top: 15px;"> BK<sup>&reg;</sup>
		DELIVERS  
	</h2>
</center>

<!-- <img src="{{ asset('FrontendCSSJS/img/close.png') }}" style="width: 50px;height: 50px;" class="img-responsive"> -->

<div class="container container_order">
	<div class="row" style="padding-left: 0px ; padding-right: 0px;">
		
		<div class="col-xs-6" style="">

			<div class="order order-details-text" style="padding-left: 8px">	
				ORDER DETAILS
			</div>
		</div>

		<div class="col-xs-4">

			<span style="color: white; float: right !important;" class="order__details order__items">
				<span class="badgeqty">0</span> ITEMS 
				<img src="{{ asset('FrontendCSSJS/img/bag.png') }}" class="img-responsive"
				style="float: right !important;margin-right: -54px;cursor: pointer;height: 50px;margin-left:15px;
				margin-top: -15px" 
				>
			</span>
		

		
			<span class="button__badge" style="    
			

        background-color: #ee7700;
    border-radius: 2px;
    color: white;
    float: right !important;
    margin-right: -100px;
    /* height: 20px; */
    padding: 0px 8px;
    font-size: 16px;
    top: 14px;
    right: 8px;
    border-radius: 50%;
    margin-top: -15px"> 
			0
		</span>
	</div>
<div class="col-xs-1"> </div>
	
</div>
</div>
</div>

<div class="container-fluid" style="">	

	<div class="row"  style="padding-left:0px; border-right:1px solid #ee7700;">
		
		<div class="col-xs-1" ></div>
		<div class="col-xs-10" style="background: #E9E9E9">	
			
			<table class="table order-history-cont" style="margin-top: 20px;">
				
				<tbody id="cart-item-holder" style="background: #fff;border-radius:25px;">
					<!-- 	<tr class="empty-cart text-center"><td colspan='3'><h2 style="">Cart is empty</h2></td>
					</tr>	
				-->

			</tbody>

		</table>
	</div>
	<div class="col-xs-1" ></div>
</div>
</div>	


<div class="container" style="">	

	<div class="row"  style="padding-left:0px;border-right:1px solid #ee7700;">
		
		<div class="col-xs-1" ></div>
		<div class="col-xs-10" style="background: #E9E9E9">	

			<table class="table order-history-cont" style="background-color: grey;">
				<tbody>
					<tr class="sub-total" style="background-color: #62A60A">
						<td colspan="4" scope="row" style="color:white;"> 
							<span style="text-align: left;" class="order__details"><b>TOTAL</b></span>
							<span class="pull-right" id="cart-total-price">0.00</span>
						</td> 
					</tr> 
				</tbody>
			</table>
		</div>
		<div class="col-xs-1" ></div>

	</div>
	<div class="container">	

		<div class="row"  style="padding-left:0px;: ">
			
			<div class="col-xs-1" ></div>
			<!-- <div class="col-xs-10" style="margin-top: 20px;">	

				<table class="table order-history-cont" style="">
					<tbody>

						<tr class="sub-total " style="margin-top: 20px;">
							<td  scope="row" style="color:white;" class="col-xs-8">
								
								<input type="text" class="form-control" placeholder="Enter Your code if ANY..." style="border-radius: 20px;">
							</td>
							<td class="col-xs-4">
								
								<img src="{{ asset('FrontendCSSJS/img/submit.png') }}" class="img-responsive couponbutton">
							</td>

							
						</div> -->
					</td>
				</tr> 


			</tbody>
		</table>
	</div>
	<div class="col-xs-1" ></div>

</div>
</div>

</div>

</div>
</div>
<div>

</div>
</div>



 <br> <br><br>

</body>

<div class="container">	
	<div class="row cartBoxRight" style="position:fixed; bottom:0;width:100%; z-index:1; background: url({{ asset('FrontendCSSJS/img/footer.png') }});
                   background-size: cover !important;
                   background-repeat: no-repeat;border-bottom: 2px solid #EE7700;border-right: 2px solid #EE7700 !important; border-left: 2px solid #EE7700  !important; "> 

		<div class="col-md-6 col-sm-5 col-xs-6">
			<!-- <a href="{{ url('bkashmicrosite/branchwisemenu/'.$bid) }}" style="margin-left: auto; margin-right:auto; ">
				<img src="{{ asset('FrontendCSSJS/img/continueshopping.png') }}" class="img-responsive" style="margin-top: 20px;margin-bottom: 17px">
			</a> -->


<form method="post" id="continueshopping"  action="{{ url('bkashmicrosite/branchwisemenu') }}">
				{{ csrf_field() }}
		<input type="hidden" name="branchid" value="<?php echo Session::get('MyBranchID'); ?>" id="branchid">
		<input type="hidden" name="locationid" value="<?php echo Session::get('MyZoneID'); ?>" id="locationid">

					<img src="{{ asset('FrontendCSSJS/img/continueshopping.png') }}" class="img-responsive cl" style="cursor: pointer;margin-top: 20px;margin-bottom: 17px" onclick="$('#continueshopping').submit()" >
			</form>

		</div>
		<div class="col-md-6 col-sm-6 col-xs-6">
			<form method="post" id="checkout" action="{{ url('bkashmicrosite/billingdetails') }}">
				{{ csrf_field() }}

				<input type="hidden" name="ordertotal" value="" id="ordertotal">
				<input type="hidden" name="ordersubtotal" id="ordersubtotal">
				<input type="hidden" name="deliverycharge" id="deliverycharge">
				
					<img src="{{ asset('FrontendCSSJS/img/checkoutgreen.png') }}" class="img-responsive cl" style="cursor: pointer;margin-top: 20px;margin-bottom: 17px" onclick="$('#checkout').submit()" >
				
			</form>
		</div>
		
	</div>
</div>
</body>
<script src="{{ asset('sweetalert.js') }}"></script>

<script type="text/javascript">
	var shoppingCartItems = [];     
	$(document).ready(function () { 
		var obj = JSON.parse(sessionStorage.getItem('shopping­cart­items'));
		if ( obj != null) { 
			shoppingCartItems = obj;
		} 

		displayShoppingCartItems();
		    
	}); 
</script>



<script type="text/javascript">
	$(document).ready(function(){
		var bdgeqty = sessionStorage["badgequantity"];
		$('.button__badge').html(bdgeqty);
		$('.badgeqty').html(bdgeqty);
	})

</script>

<script type="text/javascript">
	function displayShoppingCartItems() {      

		var cartobject = JSON.parse(sessionStorage.getItem('shopping­cart­items'));
		var subTotal = 0;
		var Total = 0;
		var deliveryCharge = sessionStorage["deliveryFee"];
        // var discount = sessionStorage["discount"];
        if (sessionStorage["shopping­cart­items"] != null && cartobject.length > 0 ) { 
        	$('.empty-cart').hide();
        	shoppingCartItems = JSON.parse(sessionStorage.getItem('shopping­cart­items')); 
        	$("#cart-item-holder").find(".cart-item").remove();

        	$.each(shoppingCartItems, function (index, item){
        		var htmlString = "";

        		if(item.image)
        		{
        			var BaseURL = 'upload/menu/thumbnail_images/';
        			var Path = BaseURL.concat(item.image);
        			var url = '{{ asset(':id') }}';
        			url = url.replace(':id',Path);
        			console.log("image is : "+url);
        		}
        		else
        		{
        			var url = 'https://www.placehold.it/80x60/EFEFEF/AAAAAA&amp;text=no+image';
        			console.log("image is : "+url);
        		}

              
        		htmlString += "<tr class='cart-item'>"
        		htmlString += "<div class='col-md-12'>"
        		htmlString += "<td class='font col-xs-4' style='border-bottom:15px solid #E9E9E9 !important;padding-right: 0px;'>"
        		htmlString += "<div  class='placeholder' style='width:140px; height: 140px;background:#eee; position: relative;'>"
        		htmlString += "<img src='"+url+"' width='100px' height='100px' class='img-responsive' style='margin-top:10px; position: absolute; top:5px;margin-left:20px'>"
        		htmlString += "<p class='font' style='text-align: center;background:#eee;margin-top:-13px; margin-bottom: 0px;background: #eee;bottom:0px; position: absolute; margin-top:5px; padding-left:40px;'>"
        		htmlString += "<button type='button' class='btn btn-xs btn-circle #ee7700 btn-item-add' data-itemindex='"+index+"' style='background:transparent;color: #4c4c4c; outline: none; bottom:0px; text-center: center'>"
        		htmlString += "<i class='fa fa-plus'></i>"
        		htmlString += "</button>"
        		htmlString += "<span class='cart-item-qty' style='color: black'><b> "+item.quantity+" </b></span>"
        		htmlString += "<button type='button' class='btn btn-xs btn-circle btn-item-remove' data-itemindex='"+index+"' style='background:transparent;color: #4c4c4c; outline: none;'>"
        		htmlString += "<i class='fa fa-minus'></i>"
        		htmlString += "</button>"
        		htmlString += "</p>"
        		htmlString += "</td>"
        		htmlString += "</div>"
        		htmlString += "</div>"

        		htmlString += "<div class='col-md-12'>"
        		htmlString += "<td class='font col-xs-4' style='border-bottom:15px solid #E9E9E9 !important;'>"
        		htmlString += "<p class='cart-item-title font'style='text-transform: uppercase !important;padding-top:10px;color: #4C4C4C;font-size:14px'>"+item.name+"</p>"
        		

        		if (item.topping.length > 0) {
        			$.each(item.topping, function(toppingIndex,toppingValue){
        				htmlString += "<span>"
        				
        				htmlString += "</span>"
        				htmlString += "<span class='font-size add-extra cart-item-addon' style='font-size: 11px;'> "+toppingValue.name+"</span>"
        				htmlString += "<p class='font'>"
        				// htmlString += "<button type='button' class='btn btn-xs btn-circle #ee7700 btn-topping-add font' data-itemindex='"+index+"' data-toppingindex='"+toppingIndex+"' style='background:transparent;color: #4c4c4c; outline: none;'>"
        				// htmlString += "<i class='fa fa-plus' style='color: #4C4C4C;font-size:11px;'></i>"
        				// htmlString += "</button>"
        				htmlString += "<span class='cart-item-qty font font-size' style='color: #4C4C4C;font-size: 11px !important;'><b> "+ toppingValue.toppingqty +" </b></span>"
        				// htmlString += "<button type='button' class='btn btn-xs btn-circle btn-topping-remove font font-size' data-itemindex='"+index+"' data-toppingindex='"+toppingIndex+"' style='background:transparent;color: #4C4C4C; outline: none;'>"
        				// htmlString += "<i class='fa fa-minus' style='font-size:11px;'></i>"
        				// htmlString += "</button>"
        				htmlString += "</p>"
        				
        			});
        		}else{
        			htmlString += "<span class='font-size add-extra cart-item-addon' style='font-size: 13px;'>"
        			htmlString += "NO TOPPINGS"
        			htmlString += "</span>"
        		}

        		htmlString += "</td>"
        		htmlString += "<td class='font col-xs-4'  style='color: #4C4C4C;border-bottom:15px solid #E9E9E9 !important;padding-left:0px; padding-right: 0px;'>"
        		htmlString += "<div style='margin-top:10px;'>"
        		htmlString += "<span> "+item.totalprice * item.quantity+" <sup> BDT </sup>	</span>"


        		htmlString += "<span style='float: right;'>"
        		htmlString += "<img src='{{ asset('FrontendCSSJS/img/blackcross.png') }}' data-itemindex='"+index+"' style='margin-right: 5px' class='img-responsive deleteitem' width='20px' height='20px'>"
        		htmlString += "</span>"


        		htmlString += "</div>"
        		htmlString += "</td>"
        		htmlString += "</div>"
        		htmlString += "</tr>";

        		$("#cart-item-holder").append(htmlString);
        		subTotal += (item.totalprice * item.quantity);

        		

        	});
Total = parseFloat(subTotal) + parseFloat(deliveryCharge);
updateShoppingCartPrice(subTotal,Total);

}else{
	$(".cart-item").remove();        
	$('.empty-cart').show();
}   
$('#orderdata').val(sessionStorage.getItem('shopping­cart­items'));
$('#ordersubtotal').val(subTotal);
$('#ordertotal').val(Total);
$('#deliverycharge').val(deliveryCharge);
}

function updateShoppingCartPrice(subTotal,Total){
	$("#cart-sub-total").text(subTotal.toFixed(2)+" Tk");
	$("#cart-total-price").text(" TK "+Total.toFixed(2));
	$(".subtotal").val(subTotal.toFixed(2)+" Tk");
}
</script>

<script type="text/javascript">
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
						updateShoppingCartPrice(0,0);

						var bdgeqty = sessionStorage["badgequantity"];
						bdgeqty--;
						sessionStorage.setItem('badgequantity',bdgeqty);
		                $('.button__badge').html(bdgeqty);
		                $('.badgeqty').html(bdgeqty);

						Array.prototype.remove = function(index){
							this.splice(index,1);
						}
						shoppingCartItems.remove(index); 

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


</script>



<script type="text/javascript">
	$(document).ready(function(){
		$('#checkout').submit(function(e){
			var obj = JSON.parse(sessionStorage.getItem('shopping­cart­items'));
			var totalamount = $('#ordertotal').val();
			if ( obj == null || obj == '') { 
				e.preventDefault();
				swal({
					title: "Your cart is empty!",
					icon: "info",
					button: "OK !",
					className: "myClass",

				});
			} 
			else if(totalamount <350)
			{
				e.preventDefault();
				swal({
					title: "Minimum order amount should be 350 TK",
					icon: "info",
					button: "OK !",
					className: "myClass",

				});
			}
		})
	})
</script>

<!-- <script type="text/javascript">
	$(document).ready(function(){
		$('.deleteitem').on('click',function(){
			var button = $(this);  
			var indexid = button.data("itemindex");  
			var tmp = sessionStorage.getItem('shopping­cart­items');
			shoppingCartItems = JSON.parse(tmp);
			if (shoppingCartItems.length > 0) {            
				$.each(shoppingCartItems, function (index, value) { 
					if (index == indexid) {    

					var bdgeqty = sessionStorage["badgequantity"];
						bdgeqty--;
						sessionStorage.setItem('badgequantity',bdgeqty);
		                $('.button__badge').html(bdgeqty);
		                $('.badgeqty').html(bdgeqty);        
						
						updateShoppingCartPrice(0,0);
						Array.prototype.remove = function(index){
							this.splice(index,1);
						}
						shoppingCartItems.remove(index);          
					}   
                     
				});
			}  
            timer();
			sessionStorage.setItem('shopping­cart­items', JSON.stringify(shoppingCartItems));
			displayShoppingCartItems(); 
		})
	})
</script> -->

<script type="text/javascript">
	$("#cart-item-holder").on('click','.deleteitem',function () { 
		var button = $(this);  
		var indexid = button.data("itemindex");  
		var tmp = sessionStorage.getItem('shopping­cart­items');
		shoppingCartItems = JSON.parse(tmp);
		if (shoppingCartItems.length > 0) {            
			$.each(shoppingCartItems, function (index, value) { 
				if (index == indexid) {            
					
						updateShoppingCartPrice(0,0);

						var bdgeqty = sessionStorage["badgequantity"];
						bdgeqty--;
						sessionStorage.setItem('badgequantity',bdgeqty);
		                $('.button__badge').html(bdgeqty);
		                $('.badgeqty').html(bdgeqty);

						Array.prototype.remove = function(index){
							this.splice(index,1);
						}
						shoppingCartItems.remove(index); 
						
            
					return false;                 
				}             
			});
		}  

		sessionStorage.setItem('shopping­cart­items', JSON.stringify(shoppingCartItems));
		displayShoppingCartItems();    
	});
</script>



@endsection