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
		$_POST = json_decode(file_get_contents('php://input'), true);
		//var_dump($_POST);
		$name = $_POST["nama_jalan"];
		$length = $_POST["panjang_jalan"];
		$history = $_POST["riwayat_perbaikan_arr"];
		$lat_lng = $_POST["lat_lng_arr"];
		$time = date('Y-m-d H:i:s');
		//echo "Nama Jalan ".$name."<br> Repair Year ".$repair_history[0]["year"];

		// Insert nama jalan dan panjangnya.
		if(!$this->db->query("INSERT INTO tb_road(name, length, created_at) 
								VALUES (
									".$this->db->escape($name).", 
									$length, 
									".$this->db->escape($time)."
								);")){
			$error = $this->db->error();
			echo $error->message;
		}

		// Ambil id terakhir dari tb_road
		$road_id = $this->db->insert_id();

		// Insert riwayat perbaikan jalan secara berulang sebanyak data di array
		for($x=0; $x<count($history); $x++){
			$job = $history[$x]["job"];
			$district = $history[$x]["district"];
			$volume = $history[$x]["volume"];
			$volume_unit = $history[$x]["volume_unit"];
			$budget = $history[$x]["budget"];
			$budget_source = $history[$x]["budget_source"];
			$execution_sys = $history[$x]["execution_sys"];
			$start = $history[$x]["start"];
			$end = $history[$x]["end"];
			$executive = $history[$x]["executive"];
			$supervisor = $history[$x]["supervisor"];
			$planner = $history[$x]["planner"];

			if(!$this->db->query("INSERT INTO tb_road_repair_history(road_id, job, district, volume, volume_unit, budget, budget_source_id, execution_sys, `start`, `end`, executive, supervisor, planner, created_at) 
									VALUES (
										$road_id, 
										".$this->db->escape($job).", 
										".$this->db->escape($district).", 
										$volume, 
										".$this->db->escape($volume_unit).", 
										$budget,
										$budget_source,
										".$this->db->escape($execution_sys).", 
										".$this->db->escape($start).", 
										".$this->db->escape($end).", 
										".$this->db->escape($executive).", 
										".$this->db->escape($supervisor).", 
										".$this->db->escape($planner).", 
										".$this->db->escape($time)."
									);")){
				$error = $this->db->error();
				echo $error->message;
			}
		}

		// Insert koordinat secara berulang sebanyak data di array
		for($x=0; $x<count($lat_lng); $x++){
			$lat = $lat_lng[$x]["lat"];
			$lng = $lat_lng[$x]["lng"];
			if(!$this->db->query("INSERT INTO tb_road_coor(road_id, lat, lng, created_at) 
									VALUES (
										$road_id, 
										$lat, 
										$lng, 
										".$this->db->escape($time)."
										);")){
				$error = $this->db->error();
				echo $error->message;
			}
		}
	}

	public function updateRoad(){
		$_POST = json_decode(file_get_contents('php://input'), true);
		//var_dump($_POST);
		$road_id = $_POST["id"];
		$name = $_POST["nama_jalan"];
		$length = $_POST["panjang_jalan"];
		$history = $_POST["riwayat_perbaikan_arr"];
		//$lat_lng = $_POST["lat_lng_arr"];
		$time = date('Y-m-d H:i:s');
		//echo "Nama Jalan ".$name."<br> Repair Year ".$repair_history[0]["year"];

		// Insert nama jalan dan panjangnya.
		if(!$this->db->query("UPDATE tb_road SET 
								name = ".$this->db->escape($name).", length = $length, updated_at = ".$this->db->escape($time)." WHERE id = ;")){
			$error = $this->db->error();
			echo $error->message;
		}

		// Insert riwayat perbaikan jalan secara berulang sebanyak data di array
		for($x=0; $x<count($history); $x++){
			$history_id = $history[$x]["history_id"];
			$job = $history[$x]["job"];
			$district = $history[$x]["district"];
			$volume = $history[$x]["volume"];
			$volume_unit = $history[$x]["volume_unit"];
			$budget = $history[$x]["budget"];
			$budget_source = $history[$x]["budget_source"];
			$execution_sys = $history[$x]["execution_sys"];
			$start = $history[$x]["start"];
			$end = $history[$x]["end"];
			$executive = $history[$x]["executive"];
			$supervisor = $history[$x]["supervisor"];
			$planner = $history[$x]["planner"];

			if(!$this->db->query("UPDATE tb_road_repair_history SET
									job = ".$this->db->escape($job).", 
									district = ".$this->db->escape($district).", 
									volume = $volume, 
									volume_unit = ".$this->db->escape($volume_unit).", 
									budget = $budget, 
									budget_source_id = $budget_source, 
									execution_sys = ".$this->db->escape($execution_sys).", 
									`start` = ".$this->db->escape($start).", 
									`end` = ".$this->db->escape($end).", 
									executive = ".$this->db->escape($executive).", 
									supervisor = ".$this->db->escape($supervisor).", 
									planner = ".$this->db->escape($planner).", 
									updated_at =  ".$this->db->escape($time).";")){
				$error = $this->db->error();
				echo $error->message;
			}
		}

		// Insert koordinat secara berulang sebanyak data di array
		// for($x=0; $x<count($lat_lng); $x++){
		// 	$lat = $lat_lng[$x]["lat"];
		// 	$lng = $lat_lng[$x]["lng"];
		// 	if(!$this->db->query("INSERT INTO tb_road_coor(road_id, lat, lng, created_at) 
		// 							VALUES (
		// 								$road_id, 
		// 								$lat, 
		// 								$lng, 
		// 								".$this->db->escape($time)."
		// 								);")){
		// 		$error = $this->db->error();
		// 		echo $error->message;
		// 	}
		// }
	}

	public function deleteRoad(){
		
	}

	// Buat script untuk request data ke database 
	// untuk ngedapetin koordinat setiap titik polyline
	public function viewPolyline(){
		//Data yang harus di return disini berisi id jalan dan koordinatnya.
		$data = array();
		$road_id_query = $this->db->query("SELECT id FROM tb_road;");
		foreach ($road_id_query->result() as $road_row){
			$data["$road_row->id"]=array();
			$lat_lng_query = $this->db->query("SELECT lat, lng FROM tb_road_coor WHERE road_id=$road_row->id;");
			$lat_lng=array();
			$lat_lng_group=array();
			foreach ($lat_lng_query->result() as $lat_lng_row){
				$lat_lng["lat"] = $lat_lng_row->lat;
				$lat_lng["lng"] = $lat_lng_row->lng;
				array_push($lat_lng_group, $lat_lng);
			}
			$data["$road_row->id"] = $lat_lng_group;
		}
		echo json_encode($data);
	}

	public function getRoadInformation(){
		$_POST = json_decode(file_get_contents('php://input'), true);
		$data = array();
		$road_id = $_POST['id'];
		$road_query = $this->db->query("SELECT `name`, `length` FROM tb_road WHERE id = $road_id;");
		foreach ($road_query->result() as $road_row){
			$data["name"] = $road_row->name;
			$data["length"] = $road_row->length;
			$road_history_query = $this->db->query("SELECT id, job, district, volume, volume_unit, budget, budget_source_id, execution_sys, `start`, `end`, executive, supervisor, planner FROM tb_road_repair_history WHERE road_id = $road_id;");
			$history_arr = array();
			foreach ($road_history_query->result() as $road_history_row){
				$history = array();
				$history["id"] = $road_history_row->id;
				$history["job"] = $road_history_row->job;
				$history["district"] = $road_history_row->district;
				$history["volume"] = $road_history_row->volume;
				$history["volume_unit"] = $road_history_row->volume_unit;
				$history["budget"] = $road_history_row->budget;
				$history["budget_source_id"] = $road_history_row->budget_source_id;
				$history["execution_sys"] = $road_history_row->execution_sys;
				$history["start"] = $road_history_row->start;
				$history["end"] = $road_history_row->end;
				$history["executive"] = $road_history_row->executive;
				$history["supervisor"] = $road_history_row->supervisor;
				$history["planner"] = $road_history_row->planner;
				array_push($history_arr, $history);
			}
			$data["history"] = $history_arr;
		}
		echo json_encode($data);
	}

	public function getBudgetSource(){
		$data = array();
		$budget_source_query = $this->db->query("SELECT id, source FROM tb_budget_source;");
		foreach ($budget_source_query->result() as $source_row){
			$arr=array();
			$arr["id"] = $source_row->id;
			$arr["source"] = $source_row->source;
			array_push($data, $arr);
		}
		echo json_encode($data);
	}

	public function signIn(){
		$_POST = json_decode(file_get_contents('php://input'), true);
		$username = $_POST['username'];
		$password = $_POST['password'];
		$data = array();
		$signin_query = $this->db->query("SELECT id, email, `type` FROM tb_user 
			WHERE username = ".$this->db->escape($username)." AND `password` = ".$this->db->escape($password).";");
		if ($signin_query->num_rows()==1){
			foreach ($signin_query->result() as $signin_row){
				$data["id"] = $signin_row->id;
				$data["email"] = $signin_row->email;
				$data["type"] = $signin_row->type;
			}
			$this->session->set_userdata('user_id', $data["id"]);
			$this->session->set_userdata('user_type', $data["type"]);
		}
		echo json_encode($data);
	}

	public function getSession(){
		$data = array();
		$data["user_id"] = $this->session->userdata('user_id');
		$data["user_type"] = $this->session->userdata('user_type');
		echo json_encode($data);
	}

	public function destroySession(){
		$this->session->sess_destroy();
	}
}
