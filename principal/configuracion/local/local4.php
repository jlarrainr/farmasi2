<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
$local	= $_REQUEST['local'];
$nom 	= $_REQUEST['nom'];
$val 	= $_REQUEST['val'];
$tip 	= $_REQUEST['tip'];
$tipdocu 	= $_REQUEST['tipdocu'];
$contit 	= $_REQUEST['contit'];
$numlinea 	= $_REQUEST['numlinea'];
mysqli_query($conexion,"update xcompa set nombre = '$nom' where codloc = '$local'");
$sql1="SELECT codloc FROM xcompadetalle where codloc = '$local' and tipdoc = '$tipdocu'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){	
mysqli_query($conexion,"update xcompadetalle set contit = '$contit' where codloc = '$local' and tipdoc = '$tipdocu'");
}
else
{
mysqli_query($conexion,"INSERT INTO xcompadetalle (codloc,tipdoc,fdisp,flinpag,fini,fcanti,fcodpro,fmarca,fpreuni,fmonto,fdescuento,fnom,fref,anchocod,anchonom,anchomarca,anchoreferencial,anchodescuento,anchocantidad,anchoprecio,anchosubtotal,contit) values ('$local','$tipdocu','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','$contit')");
}
header("Location: local2.php?val=$val&tip=$tip&local=$local&tipdocu=$tipdocu"); 
?>