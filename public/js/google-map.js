function initialize() {
	mapCenter = new google.maps.LatLng(-8.5440021, 115.4042448);
	mapProp = {
        center: mapCenter,
        zoom:15,
        scrollwheel: true,
        zoomControl:false,
        streetViewControl: false,
        mapTypeControl: false,
        disableDoubleClickZoom: true,
        scrollwheel: false,
        panControl: true,
        zoomControl: true,
        zoomControlOptions: {
            style: google.maps.ZoomControlStyle.LARGE,
            position: google.maps.ControlPosition.LEFT_CENTER
        },
        mapTypeId:google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("map"), mapProp);

}
google.maps.event.addDomListener(window, 'load', initialize);
//apalah
