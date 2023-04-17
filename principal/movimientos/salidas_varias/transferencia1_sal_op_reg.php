<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$cod    	 = $_POST['cod'];			///invnum
$referencia  = $_POST['referencia'];	///referencia
$mont2  	 = $_POST['mont2'];			///monto total
function convertir_a_numero($str)
{
	  $legalChars = "%[^0-9\-\. ]%";
	  $str=preg_replace($legalChars,"",$str);
	  return $str;
}
////VERIFICO LOS DATOS DEL DOCUMENTO Y ESCOGO EL USUARIO Y SU LOCAL
$sql="SELECT numdoc,invfec,tipmov,tipdoc,usecod FROM movmae where invnum = '$cod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    	$numdoc    = $row['numdoc'];
		$invfec    = $row['invfec'];
		$tipmov    = $row['tipmov'];
		$tipdoc    = $row['tipdoc'];
		$usecod    = $row['usecod'];
}
}
$sql="SELECT codloc FROM usuario where usecod = '$usecod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
			$codloc    = $row['codloc'];
}
}
$sql="SELECT nomloc FROM xcompa where codloc = '$codloc'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    		$nomloc    = $row['nomloc'];
}
}
require_once('../tabla_local.php');
$sql="SELECT codpro,qtypro,qtyprf,pripro,costre,costpr,numlote FROM tempmovmov where invnum = '$cod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    	$codpro    = $row['codpro'];
		$qtypro    = $row['qtypro'];
		$qtyprf    = $row['qtyprf'];
		$pripro    = $row['pripro'];
		$costre    = $row['costre'];
		$costpr    = $row['costpr'];
		$numlote   = $row['numlote'];
		$sql1="SELECT factor,stopro,$tabla FROM producto where codpro = '$codpro'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
				$factor    = $row1['factor'];
				$stopro    = $row1['stopro'];
				$cant_loc  = $row1[2];
//				$sactual   = $stopro;
                                $sactual   = $cant_loc;
		}
		}
		if ($qtyprf <> "")
		{
			$text_char =  convertir_a_numero($qtyprf);
			$cant_unid = $text_char;
		}
		else
		{
			$cant_unid = $qtypro * $factor;
		}
		//echo "existe este producto";
		$cant_local = $cant_loc - $cant_unid ;
		$stopro = $stopro - $cant_unid;
		$stocklote = 0;
		/////////////////////////////////////////////////////////////////////

		/////////////////////////////////////////////////////////////
		mysqli_query($conexion,"UPDATE producto set stopro = '$stopro',$tabla = '$cant_local' where codpro = '$codpro'");
		mysqli_query($conexion,"INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual,sucursal) values ('$numdoc','$codpro','$invfec','$tipmov','$tipdoc','$qtypro','$qtyprf','$factor','$cod','$usuario','$sactual','$codloc')")	;

		/////////////////////////////////////////////////
mysqli_query($conexion,"INSERT INTO movmov (invnum,invfec,codpro,qtypro,qtyprf,pripro,costre,costpr,numlote) values ('$cod','$invfec','$codpro','$qtypro','$qtyprf','$pripro','$costre','$costpr','$numlote')")	;
}
}
mysqli_query($conexion,"DELETE from tempmovmov where invnum = '$cod'")	;
mysqli_query($conexion,"UPDATE movmae set invtot  = '$mont2', monto = '$mont2',refere = '$referencia', estado = '0', proceso = '0' where invnum = '$cod'");
header("Location: transferencia1_sal_op_reg.php"); 
?>