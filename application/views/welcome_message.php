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

    <!-- Styles -->
    <link type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url('css/style.css');?>" rel="stylesheet">
</head>
<body>
    <div class="content">
        <!-- Lokasi HTML untuk map dari Google  -->
		<!-- Javascript dari Google Maps bisa dilihat di /public/js/google-map.js -->
	    <div class="row" id="main-content">
	        <div class="col-md-12">
	            <div id="map">
	            </div>
	        </div>
	    </div>
    </div>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
     <!-- Sesuaikan MAPS_API_KEY dengan key yang didapatkan -->
    <script src="http://maps.googleapis.com/maps/api/js?key="></script>

    <!-- File site-ui.js hanya berisi javascript untuk proses pada UI  -->
    <script type="text/javascript" src="<?php echo base_url('js/site-ui.js');?>"></script> 
    <!-- File site-ajax.js hanya berisi javascript untuk proses yang menggunakan ajax  -->
    <script type="text/javascript" src="<?php echo base_url('js/site-ajax.js');?>"></script> 
    <!-- File google-map.js hanya berisi javascript untuk map dari Google  -->
    <script type="text/javascript" src="<?php echo base_url('js/google-map.js');?>"></script>

</body>
</html>