<?php require_once('../../../conexion.php');    //CONEXION A BASE DE DATOS
$val    = $_REQUEST['val'];
$cliente = $_REQUEST['cliente'];

header("Location: por_cobrar1.php?valid=0&val=1&cliente=$cliente");
    
 
