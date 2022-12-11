  @extends('common.layout')
  @section('content')
  <div class="page-content">
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
      <div class="col-md-12">
        <div class="portlet">
          <div class="portlet-body">
            <div class="tabbable">
              <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                  <div class="row">
            
                    <div class="col-md-12">
                      <div class="row content">


                            <div class="col-md-3">
                              <div class="portlet box blue">
                                <div class="portlet-title">
                                  <div class="caption">
                                    <i class="fa fa-comments"></i>Contextual Rows
                                  </div>
                                </div>
                                <div class="portlet-body">
                                  <div class="row static-info"><div class="col-md-5 name">Member ID : <span class="value">567</span></div><div class="col-md-7 name">Waiter Name : <span class="value">Elahi</span></div></div><div class="row static-info"><div class="col-md-5 name">Order Time : <span class="value">2020-09-04</span> </div><div class="col-md-7 value">Order Status : <span class="label label-success" style="font-weight: bold">Confirmed</span></div></div>
                                  <div class="table-scrollable">
                                    <table class="table table-bordered table-hover">
                                      <thead>
                                        <tr>
                                          <th>
                                           Food Name
                                         </th>
                                         <th>
                                           Qty
                                         </th>
                                       </tr>
                                     </thead>
                                     <tbody>
                                      <tr>
                                        <td>
                                         Bangla Food 2
                                       </td>
                                       <td>
                                         6
                                       </td>
                                     </tr>
                                   </tbody>
                                 </table>
                               </div>
                             </div>
                           </div>
                         </div>




                       </div>
                     </div>

                  </div>
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

      var kitchenid = "{{ $kitchenid }}";

      function getOrderData() {
        var deliveryStatus = {
          0     : 'Placed',
          1     : 'Order Placed',
          2     : 'Confirmed & Processing',
          3     : 'Ready to Pickup',
          4     : 'On Way',
          5     : 'Delivered',
          6     : 'Returned',
          7     : 'Damaged',
          8     : 'Completed',
          9     : 'Canceled by Customer',
          10    : 'Canceled',
          11    : 'Canceled by Branch Agent',
          12    : 'In Pantry',
          13    : 'P. Ready to Pickup',
          14    : 'P. On Way',
          15    : 'P. In Pantry',
          16    : 'P. Delivered'
        }
        var url = '{{ url('ajax/live-order-data') }}';
        $.ajax({
          url: url,
          method:'GET',
          data:{},
          dataType: "json",
          success:function(order){
            console.log(order)
            $('.content').html('');
            
            var content_k1='',content_k2 = '';
            if(order.length == 0){
              $('.content').html('<h4><b style="margin-left:40px">Empty!</b></h4>');
            }else{
                if(order[1]){
                  $.each(order[1],function(index,value){
                  content_k1 += '<div class="col-md-3"><div class="portlet box blue"><div class="portlet-title"><div class="caption"><i class="fa fa-comments"></i>Order No #'+value.ordernumber+'</div></div><div class="portlet-body"><div class="row static-info"><div class="col-md-5 name">Member ID : <span class="value">'+value.member_id+'</span></div><div class="col-md-7 name">Waiter Name : <span class="value">'+value['waiter']['fullname']+'</span></div></div><div class="row static-info"><div class="col-md-5 name">Order Time : <span class="value">'+value['created_at'].split(' ')[1]+'</span> </div><div class="col-md-7 value">Order Status : <span class="label label-success" style="font-weight: bold">'+deliveryStatus[value.orderstatus]+'</span></div></div><div class="table-scrollable"><table class="table table-bordered table-hover"><thead><tr><th>Food Name</th><th>Qty</th><th>Remarks</th><th>Status</th></tr></thead><tbody>';
                  $.each(order[1][index].orderitem,function(i, item){
                    $item_status = item.itemstatus == 0 ? 'N/R' : 'R';
                    content_k1 += '<tr><td>'+item.foodinfo.foodname+'</td><td>'+item.quantity+'</td><td>'+item.remarks+'</td><td>'+$item_status+'</td></tr>';
                  });
                  content_k1 += '</tbody></table></div></div></div></div>';
                  // $('.content').html(content);
                });
                }
    
                if(order[2]){
                  $.each(order[2],function(index,value){
                  content_k2 += '<div class="col-md-3"><div class="portlet box blue"><div class="portlet-title"><div class="caption"><i class="fa fa-comments"></i>Order No #'+value.ordernumber+'</div></div><div class="portlet-body"><div class="row static-info"><div class="col-md-5 name">Member ID : <span class="value">'+value.member_id+'</span></div><div class="col-md-7 name">Waiter Name : <span class="value">'+value['waiter']['fullname']+'</span></div></div><div class="row static-info"><div class="col-md-5 name">Order Time : <span class="value">'+value['created_at'].split(' ')[1]+'</span> </div><div class="col-md-7 value">Order Status : <span class="label label-success" style="font-weight: bold">'+deliveryStatus[value.orderstatus]+'</span></div></div><div class="table-scrollable"><table class="table table-bordered table-hover"><thead><tr><th>Food Name</th><th>Qty</th><th>Remarks</th><th>Status</th></tr></thead><tbody>';
                  $.each(order[2][index].orderitem,function(i, item){
                    $item_status = item.itemstatus == 0 ? 'N/R' : 'R';
                    content_k2 += '<tr><td>'+item.foodinfo.foodname+'</td><td>'+item.quantity+'</td><td>'+item.remarks+'</td><td>'+$item_status+'</td></tr>';
                  });
                  content_k2 += '</tbody></table></div></div></div></div>';
                });
                }
                

                if(kitchenid == 1){
                  $('.content').html(content_k1);
                }
                else if(kitchenid == 2){
                  $('.content').html(content_k2);
                }else{
                  $('.content').html(content_k1+content_k2);
                }
            
            }
            
},
error:function(error){
  console.log(error);
  swal({
    title: "Refresh the page!",
    text: "You clicked the button!",
    icon: "error",
    button: "OK!",
    className: "myClass",

  });
}
})
}
        setInterval(function() {
          getOrderData();
        }, 5 * 1000);

        getOrderData();

      });

    </script>
    @endsection