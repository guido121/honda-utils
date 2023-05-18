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

  function verCliente($param = null){
    $cliente_id= $param[0];
    $cliente = $this->model->getById($cliente_id);
    
    session_start();
    $_SESSION['cliente_id'] = $cliente->cliente_id;
    $this->view->cliente = $cliente;
    $this->view->mensaje = "";
    $this->view->render('cliente/detalle');
  }

  function actualizarCliente(){
    session_start();
    $cliente_id = $_SESSION['cliente_id'];
    $razon_social = $_POST['razon_social'];
    $codigo = $_POST['codigo'];
    $activo = $_POST['activo'];

    unset($_SESSION['id_verAlumno']);

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