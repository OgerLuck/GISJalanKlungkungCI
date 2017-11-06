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
            <div id="map">
            </div>
        </div>
        <!-- Tab sebelah kiri untuk view, insert, update dan delete data informasi jalan -->
        <transition name="slide">
            <div v-if="show_left_bar" class="left-bar">
                <h3 class="left-bar-title">Tambah Informasi Jalan</h3>
                <button v-on:click="show_left_bar = !show_left_bar" class="btn btn-default btn-bar" id="left-bar-btn-close"><i class="fa fa-times"></i></button>
                <div class="form-container">
                    <label for="">Identitas Jalan</label>
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Nama Jalan">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="number" placeholder="Panjang Jalan">
                    </div>
                    <hr>
                    <label for="">Riwayat Perbaikan</label>
                    <a v-on:click="btn_add_form_riwayat_perbaikan_jalan" class="pull-right"><i class="fa fa-plus"></i></a>
                    <!-- Form riwayat perbaikan jalan, dengan template component Vue -->
                    <div class="form-group">
                        <form-riwayat-perbaikan-jalan></form-riwayat-perbaikan-jalan>
                        <form-riwayat-perbaikan-jalan v-for="n in add_form_riwayat_perbaikan_jalan"></form-riwayat-perbaikan-jalan>
                    </div>
                    <hr>
                    <label for="">Koordinat Jalan</label>
                    <a v-on:click="btn_add_form_koordinat_jalan" class="pull-right"><i class="fa fa-plus"></i></a>
                    <!-- Form koordinat jalan, dengan template component Vue -->
                    <div class="form-group">
                        <form-koordinat-jalan></form-koordinat-jalan>
                        <form-koordinat-jalan v-for="n in add_form_koordinat_jalan"></form-koordinat-jalan>
                    </div>
                </div>
                <button v-on:click="save_road_info" class="btn btn-primary" id="btn-save-road-info"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </transition>
        
        <!-- Tab sebelah kanan untuk tombol tambah yang akan membuka tab kiri -->
        <div class="right-bar">
            <button v-on:mouseover="show_btn_add_label" v-on:mouseleave="show_btn_add_label" v-on:click="show_left_bar = !show_left_bar" v-html="btn_add_label" class="btn btn-primary btn-bar" id="right-bar-btn-add"></button>
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

    <!-- File site-ui.js hanya berisi javascript untuk proses pada UI  -->
    <script type="text/javascript" src="<?php echo base_url('js/site-ui.js');?>"></script> 
    <!-- File site-ajax.js hanya berisi javascript untuk proses yang menggunakan ajax  -->
    <script type="text/javascript" src="<?php echo base_url('js/site-ajax.js');?>"></script> 
    <!-- File google-map.js hanya berisi javascript untuk map dari Google  -->
    <script type="text/javascript" src="<?php echo base_url('js/google-map.js');?>"></script>

    <!-- Template untuk form koordinat jalan -->
    <script type="x-template" id="form-koordinat-jalan">
        <div class="row form-row">
            <div class="col-lg-6">
                <input class="form-control" type="number" placeholder="Koordinat X">
            </div>
            <div class="col-lg-6">
                <input class="form-control" type="number" placeholder="Koordinat Y">
            </div>
        </div>
    </script>

    <!-- Template untuk form riwayat perbaikan jalan -->
    <script type="x-template" id="form-riwayat-perbaikan-jalan">
        <div class="row form-row">
            <div class="col-lg-12">
                <div class="form-group">
                    <input class="form-control" type="number" placeholder="Tahun Perbaikan">
                </div>
                <div class="form-group">
                    <input class="form-control" type="number" placeholder="Nama Kontraktor">
                </div>
                <div class="form-group">
                    <textarea class="form-control" type="text" placeholder="Catatan"></textarea>
                </div>
            </div>
        </div>
    </script>
</body>
</html>