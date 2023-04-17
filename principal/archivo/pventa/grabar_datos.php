<?php include('../../session_user.php');
require_once('../../../conexion.php');
$p1       = $_REQUEST['p1'];
$p2       = $_REQUEST['p2'];
$codpro   = $_REQUEST['codpro'];
$val      = $_REQUEST['val'];
$search   = $_REQUEST['search'];
$factor   = $_REQUEST['factor'];
$margene1 = $_REQUEST['margene1'];
$tabla   = $_REQUEST['TablaD'];
$p3       = $_REQUEST['p3'];

 if($tabla == 's001'){
     
     $campo_prevta = "prevta1";
     $campo_preuni = "preuni1";
     
 }else if ($tabla == 's002'){
     
     $campo_prevta = "prevta2";
     $campo_preuni = "preuni2";
     
 }
//echo $TablaD;

//if ($factor<=1);
//    {
// $p3=$p2;
//    }
 
mysqli_query($conexion,"UPDATE producto set  $campo_prevta = '$p2',$campo_preuni = '$p3' where codpro = '$codpro'");
header("Location: precios2.php?search=$search&val=$val");
?>