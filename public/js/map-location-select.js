//map.js

//Set up some of our variables.
var map; //Will contain map object.
var marker = false; ////Has the user plotted their location marker?
//Function called to initialize / create the map.
//This is called when the page has loaded.
function initMap() {
  if(typeof lat === 'undefined'&&typeof lon === 'undefined'){
    var center = new google.maps.LatLng(35.68323494144002,51.3890540599823);
    var zoom = 11;
  }else{
    //var center = new google.maps.LatLng(lat,lon);
    var center = new google.maps.LatLng(lat,lon);
    var zoom = 17;
  }
    //Map options.
    var options = {
      center: center,
      zoom: zoom //The zoom value.
    };

    var canvas = document.getElementById('map');
    //Create the map object.
    map = new google.maps.Map(canvas, options);


    if(typeof lat != 'undefined'&&typeof lon != 'undefined'){
      marker = new google.maps.Marker({position: center,map: map, draggable: true});
      marker.setMap(map);
    }

    //Listen for any clicks on the map.
    google.maps.event.addListener(map, 'click', function(event) {
        //Get the location that the user clicked.
        var clickedLocation = event.latLng;
        //If the marker hasn't been added.
        if(marker === false){
            //Create the marker.
            marker = new google.maps.Marker({
                position: clickedLocation,
                map: map,
                draggable: true //make it draggable
            });
            //Listen for drag events!
            google.maps.event.addListener(marker, 'dragend', function(event){
                markerLocation();
            });
        } else{
            //Marker has already been added, so just change its location.
            marker.setPosition(clickedLocation);
        }
        //Get the marker's location.
        markerLocation();
    });

}

//This function will get the marker's current location and then add the lat/long
//values to our textfields so that we can save the location.
function markerLocation(){
    //Get location.
    var currentLocation = marker.getPosition();
    //Add lat and lng values to a field that we can save.
    document.getElementById('map-lat').value = currentLocation.lat(); //latitude
    document.getElementById('map-lng').value = currentLocation.lng(); //longitude
}


//Load the map when the page has finished loading.
google.maps.event.addDomListener(window, 'load', initMap);
