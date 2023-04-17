<?php

require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
include('../../session_user.php');
$date_mov = date('Y-m-d');
$time_mov = date('H:i:s');
$text = $_REQUEST['text'];
$id = $_REQUEST['id'];

mysqli_query($conexion, "INSERT INTO historial (actividad,usuario,fecha,hora,id_secundario) values ('$text','$usuario','$date_mov','$time_mov','$id')");
header("Location: index1.php");
