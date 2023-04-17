<?php

require_once('conexion.php');
mysqli_query($conexion, "UPDATE detalle_venta set incentivo = '0'");
?>
