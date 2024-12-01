<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'utils/pdo.php'; ?>
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
          <h2>Usuarios</h2>
        </div>
        <div class="container">
          <div class="table">
            <table class="table table-striped table-hover">
              <thead class="thead">
                <tr>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Apellido</th>
                  <th colspan="2">Usuario</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $usuarios = getUsuarios();
                if (empty($usuarios)): ?>
                  <tr>
                    <td colspan="5">No hay usuarios</td>
                  </tr>
                <?php else: 
                  foreach($usuarios as $usuario): ?>
                    <tr>
                      <td><?php echo $usuario['id']; ?></td>
                      <td><?php echo $usuario['nombre']; ?></td>
                      <td><?php echo $usuario['apellidos']; ?></td>
                      <td><?php echo $usuario['username']; ?></td>
                      <td class="text-center">
                        <a href="editarUsuarioForm.php?id=<?php echo $usuario['id']; ?>" class="btn btn-primary">Editar</a>
                        <a href="borraUsuario.php?id=<?php echo $usuario['id']; ?>" class="btn btn-danger">Borrar</a>
                      </td>
                    </tr>
                  <?php endforeach;
                endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </main>
    </div>
  </div>
  <!--footer-->
  <?php include 'templates/footer.php'; ?>
</body>
</html>