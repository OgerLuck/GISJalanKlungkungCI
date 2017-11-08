function initialize() {
    mapCenter = new google.maps.LatLng(-8.5440021, 115.4042448);
    mapProp = {
        center: mapCenter,
        zoom:15,
        scrollwheel: true,
        zoomControl:false,
        streetViewControl: false,
        mapTypeControl: false,
        fullscreenControl: false,
        disableDoubleClickZoom: true,
        panControl: true,
        zoomControl: true,
        zoomControlOptions: {
            style: google.maps.ZoomControlStyle.LARGE,
            position: google.maps.ControlPosition.LEFT_CENTER
        },
        mapTypeId:google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("map"), mapProp);
    // Minta koordinat polyline dengan axios
    axios.get('p/tampilkan_polyline', {
    })
    .then(function (response) {
        console.log(response);
        //Untuk setiap id jalan buatin poly = new google.maps.Polyline sama pathnya disini
        //Untuk setiap Lat dan Lang dari koordinat push nilainya ke variabel path.
      })
    .catch(function (error) {
        console.log(error);
    });

    poly = new google.maps.Polyline({
        strokeColor: '#000000',
        strokeOpacity: 1.0,
        strokeWeight: 3
    });
    poly.setMap(map);
    addLatLngListener = map.addListener('click', addLatLng);
    
}
function addLatLng(event){
    var path = poly.getPath();
    //console.log("Path "+JSON.stringify(path));
    path.push(event.latLng);
    //console.log("LatLng "+ event.latLng.lat());

}
google.maps.event.addDomListener(window, 'load', initialize);
//Conflict code Test


