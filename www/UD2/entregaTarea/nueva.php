<?php
  include 'utils.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UD2. Tarea</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <!--header-->
  <?php include 'header.php'; ?>
  <div class="container-fluid">
    <div class="row">
      <!--menu-->
      <?php include 'menu.php'; ?>
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h2>Nueva tarea procesada</h2>
        </div>
        <div class="container">
          <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST'){
              $identificador = $_POST['identificador'];
              $descripcion = $_POST['descripcion'];
              $estado = $_POST['estado'];
              
              $errores = false;
              
              if (!campoValido($identificador)){
                echo '<p class="text-danger">El identificador no puede estar vacío</p>';
                $errores = true;
              }
              if (!campoValido($descripcion)){
                echo '<p class="text-danger">La descripción no puede estar vacía</p>';
                $errores = true;
              }
              if (!campoValido($estado)){
                echo '<p class="text-danger">El estado no puede estar vacío</p>';
                $errores = true;
              }
              if (!$errores){
                if(guardarTarea($identificador, $descripcion, $estado)){
                  echo '<p class="text-success">Tarea guardada correctamente</p>';
                }else{
                  echo '<p class="text-danger">Error al guardar la tarea</p>';
                }
              }
            }else{
              echo '<p class="text-danger">No se ha podido procesar la tarea</p>';
            }
          ?>
        </div>
      </main>
    </div>
  </div>
  <!--footer-->
  <?php include 'footer.php'; ?>
</body>
</html>