<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Process extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function addRoad(){
		$name = $this->input->post("nama-jalan");
		$length = $this->input->post("panjang-jalan");
		$repair_history = $this->input->post("riwayat-perbaikan-jalan");
		$coordinates = $this->input->post("koordinat-jalan");
		// Insert nama jalan dan panjangnya.
		if(!$this->db->query("INSERT INTO tb_road(name, length, created_at) 
								VALUES (".$this->db->escape($name).", $length, NOW());")){
			$error = $this->db->error();
			echo $error->message;
		}

		// Ambil id terakhir dari tb_road
		$road_id = $this->db->insert_id();

		// Insert riwayat perbaikan jalan secara berulang sebanyak data di array
		for($x=0; $x<count($repair_history); $x++){
			$repair_year = $repair_history[$x]->year;
			$repair_contractor = $repair_history[$x]->contractor;
			$repair_desc = $repair_history[$x]->desc;
			if(!$this->db->query("INSERT INTO tb_road_repair_history(road_id, year, contractor, desc, created_at) 
									VALUES ($road_id, $repair_year, ".$this->db->escape($repair_contractor).", ".$this->db->escape($repair_desc).", NOW());")){
				$error = $this->db->error();
				echo $error->message;
			}
		}

		// Insert koordinat secara berulang sebanyak data di array
		for($x=0; $x<count($coordinates); $x++){
			$coor_x = $coordinates[$x]->x;
			$coor_y = $coordinates[$x]->y;
			if(!$this->db->query("INSERT INTO tb_road_coor(road_id, coor_x, coor_y, created_at) 
									VALUES ($road_id, $coor_x, $coor_y, NOW());")){
				$error = $this->db->error();
				echo $error->message;
			}
		}
	}

	public function updateRoad(){
		
	}

	public function deleteRoad(){
		
	}

	// Buat script untuk request data ke database 
	// untuk ngedapetin koordinat setiap titik polyline
	public function viewPolyline(){
		return true;
		//Data yang harus di return disini berisi id jalan dan koordinatnya.
	}
}
