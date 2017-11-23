var app = new Vue({
    el: '#app',
    data: {
        show_left_bar: false,
        show_btn_add_label_stat: true,
        btn_add_label: "",
        add_form_koordinat_jalan: 0,
        input_koordinat_radio: true,
        input_koordinat_radio_stat: true,
        add_form_riwayat_perbaikan_jalan: [],
        lat: [],
        lng: [],
        inputLat:[],
        budget_source_options:[],
        
        left_bar_content: 0, //0 untuk tambah informasi, 1 untuk view atau edit informasi
        left_bar_title: "Tambah Informasi Jalan",
        //v-model untuk form di left bar
        form_informasi_jalan:{
            nama_jalan: "",
            panjang_jalan: ""
        },
        road_id: 0, //Menyimpan id dari jalan ketika polyline di klik
        admin_sign_in: false,
        session_user_id: 0,
        session_user_type: 0,
        show_modal_sign_in: false
    },
    methods: {
        show_btn_add_label: function(event){
            if (this.session_user_id == 0){
                if (this.show_btn_add_label_stat){
                    this.show_btn_add_label_stat = !this.show_btn_add_label_stat
                    this.btn_add_label = "<i class='fa fa-sign-in'></i> Sign In"
                } else{
                    this.show_btn_add_label_stat = !this.show_btn_add_label_stat
                    this.btn_add_label = "<i class='fa fa-sign-in'></i>"
                }
            } else{
                if (this.show_btn_add_label_stat){
                    this.show_btn_add_label_stat = !this.show_btn_add_label_stat
                    this.btn_add_label = "<i class='fa fa-plus'></i> Tambah Ruas Jalan"
                } else{
                    this.show_btn_add_label_stat = !this.show_btn_add_label_stat
                    this.btn_add_label = "<i class='fa fa-plus'></i>"
                }
            }
        },
        btn_add_form_koordinat_jalan: function(){
            this.add_form_koordinat_jalan += 1;
            
        },
        btn_add_form_riwayat_perbaikan_jalan: function(){
            //this.add_form_riwayat_perbaikan_jalan += 1;
            this.add_form_riwayat_perbaikan_jalan.push(this.form_informasi_jalan);
        },
        save_road_info: function(){
            var nama_jalan = document.querySelector('#nama-jalan').value;
            var panjang_jalan = document.querySelector('#panjang-jalan').value;

            var jumlah_riwayat_perbaikan = document.querySelectorAll(".row-riwayat-perbaikan-jalan").length;
            var nama_pekerjaan = document.querySelectorAll("input[name='nama-pekerjaan']");
            var kecamatan = document.querySelectorAll("input[name='kecamatan']");
            var volume = document.querySelectorAll("input[name='volume']");
            var satuan_volume = document.querySelectorAll("input[name='satuan-volume']");
            var budget = document.querySelectorAll("input[name='budget']");
            var sumber_budget = document.querySelectorAll("select[name='sumber-budget']");
            var sistem_pelaksanaan = document.querySelectorAll("input[name='sistem-pelaksanaan']");
            var mulai = document.querySelectorAll("input[name='mulai']");
            var berakhir = document.querySelectorAll("input[name='berakhir']");
            var pelaksana = document.querySelectorAll("input[name='pelaksana']");
            var pengawas = document.querySelectorAll("input[name='pengawas']");
            var perencana = document.querySelectorAll("input[name='perencana']");

            var riwayat_perbaikan_arr=[];
            for(var x=0; x<jumlah_riwayat_perbaikan; x++){
                riwayat_perbaikan_arr.push({
                    job: nama_pekerjaan[x].value,
                    district: kecamatan[x].value,
                    volume: volume[x].value,
                    volume_unit: satuan_volume[x].value,
                    budget: budget[x].value,
                    budget_source: sumber_budget[x].value,
                    execution_sys: sistem_pelaksanaan[x].value,
                    start: mulai[x].value,
                    end: berakhir[x].value,
                    executive: pelaksana[x].value,
                    supervisor: pengawas[x].value,
                    planner: perencana[x].value
                });
            }
            if (this.left_bar_content==0){
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
            } else if(this.left_bar_content==1){
                var id_riwayat_jalan = document.querySelector('#id-riwayat-jalan').value;
                axios.post('p/ubah_informasi_jalan', {
                    id: app.road_id,
                    history_id: id_riwayat_jalan,
                    nama_jalan: nama_jalan,
                    panjang_jalan: panjang_jalan,
                    riwayat_perbaikan_arr: riwayat_perbaikan_arr
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
        show_coordinate: function (value){
            console.log("OK");
            app.btn_add_form_koordinat_jalan();
            app.lat.push(value[0]);
            app.lng.push(value[1]);
        },
        show_road_info: function (road_id){
            console.log("Road ID "+ road_id);
            this.road_id = road_id;
            axios.post('p/informasi_jalan', {
                id: road_id
            })
            .then(function (response) {
                console.log(response);
                app.left_bar_content = 1;
                app.show_left_bar = true;
                var data = response.data;
                //Set nilai form dengan data
                app.form_informasi_jalan.nama_jalan = data.name;
                app.form_informasi_jalan.panjang_jalan = data.length;
                if(data.history.length>0){
                    app.add_form_riwayat_perbaikan_jalan = data.history;
                } else{
                    app.add_form_riwayat_perbaikan_jalan = [];
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        click_btn_right_bar: function (){
            if (this.session_user_id == 0){
                this.show_modal_sign_in = !this.show_modal_sign_in;
            } else{
                this.show_left_bar = !this.show_left_bar;
            }
        }
    },
    mounted: function (){
        // Request data sumber budget
        axios.post('p/sumber_budget')
        .then(function (response) {
            console.log(response);
            app.budget_source_options = response.data;
        })
        .catch(function (error) {
            console.log(error);
        });

        //Check session
        axios.post('p/check_session')
        .then(function (response) {
            console.log(response);
            var data = response.data;
            if (data["user_id"]==null){
                app.session_user_id = 0;
                app.session_user_type = 0;
                app.btn_add_label = "<i class='fa fa-sign-in'></i>";
            } else{
                app.session_user_id = data["user_id"];
                app.session_user_type = data["user_type"];
                app.btn_add_label = "<i class='fa fa-plus'></i>";
                if (data["user_type"]==1){
                    app.admin_sign_in= true;
                }
            }
        })
        .catch(function (error) {
            console.log(error);
        });
        
        
    },
    watch: {
        left_bar_content: function(value){
            console.log(value);
            if (value==0){
                this.left_bar_title = "Tambah Informasi Jalan"
                this.form_informasi_jalan.nama_jalan = "";
                this.form_informasi_jalan.panjang_jalan = "";
                this.add_form_riwayat_perbaikan_jalan = [];
                this.add_form_riwayat_perbaikan_jalan.push(this.form_informasi_jalan);
            } else if (value==1){
                this.left_bar_title = "Informasi Jalan"
            }
        },
        show_left_bar: function(value){
            if(!value){
                this.left_bar_content = 0;
            }
        }
    }
});

// Vue.component("form-koordinat-jalan", {
//     template: "#form-koordinat-jalan",
//     props: ['disable-this', 'lat', 'lng', 'index'],
//     data: function(){
//         return{
//             //inputLat: this.lat
//         }
        
//     }
// });

// Vue.component("form-riwayat-perbaikan-jalan", {
//     template: "#form-riwayat-perbaikan-jalan"
// });

