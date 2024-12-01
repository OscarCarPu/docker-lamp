<?php

function getTareas() {
    $mysqli = new mysqli("db", "root", "abc123.", "tareas");
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $sql = "SELECT t.id, t.titulo, t.descripcion, t.estado, t.id_usuario, u.username FROM tareas t JOIN usuarios u ON t.id_usuario = u.id";
    $result = $mysqli->query($sql);
    
    $tareas = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $tareas[] = $row;
        }
    }
    
    $mysqli->close();
    return $tareas;
}

function obtenerTareas($id_usuario = null, $estado = null) {
    $mysqli = new mysqli("db", "root", "abc123.", "tareas");
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $sql = "SELECT t.id, t.titulo, t.descripcion, t.estado, t.id_usuario, u.username FROM tareas t JOIN usuarios u ON t.id_usuario = u.id";
    if ($id_usuario !== null) {
        $sql .= " WHERE t.id_usuario = $id_usuario";
    }
    if ($estado !== null) {
        $sql .= " AND t.estado = '$estado'";
    }
    $result = $mysqli->query($sql);
    
    $tareas = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $tareas[] = $row;
        }
    }
    
    $mysqli->close();
    return $tareas;
}

function nuevaTarea($titulo, $descripcion, $estado, $id_usuario) {
    $mysqli = new mysqli("db", "root", "abc123.", "tareas");
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $stmt = $mysqli->prepare("INSERT INTO tareas (titulo, descripcion, estado, id_usuario) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $titulo, $descripcion, $estado, $id_usuario);
    
    $success = $stmt->execute();
    
    $stmt->close();
    $mysqli->close();
    
    return $success;
}

function obtenerTarea($id) {
    $mysqli = new mysqli("db", "root", "abc123.", "tareas");
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $stmt = $mysqli->prepare("SELECT * FROM tareas WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $tarea = $result->fetch_assoc();
    
    $stmt->close();
    $mysqli->close();
    
    return $tarea;
}

function editarTarea($id, $titulo, $descripcion, $estado, $id_usuario) {
    $mysqli = new mysqli("db", "root", "abc123.", "tareas");
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $stmt = $mysqli->prepare("UPDATE tareas SET titulo = ?, descripcion = ?, estado = ?, id_usuario = ? WHERE id = ?");
    $stmt->bind_param("sssii", $titulo, $descripcion, $estado, $id_usuario, $id);
    
    $success = $stmt->execute();
    
    $stmt->close();
    $mysqli->close();
    
    return $success;
}

function borraTarea($id) {
    $mysqli = new mysqli("db", "root", "abc123.", "tareas");
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $stmt = $mysqli->prepare("DELETE FROM tareas WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    $success = $stmt->execute();
    
    $stmt->close();
    $mysqli->close();
    
    return $success;
}