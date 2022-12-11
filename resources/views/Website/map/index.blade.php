@extends('Website.layouts.manage')
@section('content')


<section>
     <!-- <div class="pac-card" id="pac-card">
      <div>
        <div id="title" style="font-family: 'fs_sammyregular', Arial, Helvetica, sans-serif">
          Search a restaurant
        </div>
        <div id="type-selector" class="pac-controls">

        </div>
        <div id="strict-bounds-selector" class="pac-controls">
        
        </div>
      </div>
      <div id="pac-container">
        <input id="pac-input" type="text" class="swatch"
            placeholder="Enter a location" >
      </div>
    </div> -->
    <div id="map"></div>
    <div id="infowindow-content">
      <img src="" id="place-icon">
      <span id="place-name"  class="title"></span><br>
      <span id="place-address"></span>
    </div>

</section>

<section class="container-fluid bkCallouts bkCallout-latus" style=""></section>

<div class="form-group" style="margin-top: 0px !important; margin-bottom:0px !important">

    <div class="col-md-3">
        <input type="hidden" class="form-control" value="23.810102" name="lat" id="lat" >
    </div>

    <div class="col-md-3">
        <input type="hidden" class="form-control" value="90.409016" name="lng" id="lng" >
    </div>
</div>



@endsection