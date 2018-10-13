// //map.js
//
// //Set up some of our variables.
// var map; //Will contain map object.
// var marker = false; ////Has the user plotted their location marker?
// //Function called to initialize / create the map.
// //This is called when the page has loaded.
// function initMap() {
//   if(typeof lat === 'undefined'&&typeof lon === 'undefined'){
//     var center = new google.maps.LatLng(35.68323494144002,51.3890540599823);
//     var zoom = 11;
//   }else{
//     //var center = new google.maps.LatLng(lat,lon);
//     var center = new google.maps.LatLng(lat,lon);
//     var zoom = 17;
//   }
//     //Map options.
//     var options = {
//       center: center,
//       zoom: zoom //The zoom value.
//     };
//
//     var canvas = document.getElementById('map');
//     //Create the map object.
//     map = new google.maps.Map(canvas, options);
//
//
//     if(typeof lat != 'undefined'&&typeof lon != 'undefined'){
//       marker = new google.maps.Marker({position: center,map: map, draggable: false});
//       marker.setMap(map);
//     }
// }
//
// //Load the map when the page has finished loading.
// google.maps.event.addDomListener(window, 'load', initMap);

$(document).ready(function () {
  var osmUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
      osm = L.tileLayer(osmUrl, {maxZoom: 18});
  
  var map = L.map('map').setView([lat, lon], 15).addLayer(osm);
  L.marker([lat, lon])
      .addTo(map);
});
