<?php require_once('../../../conexion.php');    //CONEXION A BASE DE DATOS
$val                = $_REQUEST['val'];
$tipoBusqueda       = $_REQUEST['tipoBusqueda'];
$numeroDocumento    = $_REQUEST['numeroDocumento'];

header("Location:guia1.php?valid=0&val=1&tipoBusqueda=$tipoBusqueda&numeroDocumento=$numeroDocumento");
    
 
