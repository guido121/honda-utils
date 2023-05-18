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
    <h1 class="center">Sección de Destinatarios</h1>
    <br>
    <div>
      <a href="<?php echo constant('URL') . 'destinatario/nuevodestinatario' ?>">Nuevo Destinatario</a>
    </div>
    <br>
    <table width="100%">
      <thead>
        <tr>
          <th>Id</th></th>
          <th>Nombres</th>
          <th>Apellidos</th>
          <th>Correo</th>
          <th>Activo</th>
          <th>Cliente_id</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          include_once 'models/destinatariostruct.php';
          foreach($this->destinatarios as $row){ 
            $destinatario = new DestinatarioStruct();    
            $destinatario = $row;
        ?>
        <tr>
          <td><?php echo $destinatario->destinatario_id; ?></td>
          <td><?php echo $destinatario->nombres; ?></td>
          <td><?php echo $destinatario->apellidos; ?></td>
          <td><?php echo $destinatario->correo; ?></td>
          <td><?php echo $destinatario->activo; ?></td>
          <td><?php echo $destinatario->cliente_id; ?></td>
          <td><a href="<?php echo constant('URL') . 'destinatario/verDestinatario/' . $destinatario->destinatario_id; ?>">Editar</a></td>
          <td><a href="<?php echo constant('URL') . 'destinatario/eliminarDestinatario/' . $destinatario->destinatario_id; ?>">Eliminar</a></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <?php require "views/footer.php"; ?>
</body>
</html>