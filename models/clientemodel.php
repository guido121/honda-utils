<?php
include_once 'models/ClienteStruct.php';
include_once 'models/ClienteDestinatarioStruct.php';
class ClienteModel extends Model{
  public function __construct(){
    parent::__construct();
  }

  public function get(){
      $items = [];
      try{

        $query = $this->db->connect()->query("SELECT * FROM cliente");

        while($row =  $query->fetch()){
          $item = new ClienteStruct();
          $item->cliente_id  = $row['cliente_id'];
          $item->razon_social= $row['razon_social'];
          $item->codigo   = $row['codigo'];
          $item->activo   = $row['activo'];

          array_push($items, $item);
        }

        return $items;

      }catch(PDOException $e){
        return [];
      }
  }
  public function getById($id){
    $item = new ClienteStruct();
    $query =  $this->db->connect()->prepare("SELECT * FROM cliente WHERE  cliente_id = :cliente_id");
    try{
      $query->execute(['cliente_id' => $id]);

      while($row = $query->fetch()){
        $item->cliente_id = $row['cliente_id'];
        $item->razon_social = $row['razon_social'];
        $item->codigo = $row['codigo'];
        $item->activo = $row['activo'];
      }

      return $item;

    }catch(PDOException $e){
      return null;
    }
  }

  public function update($item){
    $query =  $this->db->connect()->prepare("UPDATE cliente SET razon_social = :razon_social, codigo = :codigo, activo = :activo WHERE cliente_id = :cliente_id");
    try{
      $query->execute([
        'cliente_id'    => $item['cliente_id'],
        'razon_social'  => $item['razon_social'],
        'codigo'        => $item['codigo'],
        'activo'        => $item['activo'],
      ]);

      return true;

    }catch(PDOException $e){
      return false;
    }
  }

  public function delete($id){
    $query =  $this->db->connect()->prepare("DELETE from cliente WHERE cliente_id = :id");
    try{
      $query->execute([
        'id' => $id,
      ]);

      return true;

    }catch(PDOException $e){
      return false;
    }
  }
  public function insert($datos){

    try{
      $query = $this->db->connect()->prepare('INSERT INTO cliente (RAZON_SOCIAL, CODIGO, ACTIVO) VALUES(:razon_social, :codigo, :activo)');
      $query->execute(['razon_social' => $datos['razon_social'], 'codigo' => $datos['codigo'], 'activo' => $datos['activo']]);
      return true;
      
    }catch(PDOException $e){
      //echo $e->getMessage();    
      return false;
    }
  }

  public function get_clients_info_by_codes($parametros)
  {
    //$items = [];

    $query = "SELECT A.cliente_id, A.razon_social,A.codigo,B.correo,CONCAT(B.nombres,' ',B.apellidos) AS name FROM cliente A INNER JOIN destinatarios B ON A.cliente_id = B.cliente_id WHERE A.activo = '1' AND B.activo = '1' AND codigo IN (";


    // Construir la cadena de marcadores de posición (?)
    $marcadores = implode(',', array_fill(0, count($parametros), '?'));

    // Concatenar los marcadores de posición a la consulta
    $query .= $marcadores . ")";

    try{
      // Preparar la consulta
      $stmt = $this->db->connect()->prepare($query);

      // Vincular los valores de los parámetros
      foreach ($parametros as $index => $valor) {
          $stmt->bindValue($index + 1, $valor);
      }

      // Ejecutar la consulta
      $stmt->execute();

      // Recuperar los resultados
      $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

      
      // Mostrar los resultados
      /*foreach ($resultados as $row) {

          $item = new ClienteDestinatarioStruct();
          $item->cliente_id = $row['cliente_id'];
          $item->razon_social = $row['razon_social'];
          $item->codigo = $row['codigo'];
          $item->correo = $row['correo'];
          $item->nombres = $row['nombres'];
          $item->apellidos = $row['apellidos'];

          $items[$row['codigo']] = $item;
      }*/

      return $resultados;
    }catch(PDOException $e){
      return [];
    }
  }
}
