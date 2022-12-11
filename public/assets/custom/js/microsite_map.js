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

    //The center location of our map.
    var centerOfMap = new google.maps.LatLng(lat, lng);

    //Map options.
    var options = {
        // center: centerOfMap, //Set center.
        // zoom: zoomValue //The zoom value.
        center: {lat: 23.800679, lng: 90.413134}, //Set center.
        zoom: 11 //The zoom value.
    };
 
    //Create the map object.
    map = new google.maps.Map(document.getElementById('map'), options);
    var newlatlng = {lat: parseFloat(lat), lng: parseFloat(lng) };
    // console.log(newlatlng);
    var branches = [
        ['Burger King Banani', 23.791067, 90.403530, 4],
        ['Burger King Gulshan 2', 23.795492, 90.413511, 5],
        ['Burger King Bashundhara', 23.812137, 90.422729, 3],
        ['Burger King Balaka Outlet', 23.733750, 90.384929, 2],
        ['Burger King Dhanmondi', 23.738354, 90.375751, 1],
        ['Burger King Mirpur', 23.800436, 90.355171, 6],
        ['Burger King Uttara', 23.874904, 90.398491, 7],
        ['Burger King JFP', 23.813694900486, 90.424605738692, 8]

    ];

    var image = "assets/custom/img/bkmaplogo_small.png";
      // Shapes define the clickable region of the icon. The type defines an HTML
      // <area> element 'poly' which traces out a polygon as a series of X,Y points.
      // The final coordinate closes the poly by connecting to the first coordinate.
     
    for (var i = 0; i < branches.length; i++) {
        var branch = branches[i];
        var marker = new google.maps.Marker({
        position: {lat: branch[1], lng: branch[2]},
        map: map,
        icon: image,
        // shape: shape,
        // label: {
        //     text: branch[0],
        //     color: '#222222',
        //     fontSize: '12px'
        // },
        title: branch[0],
        zIndex: branch[3]
        });
        
        var content = branch[0];
        var infowindow = new google.maps.InfoWindow();
        google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
            return function() {
               infowindow.setContent(content);
               infowindow.open(map,marker);
            };
        })(marker,content,infowindow));
    }


 	// setMarker(newlatlng);
    //Listen for any clicks on the map.
    // google.maps.event.addListener(map, 'click', function(event) {                
    //     //Get the location that the user clicked.
    //     var clickedLocation = event.latLng;
    //     // Set the Marker
    //     setMarker(clickedLocation);
        
    // });
}


// function addMarker(coords){
//   var marker = new google.maps.Marker({
//     position : coords,
//     map : map,
//     icon : 'pin.png',
//   })
// }
      
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

var button = document.getElementById('locationid');

button.addEventListener("change", function () {
    // var address = document.getElementById('address').value;
    // getLatitudeLongitude(setResult, address)
    initMap();
});