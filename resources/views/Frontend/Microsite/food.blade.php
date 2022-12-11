@extends('Frontend.layouts.manage')
@section('content')

<style type="text/css">
     ::-webkit-scrollbar{
        height: 0px;
        width: 1px;
        background: gray;
    }
    ::-webkit-scrollbar-thumb:horizontal{
        background: #000;
        border-radius: 10px;
    }
     ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
  color: #3D3D3D;
  opacity: 0.2; /* Firefox */
}

:-ms-input-placeholder { /* Internet Explorer 10-11 */
  color: #3D3D3D;
}

::-ms-input-placeholder { /* Microsoft Edge */
  color: #3D3D3D;
}
</style>
<body style=" background: url({{ asset('FrontendCSSJS/img/bg.png') }}) ; background-size: cover !important; background-repeat: no-repeat !important;font-family: 'BlockBerth'; border-bottom:  none !important;">
    <div style="">
<div class="container" style="background-color: #ffefdb;margin-top: -10px;border-left: 1px solid #ed7800 ">
    <div class="row" style="border-right: 2px solid #ed7800; border-left: 1px solid #ed7800 " >

        <center> 
            <h2 style="font-size: 25px; color: #4C4C4C"> BK<sup>&reg;</sup> DELIVERS  </h2>
        </center>
       
        

        <div id="mylightbox204" class="lightbox topping-modal">

            <div class="" style="clear:both; text-align:center"><h2> Select Toppings </h2> </div>
            <div class="row" id="addon-holder">

            </div>
            <div class="row">
               <div class="col-md-12">
                <div class="col-md-12 col-sm-12 col-xs-12 add2CartWrapper">
                    <input type="button" data-itemid="" data-itemname="" data-maxtopping="" data-mintopping="" data-topping-required="" data-image="" class="btn btn-block btn-danger btn-modal-add-to-cart featherlight-close" Value="OK">
                </div>
                
            </div>
        </div>
    </div>



    <input type="hidden" id="branchid" value="<?php echo Session::get('MyBranchID'); ?>" name="">
    <input type="hidden" id="categoryid" value="" name="">

 <div class="col-xs-12" id="categorysection" style="font-family: BlockBerth;overflow-x:scroll;white-space: nowrap;">
    <button type="button" style="background-color: #800080;text-transform: uppercase;border: 0px solid white" class="btn btn-primary allButton" id="categorybtn">
        ALL
    </button>
    @if(!empty($allCategoryData))
    @foreach($allCategoryData as $allCategory)
     <button type="button" style="background-color: #ed7800;text-transform: uppercase;border: 0px solid white" data-categoryid = "{{ $allCategory->categoryid }}" class="btn btn-primary" id="categorybtn">
        {{ $allCategory->name }}
    </button>
     @endforeach
     @endif
 </div>



<div class="col-md-12 col-sm-12 col-xs-12" id="searchbox" style="margin-top: 10px !important;"> 
               <input type="text"  id="searchfood" class='searchfood' style="width: 100%; text-align: center;border: 0px solid #fff;color: #b6b6b6;" placeholder="SEARCH BY FOOD NAME i.e BEEF BURGER,CARAMEL SUNDAE" >
</div>


    <div class="mainDiv" id="mainDiv" style="border-left:1px solid red; border-right: 8px solid red;">




            <!-- <div class="col-md-10 col-sm-10 col-xs-12 productBoxCenter">
               
                    <div class="col-md-12 col-sm-12 col-xs-12"> <a name="Cat9"> </a>
                        <img src="{{ asset('FrontendCSSJS/img/delivery/slider/budget_bites.jpg') }}" class="img img-responsive" style="text-align:center; width:100%">
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12 pContainer">

                        <div class="col-md-3 col-sm-3 col-xs-12 wrap">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                <img src="{{ asset('FrontendCSSJS/img/delivery/products/FrenchFries.jpg') }}" class="img img-responsive" style="width:auto">
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
                                    <input type="button" id="ad2cart" name="ad2cart" class="btn add2Cart" style="background-color: #ed7800; color:white" value="Add To Cart" data-featherlight='#mylightbox204'> 
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-xs-12"> <hr> </div>
                    </div>
                </div> -->



            </div>
        </div>
    </div>



    <br> <br> <br><br>
    <div class="col-md-12 col-sm-12 col-xs-12 cartBoxRight" style="position:fixed; bottom:0;width:100%; z-index:1; background: url({{ asset('FrontendCSSJS/img/footer.png') }});
                   background-size: cover !important;
                   background-repeat: no-repeat;border-left: 2px solid #EE7700;border-right: 2px solid #EE7700;border-bottom: 2px solid #EE7700 ">
      
            <div class="col-md-4 col-sm-4 col-xs-4" style="padding-left: 0px;">
                <a href="" onclick="return false;" style="margin-left: auto; margin-right:auto; ">
                <img src="{{ asset('FrontendCSSJS/img/call.png') }}" class="img-responsive" 
                     style="margin-top: 15px;width:85px;">
            </a>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <form method="post" id="checkout" action="{{ url('bkashmicrosite/billingdetails') }}">
                {{ csrf_field() }}
                <h2>
                   
              
                  <input type="hidden" name="ordertotal" value="" id="ordertotal" >
                <input type="hidden" name="ordersubtotal" id="ordersubtotal">
                <input type="hidden" name="deliverycharge" id="deliverycharge">
                    
                    
                    <img src="{{ asset('FrontendCSSJS/img/checkoutyellow.png') }}" class="img-responsive center-block" style="margin-left: 5px;cursor: pointer;margin-bottom: 18px;" onclick="$('#checkout').submit()">
                </h2>
            </form>
            </div>
            
            <div class="col-md-4 col-sm-4 col-xs-4" style="padding-left: 50px">
                <form method="post" id="previewcart" action="{{ url('bkashmicrosite/previewcart') }}">
                {{ csrf_field() }}
                <h2>
                    <input type="hidden" id="branchid" value="<?php echo Session::get('MyBranchID'); ?>" name="branchid">
                    <input type="hidden" name="orderdata" id="orderdata">
                    

                    
                    <img src="{{ asset('FrontendCSSJS/img/bag.png') }}" class="img-responsive" style="float: right !important;margin-right: 5px;cursor: pointer;height: 50px;
    margin-top: -16px;
    " onclick="$('#previewcart').submit()">
                    <span class="button__badge" style=" background-color: #ED7700;
    border-radius: 2px;
    color: white;
    
    padding: 2px 6px;
    font-size: 16px;
    position: absolute;
       top: -11px;
    right: 22px;
    border-radius: 50%;"></span>
                </h2>
            </form>
            </div>
        
    </div>

       </body>

<!-- <script type="text/javascript">
    $('body').delegate('.remove','click',function(){
  var l = $('tbody tr').length;
  if(l == 1)
  {
    alert('Not allowed to remove this row!');
  }
  else
  {
    $(this).parent().parent().remove();
    
  }
});
</script> -->

<script src="{{ asset('sweetalert.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            var branchid = $('#branchid').val();

            var url = '{{ url('bkashmicrosite/searchmicrositefood') }}';
            $.ajax({
                url: url,
                method:'get',
                data:{
                    branchid : branchid, 
                },
                dataType: "json",
                success:function(result){

                    
                  $('#deliverycharge').html(result.delfee.toFixed(2)+" Tk");

                  $('#mainDiv').html(result.data);
                  sessionStorage.setItem('deliveryFee',result.delfee);
                  
              },
              error:function(error){
                console.log(error);
                swal({
                    title: "Refresh the page again!",
                    icon: "info",
                    button: "Cancel !",
                    className: "myClass",

                });
            }
        })
        })
    </script>

    <script type="text/javascript">
        $(document).ready(function(){

            $('#categorysection').on('click','#categorybtn',function(){
                var button = $(this);

                var categoryid = button.attr('data-categoryid');
                var branchid = $('#branchid').val();
                var indicator = 'sbc'; // search by category
                $('#categoryid').val(categoryid);

                $('#searchfood').val('');
                
                $('button').css('background-color','#ed7800');

                var url = '{{ url('bkashmicrosite/searchmicrositefood') }}';
            $.ajax({
                url: url,
                method:'get',
                data:{
                    branchid : branchid, 
                    flag : indicator,
                    categoryid : categoryid,
                },
                dataType: "json",
                success:function(result){

                  button.css('background-color','#800080');
                  $('#deliverycharge').html(result.delfee.toFixed(2)+" Tk");

                  $('#mainDiv').html(result.data);
                  sessionStorage.setItem('deliveryFee',result.delfee);
                  
              },
              error:function(error){
                console.log(error);
                swal({
                    title: "Refresh the page again!",
                    icon: "info",
                    button: "Cancel !",
                    className: "myClass",

                });
            }
        })


                
            })
        })
    </script>

    <script type="text/javascript">
    $(document).ready(function(){
        $('#searchbox').on('keyup','.searchfood',function(){
            var foodString = $('.searchfood').val();
            var branchid = $('#branchid').val();
            var categoryid = $('#categoryid').val();
            


            var url = '{{ url('bkashmicrosite/searchmicrositefood') }}';
            $.ajax({
                url: url,
                method:'get',
                data:{
                    branchid : branchid,
                    searchString : foodString,
                    categoryid : categoryid,
                },
                dataType: "json",
                success:function(result){

                  $('#mainDiv').html(result.data);
                  // console.log(result.data);
                  
                 

              },
              error:function(error){
                console.log(error);
                swal({
                    title: "Refresh the page again!",
                    icon: "info",
                    button: "Cancel !",
                    className: "myClass",

                });
            }
        })
        })
    })
</script>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#mainDiv").on('click','.btn-add-topping',function () { 
                var button = $(this); 

                var topping         = button.data("topping");  
                var minaddon        = button.data("mintopping");   
                var maxaddon        = button.data("maxtopping");   
                var addonrequired   = button.data("topping-required");   
                var addon = "";
                if (addonrequired == 1) {
                    addon = 'Required';
                }else{
                    addon = 'Optional';
                }

                $(".btn-modal-add-to-cart").data("maxtopping",maxaddon);
                $(".btn-modal-add-to-cart").data("mintopping",minaddon);
                $(".btn-modal-add-to-cart").data("topping-required",addonrequired);
                $(".btn-modal-add-to-cart").attr("data-itemid",button.data("itemid"));
                $(".btn-modal-add-to-cart").attr("data-itemname",button.data("itemname"));
                $(".btn-modal-add-to-cart").attr("data-itemprice",button.data("itemprice"));
                $(".btn-modal-add-to-cart").attr("data-image",button.data("image"));


                var htmlString = "";
                $.each(topping, function (index, value) {
                    htmlString += "<div class='col-md-6'>";
                    htmlString += "<label><input type='checkbox' value='"+value.foodid+"' name='addon[]' data-addonname='"+value.foodname+"' data-addonprice='"+value.price+"'> Add "+value.foodname+" ( "+value.price+" Tk )</label>"
                    htmlString += "</div>"
                });

                $("#addon-holder").html(htmlString);
                $(".max-addon").html("Max : "+maxaddon);
                $(".min-addon").html("Min : "+minaddon);
                $(".addon-option").html(addon);

            });
        })
    </script>

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

    $(document).on("click", ".btn-modal-add-to-cart", function(){
    var button = $(this);
    var id = button.data("itemid");  
    var name = button.data("itemname");  
    var price = button.data("itemprice");  
    var image = button.data("image");          
    var pricewithaddon = button.data("itemprice");           
    var quantity = 1; 


    var topping = [];
    $("input[name='addon[]']:checked").each ( function() {
        var toppingItem = {
            addonid     : $(this).val(),
            name        : $(this).data('addonname'),
            price       : $(this).data('addonprice'),
            toppingqty  : 1,
        };

        topping.push(toppingItem);
        pricewithaddon += parseFloat($(this).data('addonprice'));
    });

    var item = {             
        id: id,             
        name: name,             
        price: price,
        image : image,             
        totalprice: pricewithaddon,             
        quantity: quantity,
        topping: topping,
        bagqty : 1     
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


    function checkTopping(firstArr,secondArr){
        var firstlen    = firstArr.length;
        var secondlen   = secondArr.length;
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
     
});

</script>

<script type="text/javascript">
    $("#mainDiv").on('click','.btn-add-to-cart',function () { 

        var button = $(this);  
        var id = button.data("itemid");  
        var name = button.data("itemname");  
        var price = button.data("itemprice"); 
        var image = button.data("image");          
        var quantity = 1;  
         
        var topping = button.data("topping");     

        var item = {             
            id: id,             
            name: name,             
            price: price,    
            image : image,         
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
</script>

<script type="text/javascript">
    function displayShoppingCartItems() {      

        var cartobject = JSON.parse(sessionStorage.getItem('shopping­cart­items'));
        var subTotal = 0;
        var Total = 0;
        var badgeqty = 0;
        var deliveryCharge = sessionStorage["deliveryFee"];
        // var discount = sessionStorage["discount"];
        if (sessionStorage["shopping­cart­items"] != null && cartobject.length > 0 ) { 
            $('.empty-cart').hide();
            shoppingCartItems = JSON.parse(sessionStorage.getItem('shopping­cart­items')); 
            $("#cart-item-holder").find(".cart-item").remove();

            


            $.each(shoppingCartItems, function (index, item){
                
                var htmlString = "";
               
                htmlString += "<tr class='cart-item'>"
                htmlString += "<td>"
                htmlString += "<p class='cart-item-title'><b>"+item.name+"</b></p>"

                if (item.topping.length > 0) {
                    $.each(item.topping, function(toppingIndex,toppingValue){

                        htmlString += "<p class='cart-item-addon'>+ "+toppingValue.name+"</p>"
                        
                    });
                }else{
                    htmlString += "<p class='cart-item-addon'>No topping</p>"
                }
                htmlString += "</td>"
                htmlString += "<td><div class='col-md-12'>"
                htmlString += "<button type='button' class='btn btn-xs btn-circle red btn-item-add' data-itemindex='"+index+"'><i class='fa fa-plus'></i></button>"
                htmlString += "<span class='cart-item-qty'> "+ item.quantity +" </span>"
                htmlString += "<button type='button' class='btn btn-xs btn-circle btn-item-remove' data-itemindex='"+index+"'><i class='fa fa-minus'></i></button></div></td>"
                htmlString += "<td> "+item.totalprice * item.quantity+" </td>"
                htmlString += "</tr>";
                
                // $("#cart-item-holder").append(htmlString);
                subTotal += (item.totalprice * item.quantity);
                badgeqty += 1;
               
                sessionStorage.setItem('badgequantity',badgeqty);

            });
            Total = parseFloat(subTotal) + parseFloat(deliveryCharge);
            updateShoppingCartPrice(subTotal,Total);
        }else{
            $(".cart-item").remove();        
            $('.empty-cart').show();
        }   
        

        $('.button__badge').html(badgeqty);
        $('#orderdata').val(sessionStorage.getItem('shopping­cart­items'));
        $('#ordersubtotal').val(subTotal);
        $('#ordertotal').val(Total);
        $('#deliverycharge').val(deliveryCharge);
    }

    function updateShoppingCartPrice(subTotal,Total){
        $("#cart-sub-total").text(subTotal.toFixed(2)+" Tk");
        $("#cart-total-price").text(Total.toFixed(2)+" Tk");
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


</script>

<script type="text/javascript">
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
        $('#cart-sub-total').text('0.00');
        $("#cart-total-price").text('0.00');
        $('.subtotal').val('0.00 Tk');
    }
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

@endsection

