<?php
include_once 'models/DestinatarioStruct.php';
class DestinatarioModel extends Model{
  public function __construct(){
    parent::__construct();
  }

  public function get(){
      $items = [];
      try{

        $query = $this->db->connect()->query("SELECT a.destinatario_id,a.nombres,a.apellidos,a.correo,a.activo,a.cliente_id,b.razon_social FROM destinatarios a LEFT JOIN cliente b ON a.cliente_id = b.cliente_id");

        while($row =  $query->fetch()){
          $item = new DestinatarioStruct();
          $item->destinatario_id  = $row['destinatario_id'];
          $item->nombres= $row['nombres'];
          $item->apellidos   = $row['apellidos'];
          $item->correo   = $row['correo'];
          $item->activo   = $row['activo'];
          $item->cliente_id   = $row['cliente_id'];
          $item->razon_social   = $row['razon_social'];

          array_push($items, $item);
        }

        return $items;

      }catch(PDOException $e){
        return [];
      }
  }
  public function getById($id){
    $item = new DestinatarioStruct();
    $query =  $this->db->connect()->prepare("SELECT a.destinatario_id,a.nombres,a.apellidos,a.correo,a.activo,a.cliente_id,b.razon_social FROM destinatarios a LEFT JOIN cliente b ON a.cliente_id = b.cliente_id WHERE  a.destinatario_id = :destinatario_id");
    try{
      $query->execute(['destinatario_id' => $id]);

      while($row = $query->fetch()){
        $item->destinatario_id = $row['destinatario_id'];
        $item->nombres = $row['nombres'];
        $item->apellidos = $row['apellidos'];
        $item->correo = $row['correo'];
        $item->activo = $row['activo'];
        $item->cliente_id = $row['cliente_id'];
      }

      return $item;

    }catch(PDOException $e){
      return null;
    }
  }

  public function update($item){
    $query =  $this->db->connect()->prepare("UPDATE destinatarios SET nombres = :nombres, apellidos = :apellidos, correo = :correo,  activo = :activo,  cliente_id = :cliente_id  WHERE destinatario_id = :destinatario_id");
    try{
      $query->execute([
        'destinatario_id'   => $item['destinatario_id'],
        'nombres'           => $item['nombres'],
        'apellidos'         => $item['apellidos'],
        'correo'            => $item['correo'],
        'activo'            => $item['activo'],
        'cliente_id'        => $item['cliente_id'],
      ]);

      return true;

    }catch(PDOException $e){
      return false;
    }
  }

  public function delete($id){

    $query =  $this->db->connect()->prepare("DELETE from destinatarios WHERE destinatario_id = :id");
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