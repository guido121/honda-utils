<?php
include_once 'models/DestinatarioStruct.php';
class DestinatarioModel extends Model{
  public function __construct(){
    parent::__construct();
  }

  public function get(){
      $items = [];
      try{

        $query = $this->db->connect()->query("SELECT * FROM destinatarios");

        while($row =  $query->fetch()){
          $item = new DestinatarioStruct();
          $item->destinatario_id  = $row['destinatario_id'];
          $item->nombres= $row['nombres'];
          $item->apellidos   = $row['apellidos'];
          $item->correo   = $row['correo'];
          $item->activo   = $row['activo'];
          $item->cliente_id   = $row['cliente_id'];

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
      $query = $this->db->connect()->prepare('INSERT INTO destinatarios (nombres,apellidos,correo,activo,cliente_id) VALUES(:nombres, :apellidos,:correo, :activo, :cliente_id)');
      $query->execute(['nombres' => $datos['nombres'], 'apellidos' => $datos['apellidos'], 'correo' => $datos['correo'], 'activo' => $datos['activo'], 'cliente_id' => $datos['cliente_id']]);
      return true;
      
    }catch(PDOException $e){
      //echo $e->getMessage();    
      return false;
    }
  }
}