var app = new Vue({
    el: '#app',
    data: {
        show_left_bar: false,
        show_btn_add_label_stat: true,
        btn_add_label: "<i class='fa fa-plus'></i>",
        add_form_koordinat_jalan: 0,
        input_koordinat_radio: true,
        input_koordinat_radio_stat: true,
        add_form_riwayat_perbaikan_jalan: 0
    },
    methods: {
        show_btn_add_label: function(event){
            if (this.show_btn_add_label_stat){
                this.show_btn_add_label_stat = !this.show_btn_add_label_stat
                this.btn_add_label = "<i class='fa fa-plus'></i> Tambah Ruas Jalan"
            } else{
                this.show_btn_add_label_stat = !this.show_btn_add_label_stat
                this.btn_add_label = "<i class='fa fa-plus'></i>"
            }
        },
        btn_add_form_koordinat_jalan: function(){
            this.add_form_koordinat_jalan += 1;
        },
        btn_add_form_riwayat_perbaikan_jalan: function(){
            this.add_form_riwayat_perbaikan_jalan += 1;
        },
        save_road_info: function(){
            var nama_jalan = document.querySelector('#nama-jalan').value;
            var panjang_jalan = document.querySelector('#panjang-jalan').value;

            var jumlah_riwayat_perbaikan = document.querySelectorAll(".row-riwayat-perbaikan-jalan").length;
            var tahun_perbaikan = document.querySelectorAll("input[name='tahun-perbaikan']");
            var nama_kontraktor = document.querySelectorAll("input[name='nama-kontraktor']");
            var deskripsi_perbaikan = document.querySelectorAll("textarea[name='deskripsi-perbaikan']");
            var riwayat_perbaikan_arr=[];
            for(var x=0; x<jumlah_riwayat_perbaikan; x++){
                riwayat_perbaikan_arr.push({
                    year: tahun_perbaikan[x].value, 
                    contractor: nama_kontraktor[x].value,
                    desc:  deskripsi_perbaikan[x].value
                });
            }

            var jumlah_lat_lng = document.querySelectorAll(".row-lat-lng-jalan").length;
            var lat = document.querySelectorAll("input[name='lat']");
            var lng = document.querySelectorAll("input[name='lng']");
            var lat_lng_arr=[];
            for(var x=0; x<jumlah_lat_lng; x++){
                lat_lng_arr.push({
                    lat: lat[x].value, 
                    lng: lng[x].value
                });
            }
            console.log(riwayat_perbaikan_arr);

            axios.post('p/tambah_informasi_jalan', {
                nama_jalan: nama_jalan,
                panjang_jalan: panjang_jalan,
                riwayat_perbaikan_arr: riwayat_perbaikan_arr,
                lat_lng_arr: lat_lng_arr
            })
            .then(function (response) {
                console.log(response);
                app.show_left_bar = false;
            })
            .catch(function (error) {
                console.log(error);
            });
        }
    },
    mounted: function (){
        EventBus.$on('latLng', function (value) {
        app.btn_add_form_koordinat_jalan();
            //console.log(value[0]+" "+value[1]);
        });
    },
});

Vue.component("form-koordinat-jalan", {
    template: "#form-koordinat-jalan",
    props: ['disable-this'],
});

Vue.component("form-riwayat-perbaikan-jalan", {
    template: "#form-riwayat-perbaikan-jalan"
});

