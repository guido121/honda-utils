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
    <h1 class="center">Detalle de <?php echo $this->destinatario->correo ?></h1>

    <div class="center"><?php echo $this->mensaje; ?></div>

    <form action="<?php echo constant('URL'); ?>destinatario/actualizarDestinatario" method="POST">
      <input type="hidden" name="destinatario_id" value="<?php echo $this->destinatario->destinatario_id ?>">
      <p>
        <label for="matricula">Nombres</label><br>
        <input type="text" name="nombres"  value="<?php echo $this->destinatario->nombres ?>" required>
      </p>
      <p>
        <label for="matricula">Apellidos</label><br>
        <input type="text" name="apellidos"  value="<?php echo $this->destinatario->apellidos ?>" required>
      </p>
      <p>
        <label for="matricula">Correo</label><br>
        <input type="text" name="correo"  value="<?php echo $this->destinatario->correo ?>" required>
      </p>

      <p>
        <label for="nombre">Activo</label><br>
        <select name="activo" id="" required>
            <option value="1" <?php echo ($this->destinatario->activo == "1" ? "selected" : "") ?>>Activo</option>
            <option value="0" <?php echo ($this->destinatario->activo != "1" ? "selected" : "") ?>>Inactivo</option>
        </select>
      <p>
        <label for="apellido">Cliente</label><br>
        <select name="cliente_id" id="cliente_id" required>
            <?php 
            include_once 'models/clientestruct.php';
            foreach($this->clientes as $row){ 
                $cliente = new ClienteStruct();    
                $cliente = $row;
            ?>
            <option <?php echo (($this->destinatario->cliente_id == $cliente->cliente_id) ? "selected" : "")?> value="<?php echo $cliente->cliente_id ?>"> <?php echo $cliente->razon_social ?></option>
            <?php } ?>
        </select>
      </p>
      <p>
        <input type="submit" value="Actualizar destinatario">
      </p>
    </form>
  </div>

  <?php require "views/footer.php"; ?>
</body>
</html>