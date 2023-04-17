<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
$local	= $_REQUEST['local'];
$val 	= $_REQUEST['val'];
$tip 	= $_REQUEST['tip'];
$desc 	= $_REQUEST['desc'];
$linea 	= $_REQUEST['linea'];
$col 	= $_REQUEST['col'];
$doc    = $_REQUEST['doc'];
$titulo	= $_REQUEST['titulo'];
$posicion	= $_REQUEST['posicion'];
$cuant 	= $_REQUEST['cuant'];
$disp 	= $_REQUEST['disp'];
$lin1 	= $_REQUEST['lin1'];
$lin2 	= $_REQUEST['lin2'];
$lin3 	= $_REQUEST['lin3'];
$lin4 	= $_REQUEST['lin4'];
$lin5 	= $_REQUEST['lin5'];
$lin6 	= $_REQUEST['lin6'];
$lin7 	= $_REQUEST['lin7'];
$lin8 	= $_REQUEST['lin8'];
$lin9 	= $_REQUEST['lin9'];
$lin10 	= $_REQUEST['lin10'];
$dbrev 	= $_REQUEST['dbrev'];
$anchocod 		= $_REQUEST['anchocod'];
$anchonom 		= $_REQUEST['anchonom'];
$anchomarca 	= $_REQUEST['anchomarca'];
$anchoreferencial 	= $_REQUEST['anchoreferencial'];
$anchodescuento 	= $_REQUEST['anchodescuento'];
$anchocantidad 	= $_REQUEST['anchocantidad'];
$anchoprecio 	= $_REQUEST['anchoprecio'];
$anchosubtotal 	= $_REQUEST['anchosubtotal'];
$tipdocu= $_REQUEST['tipdocu'];
if ($tip == 1) //////pie o cabecera
{
	$sql1="SELECT codformato FROM formato where sucursal = '$local' and descripcion = '$desc' and tipodoc = '$doc'";
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result1)){	
	while ($row1 = mysqli_fetch_array($result1)){
		$codformato = $row1['codformato'];	

	}
	mysqli_query($conexion,"update formato set contitcampo= '$titulo',linea = '$linea',columna = '$col',tipodoc = '$doc',cuanto = '$cuant',titulo='$posicion',descbrev = '$dbrev' where sucursal = '$local' and descripcion = '$desc' and tipodoc = '$doc'");
	header("Location: local2.php?val=$val&tip=$tip&local=$local&tipdocu=$tipdocu");
	}
	else
	{
		$sqlx="SELECT linea,columna FROM formato where sucursal = '$local' and titulo = '$posicion' and tipodoc = '$doc'";
		$resultx = mysqli_query($conexion,$sqlx);
		if (mysqli_num_rows($resultx)){	
		while ($rowx = mysqli_fetch_array($resultx)){
			$lineax   = $rowx['linea'];	
			$columnax = $rowx['columna'];	
	
		}
			if (($lineax == $linea) and ($columnax==$col))
			{
			header("Location: local2.php?val=$val&tip=$tip&local=$local&error=1&tipdocu=$tipdocu");
			}
			else
			{
			mysqli_query($conexion,"INSERT INTO formato (sucursal,descripcion,linea,columna,tipodoc,cuanto,titulo,descbrev,state,contitcampo) values ('$local','$desc','$linea','$col','$doc','$cuant','$posicion','$dbrev','1','$titulo')");
			header("Location: local2.php?val=$val&tip=$tip&local=$local&tipdocu=$tipdocu");
			}
		}
		else
		{
		mysqli_query($conexion,"INSERT INTO formato (sucursal,descripcion,linea,columna,tipodoc,cuanto,titulo,descbrev,state,contitcampo) values ('$local','$desc','$linea','$col','$doc','$cuant','$posicion','$dbrev','1','$titulo')");
		header("Location: local2.php?val=$val&tip=$tip&local=$local&tipdocu=$tipdocu");
		}
	} 
}
else
{
	$sql1="SELECT codloc FROM xcompadetalle where codloc = '$local' and tipdoc = '$tipdocu'";
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result1)){	
	mysqli_query($conexion,"update xcompadetalle set fdisp = '$disp',flinpag = '$lin1',fini = '$lin2',fcanti = '$lin8',fcodpro='$lin3',fmarca='$lin5',fpreuni='$lin9',fmonto='$lin10',fdescuento='$lin7',fnom='$lin4',fref ='$lin6',anchocod='$anchocod',anchonom='$anchonom',anchomarca='$anchomarca',anchoreferencial='$anchoreferencial',anchodescuento='$anchodescuento',anchocantidad='$anchocantidad',anchoprecio='$anchoprecio',anchosubtotal='$anchosubtotal' where codloc = '$local' and tipdoc = '$tipdocu'");
	}
	else
	{
	mysqli_query($conexion,"INSERT INTO xcompadetalle (codloc,tipdoc,fdisp,flinpag,fini,fcanti,fcodpro,fmarca,fpreuni,fmonto,fdescuento,fnom,fref,anchocod,anchonom,anchomarca,anchoreferencial,anchodescuento,anchocantidad,anchoprecio,anchosubtotal) values ('$local','$tipdocu','$disp','$lin1','$lin2','$lin8','$lin3','$lin5','$lin9','$lin10','$lin7','$lin4','$lin6','$anchocod','$anchonom','$anchomarca','$anchoreferencial','$anchodescuento','$anchocantidad','$anchoprecio','$anchosubtotal')");
	}
	header("Location: local2.php?val=$val&tip=$tip&local=$local&tipdocu=$tipdocu");
}
?>