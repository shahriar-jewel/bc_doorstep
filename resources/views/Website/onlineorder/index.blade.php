@extends('Website.layouts.manage')
@section('extra_css')
<style>
.slick-dots{
    display: none !important;
  }

  .location{font-size: 30px;
    /* margin-top: 10px; */
    padding-bottom: 20px;
    padding-top: 25px;
    text-align: left;
    padding-left: 5px;
}

.form-control{
  color : #bbb;
}
</style>

<style>

@media only screen and (max-width: 768px) {
  .location{font-size: 18px;margin-top: 0px;margin-bottom: 13px; padding-top: 25px;text-align: left; padding-left: 5px}
  .content__sm__index{margin-left: 15px !important; margin-right: 15px !important;}
  .content-modified{margin-top: 0px !important;
    
  }
}
@media only screen and (min-width: 768px) {
.img-cover{
  background-size: cover;
  width:100% ;
}
}
.mySlides {display: block;}
img {vertical-align: middle;}

/* Slideshow container */
.slideshow-container {
  /* max-width: 1000px; */
  position: relative;
  margin: auto;
 /*  height: 90vh;  */
  padding: 0px;
  margin-top: -2px;
}

/* Caption text */
.text {
  color: #f2f2f2;
  font-size: 15px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 100%;
  text-align: center;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.dot {
  height: 19px;
  width: 19px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;

}

.active {
  background-color: #717171;
}



/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .text {font-size: 11px}
}
</style>

<style type="text/css">
  .content-modified{
    /*margin-top: 135px;*/
    font-family: 'BlockBeCnPro', Arial, Helvetica, sans-serif;
    
  }

  @media only screen and (max-width: 1280px) {
     .content-modified{margin-top: 55px;
    
  }
}
</style>
<style type="text/css">
       
#map {
  height: 100%;
}

::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
  color: #bbbbbb;
  opacity: 1; /* Firefox */
}

:-ms-input-placeholder { /* Internet Explorer 10-11 */
  color: #bbbbbb;
}

::-ms-input-placeholder { /* Microsoft Edge */
  color: #bbbbbb;
}
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<!-- <section style="">
  <div class="slideshow-container">

    <div class="mySlides">
 
  <img src="{{ asset('WebsiteCSSJS/img/BANNER-Whopper-offer.png') }}" class="img-slider img-cover" style=" background-size: cover;margin-top: -10px; width: 100vw;">
 
</div>

<div class="mySlides">

  <img src="{{ asset('WebsiteCSSJS/img/banner1.jpg') }}" class="img-slider img-cover" style=" background-size: cover;margin-top: -10px; width: 100vw;">
 
</div>

<div class="mySlides">
 
  <img src="{{ asset('WebsiteCSSJS/img/banner3.jpg') }}" class="img-slider img-cover" style=" background-size: cover; margin-top: -10px; width: 100vw; ">
 
</div>

<div class="mySlides">
  
  <img src="{{ asset('WebsiteCSSJS/img/banner4.jpg') }}"  class="img-slider img-cover" style=" background-size: cover; margin-top: -10px; width: 100vw;">
  
</div>
<div style="text-align:center; " class="dot-position">
  <span class="dot"></span> 
  <span class="dot"></span> 
  <span class="dot"></span> 
  <span class="dot"></span> 
</div>
</div>
</section> -->
<section style="background: #FCF1EB; ">
<div class="content content-modified" style="">

  <div class="container-fluid">
    <div class="content content__sm__index" style="">
      <div class="row" style="padding-right: 0px !important; padding-left: 0px !important; ">
        <!-- <h2 
            style="" class="location">
              YOUR LOCATION
        </h2> -->
      </div><br><br>
      
    <div class="row">
        <form class="col-md-12 col-xs-12" action="{{ url('online-food-menu') }}" method="post" id="branchwisemenuform">
            {{ csrf_field() }}
            <select class="form-control select2" id="locationid" name="locationid">
               <option  value="" disabled selected >PLEASE ENTER DELIVERY LOCATION</option>
               @if(!empty($allDeliveryzone))
                     @foreach ($allDeliveryzone as $zoneid => $zonename )
                     <option value="{{ $zoneid }}" >
                        {{ $zonename }}
                    </option>
                    @endforeach
                    @endif
            </select>
            <input type="hidden" name="branchid" id="branchid">
        </form>
    </div>

    <!-- <div class="row" style="margin-top: 15px">
        <div class="col-md-4 col-xs-4" style="padding-right: 0px;padding-left: 0px">
             <input type="text" name="flatno" id="flatno" style="width: 100%; text-align: center;" placeholder="FLAT NO">
        </div>
            <div class="col-md-6 col-xs-6" style="padding-right: 5px; padding-left: 0px">
            <input type="text" name="houseno" id="houseno" style="width: 100%; text-align: center" placeholder="HOUSE NO">
        </div>
            <div class="col-md-6 col-xs-6" style="padding-left: 0px;padding-right: 0px;">
            <input type="text" name="roadno" id="roadno" style="width: 100%; text-align: center" placeholder="ROAD NO">
        </div>
    </div> -->

    <div class="row" style="height: 300px; margin-top: 30px !important;"> 
        <div id="map"></div>
    </div>

    <div class="form-group" style="margin-top: 0px !important; margin-bottom:0px !important">

    <div class="col-md-3">
        <input type="hidden" class="form-control" value="23.810102" name="lat" id="lat" >
    </div>

    <div class="col-md-3">
        <input type="hidden" class="form-control" value="90.409016" name="lng" id="lng" >
    </div>
</div>

<div class="row" style="margin-top:   30px;" >
        <div class="col-md-2 col-xs-2">  </div>
        <div class="col-md-8 col-xs-8">  
      <center  id="branchresult">
  
   
         <a href='#' style=''>
            <img id="orderblackbutton" src="{{ asset('FrontendCSSJS/img/order1.png') }}" class="img-responsive" 
            style="width: 200px"/ >
             <!-- <img id="orderblackbutton" src="img/order.png"  /> -->
        </a>
      </center>
 <center style="margin-top:   15px;margin-bottom:    15px; color: #ED7901; ">  We Are Delivering From 11 AM to 10.<span style="font-size: 16px">30</span> PM Only</center>
    </div>
      <div class="col-md-2 col-xs-2">  </div>
    </div>
</div>


  </div>
</div>

</section>
    
@endsection
@section('extra_js')
<script src="{{ asset('FrontendCSSJS/ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $('.select2').select2();
    </script>
    <script src="{{ asset('sweetalert.js') }}"></script>


     <script type="text/javascript">

    $(document).on('change','#locationid',function(){
        var locationid = $('#locationid').val();

        shoppingCartItems = [];         
        sessionStorage.removeItem('shopping­cart­items');
        sessionStorage.removeItem('badgequantity');


        var url = '{{ url('bkashmicrosite/locationwisebranch') }}';
        $.ajax({
            url: url,
            method:'get',
            data:{
                locationid : locationid, 
            },
            dataType: "json",
            success:function(data){
                $("#branchresult").empty();
                console.log(data);

                if(data == null)
                {
                 var branch = ""; 
                 branch += "<center>"
                 branch += "<a href='#' style='margin-left: auto; margin-right:auto; max-width:160px'>"
                 branch += "<img src='{{ asset('FrontendCSSJS/img/order1.png') }}' style='margin-top:15px;' />"
                 branch += "</a>"
                 branch += "</center>";

                 $("#branchresult").append(branch);
                 swal({
                    title: "Currently food delivery is off in that area.",
                    icon: "info",
                    button: "OK!",
                });
             }
             else
             {
                var status;
                var branchOCtime;
                var timing;
                var opencloseTime;
                var openingWithAMPM;
                var closingWithAMPM;


                var currentdatetime = "{{ $currentdatetime }}";
                var tempdate = currentdatetime.split(' ');
                var todaytime = tempdate[1];
                var AMPM = tempdate[2];
                var todaytimeWithAMPM = todaytime + ' ' + AMPM;




                var todayfinaltime = convertTime12to24(todaytimeWithAMPM);
                var today = "{{ $today }}";
                console.log(today);

                switch(today)
                {
                    case 'Sunday':
                    branchOCtime = data.sunday;
                    opencloseTime = branchOCtime.split('-');
                    openingWithAMPM = opencloseTime[0];
                    closingWithAMPM = opencloseTime[1];
                    status = data.sunday_status;

                    var [space, time1, modifier1] = closingWithAMPM.split(' ');
                    var finalclosingtime = time1 + ' ' + modifier1;

                    mainFunction(data,branchOCtime,todayfinaltime,openingWithAMPM,finalclosingtime,status);

                    break;
                    case 'Monday':
                    branchOCtime = data.monday;
                    opencloseTime = branchOCtime.split('-');
                    openingWithAMPM = opencloseTime[0];
                    closingWithAMPM = opencloseTime[1];
                    status = data.monday_status;

                    var [space, time1, modifier1] = closingWithAMPM.split(' ');
                    var finalclosingtime = time1 + ' ' + modifier1;

                    mainFunction(data,branchOCtime,todayfinaltime,openingWithAMPM,finalclosingtime,status);

                    break;
                    case 'Tuesday':
                    branchOCtime = data.tuesday;
                    opencloseTime = branchOCtime.split('-');
                    openingWithAMPM = opencloseTime[0];
                    closingWithAMPM = opencloseTime[1];
                    status = data.tuesday_status;

                    var [space, time1, modifier1] = closingWithAMPM.split(' ');
                    var finalclosingtime = time1 + ' ' + modifier1;

                    mainFunction(data,branchOCtime,todayfinaltime,openingWithAMPM,finalclosingtime,status);

                    break;
                    case 'Wednesday':
                    branchOCtime = data.wednesday;
                    opencloseTime = branchOCtime.split('-');
                    openingWithAMPM = opencloseTime[0];
                    closingWithAMPM = opencloseTime[1];
                    status = data.wednesday_status;

                    var [space, time1, modifier1] = closingWithAMPM.split(' ');
                    var finalclosingtime = time1 + ' ' + modifier1;

                    mainFunction(data,branchOCtime,todayfinaltime,openingWithAMPM,finalclosingtime,status);

                    break;
                    case 'Thursday':
                    branchOCtime = data.thursday;
                    opencloseTime = branchOCtime.split('-');
                    openingWithAMPM = opencloseTime[0];
                    closingWithAMPM = opencloseTime[1];
                    status = data.thursday_status;

                    var [space, time1, modifier1] = closingWithAMPM.split(' ');
                    var finalclosingtime = time1 + ' ' + modifier1;

                    mainFunction(data,branchOCtime,todayfinaltime,openingWithAMPM,finalclosingtime,status);

                    break;
                    case 'Friday':
                    branchOCtime = data.friday;
                    opencloseTime = branchOCtime.split('-');
                    openingWithAMPM = opencloseTime[0];
                    closingWithAMPM = opencloseTime[1];
                    status = data.friday_status;

                    var [space, time1, modifier1] = closingWithAMPM.split(' ');
                    var finalclosingtime = time1 + ' ' + modifier1;

                    mainFunction(data,branchOCtime,todayfinaltime,openingWithAMPM,finalclosingtime,status);

                    break;
                    case 'Saturday':
                    branchOCtime = data.saturday;
                    opencloseTime = branchOCtime.split('-');
                    openingWithAMPM = opencloseTime[0];
                    closingWithAMPM = opencloseTime[1];
                    status = data.saturday_status;

                    var [space, time1, modifier1] = closingWithAMPM.split(' ');
                    var finalclosingtime = time1 + ' ' + modifier1;

                    mainFunction(data,branchOCtime,todayfinaltime,openingWithAMPM,finalclosingtime,status);

                    break;
                }
            }
        },
        error:function(error){
            console.log(error);
            swal({
                title: "Something went wrong!",
                icon: "error",
                button: "Cancel !",
                className: "myClass",

            });
        }
    })
})
</script>

<script type="text/javascript">
    function blackOrderButton(data,status,timing)
    {
        var myLatlng = new google.maps.LatLng(parseFloat(data.latitude),parseFloat(data.longitude));
        var mapOptions = {
            zoom: 14,
            center: myLatlng
        }
        var map = new google.maps.Map(document.getElementById("map"), mapOptions);

        var infowindow = new google.maps.InfoWindow({
            content: data.branchname + ' ' + status + '<br>' + timing
        });

        
        var image = "assets/custom/img/bkmaplogo_small.png";


        var marker = new google.maps.Marker({
            position: myLatlng,
            icon : image

        });

        infowindow.open(map, marker);

        marker.setMap(map);
        


        swal({
            title: "The restaurant is closed right now.",
            icon: "info",
            button: "OK!",
        });

        var branch = "";
        branch += "<center>"
        branch += "<a href='#' style='margin-left: auto; margin-right:auto; max-width:160px'>"
        branch += "<img src='{{ asset('FrontendCSSJS/img/order1.png') }}' />"
        branch += "</a>"
        branch += "</center>";

        $("#branchresult").append(branch);
    }

    function orangeOrderButton(data,status,timing)
    {
        $('#branchid').val(data.branchid);

        var myLatlng = new google.maps.LatLng(parseFloat(data.latitude),parseFloat(data.longitude));
        var mapOptions = {
            zoom: 14,
            center: myLatlng
        }
        var map = new google.maps.Map(document.getElementById("map"), mapOptions);

        var infowindow = new google.maps.InfoWindow({
            content: data.branchname + ' ' + status + '<br>' + timing
        });

        
        var image = "assets/custom/img/bkmaplogo_small.png";


        var marker = new google.maps.Marker({
            position: myLatlng,
            icon : image
                // title:"Hello World!"
            });

        infowindow.open(map, marker);
            // To add the marker to the map, call setMap();
            marker.setMap(map);

            var branch = "";
            branch += "<center>"
            branch += "<a href='#' style='margin-left: auto; margin-right:auto; max-width:160px;'>"
            branch += "<img id='orderimageclick' src='{{ asset('FrontendCSSJS/img/orderorange1.png') }}'/>"
            branch += "</a>"
            branch += "</center>";

            $("#branchresult").append(branch);
        }
    </script>


    <script type="text/javascript">
        function mainFunction(data,branchOCtime,todayfinaltime,openingWithAMPM,finalclosingtime,status)
        {
            if(todayfinaltime>convertTime12to24(openingWithAMPM) && todayfinaltime<convertTime12to24(finalclosingtime))
            {
                if(status == 1)
                {
                    status = ' <b style="color:green;">(open)</b>';
                    orangeOrderButton(data,status,branchOCtime);
                }
                else
                {
                    status = ' <b style="color:red;">(closed)</b>';
                    blackOrderButton(data,status,branchOCtime);
                }
            }
            else
            {
                status = ' <b style="color:red;">(closed)</b>';
                blackOrderButton(data,status,branchOCtime);
            }

            console.log('openingg time :'+convertTime12to24(openingWithAMPM));
            console.log('closingg time :'+convertTime12to24(finalclosingtime));
            console.log('Todayy time :'+todayfinaltime);
        }
    </script>

    <script type="text/javascript">
        const convertTime12to24 = (time12h) => {
          const [time, modifier] = time12h.split(' ');

          let [hours, minutes] = time.split(':');

          if (hours === '12') {
            hours = '00';
        }

        if (modifier === 'PM') {
            hours = parseInt(hours,10) + 12;
        }

        return `${hours}:${minutes}`;
    }
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click','#orderimageclick',function(){
          $('#branchwisemenuform').submit();
            // var roadno = $('#roadno').val();
            // var houseno = $('#houseno').val();
            // var flatno = $('#flatno').val();

            // if(flatno == '')
            // {
            //     swal({
            //         title: "Enter your Flat No!",
            //         icon: "info",
            //         button: "OK!",
            //     });
                
            // }
            // if(houseno == '')
            // {
            //     swal({
            //         title: "Enter your House No!",
            //         icon: "info",
            //         button: "OK!",
            //     });
            // }
            // else if(roadno == '')
            // {
            //     swal({
            //         title: "Enter your Road/Block No!",
            //         icon: "info",
            //         button: "OK!",
            //     });
            // }
            // else
            // {
            //     var shippingaddress = [];
            //     var object = {             
            //         roadno : roadno,             
            //         houseno : houseno  
            //     }; 
            //     shippingaddress.push(object);
            //     sessionStorage.setItem('shippingaddress', JSON.stringify(shippingaddress));
            //     var obj = JSON.parse(sessionStorage.getItem('shippingaddress'));
            //     console.log(obj);

            //     $('#branchwisemenuform').submit();
            // }
            
        })
    })
</script>

@endsection