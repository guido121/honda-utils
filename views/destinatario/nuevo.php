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
    <h1 class="center">Sección de Nuevo Destinatario</h1>

    <div class="center"><?php echo $this->mensaje; ?></div>

    <form action="<?php echo constant('URL'); ?>destinatario/registrarDestinatario" method="POST">
      <p>
        <label for="matricula">Nombres</label><br>
        <input type="text" name="nombres" id="" required>
      </p>
      <p>
        <label for="nombre">Apellidos</label><br>
        <input type="text" name="apellidos" id="" required>
      </p>
      <p>
        <label for="correo">Correo</label><br>
        <input type="email" name="correo" id="" required>
      </p>
      <p>
        <label for="nombre">Activo</label><br>
        <input type="text" name="activo" id="" required>
      </p>
      <p>
        <label for="cliente_id">Cliente</label><br>
        <select name="cliente_id" id="cliente_id" required>
        
        
        <?php 
          include_once 'models/clientestruct.php';
          foreach($this->clientes as $row){ 
            $cliente = new ClienteStruct();    
            $cliente = $row;
        ?>
          <option value="<?php echo $cliente->cliente_id ?>"> <?php echo $cliente->razon_social ?></option>
        <?php } ?>
        </select>
      </p>
      <p>
        <input type="submit" value="Registrar nuevo destinatario">
      </p>
    </form>
  </div>

  <?php require "views/footer.php"; ?>
</body>
</html>