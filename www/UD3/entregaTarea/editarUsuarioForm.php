<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'utils/pdo.php'; ?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UD3 Tarea</title>
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
          <h2>Actualizar Usuario</h2>
        </div>
        <div class="container">
          <?php if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $usuario = obtenerUsuario($id);?>
            <form action="editarUsuario.php" method="POST">
              <input type="hidden" name="id" value="<?php echo $id; ?>">
              <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>
              </div>
              <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo $usuario['apellidos']; ?>" required>
              </div>
              <div class="mb-3">
                <label for="username" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $usuario['username']; ?>" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="contrasena">
              </div>
              <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>
          <?php
          }else{
            echo '<div class="alert alert-danger" role="alert">No se ha podido procesar el usuario</div>';
          } ?>
        </div>
      </main>
    </div>
  </div>
  <!--footer-->
  <?php include 'templates/footer.php'; ?>
</body>
</html>