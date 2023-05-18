<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>  
    <?php require "views/header.php"; ?>

  <div id="main">
    <h1 class="center">Sección de Clientes</h1>
    <br>
    <div>
      <a href="<?php echo constant('URL') . 'cliente/nuevoCliente' ?>">Nuevo Cliente</a>
    </div>
    <br>
    <table width="100%">
      <thead>
        <tr>
          <th>Id</th>
          <th>Razón Social</th>
          <th>Codigo</th>
          <th>Estado</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          include_once 'models/clientestruct.php';
          foreach($this->clientes as $row){ 
            $cliente = new ClienteStruct();    
            $cliente = $row;
        ?>
        <tr>
          <td><?php echo $cliente->cliente_id; ?></td>
          <td><?php echo $cliente->razon_social; ?></td>
          <td><?php echo $cliente->codigo; ?></td>
          <td><?php echo $cliente->activo; ?></td>
          <td><a href="<?php echo constant('URL') . 'cliente/verCliente/' . $cliente->cliente_id; ?>">Editar</a></td>
          <td><a href="<?php echo constant('URL') . 'cliente/eliminarCliente/' . $cliente->cliente_id; ?>">Eliminar</a></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <?php require "views/footer.php"; ?>
</body>
</html>