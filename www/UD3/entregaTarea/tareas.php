<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'utils/mysqli.php'; ?>
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
      <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $usuario = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : null;
          $estado = isset($_POST['estado']) ? $_POST['estado'] : null;
          $tareas = obtenerTareas($usuario, $estado);
        } else {
          $tareas = getTareas();
        }
      ?>
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h2>Tareas</h2>
        </div>
        <div class="container">
          <div class="table">
            <table class="table table-striped table-hover">
              <thead class="thead">
                <tr>
                  <th>ID</th>
                  <th>titulo</th>
                  <th>descripcion</th>
                  <th>estado</th>
                  <th colspan="2">Usuario</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                if (empty($tareas)): ?>
                  <tr>
                    <td colspan="6">No hay tareas</td>
                  </tr>
                <?php else: 
                  foreach($tareas as $tarea): ?>
                    <tr>
                      <td><?php echo $tarea['id']; ?></td>
                      <td><?php echo $tarea['titulo']; ?></td>
                      <td><?php echo $tarea['descripcion']; ?></td>
                      <td><?php echo $tarea['estado']; ?></td>
                      <td><?php echo $tarea['username']; ?></td>
                      <td class="text-center">
                        <a href="editarTareaForm.php?id=<?php echo $tarea['id']; ?>" class="btn btn-primary">Editar</a>
                        <a href="borraTarea.php?id=<?php echo $tarea['id']; ?>" class="btn btn-danger">Borrar</a>
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