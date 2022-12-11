<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<!--<title>Burger King Bangladesh</title>-->
<title>BURGER KING&#174; BANGLADESH</title>

<link rel="stylesheet" 
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" 
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" 
      crossorigin="anonymous">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link href="{{ asset('WebsiteCSSJS/css/css.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('WebsiteCSSJS/css/styles26.css') }}" rel="stylesheet" type="text/css"/> 
<link href="{{ asset('WebsiteCSSJS/css/bigSlider.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('WebsiteCSSJS/css/map.css') }}" rel="stylesheet" type="text/css"/> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.5/slick.min.css"/>
<link rel="shortcut icon" type="image/png" href="img/fav-icon.ico"/>

<style>
.slick-dots{
    display: none !important;
  }
</style>

<style>

@media only screen and (max-width: 768px) {
.next1{
    display: none;
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

/* Fading animation */
.fade {
  /* -webkit-animation-name: fade;
  -webkit-animation-duration: 1.5s;
  animation-name: fade;
  animation-duration: 1.5s; */
}

/* @-webkit-keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
} */

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .text {font-size: 11px}
}
</style>
</head>

<body style="font-family: 'BlockBeCnPro', Arial, Helvetica, sans-serif;">


  @include('Website.layouts.header')

 @yield('extra_css')


  <!--  <div class="slideshow-container">
  
  <div class="mySlides fade">
   
    <img src="img/banner4.jpg" style="width:100%; height: 90%">
    <span class="dot"></span>
  </div>
  
  <div class="mySlides fade">
   
    <img src="img/banner3.jpg" style="width:100%; height: 90%">
    <span class="dot"></span>
  </div>
  
  <div class="mySlides fade">
  
    <img src="img/banner1.jpg" style="width:100% ;height: 90%">
    <span class="dot"></span>
  </div>
  
  </div>
  <br> -->

<!-- <div style="text-align:center">
  <span class="dot"></span> 
  <span class="dot"></span> 
  <span class="dot"></span> 
</div> -->

@yield('content')


@include('Website.layouts.footer')

 

 <script type="text/javascript" src="{{ asset('WebsiteCSSJS/js/main123.js') }}"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.5/slick.min.js"> </script>
<script type="text/javascript">
$(".responsive").slick({
  dots: true,
  autoplay: true,
  prevArrow: $(".prev"),
  nextArrow: $(".next"),
  infinite: true,
  speed: 300,
  slidesToShow: 4,
  slidesToScroll: 4,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});
</script>


<script type="text/javascript" src="{{ asset('WebsiteCSSJS/misc/jquery-extend.js') }}"></script>
 
<script type="text/javascript" src="{{ asset('WebsiteCSSJS/misc/jquery-once.js') }}"></script>

<script type="text/javascript" src="{{ asset('WebsiteCSSJS/misc/drupal.js') }}"></script>

  
</script>

 <script type="text/javascript" src="{{ asset('WebsiteCSSJS/js/plugins.js') }}"></script>

<script type="text/javascript" src="{{ asset('WebsiteCSSJS/js/main1.js') }}"></script>
<script type="text/javascript">
//--><![CDATA[//><!--
jQuery.extend(Drupal.settings,
 {/*"basePath":"\/",
   "pathPrefix":"",
   "ajaxPageState":
      {"theme":"bk_theme",
       "theme_token":"XmHwJeehE8_QBU9k3aSyNsNh8ZYS2RZ02J_UhSakHy8",
        "js":{"sites\/all\/modules\/jquery_update\/replace\/jquery\/1.10\/jquery.min.js":1,"misc\/jquery-extend-3.4.0.js":1,"misc\/jquery.once.js":1,"misc\/drupal.js":1,"sites\/all\/modules\/jquery_update\/replace\/ui\/external\/jquery.cookie.js":1,"sites\/all\/modules\/contentanalysis\/contentanalysis.js":1,"sites\/all\/modules\/contentoptimizer\/contentoptimizer.js":1,"sites\/all\/modules\/authcache\/authcache.js":1,"sites\/all\/modules\/google_analytics\/googleanalytics.js":1,"0":1,"sites\/all\/themes\/custom\/bk_theme\/bower_components\/matchHeight\/jquery.matchHeight-min.js":1,"sites\/all\/themes\/custom\/bk_theme\/js\/vendor\/modernizr-min.js":1,"sites\/all\/themes\/custom\/bk_theme\/js\/plugins\/plugins.js":1,"sites\/all\/themes\/custom\/bk_theme\/js\/plugins\/homePlugins.js":1,"sites\/all\/themes\/custom\/bk_theme\/js\/main.js":1,"sites\/all\/modules\/bk_locations\/js\/bk_locations.js":1,"sites\/all\/modules\/bk_theme_override\/IN\/js\/bk_locations.js":1,"sites\/all\/modules\/bk_theme_override\/IN\/js\/contact-us-form.js":1,"sites\/all\/modules\/bk_theme_override\/IN\/js\/main.js":1},"css":{"modules\/system\/system.base.css":1,"modules\/system\/system.menus.css":1,"modules\/system\/system.messages.css":1,"modules\/system\/system.theme.css":1,"sites\/all\/modules\/bk_country_flag\/css\/bk_country_flag.css":1,"sites\/all\/modules\/bk_country_flag\/libraries\/flag-icon-css\/css\/flag-icon.min.css":1,"modules\/comment\/comment.css":1,"sites\/all\/modules\/date\/date_api\/date.css":1,"modules\/field\/theme\/field.css":1,"modules\/node\/node.css":1,"modules\/search\/search.css":1,"modules\/user\/user.css":1,"sites\/all\/modules\/views\/css\/views.css":1,"sites\/all\/modules\/ckeditor\/css\/ckeditor.css":1,"sites\/all\/modules\/ctools\/css\/ctools.css":1,"sites\/all\/modules\/panels\/css\/panels.css":1,"sites\/all\/themes\/custom\/bk_theme\/styles\/system.menus.css":1,"sites\/all\/themes\/custom\/bk_theme\/css\/styles.css":1,"sites\/all\/themes\/custom\/bk_theme\/css\/jquery.smartbanner.css":1,"sites\/all\/themes\/custom\/bk_theme\/bower_components\/fontawesome\/css\/font-awesome.min.css":1,"sites\/all\/themes\/custom\/bk_theme\/css\/override.css":1,"sites\/all\/modules\/bk_theme_override\/IN\/css\/IN.css":1*/})
//--><!]]>
</script>

<script
src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&callback=initMap" async defer>
</script>

    <script type="text/javascript" src="{{ asset('assets/custom/js/microsite_map.js') }}" ></script>

@yield('extra_js')

 <script>
var slideIndex = 0;
showSlides();

function showSlides() {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}    
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
  setTimeout(showSlides, 3000); // Change image every 2 seconds
}
</script>
</body>
</html>
