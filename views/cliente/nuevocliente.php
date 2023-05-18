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
    <h1 class="center">Sección de Nuevo Cliente</h1>

    <div class="center"><?php echo $this->mensaje; ?></div>

    <form action="<?php echo constant('URL'); ?>cliente/registrarCliente" method="POST">
      <p>
        <label for="matricula">Razón Social</label><br>
        <input type="text" name="razon_social" id="" required>
      </p>
      <p>
        <label for="nombre">Codigo</label><br>
        <input type="text" name="codigo" id="" required>
      </p>
      <!--<p>
        <label for="apellido">Activo</label><br>
        <input type="text" name="apellido" id="" required>
      </p>-->
      <p>
        <input type="submit" value="Registrar nuevo cliente">
      </p>
    </form>
  </div>

  <?php require "views/footer.php"; ?>
</body>
</html>