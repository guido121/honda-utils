<style>
  table,th, td{
    border:1px solid black;
  }
</style>
<?php


require_once"vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;

$rutaArchivo = "files/Copia de Reporte BO clientes 09.11.xlsx";

$documento = IOFactory::load($rutaArchivo);

$totalDeHojas = $documento->getSheetCount();

for ($indiceHoja = 0; $indiceHoja < $totalDeHojas; $indiceHoja++) {

  $hojaActual = $documento->getSheet($indiceHoja);
  echo "<h3>Vamos en la hoja con índice $indiceHoja</h3>";

  echo "<table>";
  foreach($hojaActual->getRowIterator() as $fila) {
    echo "<tr>";
    foreach($fila->getCellIterator() as $celda) {
       
      $valorRaw = $celda->getValue();

      echo "<td>$valorRaw</td>"; 

      $valorFormateado = $celda->getFormattedValue();
      
      $valorCalculado = $celda->getCalculatedValue();

      $fila = $celda->getRow();
      $columna = $celda->getColumn();

      //echo "En <strong>$columna$fila</strong> tenemos el valor <strong>$valorRaw</strong>.";
      //echo "Calculado es: <strong>$valorCalculado</strong><br><br";
    }
    echo "</tr>";
  }
  echo "</table>";
}