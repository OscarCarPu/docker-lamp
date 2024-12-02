<!DOCTYPE html>
<html lang="en">
<head>
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
          <h2>Inicializar base de datos</h2>
        </div>
        <div class="container">
          <?php
          try {
            // Connect as root first to create database and grant permissions
            $mysqli = new mysqli("db", "root", "test", "");
            if ($mysqli->connect_error) {
              throw new Exception("Connection failed: " . $mysqli->connect_error);
            }

            $result = $mysqli->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'tareas'");
            if ($result->num_rows > 0) {
              echo "<div class='alert alert-warning'>La base de datos \"tareas\" ya existia</div>";
            } else {
              $sql = "CREATE DATABASE tareas";
              if ($mysqli->query($sql) === TRUE) {
                echo "<div class='alert alert-success'>Base de datos \"tareas\" creada correctamente</div>";
                // Grant permissions to colegio user
                $sql = "GRANT ALL PRIVILEGES ON tareas.* TO 'colegio'@'%'";
                if ($mysqli->query($sql) === TRUE) {
                  $mysqli->query("FLUSH PRIVILEGES");
                  echo "<div class='alert alert-success'>Permisos otorgados al usuario colegio</div>";
                } else {
                  throw new Exception("Error granting privileges: " . $mysqli->error);
                }
              } else {
                throw new Exception("Error creating database: " . $mysqli->error);
              }
            }

            // Close root connection
            $mysqli->close();

            // Reconnect as colegio user to create tables
            $mysqli = new mysqli("db", "colegio", "colegio", "tareas");
            if ($mysqli->connect_error) {
              throw new Exception("Connection failed as colegio user: " . $mysqli->connect_error);
            }

            $result = $mysqli->query("SHOW TABLES LIKE 'usuarios'");
            if ($result->num_rows > 0) {
              echo "<div class='alert alert-warning'>La tabla \"usuarios\" ya existia</div>";
            } else {
              $sql = "CREATE TABLE usuarios (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) NOT NULL,
                nombre VARCHAR(50),
                apellidos VARCHAR(100),
                contrasena VARCHAR(100)
              )";
              if ($mysqli->query($sql) === TRUE) {
                echo "<div class='alert alert-success'>Tabla \"usuarios\" creada correctamente</div>";
              } else {
                echo "<div class='alert alert-danger'>Error creando la tabla usuarios: " . $mysqli->error . "</div>";
              }
            }

            $result = $mysqli->query("SHOW TABLES LIKE 'tareas'");
            if ($result->num_rows > 0) {
              echo "<div class='alert alert-warning'>La tabla \"tareas\" ya existia</div>";
            } else {
              $sql = "CREATE TABLE tareas (
                id INT AUTO_INCREMENT PRIMARY KEY,
                titulo VARCHAR(50) NOT NULL,
                descripcion VARCHAR(250),
                estado VARCHAR(50) NOT NULL,
                id_usuario INT NOT NULL,
                FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
              )";
              if ($mysqli->query($sql) === TRUE) {
                echo "<div class='alert alert-success'>Tabla \"tareas\" creada correctamente</div>";
              } else {
                echo "<div class='alert alert-danger'>Error creando la tabla tareas: " . $mysqli->error . "</div>";
              }
            }

            $mysqli->close();
          } catch (Exception $e) {
            echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
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