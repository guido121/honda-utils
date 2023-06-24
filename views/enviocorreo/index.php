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
    <h1 class="center">Envío correo</h1>
    <br>
    <div class="center"><p style="color:green;font-weight:bold"><?php echo $this->mensaje; ?></p></div>

    <form action="<?php echo constant('URL'); ?>enviocorreo/enviarcorreosmasivo" method="POST" enctype="multipart/form-data">
      <br>
      <p>
        <label for="file">Archivo</label>
        <input name="data_file" type="file">
      </p>
      <br>
       <p>
        <input type="submit" value="Enviar archivos">
      </p>
    </form>
  </div>

  <?php require "views/footer.php"; ?>
</body>
</html>