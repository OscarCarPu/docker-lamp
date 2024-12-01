<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'utils/mysqli.php'; ?>
  <?php include 'utils/pdo.php'; $usuarios = getUsuarios(); ?>
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
          <h2>Actualizar Tarea</h2>
        </div>
        <div class="container">
          <?php if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $tarea = obtenerTarea($id);?>
            <form action="editarTarea.php" method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required value="<?php echo $tarea['titulo']; ?>">
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?php echo $tarea['descripcion']; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-control" id="estado" name="estado" required>
                        <option value="pendiente" <?php if ($tarea['estado'] == 'pendiente') echo 'selected'; ?>>Pendiente</option>
                        <option value="en_progreso" <?php if ($tarea['estado'] == 'en_progreso') echo 'selected'; ?>>En Progreso</option>
                        <option value="completada" <?php if ($tarea['estado'] == 'completada') echo 'selected'; ?>>Completada</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="id_usuario" class="form-label">Usuario Asignado</label>
                    <select class="form-control" id="id_usuario" name="id_usuario" required>
                        <?php foreach ($usuarios as $usuario): ?>
                            <option value="<?php echo $usuario['id']; ?>"<?php if ($usuario['id'] == $tarea['id_usuario']) echo 'selected'; ?>><?php echo $usuario['username']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
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