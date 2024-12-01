<?php 
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
?>