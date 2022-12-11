//Set up some of our variables.
var map; //Will contain map object.
var marker = false; ////Has the user plotted their location marker? 
        
//Function called to initialize / create the map.
//This is called when the page has loaded.
function initMap() {
 	var lat = document.getElementById('lat').value;
 	var lng = document.getElementById('lng').value;
 	var zoomValue = 15 ;

 	if (lat == 0 && lng == 0) { zoomValue = 7 ; }
 	// if (lat == 0) { lat = 23.79010930290887; }
 	// if (lng == 0) { lng = 90.4089886416358; }

    //The center location of our map.
    var centerOfMap = new google.maps.LatLng(lat, lng);

    //Map options.
    var options = {
      center: centerOfMap, //Set center.
      zoom: zoomValue //The zoom value.
    };
 
    //Create the map object.
    map = new google.maps.Map(document.getElementById('map'), options);
    var newlatlng = {lat: parseFloat(lat), lng: parseFloat(lng) };
    console.log(newlatlng);
 	setMarker(newlatlng);
    //Listen for any clicks on the map.
    google.maps.event.addListener(map, 'click', function(event) {                
        //Get the location that the user clicked.
        var clickedLocation = event.latLng;
        // Set the Marker
        setMarker(clickedLocation);
        
    });
}
      
function setMarker(currentlatLng) {
	//If the marker hasn't been added.
    if(marker === false){
        //Create the marker.
        marker = new google.maps.Marker({
            position: currentlatLng,
            map: map,
            draggable: true //make it draggable
        });
        //Listen for drag events!
        google.maps.event.addListener(marker, 'dragend', function(event){
            markerLocation();
        });
    } else{
        //Marker has already been added, so just change its location.
        marker.setPosition(currentlatLng);
    }
	//Get the marker's location and Set the value to input field.
    markerLocation();
}

//This function will get the marker's current location and then add the lat/long
//values to our textfields so that we can save the location.
function markerLocation(){
    //Get location.
    var currentLocation = marker.getPosition();
    //Add lat and lng values to a field that we can save.
    document.getElementById('lat').value = currentLocation.lat(); //latitude
    document.getElementById('lng').value = currentLocation.lng(); //longitude
}
        
        
//Load the map when the page has finished loading.
google.maps.event.addDomListener(window, 'load', initMap);


/* This setResult function is used as the callback function*/

function setResult(result) {
    // document.getElementById('lat').value = result.geometry.location.lat();
    // document.getElementById('lng').value = result.geometry.location.lng();
    var myLatLng = {lat: result.geometry.location.lat(), lng: result.geometry.location.lng()};
    map.setCenter(myLatLng)
    map.setZoom(15);
    setMarker(myLatLng);
}

function getLatitudeLongitude(callback, address) {
    // If adress is not supplied, use default value '0,0'
    address = address ;
    // Initialize the Geocoder
    geocoder = new google.maps.Geocoder();
    if (geocoder) {
        geocoder.geocode({
            'address': address
        }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                callback(results[0]);
            }
        });
    }
}

var button = document.getElementById('address');

button.addEventListener("keyup", function () {
    var address = document.getElementById('address').value;
    getLatitudeLongitude(setResult, address)
});