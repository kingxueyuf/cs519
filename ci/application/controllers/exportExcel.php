<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//防止用户直接访问该类文件


class ExportExcel extends CI_Controller {


	public function excel()
	{
		$input = array_merge($_POST,$_GET);
		$from = $input['from'];
		$to = $input['to'];

		$this->load->model("dbinterface");//load by file name instead of class name

		$res = $this->dbinterface->get("1",$from,$to);

		// echo "here1";
		// $myDir = "myDir";
		// if(!file_exists($myDir))
		// {
		// 	mkdir($myDir,0777);
		// }
		// file_put_contents($myDir."/test.txt","hello file");

		$this->write_excel($res);

		$this->load->helper('download');

		$file_dir = "/tmp/weather_data.xlsx";
		$data = file_get_contents($file_dir);
		// echo "here 1";
		$name = $from."_".$to.".xlsx";

		force_download($name, $data);

	// 	echo $from;
	// 	echo $to;
	}

	public function write_excel($res)
	{
		/** Error reporting */
		error_reporting(E_ALL);
		/** Include path **/
		ini_set('include_path', ini_get('include_path').';../Classes/');
		/** PHPExcel */
		include 'PHPExcel.php';
		/** PHPExcel_Writer_Excel2007 */
		include 'PHPExcel/Writer/Excel2007.php';
		// Create new PHPExcel object
		// echo date('H:i:s') . " Create new PHPExcel object\n";
		$objPHPExcel = new PHPExcel();

		// Set properties
		// echo date('H:i:s') . " Set properties\n";
		$objPHPExcel->getProperties()->setCreator("Robin xue");
		$objPHPExcel->getProperties()->setLastModifiedBy("Robin xue");
		$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Document");
		$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Document");
		$objPHPExcel->getProperties()->setDescription("UWL Weather Station Data.");


		// Add some data
		// echo date('H:i:s') . " Add some data\n";
		$objPHPExcel->setActiveSheetIndex(0);

		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'id');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'altitude');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'humidity');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'temperature');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'latitude');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'longitude');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'pressure');
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'date');
		$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'uid');

	 	$row_position = 2;
		foreach($res->result() as $row)
		{
			// echo $row->altitude;
			$objPHPExcel->getActiveSheet()->SetCellValue("A".$row_position, $row->id);
			$objPHPExcel->getActiveSheet()->SetCellValue("B".$row_position, $row->altitude);
			$objPHPExcel->getActiveSheet()->SetCellValue("C".$row_position, $row->humidity);
			$objPHPExcel->getActiveSheet()->SetCellValue("D".$row_position, $row->temperature);
			$objPHPExcel->getActiveSheet()->SetCellValue("E".$row_position, $row->latitude);
			$objPHPExcel->getActiveSheet()->SetCellValue("F".$row_position, $row->longitude);
			$objPHPExcel->getActiveSheet()->SetCellValue("G".$row_position, $row->pressure);
			$objPHPExcel->getActiveSheet()->SetCellValue("H".$row_position, $row->date);
			$objPHPExcel->getActiveSheet()->SetCellValue("I".$row_position, $row->uid);
			$row_position++;
		}
		// Rename sheet
		// echo date('H:i:s') . " Rename sheet\n";
		$objPHPExcel->getActiveSheet()->setTitle('Weather Data');

				
		// Save Excel 2007 file
		// echo date('H:i:s') . " Write to Excel2007 format\n";
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		// $dir = getcwd();
		// $dir .= "/myDir/exportExcel.xlsx";
		// echo $dir;
		$file_dir ="/tmp/weather_data.xlsx";
		$objWriter->save($file_dir);

		// Echo done
		// echo date('H:i:s') . " Done writing file.\r\n";
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */