<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'utils/pdo.php'; ?>
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
          <h2>Gestión de Usuario</h2>
        </div>
        <div class="container">
          <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

              $id = $_POST['id'];
              $nombre = $_POST['nombre'];
              $apellidos = $_POST['apellidos'];
              $usuario = $_POST['username'];
              $contrasena = $_POST['contrasena'];
              if (campoValido($nombre) && campoValido($apellidos) && campoValido($usuario) && campoValido($id)) {
                if (campoValido($contrasena)) {
                  if (editarUsuario($id, $nombre, $apellidos, $usuario, $contrasena)) {
                    echo '<div class="alert alert-success" role="alert">Usuario actualizado correctamente.</div>';
                  } else {
                    echo '<div class="alert alert-danger" role="alert">Algun valor es incorrecto</div>';
                  }
                }
                else {
                  if (editarUsuario($id, $nombre, $apellidos, $usuario)) {
                    echo '<div class="alert alert-success" role="alert">Usuario actualizado correctamente.</div>';
                  } else {
                    echo '<div class="alert alert-danger" role="alert">Algun valor es incorrecto</div>';
                  }
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