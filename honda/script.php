<?php

//include_once("use_imports.php");
use PhpOffice\PhpSpreadsheet\IOFactory;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;

require_once"vendor/autoload.php";

class HondaExcelUtils
{
  public $filepath;
  public $activesheetIndex;
  public $sheet;
  function  __construct($filename,$activeSheetIndex){
    $this->filepath = $filename;
    $this->activesheetIndex = $activeSheetIndex;
    $loader = IOFactory::createReaderForFile($this->filepath); 
    $loader->setReadDataOnly(true);
    $reader = $loader->load($this->filepath);
    $this->sheet = $reader->setActiveSheetIndex($activeSheetIndex);
  }

  public function getSheet(){
    
    return $this->sheet->toArray();
  }

  public function writeCustomerFiles(){
    $obj_sheet = $this->getSheet();

    //Get Header
    $header = $obj_sheet[0];

    //$header = array_filter($header, fn($value) => !is_null($value) && $value !== '');
    
    //Get unique client CODES 
    unset($obj_sheet[0]);
    
    $client_codes = [];
    foreach($obj_sheet as $row){
      array_push($client_codes,$row[8]);
    }
    $client_codes_unique = array_unique($client_codes);

    //Get dataset by client codes
    $result = array();
    foreach($obj_sheet as $data){
      $client_code = $data[8];
      if(!array_key_exists($client_code,$result)){
        $result[$client_code] = array();  
      }
      array_push($result[$client_code],$data);

    }

    foreach($result as $key0=>$row){
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();

        
	  $subtotal = 0;
      foreach($row as $key=>$data_row){
        $sheet->setCellValue("A".($key+2),$data_row[0]);
        $sheet->setCellValue("B".($key+2),$data_row[1]);
        $sheet->setCellValue("C".($key+2),$data_row[2]);
        $sheet->setCellValue("D".($key+2),$data_row[3]);
        $sheet->setCellValue("E".($key+2),$data_row[4]);
        $sheet->setCellValue("F".($key+2),$data_row[5]);
        $sheet->setCellValue("G".($key+2),$data_row[6]);
        $sheet->setCellValue("H".($key+2),$data_row[7]);
        $sheet->setCellValue("I".($key+2),$data_row[8]);
        $sheet->setCellValue("J".($key+2),$data_row[9]);
        $sheet->setCellValue("K".($key+2),$data_row[10]);
        $sheet->setCellValue("L".($key+2),$data_row[11]);
        $sheet->setCellValue("M".($key+2),$data_row[12]);
        $sheet->setCellValue("N".($key+2),$data_row[13]);
        $sheet->setCellValue("O".($key+2),$data_row[14]);
        $sheet->setCellValue("P".($key+2),$data_row[15]);
        $sheet->setCellValue("Q".($key+2),$data_row[16]);
        $sheet->setCellValue("R".($key+2),$data_row[17]);
		
		$monto = $data_row[18];
        $sheet->setCellValue("S".($key+2),round($monto,2));
		$subtotal += $monto;
        //$sheet->setCellValue("T".($key+2),$data_row[19]);
		    
      }
	  
	  $sheet->setCellValue("A1",'Posición');
        $sheet->setCellValue("B1",'N° Pedido');
        $sheet->setCellValue("C1",'Fecha de Pedido');
        $sheet->setCellValue("D1",'Código de Cliente');
        $sheet->setCellValue("E1",'Clase de pedido');
        $sheet->setCellValue("F1",'Se');
        $sheet->setCellValue("G1",'CPag');
        $sheet->setCellValue("H1",'Texto:Bloqueo de nota de entrega cabecer');
        $sheet->setCellValue("I1",'PAGADOR');
        $sheet->setCellValue("J1",'CLIENTE');
        $sheet->setCellValue("K1",'REGIONAL');
        $sheet->setCellValue("L1",'Código de Material');
        $sheet->setCellValue("M1",'Reemplazo final');
        $sheet->setCellValue("N1",'Cantidad Pendiente de atención (Back Order)');
        $sheet->setCellValue("O1",'Frecuencia');
        $sheet->setCellValue("P1",'Status');
        $sheet->setCellValue("Q1",'Qty');
        $sheet->setCellValue("R1",'Valor por atender (USD)');
        $sheet->setCellValue("S1","$ ".round($subtotal,2));
        //$sheet->setCellValue("T1",'WP');

		$sheet
		->getStyle('A1:S1')
		->getFill()
		->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
		->getStartColor()
		->setARGB('BCD6FD');
		
		$sheet
		->getStyle('I1:K1')
		->getFill()
		->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
		->getStartColor()
		->setARGB('88F99E');
		
		$sheet
		->getStyle('L1:Q1')
		->getFill()
		->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
		->getStartColor()
		->setARGB('BCD6FD');
		
		$sheet
		->getStyle('R1:S1')
		->getFill()
		->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
		->getStartColor()
		->setARGB('EEFF91');
		
		$writer = new Xlsx($spreadsheet);
		$writer->save("output_files/$key0 - Stock disponible por atender.xlsx");  
		
		
    }

    
    //foreach($client_codes_unique as $client){

      //$writer = IOFactory::createWriter($spreadsheet, "Xlsx");
      //$writer->save("05featuredemo.xlsx");
    //}





  }
}

$object = new HondaExcelUtils("input_files/Copia de Reporte BO clientes 09.11.xlsx",0);

$object->writeCustomerFiles();

echo "Se crearon los archivos de salida.";

?>
<style>
  table,th, td{
    border:1px solid black;
  }
</style>
