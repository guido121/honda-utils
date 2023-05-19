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
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $activo = $_POST['activo'];
    $cliente_id = $_POST['cliente_id'];

    unset($_SESSION['destinatario_id']);

    if($this->model->update(['cliente_id' => $cliente_id, 'razon_social' => $razon_social, 'codigo' => $codigo, 'activo' => $activo])){
      $cliente = new ClienteStruct();
      $cliente->razon_social = $razon_social;
      $cliente->codigo = $codigo;
      $cliente->activo = $activo;

      $this->view->cliente = $cliente;
      $this->view->mensaje = "Alumno actualizado correctamente";
    }else{
      $this->view->mensaje = "No se pudo actualizar el alumno";
    }
    $this->view->render("cliente/detalle");

  }

  function eliminarCliente($param = null){
    $cliente_id = $param[0];
    
    if($this->model->delete($cliente_id)){
      $this->view->mensaje = "Cliente eliminado correctamente";
    }else{
      $this->view->mensaje = "No se pudo eliminar el cliente";
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