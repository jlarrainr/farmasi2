<?php include('../../session_user.php');
require_once('../../../conexion.php');
$mark    = $_REQUEST['mark'];
$ord     = $_REQUEST['ord'];
$p1      = $_REQUEST['p1'];
$val     = $_REQUEST['val'];
$use     = $_REQUEST['use'];
$prod    = $_REQUEST['prod'];
$codpro  = $_REQUEST['codpro'];
$inicio  = $_REQUEST['inicio'];
$pagina  = $_REQUEST['pagina'];
$tot_pag = $_REQUEST['tot_pag'];
$registros  = $_REQUEST['registros'];
mysqli_query($conexion,"UPDATE producto set desprod = '$prod', codmar = '$mark', codfam = '$use' where codpro = '$codpro'");
header("Location: master2.php?p1=$p1&val=$val&ord=$ord&inicio=$inicio&pagina=$pagina&tot_pag=$tot_pag&registros=$registros");
?>