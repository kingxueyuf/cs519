<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//防止用户直接访问该类文件


class Site extends CI_Controller {

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
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		echo "hi internet";
		$this->hello();
		$this->addStuff();
	}

	public function hello()
	{
		echo "something else";
	}

	public function addStuff()
	{
		$this->load->model("math");
		$res = $this->math->add(2,2);
		// echo "here";
		$this->outputJSON($res);
		// echo "finish call";
	}

	public function dashboard()
	{
		// echo "here";
		$this->load->view("dashboard.html");
	}

	public function map()
	{
		$this->load->view("map.html");
	}

	public function maptest()
	{
		$this->load->view("maptest.html");
	}

	public function export()
	{
		$this->load->view("export_excel.html");
	}
	//http://localhost:8888/ci/index.php/site/temperature
	public function temperature()
	{
		$this->load->model("dbinterface");//load by file name instead of class name
		$res = $this->dbinterface->getTemperature();
		$this->outputJSON($res);
	}

	//http://localhost:8888/ci/index.php/site/altitude
	public function altitude()
	{
		$this->load->model("dbinterface");//load by file name instead of class name
		$res = $this->dbinterface->getAltitude();
		$this->outputJSON($res);
	}

	//http://localhost:8888/ci/index.php/site/humidity
	public function humidity()
	{
		$this->load->model("dbinterface");//load by file name instead of class name
		$res = $this->dbinterface->getHumidity();
		$this->outputJSON($res);
	}

	//http://localhost:8888/ci/index.php/site/addtemperature?data=111
	public function addtemperature()
	{
		$input = array_merge($_POST,$_GET);
		$data = $input['data'];

		$this->load->model("dbinterface");//load by file name instead of class name
		$res = $this->dbinterface->addTemperature($data);
		$this->outputJSON($res);
	}

	//http://localhost:8888/ci/index.php/site/addaltitude?data=111
	public function addaltitude()
	{
		$input = array_merge($_POST,$_GET);
		$data = $input['data'];

		$this->load->model("dbinterface");//load by file name instead of class name
		$res = $this->dbinterface->addAltitude($data);
		$this->outputJSON($res);
	}

	
	public function addhumidity()
	{
		$input = array_merge($_POST,$_GET);
		$data = $input['data'];

		$this->load->model("dbinterface");//load by file name instead of class name
		$res = $this->dbinterface->addHumidity($data);
		$this->outputJSON($res);
	}


	//http://localhost:8888/ci/index.php/site/add?data=temperature_altitude_humidity_pressure_latitude_longitude_uid
	//http://localhost:8888/ci/index.php/site/add?data=72.2463_911.617_35.9006_10.0_43.81_-91.23_1
	//http://138.49.196.13/ci/index.php/site/add?data=temperature_altitude_humidity_pressure_latitude_longitude_uid
	public function add()
	{
		$input = array_merge($_POST,$_GET);
		$data = $input['data'];

		$arr = explode("_",$data);

		$this->load->model("dbinterface");//load by file name instead of class name


		$temperature = $arr[0];
		$altitude = $arr[1];
		$humidity = $arr[2];
		$pressure = $arr[3];
		$latitude = $arr[4];
		$longitude = $arr[5];
		$uid = $arr[6];


		$insert_arr = array("temperature" => $temperature,
			"altitude" => $altitude,
			"humidity" => $humidity,
			"pressure" => $pressure,
			"latitude" => $latitude,
			"longitude" => $longitude,
			"uid" => $uid);

		$res = $this->dbinterface->add($insert_arr);
		$this->outputJSON($res);
	}


	//http://localhost:8888/ci/index.php/site/data?uid=1&date=2014-04-15
	public function data()
	{
		$input = array_merge($_POST,$_GET);
		$uid = $input['uid'];
		/*
		 * start_date with this format Y-M-D 2014-04-10 
		 */
		$start_date = $input['date'];

		// echo $start_date;
		
		$end_date = date('Y-m-d', strtotime($start_date . ' + 1 day'));

		// echo $end_date;

		$this->load->model("dbinterface");//load by file name instead of class name

		$res = $this->dbinterface->get($uid,$start_date,$end_date);

		// echo "call filter_data() \n";
		$this->filter_data($res);
		// echo "finish call \n";

	}

	private function filter_data($res)
	{
		$res_array = array();
		$last_hour = -1;
		foreach($res->result() as $row)
		{
			$date = $row->date;
			$date = strtotime($date);
			$hour = date('H', $date);
			$hour = intval($hour);
			if( $hour != $last_hour )
			{
				$temp = array("id"=>$row->id,
				 				"altitude" =>$row->altitude,
				 				"humidity"=>$row->humidity,
				 				"temperature"=>$row->temperature,
				 				"latitude"=>$row->latitude,
				 				"longitude"=>$row->longitude,
				 				"pressure"=>$row->pressure,
				 				"date"=>$hour,
				 				"uid"=>$row->uid);
				array_push($res_array,$temp);
				$last_hour = $hour;
			}
		}
		echo json_encode($res_array);
	}

	//http://localhost:8888/ci/index.php/site/list?uid=1&page=1
	public function page()
	{
		$input = array_merge($_POST,$_GET);
		$uid = $input['uid'];
		$page = $input['page'];

		$uid = intval($uid);
		$page = intval($page);
		$this->load->model("dbinterface");//load by file name instead of class name

		$res = $this->dbinterface->getByPage($uid,$page);
		$this->outputJSON2($res);
	}

	function outputJSON($res)
	{
		// echo "outputJson";S
		$res_array = array();
		if($res ==false)
		{
			echo "failure";
		}else
		{
			foreach($res->result() as $row)
			{
				 $temp = array("id"=>$row->id,
				 				"data" =>$row->data,
				 				"date"=>$row->date);
				 array_push($res_array,$temp);
			}
		}
		echo json_encode($res_array);
	}

	function outputJSON2($res)
	{
		// echo "outputJson";S
		$res_array = array();
		if($res ==false)
		{
			echo "failure";
		}else
		{
			foreach($res->result() as $row)
			{
				 $temp = array("id"=>$row->id,
				 				"altitude" =>$row->altitude,
				 				"humidity"=>$row->humidity,
				 				"temperature"=>$row->temperature,
				 				"latitude"=>$row->latitude,
				 				"longitude"=>$row->longitude,
				 				"pressure"=>$row->pressure,
				 				"date"=>$row->date,
				 				"uid"=>$row->uid);
				 array_push($res_array,$temp);
			}
		}
		echo json_encode($res_array);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */