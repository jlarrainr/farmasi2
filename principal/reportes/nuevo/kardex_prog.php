<?php include('../session_user.php');
require_once('../../conexion.php');
require_once('../../titulo_sist.php');
require_once('../../convertfecha.php');	//CONEXION A BASE DE DATOS
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=SIST_EXPORT_DATA.xls");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $desemp?></title>
</head>
<?php require_once("../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../funciones/funct_principal.php");	//IMPRIMIR-NUME
$sql="SELECT nomusu FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$user    = $row['nomusu'];
}
}
$date   		= date('d/m/Y');
$hour                   = date(G);  
//$hour   = CalculaHora($hour);
$min			= date(i);
if ($hour <= 12)
{
    $hor    = "am";
}
else
{
    $hor    = "pm";
}
$val   			= $_REQUEST['val'];
$country_ID 	= $_REQUEST['country_ID'];
$country		= $_REQUEST['country'];
$date1 			= $_REQUEST['date1'];
$date2 			= $_REQUEST['date2'];
$report			= $_REQUEST['report'];
$inicio 		= $_REQUEST['inicio'];
$pagina 		= $_REQUEST['pagina'];
$tot_pag 		= $_REQUEST['tot_pag'];
$registros  	= $_REQUEST['registros'];
$local 			= $_REQUEST['local'];
$dat1		= $date1;
$dat2       = $date2;
$date1  	= fecha1($date1);
$date2  	= fecha1($date2);
if ($pagina == 1)
{
$i=0;
}
else
{
$t = $pagina - 1;
$i = $t * $registros;
}
function formato($c) {
printf("%06d",$c);
} 
function convertir_a_numero($str)
{
	  $legalChars = "%[^0-9\-\. ]%";
	  $str=preg_replace($legalChars,"",$str);
	  return $str;
}
?>
<body>
<table width="930" border="0">
  <tr>
    <td width="1120">
      <table width="924" border="0">
        <tr>
          <td width="278"><strong><?php echo $desemp?> </strong></td>
            <td width="563"><div align="center"><strong>REPORTE DE KARDEX DE PRODUCTOS</strong></div></td>
            <td width="278"><div align="right"><strong>FECHA: <?php echo date('d/m/Y');?> - HORA : <?php echo $hour;?>:<?php echo $min;?> <?php echo $hor?></strong></div></td>
        </tr>
      </table>
      <table width="924" border="0">
        <tr>
          <td width="278"><strong>PAGINA <?php echo $pagina;?> de <?php echo $tot_pag?></strong></td>
            <td width="565"><div align="center"><b><?php if ($val == 1){ echo $country; }?></b></div></td>
            <td width="276"><div align="right">USUARIO:<span class="text_combo_select"><?php echo $user?></span></div></td>
        </tr>
      </table>
      <table width="924" border="0">
          <tr>
            <td><div align="center"><b>
              <?php if ($val == 1){echo "FECHAS ENTRE :"; echo $dat1; echo " AL "; echo $dat2;}?>
            </b></div></td>
          </tr>
      </table>
      <div align="left"><img src="../../images/line2.png" width="920" height="4" /></div></td>
  </tr>
</table>
<?php if ($val == 1)
{
?>
<table width="930" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="924" border="0">
      <tr>
		<td width="54"><strong>FECHA</strong></td>
        <td width="60"><div align="left"><strong>N&ordm; INT </strong></div></td>
        <td width="145"><div align="left"><strong>TIPO DE MOV </strong></div></td>
        <td width="85"><div align="left"><strong>N&ordm; DOC </strong></div></td>
        <td width="240"><div align="left"><strong>PROVEEDOR/CLIENTE</strong></div></td>
        <td width="193"><div align="left"><strong>USUARIO</strong></div></td>
        <td width="76"><div align="right"><strong>HISTOR. STOCK </strong></div></td>
        <td width="57"><div align="right"><strong>CANT</strong></div></td>
        </tr>
    </table></td>
  </tr>
</table>
<table width="930" border="1" cellpadding="0" cellspacing="0">
	  <?php
	  $sql="SELECT * FROM kardex where fecha between '$date1' and '$date2' and codpro = '$country_ID' and sucursal = '$local' order by fecha,codkard";
	  $result = mysqli_query($conexion,$sql);
	  if (mysqli_num_rows($result)){
	  while ($row = mysqli_fetch_array($result)){
		$fecha     = $row['fecha'];
		$nrodoc    = $row['nrodoc'];
		$tipmov    = $row['tipmov'];
		$tipdoc    = $row['tipdoc'];
		$qtypro    = $row['qtypro'];
		$fraccion  = $row['fraccion'];
		$factor    = $row['factor'];
		$sactual   = $row['sactual'];
		$invnum    = $row['invnum'];
		$ver	   = 0;
		$car	   = 0;
		//$saldoactual = 0;
		///////////////////////////////////////////////////////////////////////////////////
		if ($tipmov == 1)
		{
			$signo = "+ ";
			$sig   = 'mas';
			if ($tipdoc == 1)
			{
			$desctip = "INGRESO POR COMPRA";
			}
			if ($tipdoc == 2)
			{
			$desctip = "INGRESO POR TRANSF DE SUCURSAL";
			}
			if ($tipdoc == 3)
			{
			$desctip = "DEVOLUCION EN BUEN ESTADO";
			}
			if ($tipdoc == 4)
			{
			$desctip = "CANJE AL LABORATORIO";
			}
			if ($tipdoc == 5)
			{
			$desctip = "OTROS INGRESOS";
			}
		}
		if ($tipmov == 2)
		{
			$signo = "- ";
			$sig   = 'menos';
			if ($tipdoc == 1)
			{
			$desctip = "SALIDAS VARIAS";
			}
			if ($tipdoc == 2)
			{
			$desctip = "GUIAS DE REMISION";
			}
			if ($tipdoc == 3)
			{
			$desctip = "SALIDA POR TRANSFERENCIA DE SUCURSAL ";
			}
			if ($tipdoc == 4)
			{
			$desctip = "CANJE PROVEEDOR ";
			}
			if ($tipdoc == 5)
			{
			$desctip = "PRESTAMOS CLIENTE ";
			}
		}
		///////////////////////////////////////////////////////////////////////////////////
		if (($tipmov == 1) || ($tipmov == 2))
		{
			  //$sql1="SELECT invnum,usecod,cuscod FROM movmae where invfec = '$fecha' and numdoc = '$nrodoc' and tipmov = '$tipmov' and tipdoc = '$tipdoc'";
			  $sql1="SELECT invnum,usecod,cuscod FROM movmae where invfec = '$fecha' and invnum = '$invnum' and tipmov = '$tipmov' and tipdoc = '$tipdoc'";
			  $result1 = mysqli_query($conexion,$sql1);
			  if (mysqli_num_rows($result1)){
			  while ($row1 = mysqli_fetch_array($result1)){
			  $invnum     = $row1['invnum'];
			  $usecod     = $row1['usecod'];
			  $cuscod     = $row1['cuscod'];
			  }
			  }
		}
		if (($tipmov == 9) || ($tipmov == 10))
		{
			  $sql1="SELECT invnum,usecod,cuscod FROM venta where invfec = '$fecha' and nrovent = '$nrodoc'";
			  $result1 = mysqli_query($conexion,$sql1);
			  if (mysqli_num_rows($result1)){
			  while ($row1 = mysqli_fetch_array($result1)){
			  $invnum     = $row1['invnum'];
			  $usecod     = $row1['usecod'];
			  $cuscod     = $row1['cuscod'];
			  }
			  }
		}
		if (($tipmov == 11) || ($tipmov == 11))
		{
			  //$sql1="SELECT invnum,usecod,cuscod FROM movmae where invfec = '$fecha' and numdoc = '$nrodoc'";
			  $sql1="SELECT invnum,usecod,cuscod FROM movmae where invfec = '$fecha' and numdoc = '$nrodoc'";
			  $result1 = mysqli_query($conexion,$sql1);
			  if (mysqli_num_rows($result1)){
			  while ($row1 = mysqli_fetch_array($result1)){
			  $invnum     = $row1['invnum'];
			  $usecod     = $row1['usecod'];
			  $cuscod     = $row1['cuscod'];
			  }
			  }
		}
		  $sql1="SELECT nomusu FROM usuario where usecod = '$usecod'";
		  $result1 = mysqli_query($conexion,$sql1);
		  if (mysqli_num_rows($result1)){
		  while ($row1 = mysqli_fetch_array($result1)){
		  $user     = $row1['nomusu'];
		  }
		  }
		  if ($cuscod <> 0)
		  {
		  $sql1="SELECT descli FROM cliente where codcli = '$cuscod'";
		  $result1 = mysqli_query($conexion,$sql1);
		  if (mysqli_num_rows($result1)){
		  while ($row1 = mysqli_fetch_array($result1)){
		  $descli   = $row1['descli'];
		  }
		  }
		  }
		  else
		  {
		  $cudcod = 0;
		  $descli ="";
		  }
		///////////////////////////////////////////////////////////////////////////////////
		if (($tipmov == 9) && ($tipdoc == 9))
		{
			$signo   = "- ";
			$sig   	 = 'menos';
			$desctip = "VENTA";
			$ver	 = 1;
		}
		if (($tipmov == 10) && ($tipdoc == 9))
		{
			$signo = "+ ";
			$sig   = 'mas';
			$desctip = "VENTA DESHABILITADA";
			$ver	 = 1;
		}
		if (($tipmov == 10) && ($tipdoc == 10))
		{
			$signo 	 = "- ";
			$sig   	 = 'menos';
			$desctip = "VENTA HABILITADA";
			$ver	 = 1;
		}
		if (($tipmov == 11) && ($tipdoc == 11))
		{
			$signo = "+ ";
			$sig   = 'mas';
			$desctip = "INGRESO DE BONIF";
		}
		if (($tipmov == 9) && ($tipdoc == 11))
		{
			$signo   = "- ";
			$sig   	 = 'menos';
			$desctip = "VENTAS POR BONIF";
			$ver	 = 1;
		}
		if ($factor == 1)
		{
			if ($qtypro <> "")
			{
				$cant      = $qtypro;
				$descuenta = $cant * $factor;
				$car	   = $descuenta;
				$cant_desc = "C".$cant;
			}
			//echo $qtypro;
			if ($fraccion <> "")
			{
				$cant      = convertir_a_numero($fraccion);
				$descuenta = $cant;
				$car	   = $descuenta;
				$cant_desc = "C".$cant;
			}
		}
		else
		{
			if ($qtypro <> "")
			{
				$cant      = $qtypro;
				$descuenta = $cant * $factor;
				$car	   = $descuenta;
				$cant_desc = "C".$cant;
			}
			//echo $qtypro;
			if ($fraccion <> "")
			{
				$cant      = convertir_a_numero($fraccion);
				$descuenta = $cant;
				$car	   = $descuenta;
				$cant_desc = "U".$cant;
			}
		}
		//echo $fraccion;
		/*echo $car;
		echo ' + ';
		echo $sactual;
		echo ' = ';
		echo $saldoactual;
		echo '<br>';
		*/
		if ($sig == 'mas')
		{
		$saldoactual = $car + $saldoactual;
		}
		else
		{
		$saldoactual = $saldoactual - $car;
		}
		if ($ver == 1)
		{
		$dir = 'ver_venta_usu.php?invnum='.$invnum;
		}
		else
		{
		$dir = 'ver_movimiento1.php?invnum='.$invnum;
		}
	  ?>
	  <tr>
        <td width="60"><?php echo fecha($fecha)?></td>
		<td width="60">
		<a href="javascript:popUpWindow('<?php echo $dir?>', 10, 50, 1000, 350)">
		<?php echo formato($invnum);?></a></td>
        <td width="145"><div align="left"><?php echo $desctip?></div></td>
        <td width="85"><div align="left"><?php echo formato($nrodoc);?></div></td>
        <td width="240"><div align="left"><?php echo substr($descli,0,70);?></div></td>
        <td width="193"><div align="left"><?php echo substr($user,0,70)?></div></td>
        
        <!--<td width="83"><div align="right"><?php echo $saldoactual;?></div></td>-->
        <td width="76"><div align="right"><?php echo $sactual;?></div></td>
        <td width="57"><div align="right"><?php echo $signo; echo $cant_desc?></div></td>
      </tr>
	  <?php }
	  }
	  else
	  {
	  ?>
	  <center><br /><br /><br /><br />NO SE PUDO ENCONTRAR INFORMACION CON LOS DATOS INGRESADOS</center>
	  <?php }
	  ?>
</table>
<?php }
?>
</body>
</html>
