Vue.component("form-koordinat-jalan", {
    template: "#form-koordinat-jalan"
});

Vue.component("form-riwayat-perbaikan-jalan", {
    template: "#form-riwayat-perbaikan-jalan"
});

var app = new Vue({
    el: '#app',
    data: {
        show_left_bar: false,
        show_btn_add_label_stat: true,
        btn_add_label: "<i class='fa fa-plus'></i>",
        add_form_koordinat_jalan: 0,
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
            axios.post('p/tambah_informasi_jalan', {
                firstName: 'Fred',
                lastName: 'Flintstone'
            })
            .then(function (response) {
                console.log(response);
              })
            .catch(function (error) {
                console.log(error);
            });
        }
    }
});