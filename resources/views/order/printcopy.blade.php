<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="style.css">
  <title>Receipt example</title>
  <style type="text/css">
    * {
      font-size: 12px;
      font-family: 'monospace';
    }

    td{
      font-family: monospace;
    }
    p{
      font-family: monospace;
    }

    .centered {
      text-align: center;
      align-content: center;
    }

    .ticket {
      width: 240px;
      max-width: 240px;
      /*text-align: center;*/
    }

    img {
      max-width: inherit;
      width: inherit;
    }

    @media print {
      .hidden-print,
      .hidden-print * {
        display: none !important;
      }
    }
  </style>
</head>
<body>
  <div class="ticket">
    
    <p class="centered" style="font-family: monospace;"><b>BURGER KING</b>
      <br>Tiffin Box Limited
      <br><span id="branchname" style="font-family: monospace;">{{ $branchname }}</span>
      <br>{{ $branchaddress }}
      
    </p>

    <p class="centered" style="font-family: monospace;"><b >ORDER FORM</b></p>

    <p style="border-top: 1px dashed black;border-bottom: 1px dashed black;padding: 5px;font-family: monospace;">Chk {{ $orderDetail['orderid'] }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ date("Y-m-d h:i A") }}</p><span style="font-family: monospace;"><b>DOORSTEP</b></span><br>

    <table style="margin-left: 7px;">
      <tbody>
        <tr>
          <td width="5%">&nbsp;&nbsp;Qty</td>
          <td width="5%">Items</td>
          <td width="5%"></td>
        </tr>
      </tbody>
    </table>

    <table style="margin-left: 7px;">
      <tbody>
       @if(!empty($orderDetail))
       @foreach( $orderDetail['orderitem'] as $item )
       <tr>
        <td width="5%"></td>
        <td width="50%">
         {{ $item['quantity'] }}&nbsp; {{ $item['foodinfo']['foodname'] }}  
         @foreach($item['orderitemaddon'] as $addon)
         <br>&nbsp;&nbsp;&nbsp; +{{ $addon['addonInfo']['foodname'] }} 
         @endforeach
       </td>
       <td width="15%"></td>
     </tr>
     @endforeach
     @endif
   </tbody>
 </table>

 <p style="border-top: 1px dashed black;margin-left: 25px;margin-bottom: 70px;"><b style="font-family: monospace;">Customer Details :</b><br>Customer Name : {{ $orderDetail['customer']['name'] }}<br>Phone : {{ $orderDetail['customer']['contactno'] }}<br>Address : {{ $orderDetail['customer']['address'] }}
  @if(!empty($orderDetail['specialinstruction']))
  <br>Instruction : {{ $orderDetail['specialinstruction'] }}
  @endif
  <br>Payment Method : 
  @if($orderDetail['paymentmethod']== 1)
  {{ __('Cash') }} 
  @elseif($orderDetail['paymentmethod']== 2)
  {{ __('Card') }} 
  @elseif($orderDetail['paymentmethod']== 3)
  {{ __('bKash') }}
  @endif
  <br><br>Thanks for ordering from Burger King. Please do Visit Us Again<br>Call : {{ $branchphone }}<br>Have a Nice Day<br>****************************</p>

  <p class="centered" style="color: white;">f</p>
</div>
<button style="background-color: orange;border: 0px solid white;padding: 10px;" id="btnPrint" class="hidden-print"><b>PRINT</b></button>
<script src="script.js"></script>
</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script type="text/javascript">
  const $btnPrint = document.querySelector("#btnPrint");
  $btnPrint.addEventListener("click", () => {
    window.print();
  });
</script>

<script type="text/javascript">
 $(document).ready(function(){

  var branchname = '{{ $branchname }}';
  const [first,second,third] = branchname.split(' ');
  var finalbranchname = third + ' ' + 'Outlet';
  $('#branchname').html(finalbranchname);

})
</script>