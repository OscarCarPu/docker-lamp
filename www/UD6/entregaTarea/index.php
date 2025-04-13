<?php

require 'flight/Flight.php';

try {
  $host = $_ENV['DATABASE_HOST'];
  $name = $_ENV['DATABASE_NAME'];
  $user = $_ENV['DATABASE_USER'];
  $pass = $_ENV['DATABASE_PASSWORD'];

  Flight::register('db', 'PDO', array("mysql:host=$host;dbname=$name", $user, $pass));
} catch (PDOException $e) {
  die(json_encode(['error' => 'Error al conectar con la base de datos: ' . $e->getMessage()]));
}

Flight::before('start', function() {
  try {
    $ruta = Flight::request()->url;

    if (str_starts_with($ruta, '/contactos')) {
      $token = Flight::request()->getHeader('X-Token');

      if (!$token) {
        Flight::halt(401, json_encode(['error' => 'Token no proporcionado']));
      }
      $sql = 'SELECT * FROM usuarios WHERE token = :token';
      $sentencia = Flight::db()->prepare($sql);
      $sentencia->bindParam(':token', $token);
      $sentencia->execute();
      $usuario = $sentencia->fetch();
      if (!$usuario) {
        Flight::halt(401, json_encode(['error' => 'Token inválido']));
      }
      Flight::set('user', $usuario);
    }
  } catch (Throwable $e) {
    Flight::halt(500, json_encode(['error' => 'Error en la autenticación: ' . $e->getMessage()]));
  }
});

Flight::route('POST /register', function() {
  try {
    $nombre = Flight::request()->data->nombre;
    $email = Flight::request()->data->email;
    $password = Flight::request()->data->password;

    $hash = password_hash($password, PASSWORD_BCRYPT);

    $sql = 'INSERT INTO usuarios(nombre, email, password, created_at) VALUES (?, ?, ?, NOW())';
    $stmt = Flight::db()->prepare($sql);
    $stmt->bindParam(1, $nombre);
    $stmt->bindParam(2, $email);
    $stmt->bindParam(3, $hash);

    if ($stmt->execute()) {
      Flight::json(['message' => 'Usuario registrado correctamente.']);
    } else {
      Flight::halt(500, json_encode(['error' => 'Error al registrar el usuario.']));
    }
  } catch (Throwable $e) {
    Flight::halt(500, json_encode(['error' => 'Error al registrar el usuario: ' . $e->getMessage()]));
  }
});

Flight::route('POST /login', function() {
  try {
    $email = Flight::request()->data->email;
    $password = Flight::request()->data->password;

    $sql = 'SELECT * FROM usuarios WHERE email = ?';
    $stmt = Flight::db()->prepare($sql);
    $stmt->bindParam(1, $email);
    $stmt->execute();
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($password, $usuario['password'])) {
      $token = bin2hex(random_bytes(32));

      $updateSql = 'UPDATE usuarios SET token = ? WHERE id = ?';
      $updateStmt = Flight::db()->prepare($updateSql);
      $updateStmt->bindParam(1, $token);
      $updateStmt->bindParam(2, $usuario['id']);
      $updateStmt->execute();

      Flight::json(['message' => 'Login exitoso.', 'token' => $token]);
    } else {
      Flight::halt(401, json_encode(['error' => 'Credenciales inválidas.']));
    }
  } catch (Throwable $e) {
    Flight::halt(500, json_encode(['error' => 'Error al iniciar sesión: ' . $e->getMessage()]));
  }
});

Flight::route('GET /contactos(/@id)', function($id = null) {
  try {
    $usuario = Flight::get('user');
    $userId = $usuario['id'];

    if ($id) {
      $sql = 'SELECT * FROM contactos WHERE id = :id AND usuario_id = :usuario_id';
      $stmt = Flight::db()->prepare($sql);
      $stmt->execute([':id' => $id, ':usuario_id' => $userId]);
      $contacto = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$contacto) {
        Flight::halt(403, json_encode(['error' => 'No tienes permiso para acceder a este contacto.']));
      }

      Flight::json($contacto);
    } else {
      $sql = 'SELECT * FROM contactos WHERE usuario_id = :usuario_id';
      $stmt = Flight::db()->prepare($sql);
      $stmt->execute([':usuario_id' => $userId]);
      $contactos = $stmt->fetchAll(PDO::FETCH_ASSOC);

      Flight::json($contactos);
    }
  } catch (Throwable $e) {
    Flight::halt(500, json_encode(['error' => 'Error al obtener contactos: ' . $e->getMessage()]));
  }
});

Flight::route('POST /contactos', function() {
  try {
    $usuario = Flight::get('user');
    $userId = $usuario['id'];

    $nombre = Flight::request()->data->nombre;
    $telefono = Flight::request()->data->telefono;
    $email = Flight::request()->data->email;

    $sql = 'INSERT INTO contactos(nombre, telefono, email, usuario_id) VALUES (?, ?, ?, ?)';
    $stmt = Flight::db()->prepare($sql);
    $stmt->bindParam(1, $nombre);
    $stmt->bindParam(2, $telefono);
    $stmt->bindParam(3, $email);
    $stmt->bindParam(4, $userId);

    if ($stmt->execute()) {
      Flight::json(['message' => 'Contacto añadido correctamente.']);
    } else {
      Flight::halt(500, json_encode(['error' => 'Error al añadir el contacto.']));
    }
  } catch (Throwable $e) {
    Flight::halt(500, json_encode(['error' => 'Error al añadir el contacto: ' . $e->getMessage()]));
  }
});

Flight::route('PUT /contactos', function() {
  try {
    $usuario = Flight::get('user');
    $userId = $usuario['id'];

    $id = Flight::request()->data->id;
    $nombre = Flight::request()->data->nombre;
    $telefono = Flight::request()->data->telefono;
    $email = Flight::request()->data->email;

    $sql = 'SELECT * FROM contactos WHERE id = :id AND usuario_id = :usuario_id';
    $stmt = Flight::db()->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':usuario_id', $userId);
    $stmt->execute();
    $contacto = $stmt->fetch();

    if (!$contacto) {
      Flight::halt(403, json_encode(['error' => 'No tienes permiso para modificar este contacto.']));
    }

    $updateSql = 'UPDATE contactos SET nombre = ?, telefono = ?, email = ? WHERE id = ?';
    $updateStmt = Flight::db()->prepare($updateSql);
    $updateStmt->bindParam(1, $nombre);
    $updateStmt->bindParam(2, $telefono);
    $updateStmt->bindParam(3, $email);
    $updateStmt->bindParam(4, $id);

    if ($updateStmt->execute()) {
      Flight::json(['message' => 'Contacto actualizado correctamente.']);
    } else {
      Flight::halt(500, json_encode(['error' => 'Error al actualizar el contacto.']));
    }
  } catch (Throwable $e) {
    Flight::halt(500, json_encode(['error' => 'Error al actualizar el contacto: ' . $e->getMessage()]));
  }
});

Flight::route('DELETE /contactos', function() {
  try {
    $usuario = Flight::get('user');
    $userId = $usuario['id'];

    $id = Flight::request()->data->id;

    $sql = 'SELECT * FROM contactos WHERE id = :id AND usuario_id = :usuario_id';
    $stmt = Flight::db()->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':usuario_id', $userId);
    $stmt->execute();
    $contacto = $stmt->fetch();

    if (!$contacto) {
      Flight::halt(403, json_encode(['error' => 'No tienes permiso para eliminar este contacto.']));
    }

    $deleteSql = 'DELETE FROM contactos WHERE id = :id';
    $deleteStmt = Flight::db()->prepare($deleteSql);
    $deleteStmt->bindParam(':id', $id);

    if ($deleteStmt->execute()) {
      Flight::json(['message' => "Contacto $id eliminado correctamente."]);
    } else {
      Flight::halt(500, json_encode(['error' => 'Error al eliminar el contacto.']));
    }
  } catch (Throwable $e) {
    Flight::halt(500, json_encode(['error' => 'Error al eliminar el contacto: ' . $e->getMessage()]));
  }
});

Flight::start();