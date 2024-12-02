<?php

function getUsuarios() {
    try {
        $dsn = "mysql:host=db;dbname=tareas";
        $usuario = "root";
        $contrasena = "abc123.";
        
        $pdo = new PDO("mysql:host=db;dbname=tareas","colegio","colegio");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $pdo->prepare("SELECT * FROM usuarios");
        $stmt->execute();
        
        return $stmt->fetchAll();
        
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        return array();
    }
}

function nuevoUsuario($nombre, $apellidos, $username, $contrasena) {
    try {
        $dsn = "mysql:host=db;dbname=tareas";
        $usuario = "root";
        $contrasena = "abc123.";
        
        $pdo = new PDO("mysql:host=db;dbname=tareas","colegio","colegio");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $pdo->prepare("INSERT INTO usuarios (username, nombre, apellidos, contrasena) VALUES (:username, :nombre, :apellidos, :contrasena)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':contrasena', $contrasena);
        $stmt->execute();
        
        return true;
        
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function obtenerUsuario($id) {
    try {
        $dsn = "mysql:host=db;dbname=tareas";
        $usuario = "colegio";
        $contrasena = "colegio";
        
        $pdo = new PDO("mysql:host=db;dbname=tareas","colegio","colegio");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch();
        
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        return array();
    }
}

function editarUsuario($id, $nombre, $apellidos, $username, $contrasena = null) {
    try {
        $pdo = new PDO("mysql:host=db;dbname=tareas", "colegio", "colegio");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        if ($contrasena === null) {
            $stmt = $pdo->prepare("UPDATE usuarios SET username = :username, nombre = :nombre, apellidos = :apellidos WHERE id = :id");
        } else {
            $stmt = $pdo->prepare("UPDATE usuarios SET username = :username, nombre = :nombre, apellidos = :apellidos, contrasena = :contrasena WHERE id = :id");
            $stmt->bindParam(':contrasena', $contrasena);
        }
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->execute();
        
        return true;
    } catch(PDOException $e) {
        error_log("Error in editarUsuario: " . $e->getMessage());
        return false;
    }
}

function borraUsuario($id) {
    try {
        $pdo = new PDO("mysql:host=db;dbname=tareas", "colegio", "colegio");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return true;
    } catch(PDOException $e) {
        error_log("Error in borrarUsuario: " . $e->getMessage());
        return false;
    }
}