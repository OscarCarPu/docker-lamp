<?php
session_start();

function listarTareas(){
  if (!isset($_SESSION['tareas']))
    return [];
  return $_SESSION['tareas'];
}

function limpiarEntrada($dato){
  $dato = trim($dato);
  $dato = stripslashes($dato);
  $dato = htmlspecialchars($dato);
  return $dato;
}

function campoValido($dato){
  $dato = limpiarEntrada($dato);
  return !empty($dato);
}

function guardarTarea($identificador, $descripcion, $estado){
  if(campoValido($identificador) && campoValido($descripcion) && campoValido($estado) && in_array($estado, ['pendiente', 'en proceso', 'completada'])){
    $identificador = limpiarEntrada($identificador);
    $descripcion = limpiarEntrada($descripcion);
    $estado = limpiarEntrada($estado);
    $tarea = array(
      'identificador' => $identificador,
      'descripcion' => $descripcion,
      'estado' => $estado
    );
    $_SESSION['tareas'][] = $tarea;
    return true;
  }
  return false;
}

?>