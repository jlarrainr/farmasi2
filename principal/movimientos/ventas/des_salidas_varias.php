<?php require_once('../../session_user.php');
require_once('../../../conexion.php');
$cod	 = $_REQUEST['cod'];		///CODIGO UTILIZADO PARA ELIMINAR

//ECHO $cod;
$sql = "SELECT nrovent,invfec,usecod,cuscod,invtot FROM venta where invnum = '$cod'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$numdoc    = $row['nrovent'];
		$invfec    = $row['invfec'];
		$usecod    = $row['usecod'];
		$cuscod    = $row['cuscod'];
		$invtot    = $row['invtot'];
	}
}
$sql1 = "SELECT  drogueria FROM datagen_det";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
	while ($row1 = mysqli_fetch_array($result1)) {

		$drogueria      = $row1['drogueria'];
	}
}

$sql = "SELECT puntosdiv,precioIcbperAnual,diasCuotasVentas FROM datagen ";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $puntosdiv1 = $row['puntosdiv'];
        $precioIcbperAnual = $row['precioIcbperAnual'];
        $diasCuotasVentas = $row['diasCuotasVentas'];
    }
}
if ($puntosdiv1 == '0.00') {

    $puntosdiv = '1.00';
} else {
    $puntosdiv = $puntosdiv1;
}


$date = date("Y-m-d");
//$hour   = date(G);
//$date	= CalculaFechaHora($hour);
require_once('funciones/datos_generales.php'); //////CODIGO Y NOMBRE DEL LOCAL
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
$sql = "SELECT codpro,canpro,fraccion,factor,idlote FROM detalle_venta where invnum = '$cod'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$codpro         = $row['codpro'];
		$canpro         = $row['canpro'];
		$fraccion       = $row['fraccion'];
		$factor         = $row['factor'];
		$idlote         = $row['idlote'];
		if ($fraccion == 'F') {
			$cantidad = $canpro * $factor;
			$cantidad_kardex = $canpro;
		} else {
			$cantidad = $canpro;
			$cantidad_kardex = 'f' . $canpro;
		}
		$sql1 = "SELECT stopro,$tabla,codpro FROM producto where codpro = '$codpro'";
		$result1 = mysqli_query($conexion, $sql1);
		if (mysqli_num_rows($result1)) {
			while ($row1 = mysqli_fetch_array($result1)) {
				$stopro    = $row1['stopro'];
				$codpro    = $row1['codpro'];
				$cant_loc  = $row1[1];
			}
		}
		$total_lote = 0;
		$sqlLote = "SELECT stock FROM movlote where idlote = '$idlote'";
		$resultLote = mysqli_query($conexion, $sqlLote);
		if (mysqli_num_rows($resultLote)) {
			while ($row1 = mysqli_fetch_array($resultLote)) {
				$stockLote    = $row1['stock'];
			}
			$total_lote  = $stockLote + $cantidad;
		}
		$total_local = $cantidad + $cant_loc;
		$total_general = $cantidad + $stopro;

		mysqli_query($conexion, "UPDATE movlote set stock = '$total_lote' where idlote = '$idlote'");
		mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', $tabla = '$total_local' where codpro = '$codpro'");
		if ($fraccion == 'T') {
			mysqli_query($conexion, "INSERT INTO kardex(nrodoc,codpro,fecha,tipmov,tipdoc,fraccion,factor,invnum,usecod,sactual,sucursal) values ('$numdoc','$codpro','$date','10','9','$cantidad_kardex','$factor','$cod','$usuario','$cant_loc','$codloc')");
		} else {
			mysqli_query($conexion, "INSERT INTO kardex(nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,factor,invnum,usecod,sactual,sucursal) values ('$numdoc','$codpro','$date','10','9','$cantidad_kardex','$factor','$cod','$usuario','$cant_loc','$codloc')");
		}
	}
}

 //PUNTOS DE CLIENTES
    if ($cuscod <> 0) {
        $Puntos = 0;
        $sqlPuntos = "SELECT codcli,puntos FROM cliente where codcli = '$cuscod' AND ((descli <> 'PUBLICO EN GENERAL') )";
        $resultPuntos = mysqli_query($conexion, $sqlPuntos);
        if (mysqli_num_rows($resultPuntos)) {
            while ($row = mysqli_fetch_array($resultPuntos)) {
                $codcli = $row['codcli'];
                $Puntos2 = $row['puntos'];
            }
            
            
            // por si canjea sus ountos antes de anular entonces si puntos =0 - n sale error
            
            // n =inctot
            if($Puntos2 >=  (intval($invtot) / $puntosdiv)){
            $Puntos = $Puntos2 - (intval($invtot) / $puntosdiv)  ;
            $sqlVP = "UPDATE cliente set puntos = '$Puntos' where codcli = '$codcli'";
            $result2 = mysqli_query($conexion, $sqlVP);
            }
            
        }
    }

mysqli_query($conexion, "UPDATE venta set val_habil = '1' where invnum = '$cod'");
mysqli_query($conexion, "UPDATE venta_cuotas set eliminado = '1' where venta_id = '$cod'");

header("Location: ventas.php?retorno=$cod&tip=1");
