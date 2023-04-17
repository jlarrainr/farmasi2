<?php

include('../../session_user.php');
require_once('../../../conexion.php');


$codpro = $_REQUEST['codproducto_grabar'];
$invnum = $_REQUEST['invnum_grabar'];
$cantidad = $_REQUEST['cantidad'];
$monto = $_REQUEST['monto'];
$estado = $_REQUEST['estado'];

/*$sql = "SELECT codloc FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codloc = $row['codloc'];
    }
}*/

//and codloc = '$codloc'
mysqli_query($conexion, "UPDATE incentivadodet set estado = '$estado', canprocaj = '$cantidad',canprounid = '0',pripro = '$monto' where codpro = '$codpro' and invnum = '$invnum'");


header("Location: incentivohist2.php?invnum=$invnum");