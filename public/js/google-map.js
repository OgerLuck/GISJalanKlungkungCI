// const EventBus = new Vue();
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
    methods: {
        addLatLng: function(event){
            var path = this.poly.getPath();
            path.push(event.latLng);
            this.latLng = [event.latLng.lat(), event.latLng.lng()];
            // Kirim nilai latlng ke parent dengan metode emit. Nilai ini akan diterima oleh event bernama coordinate
            this.$emit('coordinate', this.latLng);
        },
        createPoly: function(lat_lng_arr, road_id){
            var bounds = new google.maps.LatLngBounds();
            //var poly=[];
            path = [];
            //console.log(lat_lng_arr);
            for (var lat_lng in lat_lng_arr) {
                path.push( new google.maps.LatLng(
                    lat_lng_arr[lat_lng][0],
                    lat_lng_arr[lat_lng][1]
                ));      
                bounds.extend(path[path.length-1]);
            }
            var poly = new google.maps.Polyline({
                                id: road_id,
                                path: path,
                                strokeColor: '#FF0000',
                                strokeOpacity: 0.8,
                                strokeWeight: 4,
                                fillColor: '#FF0000',
                                fillOpacity: 0.35
                            }); 
            poly.setMap(this.map);   
            this_component = this;
            google.maps.event.addListener(poly, 'click', function(event) {
                //alert(road_id);
                this_component.$emit('road_info', road_id);
                //this.map.fitBounds(bounds);
            });
        }
    },
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
        this_component = this;
        axios.post('p/tampilkan_polyline')
        .then(function (response) {
            //console.log(response);
            var data = response.data;
            for(var x in data){
                var lat_lng_arr=[];
                for(var y=0; y<data[x].length; y++){
                    var lat_lng = [parseFloat(data[x][y].lat), parseFloat(data[x][y].lng)];
                    lat_lng_arr.push(lat_lng);                                                    
                }
                //console.log(x);
                this_component.createPoly(lat_lng_arr, x);
            }
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    watch: {
        show_left_bar: function(value){
            if (value){
                this.addListenerPoly = this.map.addListener('click', this.addLatLng);
            } else{
                google.maps.event.removeListener(this.addListenerPoly);
            }
        },
        // latLng: function(value){
        //     this.$emit('latLng', this.latLng);
        // }
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

