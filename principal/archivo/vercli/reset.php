<?php
include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');

$codcli = $_REQUEST['codigo'];


mysqli_query($conexion, "UPDATE cliente set puntos = '0' where codcli = '$codcli'");
header("Location: cli.php");
