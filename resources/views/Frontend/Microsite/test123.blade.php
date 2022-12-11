@extends('Frontend.layouts.manage')
@section('content')
<style type="text/css">
    body{
        border: 2px solid #ED7700;
        border-right: 3px solid #ED7700;
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

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<div style="background-color: #ffefdb">
    <div class="main-slider">

        <!-- Example row of columns -->
        <div style="min-height: 50px; overflow:hidden;"> 
          <!-- Jssor Slider Begin --> 
          <!-- To move inline styles to css file/block, please specify a class name for each element. --> 

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

            <!-- <div>
                <a href="#">  
                    <img u="image" src2="{{ asset('FrontendCSSJS/img/main-slider/offer1.png') }}" alt="Whopper Burger" width="100%" />
                </a>
            </div> -->
            
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

        <!--#region Bullet Navigator Skin Begin --> 
        <!-- Help: http://www.jssor.com/development/slider-with-bullet-navigator-jquery.html -->
        <style>
            /* jssor slider bullet navigator skin 21 css */
                /*
                .jssorb21 div           (normal)
                .jssorb21 div:hover     (normal mouseover)
                .jssorb21 .av           (active)
                .jssorb21 .av:hover     (active mouseover)
                .jssorb21 .dn           (mousedown)
                */
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
            <!-- bullet navigator container -->
            <div u="navigator" class="jssorb21" style="bottom: 0px; right: 6px;"> 
              <!-- bullet navigator item prototype -->
              <div u="prototype"></div>
          </div>
          <!--#endregion Bullet Navigator Skin End --> 

          <!--#region Arrow Navigator Skin Begin --> 
          <!-- Help: http://www.jssor.com/development/slider-with-arrow-navigator-jquery.html -->
          <style>
            /* jssor slider arrow navigator skin 21 css */
                /*
                .jssora21l                  (normal)
                .jssora21r                  (normal)
                .jssora21l:hover            (normal mouseover)
                .jssora21r:hover            (normal mouseover)
                .jssora21l.jssora21ldn      (mousedown)
                .jssora21r.jssora21rdn      (mousedown)
                */
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
            <!-- Arrow Left --> 
            <span u="arrowleft" class="jssora21l" style="top: 123px; left: 8px;"> </span> 
            <!-- Arrow Right --> 
            <span u="arrowright" class="jssora21r" style="top: 123px; right: 8px;"> </span> 
            <!--#endregion Arrow Navigator Skin End -->
            <!-- <a style="display: none" href="http://www.jssor.com">Bootstrap Slider</a> -->
        </div>
        <!-- Jssor Slider End --> 
    </div>
</div>
<br>

<div style="text-align: center"><span><h2 class="text-center" style="font-size: 15px;margin-top: 0px;margin-bottom: 13px">YOUR LOCATION</h2></span></div>

<form class="col-md-12 col-xs-12"  method="post" id="branchwisemenuform" action="{{ url('bkashmicrosite/branchwisemenu') }}" >
   {{ csrf_field() }}
   <div class="container">
    <div class="row">
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
</div>

<input type="hidden" name="branchid" id="branchid">

<div class="row" style="margin-top: 15px">
    <div class="col-md-4 col-xs-4" style="padding-right: 0px;padding-left: 20px">
       <input type="text" name="roadno" id="roadno" style="width: 100%; text-align: center;" placeholder="ROAD NO">
   </div>
   <div class="col-md-4 col-xs-4" style="padding-right: 5px; padding-left: 5px">
       <input type="text" name="houseno" id="houseno" style="width: 100%; text-align: center" placeholder="HOUSE NO">
   </div>
   <div class="col-md-4 col-xs-4" style="padding-left: 0px;padding-right: 20px;">
       <input type="text" name="flatno" id="flatno" style="width: 100%; text-align: center" placeholder="FLAT NO">
   </div>
</div>
</div>
</form>

<div class="container">

    <div style="text-align: center"><span><h2 class="text-center" style="font-size: 15px;margin-top: 0px;margin-bottom: 13px"></h2></span>

        <div class="form-group" style="margin-top: 0px !important; margin-bottom:0px !important">
            <div class="col-md-9" style="padding-left: 0px !important;padding-right: 0px;margin-top:90px;">
                <div id="map" class="gmaps" style="height: 300px;padding-left: 0px !important">
                </div>
            </div>
        </div>


        <div class="form-group" style="margin-top: 0px !important; margin-bottom:0px !important">

            <div class="col-md-3">
                <input type="hidden" class="form-control" name="lat" id="lat" >
            </div>

            <div class="col-md-3">
                <input type="hidden" class="form-control" name="lng" id="lng" >
            </div>
        </div>




        <div style="" id="branchresult">
          <center style="margin-top:0px;padding-top:15px">
             <a href='#' style=''>
                <img id="orderblackbutton" src="{{ asset('FrontendCSSJS/img/order.png') }}" />
            </a>
        </center>
    </div>

</div>

<div class="col-md-12 col-sm-12 col-xs-12 cartBoxRight" style=" bottom:0;width:100%; z-index:1;background-color:#ffefdb">


    <a href="#" style="margin-left: auto; margin-right:auto; ">
       <h2 style="padding-top: 15px;padding-bottom:10px;color: #EE7700;font-size: 15px;text-align: center;margin-top: 0px;padding-left: 0px;">We are delivering 11 am to 9:45 pm only.</h2>
   </a>
</div>
</div>

<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}"></script> -->

<script
src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&libraries=places&region=BD&callback=initMap" async defer>
</script>


<!-- <script type="text/javascript">
    var xmlHttp;
function srvTime(){
    try {
      
        xmlHttp = new XMLHttpRequest();
    }
    catch (err1) {
        
        try {
            xmlHttp = new ActiveXObject('Msxml2.XMLHTTP');
        }
        catch (err2) {
            try {
                xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
            }
            catch (eerr3) {
               
                alert("AJAX not supported");
            }
        }
    }
    xmlHttp.open('HEAD',window.location.href.toString(),false);
    xmlHttp.setRequestHeader("Content-Type", "text/html");
    xmlHttp.send('');
    return xmlHttp.getResponseHeader("Date");
}

var st = srvTime();
var date = new Date(st);
console.log(date);
</script> -->



<script type="text/javascript" src="{{ asset('assets/custom/js/microsite_map.js') }}" ></script>

<script src="{{ asset('sweetalert.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('.addresswiselatlng').on('click',function(){
            $.ajaxSetup({
              headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
          });

            shoppingCartItems = [];         
            sessionStorage.removeItem('shopping­cart­items');
            sessionStorage.removeItem('badgequantity');
            sessionStorage.removeItem('shippingaddress');


            var lat = $('#lat').val();
            var lng = $('#lng').val();
            var address = $('#address').val();



//             function getServerTime() {
//   return $.ajax({async: false}).getResponseHeader( 'Date' );
// }
// console.log('Server Time: ', getServerTime());
// console.log('Locale Time: ', new Date(getServerTime()));


/* Date Time structure change */

// var createTime = '2020-07-01T10:51:43:553 GMT+0000';

// var withoutT = createTime.replace("T", " ");
// var separateDateTime =  withoutT.split(' ');

// var onlyTime =  separateDateTime[1].split(':');
// console.log(separateDateTime[0] +' '+onlyTime[0]+':'+ onlyTime[1] + ':' + onlyTime[2]);






            var dt = new Date();//current Date that gives us current Time also

            var startTime = '11:00:00';
            var endTime = '21:45:00';

            var s =  startTime.split(':');
            var dt1 = new Date(dt.getFullYear(), dt.getMonth(), dt.getDate(),
             parseInt(s[0]), parseInt(s[1]), parseInt(s[2]));

            var e =  endTime.split(':');
            var dt2 = new Date(dt.getFullYear(), dt.getMonth(),
             dt.getDate(),parseInt(e[0]), parseInt(e[1]), parseInt(e[2]));





            if(address == '')
            {

                swal({
                    title: "Please put your delivery location and press enter!",
                    icon: "info",
                    button: "OK!",
                });
            }

           //  else if(dt < dt1 || dt > dt2)
           //  {
           //     swal({
           //      title: "We are delivering from 11 AM to 9:45 PM only !",
           //      icon: "info",
           //      button: "OK!",
           //  });
           // }


           else
           {
            var branch = "";

            var url = '{{ url('bkashmicrosite/latlngwisebranch') }}';
            $.ajax({
                url: url,
                method:'get',
                data:{
                    lat: lat, 
                    lng : lng},
                    dataType: "json",
                    
                    success:function(data){
                        console.log(data);
                        $("#branchresult").empty();
                        if(data == '')
                        {

                            $('#address').val('');
                            swal({
                                title: "Your provided location is not available in delivery area, Please change to place order.",
                                icon: "info",
                                button: "OK!",
                            });
                            branch += "<center>"
                            branch += "<a href='#' style='margin-left: auto; margin-right:auto; max-width:160px'>"
                            branch += "<img src='{{ asset('FrontendCSSJS/img/order.png') }}' />"
                            branch += "</a>"
                            branch += "</center>";

                            $("#branchresult").append(branch);
                        }
                        else
                        {

            // var BaseURL = 'bkashmicrosite/branchwisemenu';
            // var Path = BaseURL.concat(data[0].branchid);
            // var url = '{{ url(':id') }}';
            // url = url.replace(':id',Path);
            // console.log(url);

            $('#branchid').val(data[0].branchid);

            branch += "<center>"
            branch += "<a href='#' style='margin-left: auto; margin-right:auto; max-width:160px;'>"
            branch += "<img id='orderimageclick' src='{{ asset('FrontendCSSJS/img/orderorange.png') }}' style='margin-top:15px;' />"
            branch += "</a>"
            branch += "</center>";

            $("#branchresult").append(branch);
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
        }

    })
})
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click','#orderimageclick',function(){
            var roadno = $('#roadno').val();
            var houseno = $('#houseno').val();
            var flatno = $('#flatno').val();

            if(roadno == '')
            {
                swal({
                    title: "Enter your Road No!",
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
            else if(flatno == '')
            {
                swal({
                    title: "Enter your Flat No!",
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



<script type="text/javascript">
  $('.addresswiselatlng').on('click', function() {
      $('html, body').animate({
        scrollTop: 2000
    }, 'slow');
  })
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#orderblackbutton').on('click',function(){
            var address = $('#address').val();
            if(address == '')
            {
                swal({
                    title: "Please put your delivery location and press enter!",
                    icon: "info",
                    button: "OK!",
                });
            }
        })
    })
</script>

<!-- New System Javascript for Location selection -->

<script type="text/javascript">
    $(document).ready(function(){
        $('#locationid').on('change',function(){
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
                       branch += "<center>"
                       branch += "<a href='#' style='margin-left: auto; margin-right:auto; max-width:160px'>"
                       branch += "<img src='{{ asset('FrontendCSSJS/img/order.png') }}' style='margin-top:15px;' />"
                       branch += "</a>"
                       branch += "</center>";

                       $("#branchresult").append(branch);
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

        var marker = new google.maps.Marker({
            position: myLatlng,

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

        var marker = new google.maps.Marker({
            position: myLatlng,
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


@endsection