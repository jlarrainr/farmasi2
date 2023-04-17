<?php

require_once('../../../conexion.php');  //CONEXION A BASE DE DATOS
$CodEstab = $_REQUEST['CodEstab'];

mysqli_query($conexion, "UPDATE datagen set CodEstab = '$CodEstab'");