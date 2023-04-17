<?php 
require_once('../../../conexion.php');
$claveventa = $_REQUEST['Codigo'];
$sql= "SELECT usecod,claveventa FROM usuario where claveventa = '$claveventa'";
$resulset = mysqli_query($conexion,$sql);
$arr = array();
while ($obj = mysqli_fetch_object($resulset)) {
    	$arr[] = array('ID' => $obj->usecod,
                   'C' => utf8_encode($obj->claveventa),
        );
}
echo '' . json_encode($arr) . '';
?>