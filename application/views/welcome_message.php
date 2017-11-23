<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('url');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GIS Jalan Klungkung</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <!-- Styles -->
    <link type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url('css/style.css');?>" rel="stylesheet">
</head>
<body>
    <div class="content" id="app">
        <!-- Lokasi HTML untuk map dari Google  -->
		<!-- Javascript dari Google Maps bisa dilihat di /public/js/google-map.js -->
	    <div id="main-content">
            <!-- <div id="map">
            </div> -->
            <google-map :show_left_bar="show_left_bar" v-on:coordinate="show_coordinate" v-on:road_info="show_road_info"></google-map>
        </div>
        <!-- Tab sebelah kiri untuk view, insert, update dan delete data informasi jalan -->
        <transition name="slide">
            <div v-if="show_left_bar" class="left-bar">
                <h3 class="left-bar-title">{{ left_bar_title }}</h3>
                <button v-on:click="show_left_bar = !show_left_bar" class="btn btn-default btn-bar" id="left-bar-btn-close"><i class="fa fa-times"></i></button>
                <div class="form-container">
                    <label for="">Identitas Jalan</label>
                    <div class="form-group">
                        <input id="nama-jalan" class="form-control" v-model="form_informasi_jalan.nama_jalan" type="text" placeholder="Nama Jalan" v-bind:disabled="!admin_sign_in">
                    </div>
                    <div class="form-group input-group">
                        <input id="panjang-jalan" class="form-control" v-model="form_informasi_jalan.panjang_jalan" type="number" placeholder="Panjang Jalan" v-bind:disabled="!admin_sign_in">
                        <span class="input-group-addon">Meter</span>
                    </div>
                    <hr>
                    <label for="">Riwayat Perbaikan</label>
                    <a v-if="admin_sign_in" v-on:click="btn_add_form_riwayat_perbaikan_jalan" class="pull-right"><i class="fa fa-plus"></i></a>
                    <!-- Form riwayat perbaikan jalan, dengan template component Vue -->
                    <div class="form-group">
                        <div class="row form-row row-riwayat-perbaikan-jalan" v-for="(item, index) in add_form_riwayat_perbaikan_jalan">
                        <p style="text-align: center; ">Riwayat ke-{{ index+1 }}</p>
                        <!-- <form-riwayat-perbaikan-jalan></form-riwayat-perbaikan-jalan>
                        <form-riwayat-perbaikan-jalan v-for="n in add_form_riwayat_perbaikan_jalan"></form-riwayat-perbaikan-jalan> -->
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input name="id-riwayat-jalan" type="hidden" v-bind:value="item.id">
                                    <input name="nama-pekerjaan" class="form-control" type="text" placeholder="Nama Pekerjaan" v-bind:value="item.job" v-bind:disabled="!admin_sign_in">
                                </div>
                                <div class="form-group">
                                    <input name="kecamatan" class="form-control" type="text" placeholder="Kecamatan" v-bind:value="item.district" v-bind:disabled="!admin_sign_in">
                                </div>
                                <div class="form-group">
                                    <div class="row form-row">
                                        <div class="col-lg-8">
                                            <input name="volume" class="form-control" type="number" placeholder="Volume" v-bind:value="item.volume" v-bind:disabled="!admin_sign_in">
                                        </div>
                                        <div class="col-lg-4">
                                            <input name="satuan-volume" class="form-control" type="text" placeholder="Satuan" v-bind:value="item.volume_unit" v-bind:disabled="!admin_sign_in">
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="form-group"> 
                                    <div class="row form-row">
                                        <div class="col-lg-6">
                                            <input name="budget" class="form-control" type="number" placeholder="Anggaran" v-bind:value="item.budget" v-bind:disabled="!admin_sign_in">
                                        </div>
                                        <div class="col-lg-6">
                                            <select class="form-control" name="sumber-budget" id="sumber-budget" v-bind:disabled="!admin_sign_in">
                                                <option value="0">Sumber Anggaran</option>
                                                <option v-for="option in budget_source_options" v-bind:value="option.id" v-bind:selected="option.id == item.budget_source_id" >{{ option.source }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <input name="sistem-pelaksanaan" class="form-control" type="text" placeholder="Sistem Pelaksanaan" v-bind:value="item.execution_sys" v-bind:disabled="!admin_sign_in">
                                </div>
                                <div class="form-group">
                                    <input name="mulai" class="form-control" type="date" placeholder="Waktu Mulai" v-bind:value="item.start" v-bind:disabled="!admin_sign_in">
                                </div>
                                <div class="form-group">
                                    <input name="berakhir" class="form-control" type="date" placeholder="Waktu Berakhir" v-bind:value="item.end" v-bind:disabled="!admin_sign_in">
                                </div>
                                <div class="form-group">
                                    <input name="pelaksana" class="form-control" type="text" placeholder="Pelaksana" v-bind:value="item.executive" v-bind:disabled="!admin_sign_in"> 
                                </div>
                                <div class="form-group">
                                    <input name="pengawas" class="form-control" type="text" placeholder="Pengawas" v-bind:value="item.supervisor" v-bind:disabled="!admin_sign_in">
                                </div>
                                <div class="form-group">
                                    <input name="perencana" class="form-control" type="text" placeholder="Perencana" v-bind:value="item.planner" v-bind:disabled="!admin_sign_in">
                                </div>
                                <!-- <hr style="  border: 0; height: 3px;background: #333;background-image: linear-gradient(to right, #ccc, #333, #ccc);"> -->
                            </div>
                            
                        </div>
                        
                    </div>
                    <hr>
                    <label for="">Koordinat Jalan</label>
                    <label v-if="admin_sign_in" class="radio-inline"><input v-model="input_koordinat_radio"  v-bind:value="0==1" type="radio" name="input-lat-lng">Manual</label>
                    <label v-if="admin_sign_in" class="radio-inline"><input v-model="input_koordinat_radio"  v-bind:value="1==1" type="radio" name="input-lat-lng" :checked="true">Dari Peta</label>
                    <a v-if="!input_koordinat_radio" v-on:click="btn_add_form_koordinat_jalan" class="pull-right"><i class="fa fa-plus"></i></a>
                    <!-- Form koordinat jalan, dengan template component Vue -->
                    <div class="form-group">
                        <!-- <form-koordinat-jalan v-if="input_koordinat_radio==false" v-bind:disable-this="input_koordinat_radio"></form-koordinat-jalan> -->
                        <!-- <form-koordinat-jalan v-bind:lat="lat" v-bind:lng="lng" v-bind:disable-this="input_koordinat_radio" v-for="(n, index) in add_form_koordinat_jalan" v-bind:key="add_form_koordinat_jalan"></form-koordinat-jalan> -->
                        <div class="row form-row row-lat-lng-jalan" v-for="(n, index) in add_form_koordinat_jalan" v-bind:key="add_form_koordinat_jalan">
                            <div class="col-lg-6">
                                <input name="lat" class="form-control" type="number" placeholder="Latitude" v-bind:value="lat[index]" v-bind:disabled="input_koordinat_radio == true">
                            </div>
                            <div class="col-lg-6">
                                <input name="lng" class="form-control" type="number" placeholder="Longitude" v-bind:value="lng[index]" v-bind:disabled="input_koordinat_radio == true">
                            </div>
                        </div>
                    </div>
                </div>
                <button v-if="admin_sign_in" v-on:click="save_road_info" class="btn btn-primary" id="btn-save-road-info"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </transition>
        
        <!-- Tab sebelah kanan untuk tombol tambah yang akan membuka tab kiri -->
        <div class="right-bar">
            <button v-on:mouseover="show_btn_add_label" v-on:mouseleave="show_btn_add_label" v-on:click="click_btn_right_bar" v-html="btn_add_label" class="btn btn-primary btn-bar" id="right-bar-btn-add"></button>
        </div>

        <!-- Modal untuk login -->
        <div v-if="show_modal_sign_in">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" v-on:click="show_modal_sign_in=false">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title">Sign In</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input name="username" class="form-control" type="text" placeholder="Username">
                                    </div>
                                    <div class="form-group">
                                        <input name="password" class="form-control" type="text" placeholder="Password">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" v-on:click="show_modal_sign_in=false">Cancel</button>
                                    <button type="button" class="btn btn-primary">Sign In</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </div>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
     <!-- Sesuaikan MAPS_API_KEY dengan key yang didapatkan -->
    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyC3iE--BXcBVpLi6MXVS6u4sYQl8D8kAY4"></script>
    <!-- Vue JS -->
    <script src="https://unpkg.com/vue"></script>
    <!-- Axios untuk proses XMLHttpRequest / AJAX -->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    
    <script type="x-template" id="google-map-jalan">
        <div id="map"></div>
    </script>

    <!-- File google-map.js hanya berisi javascript untuk map dari Google  -->
    <script type="text/javascript" src="<?php echo base_url('js/google-map.js');?>"></script>
    <!-- File site-ui.js hanya berisi javascript untuk proses pada UI  -->
    <script type="text/javascript" src="<?php echo base_url('js/site-ui.js');?>"></script> 
    <!-- File site-ajax.js hanya berisi javascript untuk proses yang menggunakan ajax  -->
    <script type="text/javascript" src="<?php echo base_url('js/site-ajax.js');?>"></script> 

    <!-- Template untuk form riwayat perbaikan jalan -->
    <script type="x-template" id="form-riwayat-perbaikan-jalan">
        <div class="row form-row row-riwayat-perbaikan-jalan">
            <div class="col-lg-12">
                <div class="form-group">
                    <input name="tahun-perbaikan" class="form-control" type="number" placeholder="Tahun Perbaikan">
                </div>
                <div class="form-group">
                    <input name="nama-kontraktor" class="form-control" type="text" placeholder="Nama Kontraktor">
                </div>
                <div class="form-group">
                    <textarea name="deskripsi-perbaikan" class="form-control" type="text" placeholder="Catatan"></textarea>
                </div>
            </div>
        </div>
    </script>
    <!-- Template untuk form koordinat jalan -->
    <script type="x-template" id="form-koordinat-jalan">
        <div class="row form-row row-lat-lng-jalan">
            <div class="col-lg-6">
                <input name="lat" class="form-control" type="number" placeholder="Latitude" v-bind:value="lat" v-bind:disabled="disableThis == true">
            </div>
            <div class="col-lg-6">
                <input name="lng" class="form-control" type="number" placeholder="Longitude" v-bind:value="lng" v-bind:disabled="disableThis == true">
            </div>
        </div>
    </script>


</body>
</html>