@extends('Website.layouts.manage')
@section('extra_css')

  <style type="text/css">
    .content__margin {
   
    margin-bottom: 60px !important;
    padding-bottom: 50px !important;
}
  .delete{font-size: 28px;top: -25px;float: right;margin-right: -10px;}
  .img_sml{background: #eee;width: 170px,background: #BFBFBF;}
  .col__xs__modified{margin-top: 25px; margin-bottom: 0px; background: #fff !important;height: 250px; z-index: 1 !important}
  .order__details{background: #FFEBD7; margin-top: 92px !important}

 .menu__title{font-size: 35px; padding-top: 40px;padding-bottom: 0px;color: #323231}
 
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

#input, #input2{
    border: none; width: 50px; text-align: center;background: #fff;
}
.order__bag{
  margin-top: -50px;
  margin-bottom: 20px;
  height: 110px;
}
.col__xs__checkout{
    padding-left: 15px;
}
.col__xs__continue__shopping

.order__details__title, .order__details__price{
 color: #fff;
 padding-top: 13px;
 font-size: 30px !important;
}


.order__details__title{
        padding-top: 20px;
    padding-bottom: 15px;
    color: #fff;
    
    font-size: 30px !important;
}

.order__details__title__initial{
    padding-left: 0px;
}
.order__details__title__final{
    padding-left: 45px;
}
.row-container{
  background: #FFEBD7;
}
.order__details__img{
  /*margin-top: 60px; */
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
  font-family: 'BlockBeCnPro', Arial, Helvetica, sans-serif;
}

.badge{
    
        background-color: #ED7700;
    color: white;
    padding: 6px 12px !important;
    font-size: 20px;
    position: absolute;
    top: -60px;
    right: 85px;
    border-radius: 50%;
}
.order__amount{
    padding-right: 25px;padding-top: 20px; padding-bottom: 15px; color: #fff
    }
    #plus, #minus,#plus2, #minus2{
        background: transparent;border: none;outline: none
    }
    .plus__icon{width: 13px;}
    
    .minus__icon{width: 15px; margin-top: -8px !important}
    #plus, #minus{padding-left:0px; padding-right: 0px }
    .content__sm__margin{margin-bottom: 80px}
    .row-container{ padding-top: 0px !important;}
    .row-container-mod{padding-bottom: 25px !important;padding-top: 0px !important}
</style>


<style type="text/css">
    @media only  screen and (max-width: 768px) {
    .content__sm__margin {
       margin-bottom: 45px;
    }
   #plus, #minus{padding-left:0px; padding-right: 0px }
    .row-container{
     margin-left: -7px !important;
    margin-right: -7px !important;
   
      }
    .minus__icon {
    width: 9px;
    margin-top: -6px !important;}
    .plus__icon{width: 9px;}
    .delete{font-size: 26px;top: -33px;float: right;margin-right: -10px;}
    .order__details__title, .order__details__price{
 color: #fff;
 padding-top: 23px;
 font-size: 30px !important;
}

      .col__xs__modified{
        height: 195px !important;
      }
      .img__sml{
        margin-top: 65px;
/*        margin-left: 5px !important;;
*/          height: 95px !important;    
           background: #BFBFBF; 
      }
       .order__details{background: #FFEBD7; margin-top: 50px !important}
      .bk-logo{
        margin-top: 15px !important;
      }
        #input{
           border: none; width: 27px; text-align: center;background: #fff;
      }
   

        .order__details__title__initial{
    padding-left: 15px;
}
.order__details__title__final{
    padding-left: 0px;
}
        .col__xs__checkout{
            padding-left: 5px !important;
    padding-right: 5px;
        }
        .col__xs__continue__shopping{
            padding-left: 5px;
                padding-right: 5px;

        }
        .col__xs__modified{
            /*margin-left: 25px;*/
            margin-top:25px;
        }

        .right__margin {
    padding-right: 5px;
}

      .order__details__title, .order__details__price{
        font-size: 18px !important;
      }  

      .order__details__price{
        padding-left: 15px;
      }
      .order__bag{
       float: right;
       margin-bottom: 10px;
       margin-right: 10px;
       top: -10px !important;
      }
      .menu__details {
    font-size: 13px;
    padding-left: 0px;
}

.badge {
    background-color: #ED7700;
    /* color: white; */
    padding: 6px 10px !important;
    font-size: 15px;
    position: absolute;
    top: -10px !important; 
    right: 10px;
    border-radius: 50%;
      }


.order__details__title{
        padding-top: 10px;
    padding-bottom: 15px;
    color: #fff;
    padding-left: 15px !important;
}

.order__details__title__sm{
    padding-left: 15px !important;
}

.order__amount{
    padding-right: 25px;padding-top: 10px; padding-bottom: 15px; color: #fff
    }

 .order__details__title__row{
    margin-left: 15px; margin-right: 15px;
 }
 .order__bag{
  margin-top: 0px;
  height: 60px;
}
}
</style>

@endsection
@section('content')
<section style="background: #FCF1EB;">
  <div class="content " >
    <div class="container-fluid" >
        <div class="content  order__details " style="background: #FFEBD7; ">
            <div class="row order__details__title__row"  style="background: #F08B21; border-radius: 15px !important" >
                <div class="col-md-1"></div>
                <div class="col-md-7 col-xs-4">
                    <div class="order__details__title order__details__title__initial" 
                         style="padding-top: 15px; padding-bottom: 15px;">
                          ORDER DETAILS
                    </div>
                </div>
   
         <div class="col-md-2 col-xs-3"> 
                    <div class="order__details__price"
                         style="padding-top: 15px; padding-bottom: 15px;">
                         <span class="badgeqty">0</span>  <span id="itemoritems">ITEMS</span> 
                    </div>
        </div>

        <div class="col-md-2 col-xs-5">
         <img src="{{ asset('FrontendCSSJS/img/bag.png') }}" class="img-responsive order__bag" >
         <span class="button__badge badge">0</span>
       </div>
     </div>
   </div>
 </div>
</div>

<div class="content" >
    <div class="container-fluid" >
      <div class="content  order__details content__margin" style="background: #FFEBD7; margin-top: 0px !important;z-index: 1000 !important ">
      <div id="cart-item-holder">
       
      </div>

      <div class="row" style=" border-radius: 15px !important;padding-top: 25px" >
         <div class="col-md-1 col-xs-1"></div>
         <div class="col-md-5 col-xs-5" style="background: #62A608;">
          <div class="order__details__title" style="padding-top: 20px; padding-bottom: 15px; color: #fff; padding-left: 45px"> TOTAL
          </div>
         </div>

         <div class="col-md-5 col-xs-5" style="background: #62A608;">
          <span class="pull-right order__details__title" id="cart-total-price" style="padding-right: 25px;padding-top: 20px; padding-bottom: 15px; color: #fff">TK 0.00 </span>
         </div>
        <div class="col-md-1 col-xs-1"></div>
      </div>

</div>
</div>
</div>

</section>

<section style="background: #FCF1EB; ">
<div class="content" style="">

  <div class="container-fluid" style="background: #61342C">
    <div class="content" >
        <div class="row" style="margin-top: 25px;margin-bottom: 20px">
          <div class="col-md-2 " > </div>
        <div class="col-md-4 col-xs-6 col__xs__continue__shopping" style="">
             <!-- input type="text" name="" style="width: 100%; text-align: center;" placeholder="ROAD NO" > -->
            <form method="post" id="continueshopping" action="{{ url('online-food-menu') }}">
        {{ csrf_field() }}
         <input type="hidden" name="branchid" value="<?php echo Session::get('MyBranchID'); ?>" id="branchid">
            <input type="hidden" name="locationid" value="<?php echo Session::get('MyZoneID'); ?>" id="locationid">

          <a href="" onclick="return false;">
            
               <!--  <img src="img/button/shopping.png" class="img-responsive pull-right" 
                     style=""> -->
                     <img src="{{ asset('FrontendCSSJS/img/goback.png') }}" class="img-responsive pull-right" onclick="$('#continueshopping').submit()" width="220px">
            </a>
          </form>
        </div>
        
         <div class="col-md-4 col-xs-6 col__xs__checkout" style="">
              <form method="post" id="checkout" action="{{ url('billingdetails') }}">
        {{ csrf_field() }}
        <input type="hidden" name="ordertotal" value="" id="ordertotal">
        <input type="hidden" name="ordersubtotal" id="ordersubtotal">
        <input type="hidden" name="total_discountamount" id="total_discountamount">
        <input type="hidden" name="deliverycharge" id="deliverycharge">
          <a href="" onclick="return false;">
                 <img src="{{ asset('FrontendCSSJS/img/checkoutgreen.png') }}" class="img-responsive" onclick="$('#checkout').submit()">
            </a>
          </form>
        </div>
        <div class="col-md-2" > </div>

  
    </div>

</div>


  </div>
</div>

</section>

@endsection
@section('extra_js')
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
    if(cartobject.length ==1 || cartobject.length == 0){
      $('#itemoritems').text('ITEM');
    }else {
      $('#itemoritems').text('ITEMS');
    }
    var subTotal = 0;
    var Total = 0;
    var discountamount = 0;
    var total_discountamount = 0;
    var deliveryCharge = sessionStorage["deliveryFee"];
       
        if (sessionStorage["shopping­cart­items"] != null && cartobject.length > 0 ) { 
         
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
              
            }
            else
            { 
              var url = '{{ asset("imageFolder/no-image.png") }}';
            }


           
            htmlString += "<div class='row row-container cart-item' style='border-radius: 15px !important;'>"
            htmlString += "<div class='col-md-1 col-xs-1'></div>"
            htmlString += "<div class='col-md-3 col-xs-4 col__xs__modified'  style='margin-top: 25px; margin-bottom: 25px; background: #fff !important;height: 250px; z-index: 1 !important'>"
            htmlString += "<div class='order__details__img'>"
            htmlString += "<img src='"+url+"' class='img-responsive center-block img__sml'>"
            htmlString += "</div>"
            htmlString += "</div>"
            htmlString += "<div class='col-md-7 col-xs-6  col__xs__modified' style='background: #fff; margin-top: 25px;height: 250px;'>"
            htmlString += "<div class='order__details__price' style='color: #000;'>"
            htmlString += "</div>"
            htmlString += "<ul style='background: transparent !important;'>"
            htmlString += "<li style='background: transparent !important;'>"
            htmlString += "<i class='glyphicon glyphicon-remove-circle delete deleteitem' data-itemindex='"+index+"'> </i>"
            htmlString += "</li>"
            htmlString += "<li style='clear:both' class='menu__details'>"
            htmlString += "<span> "+item.name+"</span>"
            htmlString += "<span class='pull-right right__margin'> "+item.totalprice * item.quantity+" BDT </span></li>"
            htmlString += "<li class='menu__details'>"
            htmlString += "<span>Quantity</span>"
            htmlString += "<span class='pull-right right__margin'>"
            htmlString += "<button id='minus' class='btn-item-remove' data-itemindex='"+index+"' style='background:transparent;border:none;outline:none;'>"
            htmlString += "<img src='{{ asset('imageFolder/minus.png') }}' class='img-responsive minus__icon' />"
            htmlString += "</button>"
            htmlString += "<input type='text' disabled value='"+item.quantity+"' id='input' style='border: none; width: 21px; text-align: center;' />"
            htmlString += "<button id='plus' data-itemindex='"+index+"' class='btn-item-add' style='background:transparent;border:none;outline:none;'>"
            htmlString += "<img src='{{ asset('imageFolder/plus.png') }}' class='img-responsive plus__icon' style='width: 13px !important'/>"
            htmlString += "</button>"
            
      
            htmlString += "</span>"
            htmlString += "</li>"
           
            if (item.topping.length > 0) {
              $.each(item.topping, function(toppingIndex,toppingValue){
                htmlString += "<li style='clear:both;' class='menu__details'>"
                htmlString += "<span>"+toppingValue.name+"</span>"
                // htmlString += "<span class='pull-right right__margin'> "+ toppingValue.toppingqty +"</span>"
                htmlString += "</li>"
              });
            }else{
              htmlString += "<li style='' class='menu__details'>"
              htmlString += "<span>NO TOPPINGS</span>"
              htmlString += "<span class='pull-right right__margin'> 0</span>"
              htmlString += "</li>"
            }
            htmlString += "</ul>"
            htmlString += "</div>"
            htmlString += "<div class='col-md-1'></div>"
            htmlString += "</div>"
            
            
            $("#cart-item-holder").append(htmlString);
            subTotal += (item.totalprice * item.quantity);
            discountamount += parseFloat((item.discountamount * item.quantity) + (item.addondiscount*item.quantity));
            
          });
          Total = parseFloat(subTotal) + parseFloat(deliveryCharge);
          total_discountamount = discountamount;
          console.log(total_discountamount);
          updateShoppingCartPrice(subTotal,Total);
        }else{
          $(".cart-item").remove();        
          $('.empty-cart').show();
        }   
$('#orderdata').val(sessionStorage.getItem('shopping­cart­items'));
$('#ordersubtotal').val(subTotal);
$('#ordertotal').val(Total);
$('#total_discountamount').val(total_discountamount);
$('#deliverycharge').val(deliveryCharge);
}
function updateShoppingCartPrice(subTotal,Total){
  
  $("#cart-total-price").text(" TK "+Total.toFixed(2));
 
}
</script> 


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
</script>
<script type="text/javascript">
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
</script>
@endsection