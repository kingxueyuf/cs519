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