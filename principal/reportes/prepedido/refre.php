<?php
include('../../session_user.php');
require_once ('../../../conexion.php'); //CONEXION A BASE DE DATOS
require_once('../../../titulo_sist.php');
require_once('../../../convertfecha.php');
require_once("../local.php"); //OBTENGO EL NOMBRE Y CODIGO DEL LOCAL

$idpreped = $_REQUEST['idpreped'];
$numpagina = $_REQUEST['numpagina'];
$iddetalle = $_REQUEST['iddetalle'];

//echo $iddetalle;
header("Location: prepedido.php?idpreped=$idpreped&numpagina=$numpagina"); 