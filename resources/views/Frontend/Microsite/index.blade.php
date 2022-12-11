@extends('Frontend.layouts.manage')
@section('content')
<style type="text/css">
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
select {
  color: #3D3D3D !important;
}

select:focus {
  color: #3D3D3D !important;
}
option {
  color: #3D3D3D !important;
}
option:first-of-type {
  color: #3D3D3D !important;
}
.select2-container--default .select2-selection--single .select2-selection__rendered{
 color: #3D3D3D !important; 
 opacity: 0.2;  
}
</style>
<body style=" background: url({{ asset('FrontendCSSJS/img/bg.png') }}) ; background-size: cover !important; background-repeat: no-repeat !important;font-family: 'BlockBerth'; border-bottom:  none !important;">
    <div style="">
        <div class="main-slider" style="border-left: 3px solid #EE7700; border-right: 3px solid #EE7700">


            <div style="min-height: 50px; overflow:hidden;"> 

              <div id="slider1_container" style="display: none; position: relative;
              width: 1800px; height: 760px; overflow: hidden;"> 
              <!-- Loading Screen -->
              <div u="loading" style="position: absolute; top: 0px; left: 0px;">
                  <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block;
                  top: 0px; left: 0px; width: 100%; height: 100%;"> </div>
                  <div style="position: absolute; display: block; background: url(FrontendCSSJS/img/loading.html) no-repeat center center;
                  top: 0px; left: 0px; width: 100%; height: 100%;"> </div>
              </div>

              <!-- Slides Container -->
              <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 1800px; height: 760px; overflow: hidden;">

                <div>
                    <a href="#">  
                        <img u="image" src2="{{ asset('FrontendCSSJS/img/main-slider/1.png') }}" alt="Whopper Burger" width="100%" />
                    </a>
                </div>

                <div>
                    <a href="#">  
                        <img u="image" src2="{{ asset('FrontendCSSJS/img/main-slider/3.png') }}" alt="King's Treat meal for two persons" width="100%" />
                    </a>
                </div>

                <div>
                    <a href="#">  
                        <img u="image" src2="{{ asset('imageFolder/Banner-BK-1800.jpg') }}" alt="King's Treat meal for two persons" width="100%" />
                    </a>
                </div>


            </div>


            <style>

                .jssorb21 {
                    position: absolute;
                }
                .jssorb21 div, .jssorb21 div:hover, .jssorb21 .av {
                    position: absolute;
                    /* size of bullet elment */
                    width: 19px;
                    height: 19px;
                    text-align: center;
                    line-height: 19px;
                    color: white;
                    font-size: 12px;
                    background: url(FrontendCSSJS/img/b21bk.png) no-repeat;
                    overflow: hidden;
                    cursor: pointer;
                }
                .jssorb21 div { background-position: -5px -5px; }
                .jssorb21 div:hover, .jssorb21 .av:hover { background-position: -35px -5px; }
                .jssorb21 .av { background-position: -65px -5px; }
                .jssorb21 .dn, .jssorb21 .dn:hover { background-position: -95px -5px; }
            </style>

            <div u="navigator" class="jssorb21" style="bottom: 0px; right: 6px;"> 

              <div u="prototype"></div>
          </div>

          <style>

            .jssora21l, .jssora21r {
                display: block;
                position: absolute;
                /* size of arrow element */
                width: 55px;
                height: 55px;
                cursor: pointer;
                background: url(FrontendCSSJS/img/a11.png) center center no-repeat;
                overflow: hidden;
            }
            .jssora21l { background-position: -3px -33px; }
            .jssora21r { background-position: -63px -33px; }
            .jssora21l:hover { background-position: -123px -33px; }
            .jssora21r:hover { background-position: -183px -33px; }
            .jssora21l.jssora21ldn { background-position: -243px -33px; }
            .jssora21r.jssora21rdn { background-position: -303px -33px; }
        </style>

        <span u="arrowleft" class="jssora21l" style="top: 123px; left: 8px;"> </span> 

        <span u="arrowright" class="jssora21r" style="top: 123px; right: 8px;"> </span> 

    </div>

</div>
</div>
<br>


<div class="container" style="padding-right: 0px !important; padding-left: 0px !important; border-right: 3px solid #ee7700; margin-top:-25px;">

    <div>
      <span>
        <h2 class="text-center" 
        style="font-size: 15px;margin-top: 0px;margin-bottom: 13px; padding-top: 25px;">
        YOUR LOCATION
    </h2>
</span>

<div class="form-group" style="margin-top: 0px !important; margin-bottom:0px !important; ">
    <div class="" >

        <div class="container">
            <div class="row">
                <form class="col-md-12 col-xs-12" method="post" id="branchwisemenuform" action="{{ url('bkashmicrosite/branchwisemenu') }}">
                   {{ csrf_field() }}
                   <!--  <label>Select</label -->
                    <select class="form-control select2" id="locationid" name="locationid">
                     <option  value="" disabled selected style="color: #b6b6b6">PLEASE SELECT YOUR LOCATION FOR DELIVERY</option>
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
        <div class="row" style="margin-top: 15px">

            <div class="col-md-4 col-xs-4" style="padding-right: 0px;padding-left: 20px"> 
               <input type="text" name="flatno" id="flatno" style="width: 100%; text-align: center;border: 0px solid #fff;color: #b6b6b6" placeholder="FLAT" >
           </div>
           <div class="col-md-4 col-xs-4" style="padding-right: 5px; padding-left: 5px"> 
               <input type="text" name="houseno" id="houseno" style="width: 100%; text-align: center; border: none;color: #b6b6b6" placeholder="HOUSE">
           </div>
           <div class="col-md-4 col-xs-4" style="padding-left: 0px;padding-right: 20px;"> 
               <input type="text" name="roadno" id="roadno" style="width: 100%; text-align: center;border: none;color: #b6b6b6" placeholder="ROAD/BLOCK">
           </div>
       </div>
   </div>

</div>
</div>


</div>
<div class="form-group" style="margin-top: 0px !important; margin-bottom:0px !important;padding-left: 15px; padding-right: 15px; ">
    <div class="col-md-9" style="padding-left: 0px !important;padding-right: 0px;margin-top:20px;">
        <div id="map" class="gmaps" style="height: 300px;padding-left: 0px !important">
        </div>
    </div>
</div>


<div class="form-group" style="margin-top: 0px !important; margin-bottom:0px !important">

    <div class="col-md-3">
        <input type="hidden" class="form-control" value="23.810102" name="lat" id="lat" >
    </div>

    <div class="col-md-3">
        <input type="hidden" class="form-control" value="90.409016" name="lng" id="lng" >
    </div>
</div>



<div class="container-fluid" style="border-left: 3px solid #ee7700; "> 
    <div style="" id="branchresult" class="row" >
      <center style="margin-top:0px;padding-top:15px">
         <a href='#' style=''>
            <img id="orderblackbutton" src="{{ asset('FrontendCSSJS/img/order.png') }}" />
        </a>
    </center>
</div>


<div class="col-md-12 col-sm-12 col-xs-12 cartBoxRight" style=" bottom:0;width:100%; z-index:1;">




    <a href="#" style="margin-left: auto; margin-right:auto; ">
       <h2 style="padding-top: 15px;padding-bottom:10px;color: #EE7700;font-size: 15px;text-align: center;margin-top: 0px;padding-left: 0px;">We are delivering 11 am to 9:45 pm only.<br></h2>
   </a>


</div>
</div>

</div>

</div>


<script
src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&callback=initMap" async defer>
</script>




<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->

<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" /> -->

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" /> -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>




    <script>
        $('.select2').select2();
    </script>


    <script type="text/javascript" src="{{ asset('assets/custom/js/microsite_map.js') }}" ></script>

    <script src="{{ asset('sweetalert.js') }}"></script>



    <script type="text/javascript">
      $('.addresswiselatlng').on('click', function() {
          $('html, body').animate({
            scrollTop: 2000
        }, 'slow');
      })
  </script>

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
                 branch += "<img src='{{ asset('FrontendCSSJS/img/order.png') }}' style='margin-top:15px;' />"
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
        branch += "<img src='{{ asset('FrontendCSSJS/img/order.png') }}' style='margin-top:15px;' />"
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
            branch += "<img id='orderimageclick' src='{{ asset('FrontendCSSJS/img/orderorange.png') }}' style='margin-top:15px;' />"
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
            var roadno = $('#roadno').val();
            var houseno = $('#houseno').val();
            var flatno = $('#flatno').val();

            if(flatno == '')
            {
                swal({
                    title: "Enter your Flat No!",
                    icon: "info",
                    button: "OK!",
                });
                
            }
            else if(houseno == '')
            {
                swal({
                    title: "Enter your House No!",
                    icon: "info",
                    button: "OK!",
                });
            }
            else if(roadno == '')
            {
                swal({
                    title: "Enter your Road/Block No!",
                    icon: "info",
                    button: "OK!",
                });
            }
            else
            {
                var shippingaddress = [];
                var object = {             
                    roadno : roadno,             
                    houseno : houseno,             
                    flatno : flatno    
                }; 
                shippingaddress.push(object);
                sessionStorage.setItem('shippingaddress', JSON.stringify(shippingaddress));
                var obj = JSON.parse(sessionStorage.getItem('shippingaddress'));
                console.log(obj);

                $('#branchwisemenuform').submit();
            }
            
        })
    })
</script>


</body>

@endsection