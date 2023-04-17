<?php include('../../session_user.php');
$remesa   	  = $_SESSION['remesa'];
require_once ('../../../conexion.php');
$cajero 	= $_REQUEST['cajero'];
$turno  	= $_REQUEST['turno'];
$ventinic 	= $_REQUEST['ventinic'];
$ventfin	= $_REQUEST['ventfin'];
$bolini 	= $_REQUEST['bolini'];
$bolfin  	= $_REQUEST['bolfin'];
$facini 	= $_REQUEST['facini'];
$facfin  	= $_REQUEST['facfin'];
$cobrainic 	= $_REQUEST['cobrainic'];
$cobrafin 	= $_REQUEST['cobrafin'];
$ventefect 	= $_REQUEST['ventefect'];
$planilla 	= $_REQUEST['planilla'];
$total 		= $_REQUEST['total'];
$creditos 	= $_REQUEST['creditos'];
$cheque 	= $_REQUEST['cheque'];
$tarjetas 	= $_REQUEST['tarjetas'];
$totingsol 	= $_REQUEST['totingsol'];
$totgastsol = $_REQUEST['totgastsol'];
$ttgastdol 	= $_REQUEST['ttgastdol'];
$dolar 		= $_REQUEST['dolar'];
$totefectsol= $_REQUEST['totefectsol'];
$totefectdol= $_REQUEST['totefectdol'];
$depsoles 	= $_REQUEST['depsoles'];
$depdolar 	= $_REQUEST['depdolar'];
$entregassol= $_REQUEST['entregassol'];
$entregasdol= $_REQUEST['entregasdol'];
/*
mysqli_query($conexion,"UPDATE remesa set turno='$turno',estado='0',iniven='$ventinic',finven='$ventfin',inipla='$cobrainic', finpla='$cobrafin',efeven='$ventefect',creven='$planilla',total='$total',creditos='$creditos',cheque='$cheque',tarjetas='$tarjetas',totingsol='$totingsol',totgastsol='$totgastsol',ttgastdol='$ttgastdol',dolar='$dolar',totefectsol='$totefectsol',totefectdol='$totefectdol',depsoles='$depsoles',depdolar='$depdolar',entregassol='$entregassol',entregasdol='$entregasdol' where invnum = '$remesa'");
*/
mysqli_query($conexion,"UPDATE remesa set turno='$turno',estado='0',iniven='$ventinic',finven='$ventfin',inipla='$cobrainic', finpla='$cobrafin',efeven='$ventefect',creven='$creditos',totings='$totingsol',totingd = '$totingdol',totgass='$totgastsol',totgasd='$ttgastdol',cambio='$dolar',totefes   ='$totefectsol',totefed='$totefectdol',totdeps   ='$depsoles',totdepd='$depdolar',bolini = '$bolini',bolfin='$bolfin',facini='$facini',facfin='$facfin',totefes = '$totefectsol', totefed = '$totefectdol',totdeps = '$depsoles',totdepd = '$depdolar' where invnum = '$remesa'");
header("Location: ../../index.php");
?>