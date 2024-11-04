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
          <h2>Nueva tarea</h2>
        </div>
        <div class="container">
          <form class="mb-5" action="nueva.php" method="post">
            <div class="mb-3">
              <label class="form-label">Identificador</label>
              <input class="form-control" type="text" name="identificador" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Descripción</label>
              <textarea class="form-control" name="descripcion" required></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Estado</label>
              <select class="form-select" name="estado" required>
                <option value="pendiente">pendiente</option>
                <option value="en proceso">en proceso</option>
                <option value="completada">completada</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
          </form>
        </div>
      </main>
    </div>
  </div>
  <!--footer-->
  <?php include 'footer.php'; ?>
</body>
</html>