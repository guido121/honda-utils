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
    <h1 class="center">Detalle de <?php echo $this->cliente->razon_social ?></h1>

    <div class="center"><?php echo $this->mensaje; ?></div>

    <form action="<?php echo constant('URL'); ?>cliente/actualizarCliente" method="POST">
      <input type="hidden" name="cliente_id" value="<?php echo $this->cliente->cliente_id ?>">
      <p>
        <label for="matricula">Razon Social</label><br>
        <input type="text" name="razon_social"  value="<?php echo $this->cliente->razon_social ?>" required>
      </p>
      <p>
        <label for="nombre">Código</label><br>
        <input type="text" name="codigo"  value="<?php echo $this->cliente->codigo ?>" required>
      </p>
      <p>
        <label for="apellido">Activo</label><br>
        <select name="activo"  value="" required>
          <option <?php echo (($this->cliente->activo == "1" ? "selected" : "")) ?> value="1">Activo</option>
          <option <?php echo (($this->cliente->activo != "1" ? "selected" : "")) ?> value="0">Inactivo</option>
        </select>
      </p>
      <p>
        <input type="submit" value="Actualizar cliente">
      </p>
    </form>
  </div>

  <?php require "views/footer.php"; ?>
</body>
</html>