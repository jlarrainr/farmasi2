<?php require_once('../../../conexion.php');    //CONEXION A BASE DE DATOS
$val    = $_REQUEST['val'];
$proveedor = $_REQUEST['proveedor'];

header("Location: por_pagar1.php?valid=0&val=1&proveedor=$proveedor");
    
 
