const EventBus = new Vue();
Vue.component('google-map', {
    template: '#google-map-jalan',
    data: function() {
        return {
            map: null,
            poly: null,
            latLng: [],
            addListenerPoly: null,
            left_bar_open : ''
        }
    },
    props: ['show_left_bar'],
    mounted: function () {
        const element = document.getElementById("map")
        mapCenter = new google.maps.LatLng(-8.5440021, 115.4042448);
        const mapProp = {
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
        this.map = new google.maps.Map(element, mapProp);
        this.poly = new google.maps.Polyline({
            strokeColor: '#000000',
            strokeOpacity: 1.0,
            strokeWeight: 3
        });
        this.poly.setMap(this.map);
        //this.map.addListener('click', this.addLatLng);
    },
    methods: {
        addLatLng: function(event){
            var path = this.poly.getPath();
            path.push(event.latLng);
            this.latLng = [event.latLng.lat(), event.latLng.lng()];
        }
    },
    watch: {
        show_left_bar: function(value){
            if (value){
                this.addListenerPoly = this.map.addListener('click', this.addLatLng);
            } else{
                google.maps.event.removeListener(this.addListenerPoly);
            }
        },
        latLng: function(value){
            EventBus.$emit('latLng', this.latLng);
        }
    }
});


// var map = new google.maps.Map(document.getElementById("map-jalan"), mapProp);
// function initialize() {
//     // Minta koordinat polyline dengan axios
//     axios.get('p/tampilkan_polyline', {
//     })
//     .then(function (response) {
//         console.log(response);
//         //Untuk setiap id jalan buatin poly = new google.maps.Polyline sama pathnya disini
//         //Untuk setiap Lat dan Lang dari koordinat push nilainya ke variabel path.
//       })
//     .catch(function (error) {
//         console.log(error);
//     });

//     poly = new google.maps.Polyline({
//         strokeColor: '#000000',
//         strokeOpacity: 1.0,
//         strokeWeight: 3
//     });
//     poly.setMap(map);
    
// }
// function addLatLng(event){
//     var path = poly.getPath();
//     //console.log("Path "+JSON.stringify(path));
//     path.push(event.latLng);
//     //console.log("LatLng "+ event.latLng.lat());

// }
// google.maps.event.addDomListener(window, 'load', initialize);
//Conflict code Test

