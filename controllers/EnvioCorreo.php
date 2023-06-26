<?php

include_once 'models/ClienteModel.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class EnvioCorreo extends Controller{

  public $filepath;
  public $activesheetIndex;
  public $sheet;

  public $outputpath;

  public $filename;

  function __construct() {
    parent::__construct();
    
    $this->view->clientes = [];
    $this->outputpath = constant('URL') . 'public/storage/output_files';
  }

  function render(){
    $clientes = $this->model->get();
    $this->view->clientes = $clientes;
    $this->view->mensaje = "";
    $this->view->render('enviocorreo/index');
  }

  public function getSheet(){
    
    return $this->sheet->toArray();
  }

  function enviarcorreosmasivo(){

    //CONSTRUCTOR
    $fileType = $_FILES['data_file']['type'];
    //$tamanio = $_FILES['data_file']['size'];
    $fileName 		= $_FILES["data_file"]["name"];
    $archivotmp = $_FILES['data_file']['tmp_name'];
    
   

    $this->filepath = $archivotmp;
    $this->activesheetIndex = 0;
    $this->filename = $fileName;

    $loader = IOFactory::createReaderForFile($this->filepath); 
    $loader->setReadDataOnly(true);
    $reader = $loader->load($this->filepath);
    $this->sheet = $reader->setActiveSheetIndex($this->activesheetIndex);
    
    //Escribir archivos
    $clientes_excel_array =  $this->writeCustomerFiles();

    $clientes_actualizado_cruce_bd_array = $this->filtrarCompletarDatosClientesDestinatarios($clientes_excel_array);


    foreach($clientes_actualizado_cruce_bd_array as $row){
        $mensaje_correo = $this->enviar_correo(
          "Facturación BO con stock disponible - " . $row["razon_social"],
          $row["destinatarios"],
          "<html>
          <head>
          <style>
            p { font: small/1.5 Arial,Helvetica,sans-serif; }
            .tb { border-collapse: collapse; font: small/1.5 Arial,Helvetica,sans-serif; }
            .tb th, .tb td { padding: 5px; border: solid 1px #777; }
            .tb th { background-color: lightblue; }
            pre {font: small/1.5 Arial,Helvetica,sans-serif; color: #4f4f4f}
            .firmaNombre { font-weight:bold }
            .firmatexto { float: left; }
            .firmaimagen { float: left; margin: 0 15px; }
            .subtextofirma { font-size: 92% }
          </style>
          </head>
          <body>
          <p>Estimado Concesionario</p>
            <p>Buenos d&iacute;as, a continuaci&oacute;n le adjuntamos el detalle de los pedidos Back Orders que ingresaron en nuestro sistema SAP(Dealer Portal) y que ya se encuentran disponibles, por tal solicitamos que puedan realizar el pago cuanto antes. El total de sus BO&rsquo;s es <span>" . $row["subtotal"] . " </span> USD.</p>
            <p>As&iacute; mismo, adjuntamos las cuentas de Honda del Per&uacute; para procedan con el pago efectivo. Si ya realizaron el pago, favor omitir el correo.</p>
            <table class='tb'>
            <thead>
            <tr>
            <th>BANCO</th>
            <th>CUENTA</th>
            <th>MONEDA</th>
            <th>N&deg; CUENTA</th>
            <th>TIPO</th>
            <th>CCI</th>
            <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td>BCP</td>
            <td>REC</td>
            <td>DOLARES</td>
            <td>193-1172844-1-17</td>
            <td>RECAUDADORA</td>
            <td>00219300117284411718</td>
            <td>&nbsp;</td>
            </tr>
            <tr>
            <td>BCP</td>
            <td>REC</td>
            <td>SOLES</td>
            <td>193-0443060-0-53</td>
            <td>RECAUDADORA</td>
            <td>00219300044306005318</td>
            <td>&nbsp;</td>
            </tr>
            <tr>
            <td>BBVA</td>
            <td>CTA. CTE.</td>
            <td>DOLARES</td>
            <td>011-0686-35-0100003547</td>
            <td>RECAUDADORA</td>
            <td>011-686-00-01000003547-35</td>
            <td>Codigo 213</td>
            </tr>
            <tr>
            <td>BBVA</td>
            <td>CTA. CTE.</td>
            <td>SOLES</td>
            <td>011-0686-36-0100000483</td>
            <td>RECAUDADORA</td>
            <td>011-686-00-01000000483-36</td>
            <td>Codigo 212</td>
            </tr>
            <tr>
            <td>SCOTIABANK</td>
            <td>CTA. CTE.</td>
            <td>DOLARES</td>
            <td>00-001-103-2948-71</td>
            <td>NORMAL</td>
            <td>00900100110329487190</td>
            <td>&nbsp;</td>
            </tr>
            <tr>
            <td>SCOTIABANK</td>
            <td>CTA. CTE.</td>
            <td>SOLES</td>
            <td>00-001-103-1845-35</td>
            <td>RECAUDADORA</td>
            <td>00900100010318453595</td>
            <td>&nbsp;</td>
            </tr>
            </tbody>
            </table>
            <br>
            <p>Gracias</p>
            <br>
            <p>Saludos Cordiales</p>
            <br>
            <div class='firma'> 
            <div class='firmatexto'>
            <pre><span class='firmaNombre'>Daniela Chavez</span>
<span class='subtextofirma'>Asistente de Exportaciones
Motorcycle Division |  Honda del Per&uacute; S. A.
Phone: (511) 418-0418
Cell phone: (051) 961 564 390
Address: Av. Elmer Faucett 3737 Callao - Per&uacute;
E-mail: : <a href='mailto:daniela_chavez@honda.com.pe'>Daniela_Chavez@honda.com.pe</a>
</span>
<a href='https://www.honda.com.pe'>www.honda.com.pe</a>

</pre>
            </div>
            <div class='firmaimagen'>
              <img src='https://i.postimg.cc/XYz2PZyc/hondaperu.jpg'>
            </div>
</div>
</body>
</html>
",
          "Texto alternativo",
          [
            ["path" => $row["path"], "name" => $row["codigo"] .".xlsx"]
          ]
        );
    }

    $this->view->mensaje = $mensaje_correo;
    $this->view->render("enviocorreo/index");
  }

  public function filtrarCompletarDatosClientesDestinatarios($clientes_array){
    
    $resultado = array();

    $codigos_cliente = array_keys($clientes_array);

    $objCliente = new ClienteModel();
    
    $client_info = $objCliente->get_clients_info_by_codes($codigos_cliente);

    $resultado1 = array();

    foreach ($client_info as $item) {
        $cliente_id = $item['cliente_id'];
        $razon_social = $item['razon_social'];
        $codigo = $item['codigo'];
        $correo = $item['correo'];
        $name = $item['name'];

        $encontrado = false;

        foreach ($resultado1 as &$item2) {
            if ($item2['cliente_id'] == $cliente_id && $item2['razon_social'] == $razon_social && $item2['codigo'] == $codigo) {
                $item2['destinatarios'][] = array('correo' => $correo, 'name' => $name);
                $encontrado = true;
                break;
            }
        }

        if (!$encontrado) {
            $resultado1[] = array('cliente_id' => $cliente_id, 'razon_social' => $razon_social,  'codigo' => $codigo, 'destinatarios' => array(array('correo' => $correo, 'name' => $name)));
        }
    }

    //var_dump($resultado1);
    //echo "<br>";
    //echo "<br>";
    //var_dump($clientes_array);
    //die();
    $resultado2 = array();
    
    foreach ($resultado1 as $item1) {
        $codigo = $item1['codigo'];

        foreach ($clientes_array as $item2) {
             
            if ($item2["codigocliente"] == $codigo) {
                //print_r($item2[$codigo]);
                $item3 = $item1;
                $item3['path'] = $item2['path'];
                $item3['subtotal'] = $item2['subtotal'];
                $resultado2[] = $item3;
                break;
            }
        }
    }
    
    return $resultado2;
  }

   public function writeCustomerFiles(){
    $obj_sheet = $this->getSheet();

    //Get Header
    $header = $obj_sheet[0];

    //$header = array_filter($header, fn($value) => !is_null($value) && $value !== '');
    
    //Get unique client CODES 
    unset($obj_sheet[0]);
    
    // Se obtienen los codigos unicos de cliente 
    $client_codes = [];
    foreach($obj_sheet as $row){
      array_push($client_codes,$row[8]);
    }
    $client_codes_unique = array_unique($client_codes);

    //Organiza la data en array con llave de codigo de cliente
    $result = array();
    foreach($obj_sheet as $data){
      $client_code = $data[8];
      if(!array_key_exists($client_code,$result)){
        $result[$client_code] = array();  
      }
      array_push($result[$client_code],$data);

    }

    $resultado_final = array();

    foreach($result as $clientcode=>$row){
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
      
      $filepath = "public/storage/output_files/$clientcode.xlsx";

      $writer = new Xlsx($spreadsheet);
      //$writer->save("public/storage/output_files/$clientecode - $this->filename");  
      $writer->save($filepath);  
      
      
      $resultado_final[$clientcode] = [ 
          "path" => $filepath,
          "subtotal" => $subtotal,
          "codigocliente" => $clientcode,
          "razonsocial" => "",
          "destinatarios" => array()
      ];

    }
    
    return $resultado_final;

  }

  function enviar_correo($subject,$recipients,$message,$alternative_text,$attachments){
      //Create an instance; passing `true` enables exceptions
      $mail = new PHPMailer(true);

      try {
          $mail->isSMTP();                                            //Send using SMTP  
        //Server settings
          $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;                      //Enable verbose debug output

          $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
          $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
          
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption

          $mail->SMTPAuth   = true;                                   //Enable SMTP authentication

          $email = '';
          $mail->Username   = $email;                           //SMTP username
          $mail->Password   = '';                               //SMTP password
          
          

          //Recipients
          $mail->setFrom($email, 'Luis Palacin');

          //$mail->addReplyTo('daniela-ch@hotmail.com', 'Daniela Chavez');

          foreach($recipients as $recipient){
            $mail->addAddress($recipient["correo"], $recipient["name"]);     //Add a recipient
          }
          

          
          //$mail->addCC('cc@example.com');
          //$mail->addBCC('bcc@example.com');

          //Content
          $mail->Subject = $subject;

          $mail->isHTML(true);                                  //Set email format to HTML
          $mail->CharSet = 'UTF-8'; 
          
          $mail->Body    = $message;
          //Texto Alternativo
          $mail->AltBody = $alternative_text;

           //Attachments
          foreach($attachments as $attachment){
            $mail->addAttachment($attachment["path"],$attachment["name"]);         //Add attachments
          }

          if(!$mail->send()){
            throw new Exception($mail->ErrorInfo);
          }
          
          return "Se enviaron los correos de manera correcta.";
          
      } catch (Exception $e) {
          return $e->getMessage();
      }

  }
}