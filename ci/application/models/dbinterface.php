<?php


	class Dbinterface extends CI_Model{


		/*
		 * constructer()
		 */
		function __construct()
		{
			parent::__construct();
			$this->load->database();//链接数据库

		}


		public function addTemperature($data)
		{

			$sql = "INSERT INTO temperature (data) VALUES ( $data )";
			$res = $this->db->query($sql);
			return $res;
		}

		public function addHumidity($data)
		{

			$sql = "INSERT INTO humidity (data) VALUES ( $data )";
			$res = $this->db->query($sql);
			return $res;
		}

		public function addAltitude($data)
		{

			$sql = "INSERT INTO altitude (data) VALUES ( $data )";
			$res = $this->db->query($sql);
			return $res;
		}

		public function add($data)
		{
			$temperature = $data['temperature'];
			$altitude = $data['altitude'];
			$humidity = $data['humidity'];
			$pressure = $data['pressure'];
			$latitude = $data['latitude'];
			$longitude = $data['longitude'];
			$uid = $data['uid'];

			$sql = "INSERT INTO air_quality (altitude,humidity,temperature,latitude,longitude,pressure,uid) VALUES ( $altitude,$humidity,$temperature,$latitude,$longitude,$pressure,$uid)";
			// echo $sql;
			$res = $this->db->query($sql);
			return $res;
		}

		public function get($uid,$start_date,$end_date)
		{
			$sql = "SELECT * FROM air_quality WHERE uid = $uid AND date > '$start_date' and date < '$end_date'";
			// echo $sql;
			$res = $this->db->query($sql);
			return $res;
		}

		public function getByPage($uid,$page)
		{
			$start = ($page-1)*5;
			$sql = "SELECT * FROM air_quality WHERE uid = $uid ORDER BY date DESC limit $start, 5";
			$res = $this->db->query($sql);
			return $res; 
		}
		
		public function getTemperature()
		{

			$sql = "select * from temperature";
			$res = $this->db->query($sql);
			return $res;
		}

		public function getHumidity()
		{
			$sql = "select * from humidity";
			$res = $this->db->query($sql);
			return $res;
		}

		public function getAltitude()
		{
			$sql = "select * from altitude";
			$res = $this->db->query($sql);
			return $res;
		}

	}

?>