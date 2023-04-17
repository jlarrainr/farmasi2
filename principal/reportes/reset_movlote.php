<?php
require_once('../../conexion.php');

$codigo = $_REQUEST['codigo'];

//echo $codcli;
mysqli_query($conexion, "UPDATE movlote set stock = '0' where idlote = '$codigo'");
header("Location: venci.php");
