<?php


class Cliente extends Controller{

  function __construct() {
    parent::__construct();
    
    $this->view->clientes = [];
  
  }

  function render(){
    $clientes = $this->model->get();
    $this->view->clientes = $clientes;
    $this->view->render('cliente/index');
  }

  function nuevoCliente(){
    
    //$this->view->alumno = $alumno;
    $this->view->mensaje = "";
    $this->view->render('cliente/nuevocliente');
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

  function registrarCliente(){
    $razon_social = $_POST['razon_social'];
    $codigo = $_POST['codigo'];
    $activo = "1";

    $mensaje = "";

    if($this->model->insert(['razon_social' => $razon_social, 'codigo' => $codigo, 'activo' => $activo])){
      $mensaje = "Nuevo Cliente creado";
    }else{
      $mensaje = "El cliente ya existe";
    }

    $this->view->mensaje = $mensaje;
    $this->render();

  }
}