<?php
include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');




mysqli_query($conexion, "UPDATE cliente set puntos = '0' ");
header("Location: cli.php");
