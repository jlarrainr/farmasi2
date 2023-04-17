<?php include('../../session_user.php');
require_once('../../../conexion.php');
$cod    	 = $_POST['cod'];			///invnum
$referencia  = $_POST['referencia'];	///referencia
$local_dest	 = $_POST['local'];			///local
$vendedor    = $_POST['vendedor'];		///vendedor destino
$mont2  	 = $_POST['mont2'];	///monto total
function convertir_a_numero($str)
{
	$legalChars = "%[^0-9\-\. ]%";
	$str = preg_replace($legalChars, "", $str);
	return $str;
}
////VERIFICO LOS DATOS DEL DOCUMENTO Y ESCOGO EL USUARIO Y SU LOCAL
$sql = "SELECT numdoc,invfec,tipmov,tipdoc,usecod FROM movmae where invnum = '$cod'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$numdoc    = $row['numdoc'];
		$invfec    = $row['invfec'];
		$tipmov    = $row['tipmov'];
		$tipdoc    = $row['tipdoc'];
		$usecod    = $row['usecod'];
	}
}
$sql = "SELECT codloc FROM usuario where usecod = '$usecod'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$codloc    = $row['codloc'];
	}
}
$sql = "SELECT nomloc FROM xcompa where codloc = '$codloc'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$nomloc    = $row['nomloc'];
	}
}
$numero_xcompa = substr($nomloc, 5, 2);
$tabla = "s" . str_pad($numero_xcompa, 3, "0", STR_PAD_LEFT);

$sqlP_drogueria = "SELECT  drogueria  FROM datagen_det";
$resultP_drogueria = mysqli_query($conexion, $sqlP_drogueria);
if (mysqli_num_rows($resultP_drogueria)) {
	while ($row_drogueria = mysqli_fetch_array($resultP_drogueria)) {
		$drogueria = $row_drogueria['drogueria'];
	}
}


$sql = "SELECT codpro,qtypro,qtyprf,pripro,costre,costpr,numlote FROM tempmovmov where invnum = '$cod'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$codpro    = $row['codpro'];
		$qtypro    = $row['qtypro'];
		$qtyprf    = $row['qtyprf'];
		$pripro    = $row['pripro'];
		$costre    = $row['costre'];
		$costpr    = $row['costpr'];
		$numlote   = $row['numlote'];
		$sql1 = "SELECT factor,stopro,$tabla,codpro FROM producto where codpro = '$codpro'";
		$result1 = mysqli_query($conexion, $sql1);
		if (mysqli_num_rows($result1)) {
			while ($row1 = mysqli_fetch_array($result1)) {
				$factor    	= $row1['factor'];
				$stopro    	= $row1['stopro'];
				$cant_loc1  = $row1[2];
				$codpro    	= $row1['codpro'];


				if ($drogueria == 1) {

					$sql1_movlote = "SELECT  SUM(stock) FROM movlote where codpro = '$codpro' and codloc='$codloc' and stock > 0 and date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') >= NOW() ORDER BY date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d')   ";
					$result1_movlote = mysqli_query($conexion, $sql1_movlote);
					if (mysqli_num_rows($result1_movlote)) {
						while ($row1_movlote = mysqli_fetch_array($result1_movlote)) {
							$stock_movlote = $row1_movlote[0];
						}
					}

					$cant_loc = $stock_movlote;
				} else {

					$cant_loc = $cant_loc1;
				}

				$sactual   = $cant_loc;
			}
		}
		if ($qtyprf <> "") {
			$text_char =  convertir_a_numero($qtyprf);
			$cant_unid = $text_char;
		} else {
			$cant_unid = $qtypro * $factor;
		}
		//echo "existe este producto";
		$cant_local = $cant_loc - $cant_unid;
		$stopro = $stopro - $cant_unid;
		$stocklote = 0;
		/////////////////////////////////////////////////////////////////////
		if ($numlote <> "") {
			$sql1 = "SELECT numlote,vencim,stock FROM movlote where numlote = '$numlote'";
			$result1 = mysqli_query($conexion, $sql1);
			if (mysqli_num_rows($result1)) {
				while ($row1 = mysqli_fetch_array($result1)) {
					$numerolote     = $row1['numlote'];
					$fvencimi       = $row1['vencim'];
					$stocklote      = $row1['stock'];
					$stocklote		= $stocklote - $cant_local;
				}
				mysqli_query($conexion, "UPDATE movlote set stock = '$stocklote' where codpro = '$codpro' and numlote = '$numerolote'");
			}
		}
		/////////////////////////////////////////////////////////////
		mysqli_query($conexion, "UPDATE producto set stopro = '$stopro',$tabla = '$cant_local' where codpro = '$codpro'");
		mysqli_query($conexion, "INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual,sucursal) values ('$numdoc','$codpro','$invfec','$tipmov','$tipdoc','$qtypro','$qtyprf','$factor','$cod','$usuario','$sactual','$codloc')");

		/////////////////////////////////////////////////
		mysqli_query($conexion, "INSERT INTO movmov (invnum,invfec,codpro,qtypro,qtyprf,pripro,costre,costpr,numlote) values ('$cod','$invfec','$codpro','$qtypro','$qtyprf','$pripro','$costre','$costpr','$numlote')");

		//mysqli_query($conexion,"INSERT INTO detalle_venta(invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr,bonif,incentivo) values ('$venta','$date','$cuscod','$usuario','$codpro','$canpro','$fraccion','$factor','$prisal','$pripro','$codmar','$cospro','$costpr','$bonif','$yesincentivo')")	;

	}
}
mysqli_query($conexion, "DELETE from tempmovmov where invnum = '$cod'");
mysqli_query($conexion, "UPDATE movmae set invtot  = '$mont2', monto = '$mont2',refere = '$referencia', codusu = '$vendedor', estado = '0', proceso = '0' where invnum = '$cod'");

//mysqli_query($conexion,"UPDATE venta set bruto = '$mont1',valven = '$mont3',igv = '$mont4',invtot = '$mont5',saldo = '$mont5',estado = '0',cosvta = '$total_costo',hora = '$hora',redondeo = '$redondeo' where invnum = '$venta'");




header("Location: transferencia1_sal_op_reg1.php");
