@extends('Website.layouts.manage')
@section('extra_css')

<style>
  .col__xs__img{
    width: 150px !important;
  }
  .img__menu{
    margin-left: -15px;
  }
  .searchTerm {
    width: 100%;
    border: none;

    padding: 15px;

    border-radius: 10px;
    outline: none;
    color: #9DBFAF;

  }

  .searchTerm:focus{
    color: #00B4CC;
  }
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
  .food__menu__container___second{
    margin-top: -130px;
  }
  .food__menu__container__third{
    margin-top: 40px;
  }
  .food__menu__container___fourth{
    margin-top: 30px;
  }
  .order__bag{
    margin-right: 65px;cursor: pointer;height: 110px;margin-top: -17px; " 
  }
  .badge{background-color: #ED7700;
    background-color: #ED7700;
    color: white;
    padding: 2px 10px;
    font-size: 27px;
    position: absolute;
    top: -28px;
    right: 70px;
    border-radius: 50%;
  }

  .content{font-family: 'BlockBeCnPro', Arial, Helvetica, sans-serif;}
  .menu__title{font-size: 35px; padding-top: 40px;padding-bottom: 0px;color: #323231}


  .menu__name{
    padding-top: 60px; font-size: 30px; padding-left: 10px
  }

  .menu__price{
    text-align: right;
    font-size: 25px;
    padding-top: 20px;
  }

  .menu__btn{
    background-color: #ed7800 !important; color:white !important;
  }

  .row__food{
    height: 130px;
  }

  .col-xs-img{margin-left: -15px;}
  .col-xs-line{margin-top: 20px;}
  @media only screen and (max-width: 768px) {

    .row__food{
      height: 90px;
    }

    .menu__name{
      clear: both;

      font-size: 15px;
      padding-top: 19px;
    }
    .menu__price{
      padding-right: 0px;
      font-size: 15px;
      margin-top: -30px;
      text-align: right;

    }

    .col-xs-img{margin-left: 0px; width:150px; margin: 0 auto !important;display: block;}
    .col-xs-line{margin-top: 130px}
    .menu__btn{
     padding: 6px 0px;
   }
   .order__bag{
    margin-top: 0px;
    height: 60px !important;
    margin-right: 15px !important;
  }
  .badge{background-color: #ED7700;
    background-color: #ED7700;
    color: white;
    padding: 6px 12px;
    font-size: 21px;
    position: absolute;
    top: -15px;
    right: 15px;
  }

  .img-checkout{
    margin-left: 15px;
    
  }
  .menu__price__rt{
    float: right;
  }
}



</style>

@endsection
@section('content')
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div id="meal-div">
        
      </div>
      <div class="modal-header">
        <h4 class="modal-title">Toppings</h4>
      </div>
      <div class="modal-body" id="addon-holder">

      </div>
      <div class="modal-footer">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <input type="button" data-itemid="" data-itemname="" data-maxtopping="" data-mintopping="" data-topping-required="" data-image="" class="btn btn-block btn-danger btn-modal-add-to-cart" data-dismiss="modal" Value="OK">
        </div>
      </div>
    </div>
  </div>
</div>

<input type="hidden" id="branchid" value="<?php echo Session::get('MyBranchID'); ?>" name="">
<input type="hidden" id="categoryid" value="" name="">

<section style="background: #FCF1EB; ">
  <div class="content" 
  style="">
  <div class="container-fluid" style="">
    <div class="content" >
      <div class="row" >
        <div class="col-md-3" >
          <div class="menu__title"> BK<span class="register">&#174;</span> DELIVERS </div>
        </div> 
        <div class="col-md-9"> </div>     
      </div>
    </div>
  </div>
</div>

<div class="content" 
style="">
<div class="container-fluid" style="">
  <div class="content" >
    <div class="row" >
      <div class="col-md-3" >
        <div class="menu__title"> MENU 
          <ul class="" id="categorysection" style="font-size: 22px;padding-top: 30px;cursor: pointer;">
            <li id="categorybtn" style="color: #800080"> ALL  </li>
            @if(!empty($allCategoryData))
            @foreach($allCategoryData as $allCategory)
            <li style="text-transform: uppercase;" id="categorybtn" data-categoryid = "{{ $allCategory->categoryid }}"> {{ $allCategory->name }}  </li>
            @endforeach
            @endif
          </ul>
        </div>
      </div> 
      <div class="col-md-9">
        <div class="row">
         <div class="col-md-1 col-xs-1"></div>
         <div class="col-md-10 col-xs-10">
           <img src="{{ asset('WebsiteCSSJS/img/10discbanner.png') }}" style="" class="img-responsive" ><br>
           <div class="search" id="searchbox">
            <input type="text" class="searchTerm searchfood" placeholder="SEARCH">
          </div>

          <div class="food__menu__container" id="food__menu__container"> 

            <!-- <div class="row row__food" style=""> 
              <div class="col-md-3  col-xs-12 ">
                <img src="{{ asset('WebsiteCSSJS/menu/img/chicken/ChickN-Crisp.png') }}" style="" class="img-responsive col-xs-img" >
              </div>     
              <div class="col-md-6 col-xs-6">
                <div style="" class="menu__name">DOUBLE WHOPPER</div>
              </div>
              <div class="col-md-3 col-xs-6" style="">

                <div class="menu__price">
                  <span class="menu__price__rt">199 BDT</span> <br/>
                  <input type="button " class="btn menu__btn" 
                  style="" 
                  value="ADD TO CART" > 
                </div>
              </div>
            </div>

            <div class='row col-xs-line'> 
              <div class='col-md-2'>
              </div>
              <div class='col-md-8'>
                <img src='{{ asset('WebsiteCSSJS/img/line.png') }}' class='img-responsive' style='margin-top: 20px'>
              </div>
              <div class='col-md-2'>
              </div>
            </div> --> 

          </div>

        </div> 
        <div class="col-md-1 col-xs-1"></div>
      </div>
    </div>     
  </div>
</div>
</div>
</div>
</section>


<section style="background: #FCF1EB;">
  <div class="content" style="position:fixed; bottom:0;width:100%; z-index:1;">

    <div class="container-fluid" style="background: #61342C">
      <div class="content" >
        <div class="row" style="margin-top: 15px;margin-bottom: 10px">
          <div class="col-md-4 col-xs-4" style="padding-right: 0px;padding-left: 0px">

            <a href="" onclick="return false;" style="margin-left: auto; margin-right:auto; ">
              <img src="{{ asset('FrontendCSSJS/img/call.png') }}" class="img-responsive" 
              style="margin-top: 5px;width:150px;">
            </a>
          </div>

          <div class="col-md-4 col-xs-4" style="padding-right: 5px; padding-left: 5px">
            <form method="post" id="checkout" action="{{ url('billingdetails') }}">
              {{ csrf_field() }}

              <input type="hidden" name="ordertotal" id="ordertotal" >
              <input type="hidden" name="ordersubtotal" id="ordersubtotal">
              <input type="hidden" name="deliverycharge" id="deliverycharge">
              <input type="hidden" name="total_discountamount" id="total_discountamount">

              <a href="" onclick="return false;" style="margin-left: auto; margin-right:auto; ">
                <img src="{{ asset('FrontendCSSJS/img/checkoutyellow.png') }}" class="img-responsive center-block img-checkout" 
                style="margin-top: 8px;width:200px;" onclick="$('#checkout').submit()">
              </a>
            </form>
          </div>

          <div class="col-md-4 col-xs-4" style="padding-left: 0px;padding-right: 0px;">
           <form method="post" id="previewcart" action="{{ url('previewcart') }}">
            {{ csrf_field() }}

            <input type="hidden" id="branchid" value="<?php echo Session::get('MyBranchID'); ?>" name="branchid">
            <input type="hidden" name="orderdata" id="orderdata">

            <a href="" onclick="return false;" style="margin-left: auto; margin-right:auto; ">
              <img src="{{ asset('FrontendCSSJS/img/bag.png') }}" class="img-responsive pull-right order__bag" style="" onclick="$('#previewcart').submit()">
              <span class="button__badge badge" style="">0</span>
            </a>
          </form>
        </div>
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
    var branchid = $('#branchid').val();

    var url = '{{ url('onlinefoodajax') }}';
    $.ajax({
      url: url,
      method:'get',
      data:{
        branchid : branchid, 
      },
      dataType: "json",
      success:function(result){

        $('#deliverycharge').html(result.delfee.toFixed(2)+" Tk");

        $('#food__menu__container').html(result.data);
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
                
                $('li').css('color','#000');

                var url = '{{ url('onlinefoodajax') }}';
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

                    button.css('color','#800080');
                    // $('#deliverycharge').html(result.delfee.toFixed(2)+" Tk");
                    if(result.data != '')
                    {
                      $('#food__menu__container').html(result.data);
                      sessionStorage.setItem('deliveryFee',result.delfee);
                    }
                    else
                    {
                      $('#food__menu__container').html('Food not found!');
                    }

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

      var url = '{{ url('onlinefoodajax') }}';
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
          if(result.data != '')
          {
           sessionStorage.setItem('deliveryFee',result.delfee);
           $('#food__menu__container').html(result.data);
         }
         else
         {
           $('#food__menu__container').html('Food not found!');
         }

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
    $("#food__menu__container").on('click','.btn-add-topping',function () { 
      var button = $(this); 

      var topping         = button.data("topping");  
      var mealtopping     = button.data("mealtopping");  
      var minaddon        = button.data("mintopping");   
      var maxaddon        = button.data("maxtopping");   
      var addonrequired   = button.data("topping-required");
      var itemname        = button.attr("data-itemname");
      var categorytype    = button.attr("data-categorytype");

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
      $(".btn-modal-add-to-cart").attr("data-itemname",itemname);
      $(".btn-modal-add-to-cart").attr("data-itemprice",button.data("itemprice"));
      $(".btn-modal-add-to-cart").attr("data-discount",button.data("discount"));
      $(".btn-modal-add-to-cart").attr("data-discountamount",button.data("discountamount"));
      $(".btn-modal-add-to-cart").attr("data-offerprice",button.data("offerprice"));
      $(".btn-modal-add-to-cart").attr("data-image",button.data("image"));

      var htmlString = "";
      var mealData = "";
      var addondiscount;
      $.each(topping, function (index, value) {
        if(categorytype != 'Offers' && value.discount != 0)
        {
          addondiscount = value.price - value.offerprice;
          htmlString += "<div class='col-md-6'>";
            htmlString += "<label><input type='checkbox' value='"+value.foodid+"' name='addon[]' data-addonname='"+value.foodname+"' data-addondiscount='"+addondiscount+"' data-addonprice='"+value.offerprice+"'> Add "+value.foodname+" <span style='text-decoration:line-through'> ( "+value.price+" Tk )</span>( "+value.offerprice+" Tk )</label>"
            htmlString += "</div>"
        }
        else
        {
          addondiscount = 0;
         htmlString += "<div class='col-md-6'>";
         htmlString += "<label><input type='checkbox' value='"+value.foodid+"' name='addon[]' data-addonname='"+value.foodname+"' data-addondiscount='"+addondiscount+"' data-addonprice='"+value.price+"'> Add "+value.foodname+" ( "+value.price+" Tk )</label>"
         htmlString += "</div>"
       }
     });

      $('#meal-div').empty();

      $.each(mealtopping, function (index, value) {
        if(categorytype != 'Offers' && value.discount != 0)
        {
          addondiscount = value.price - value.offerprice;
          mealData += "<div class='col-md-6'>";
            mealData += "<label><input type='checkbox' value='"+value.foodid+"' name='addon[]' data-addonname='"+value.foodname+"' data-addondiscount='"+addondiscount+"' data-addonprice='"+value.offerprice+"'> Add "+value.foodname+" <span style='text-decoration:line-through'> ( "+value.price+" Tk )</span>( "+value.offerprice+" Tk )</label>"
            mealData += "</div>"
        }
        else
        {
         addondiscount = 0;
         mealData += "<div class='col-md-6'>";
         mealData += "<label><input type='checkbox' value='"+value.foodid+"' name='addon[]' data-addonname='"+value.foodname+"' data-addondiscount='"+addondiscount+"' data-addonprice='"+value.price+"'> Add "+value.foodname+" ( "+value.price+" Tk )</label>"
         mealData += "</div>"
       }
     });

      if(mealtopping.length != 0) {
          var mealdiv = "";
          mealdiv += "<div class='modal-header'>";
          mealdiv += "<button type='button' class='close' data-dismiss='modal'>&times;</button>";
          mealdiv += "<h4 class='modal-title'>Want to make a Meal ?</h4>";
          mealdiv += "</div>";
          mealdiv += "<div class='modal-body'>"+mealData+"</div>";
          $("#meal-div").html(mealdiv);
      }

      $("#addon-holder").html(htmlString);
      $(".max-addon").html("Max : "+maxaddon);
      $(".min-addon").html("Min : "+minaddon);


    });
  })
</script>
<script type="text/javascript">

  $(document).on("click",'.btn-modal-add-to-cart', function(){
    var button = $(this);
    var pricewithaddon;
    var totaladdondiscount=0;
    var id = button.attr("data-itemid");  
    var name = button.attr("data-itemname");  
    var price = button.attr("data-itemprice");
    var discount = button.attr("data-discount");
    var discountamount = button.attr("data-discountamount");
    var offerprice = button.attr("data-offerprice");  
    var image = button.attr("data-image");          
    if(discount == 0 || discount == null)
    {
      pricewithaddon = parseFloat(button.attr("data-itemprice"));
    }           
    else
    {
      pricewithaddon = parseFloat(button.attr("data-offerprice"));
    }
        // pricewithaddon = parseFloat(button.attr("data-itemprice"));
        var quantity = 1; 

        var topping = [];
        $("input[name='addon[]']:checked").each ( function() {
          var toppingItem = {
            addonid     : $(this).val(),
            name        : $(this).data('addonname'),
            price       : $(this).data('addonprice'),
            addondiscount       : $(this).data('addondiscount'),
            toppingqty  : 1,
          };

          topping.push(toppingItem);
          pricewithaddon += parseFloat($(this).data('addonprice'));
          totaladdondiscount += parseFloat($(this).data('addondiscount'));
        });

        var item = {             
          id: id,             
          name: name,             
          price: price,
          image : image,             
          totalprice: pricewithaddon,             
          quantity: quantity,
          discount: discount,
          discountamount: discountamount,
          addondiscount: totaladdondiscount,
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
    // var cartobject = JSON.parse(sessionStorage.getItem('shopping­cart­items'));
    // console.log(cartobject)

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
  $("#food__menu__container").on('click','.btn-add-to-cart',function () { 

    var button = $(this);  
    var id = button.attr("data-itemid");  
    var name = button.attr("data-itemname");  
    var price = button.attr("data-itemprice"); 
    var discount = button.attr("data-discount"); 
    var discountamount = button.attr("data-discountamount");
    var offerprice = button.attr("data-offerprice"); 
    var image = button.attr("data-image");          
    var quantity = 1;  
    var pricetotal;

    var topping = button.data("topping"); 

    if(discount == 0 || discount == null)
    {
      pricetotal = parseFloat(button.attr("data-itemprice"));
    }           
    else
    {
      pricetotal = parseFloat(button.attr("data-offerprice"));
    }    

    var item = {             
      id: id,             
      name: name,             
      price: price,    
      image : image,         
      totalprice: pricetotal,      
      quantity: quantity,
      discount: discount,
      discountamount: discountamount,
      addondiscount: 0,
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
    var badgeqty = 0;
    var subTotal = 0;
    var Total = 0;
    var discountamount = 0;
    var total_discountamount = 0;
    var deliveryCharge = sessionStorage["deliveryFee"];

    if (sessionStorage["shopping­cart­items"] != null && cartobject.length > 0 ) { 
      shoppingCartItems = JSON.parse(sessionStorage.getItem('shopping­cart­items')); 
      $.each(shoppingCartItems, function (index, item){
        subTotal += (item.totalprice * item.quantity);
        discountamount += parseFloat((item.discountamount * item.quantity) + (item.addondiscount*item.quantity));
        badgeqty += 1;
        sessionStorage.setItem('badgequantity',badgeqty);
      });
      Total = parseFloat(subTotal) + parseFloat(deliveryCharge);
      total_discountamount = discountamount;
    }  
    $('.button__badge').html(badgeqty);
    $('#orderdata').val(sessionStorage.getItem('shopping­cart­items'));
    $('#ordersubtotal').val(subTotal);
    $('#ordertotal').val(Total);
    $('#total_discountamount').val(total_discountamount);
    $('#deliverycharge').val(deliveryCharge);
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
<!-- <script type="text/javascript">
  var width = $(document).width()
  if(width < 768)
  {
     document.getElementById('smallCategory').style.display = '';
     document.getElementById('bigCategory').style.display = 'none';
  }
  else
  {
    document.getElementById('smallCategory').style.display = 'none';
    document.getElementById('bigCategory').style.display = '';
  }
</script> -->
@endsection