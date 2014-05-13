<?php

class Math extends CI_Model{

	function __construct()
	{
		parent::__construct();
		$this->load->database();//链接数据库

	}

	public function add($val1,$val2)
	{
		// return $val1 + $val2;
		echo "add here";
		$sql = "select * from temperature";
		$res = $this->db->query($sql);
		echo $sql;
		echo "add finish";
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