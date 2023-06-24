<?php
include_once 'models/ClienteModel.php';

class Destinatario extends Controller{

  function __construct() {
    parent::__construct();
    
    $this->view->destinatarios = [];
  
  }

  function render(){
    $destinatarios = $this->model->get();
    $this->view->destinatarios = $destinatarios;
    $this->view->render('destinatario/index');
  }

  function nuevoDestinatario(){
    //$this->view->alumno = $alumno;
    $clienteModelObj = new ClienteModel();
    $this->view->clientes = $clienteModelObj->get();
    $this->view->mensaje = "";
    $this->view->render('destinatario/nuevo');
  }

  function verDestinatario($param = null){
    $destinatario_id= $param[0];
    $destinatario = $this->model->getById($destinatario_id);
    
    session_start();
    $_SESSION['destinatario_id'] = $destinatario->destinatario_id;
    $clienteModelObj = new ClienteModel();
    $this->view->clientes = $clienteModelObj->get();
    $this->view->destinatario = $destinatario;
    $this->view->mensaje = "";
    $this->view->render('destinatario/detalle');
  }

  function actualizarDestinatario(){
    session_start();
    $destinatario_id = $_SESSION['destinatario_id'];
    $nombres    = $_POST['nombres'];
    $apellidos  = $_POST['apellidos'];
    $correo     = $_POST['correo'];
    $activo     = $_POST['activo'];
    $cliente_id = $_POST['cliente_id'];

    unset($_SESSION['destinatario_id']);

    if($this->model->update(['destinatario_id' => $destinatario_id, 'nombres' => $nombres, 'apellidos' => $apellidos, 'correo' => $correo, 'activo' => $activo, 'cliente_id' => $cliente_id])){
      $destinatario = new DestinatarioStruct();
      $destinatario->destinatario_id    = $destinatario_id;
      $destinatario->nombres            = $nombres;
      $destinatario->apellidos          = $apellidos;
      $destinatario->correo             = $correo;
      $destinatario->activo             = $activo;
      $destinatario->cliente_id         = $cliente_id;
      
      $clienteModelObj = new ClienteModel();
      $this->view->clientes = $clienteModelObj->get();
      $this->view->destinatario = $destinatario;
      
      $this->view->mensaje = "Destinatario actualizado correctamente";
    }else{
      $this->view->mensaje = "No se pudo actualizar el destinatario";
    }
    $this->view->render("destinatario/detalle");

  }

  function eliminarDestinatario($param = null){
    $destinatario_id = $param[0];
    
    if($this->model->delete($destinatario_id)){
      $this->view->mensaje = "Destinatario eliminado correctamente";
    }else{
      $this->view->mensaje = "No se pudo eliminar el Destinatario";
    }
    $this->render();

  }

  function registrarDestinatario(){
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $activo = "1";
    $cliente_id = $_POST['cliente_id'];


    $mensaje = "";

    if($this->model->insert(['nombres' => $nombres, 'apellidos' => $apellidos, 'correo' => $correo, 'activo' => $activo, 'cliente_id' => $cliente_id])){
      $mensaje = "Nuevo destinatario creado";
    }else{
      $mensaje = "El destinatario ya existe";
    }

    $this->view->mensaje = $mensaje;
    $this->render();

  }
}