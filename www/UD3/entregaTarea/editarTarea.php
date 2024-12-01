<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'utils/mysqli.php'; ?>
  <?php include 'utils/utils.php'; ?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UD3. Tarea</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <!--header-->
  <?php include 'templates/header.php'; ?>
  <div class="container-fluid">
    <div class="row">
      <!--menu-->
      <?php include 'templates/menu.php'; ?>
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h2>Gestión de Tarea</h2>
        </div>
        <div class="container">
          <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

              $id = $_POST['id'];
              $titulo = $_POST['titulo'];
              $descripcion = $_POST['descripcion'];
              $estado = $_POST['estado'];
              $id_usuario = $_POST['id_usuario'];
              if (campoValido($titulo) && campoValido($descripcion) && campoValido($estado) && campoValido($id) && campoValido($id_usuario)) {
                if (editarTarea($id, $titulo, $descripcion, $estado, $id_usuario)) {
                  echo '<div class="alert alert-success" role="alert">Tarea actualizada correctamente.</div>';
                } else {
                  echo '<div class="alert alert-danger" role="alert">Algun valor es incorrecto</div>';
                }
              }
            }
            else {
              echo '<div class="alert alert-danger" role="alert">No se ha podido procesar la tarea</div>';
            }
          ?>
        </div>
      </main>
    </div>
  </div>
  <!--footer-->
  <?php include 'templates/footer.php'; ?>
</body>
</html>