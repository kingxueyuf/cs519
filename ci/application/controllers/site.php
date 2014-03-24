<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */