<?php include('../session_user.php');
require_once('../../conexion.php');
require_once('../../titulo_sist.php');
require_once('../../convertfecha.php');	//CONEXION A BASE DE DATOS
//header("Content-Type: application/vnd.ms-excel");
//header("Expires: 0");
//header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
//header("content-disposition: attachment;filename=SIST_EXPORT_DATA.xls");
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
$date   = date('d/m/Y');
$hour  = date(G);  
//$hour   = CalculaHora($hour);
$min	= date(i);
if ($hour <= 12)
{
    $hor    = "am";
}
else
{
    $hor    = "pm";
}
//$val    = $_REQUEST['val'];
//$date1  = $_REQUEST['date1'];
//$date2  = $_REQUEST['date2'];
//$local  = $_REQUEST['local'];
//$inicio = $_REQUEST['inicio'];
$pagina = $_REQUEST['pagina'];
$ord    = $_REQUEST['ord'];
$tip    = $_REQUEST['tip'];
$tot_pag = $_REQUEST['tot_pag'];
$registros  = $_REQUEST['registros'];
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
if ($local <> 'all')
{
	$sql="SELECT nomloc FROM xcompa where codloc = '$local'";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
		$nomloc    = $row['nomloc'];
	}
	}
}
?>
<body>
<table width="930" border="0" align="center">
  <tr>
    <td><table width="914" border="0">
      <tr>
        <td width="260"><strong><?php echo $desemp?> </strong></td>
        <td width="380">
		<div align="center"><strong>REPORTE CURVA ABC - 
          <?php if ($local == 'all'){ echo 'TODAS LAS SUCURSALES';} else { echo $nomloc;}?>
        </strong></div>
		</td>
        <td width="260">
		<div align="right"><strong>FECHA: <?php echo date('d/m/Y');?> - HORA : <?php echo $hour;?>:<?php echo $min;?> <?php echo $hor?></strong></div></td>
      </tr>

    </table>
      <table width="914" border="0">
        <tr>
          <td width="134"><strong>PAGINA <?php echo $pagina;?> de <?php echo $tot_pag?></strong></td>
          <td width="633">
		  <div align="center">
		  <b>
		  <?php if ($val == 1){?>
            FECHAS ENTRE EL <?php echo $dat1; ?> Y EL <?php echo $dat2; }?>
		  </b>
		  </div>
		  </td>
          <td width="133"><div align="right">USUARIO:<span class="text_combo_select"><?php echo $user?></span></div></td>
        </tr>
      </table>
      <div align="center"><img src="../../images/line2.png" width="910" height="4" /></div></td>
  </tr>
</table>
<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="926" border="0" align="center">
      <tr>
        <td width="38"><strong>N�</strong></td>
        <td width="379"><div align="left"><strong>PRODUCTO </strong></div></td>
        <td width="169"><div align="left"><strong>MARCA</strong></div></td>
        <td width="68"><div align="right"><strong> 
		<a href="curva2.php?val=<?php echo $val?>&date1=<?php echo $date1?>&date2=<?php echo $date2?>&local=<?php echo $local?>&inicio=<?php echo $inicio?>&registros=<?php echo $registros?>&pagina=<?php echo $pagina?>&tot_pag=<?php echo $total_paginas?>&ord=1&tip=1"><img src="down_enabled.gif" width="7" height="9" border="0" /></a>
		MONTO
		<a href="curva2.php?val=<?php echo $val?>&date1=<?php echo $date1?>&date2=<?php echo $date2?>&local=<?php echo $local?>&inicio=<?php echo $inicio?>&registros=<?php echo $registros?>&pagina=<?php echo $pagina?>&tot_pag=<?php echo $total_paginas?>&ord=0&tip=1"><img src="up_enabled.gif" width="7" height="9" border="0"/></a>
		</strong></div></td>
        <td width="87"><div align="right"><strong> 
		<?php /*?><a href="curva2.php?val=<?php echo $val?>&date1=<?php echo $date1?>&date2=<?php echo $date2?>&local=<?php echo $local?>&inicio=<?php echo $inicio?>&registros=<?php echo $registros?>&pagina=<?php echo $pagina?>&tot_pag=<?php echo $total_paginas?>&ord=1&tip=2"><img src="down_enabled.gif" width="7" height="9" border="0" /></a> <?php */?>
		UNIDADES
		<?php /*?>
		<a href="curva2.php?val=<?php echo $val?>&date1=<?php echo $date1?>&date2=<?php echo $date2?>&local=<?php echo $local?>&inicio=<?php echo $inicio?>&registros=<?php echo $registros?>&pagina=<?php echo $pagina?>&tot_pag=<?php echo $total_paginas?>&ord=0&tip=2"><img src="up_enabled.gif" width="7" height="9" border="0"/></a><?php */?>
		</strong></div></td>
        <td width="77"><div align="right"><strong>% DEL TOTAL</strong></div></td>
        <td width="78"><div align="right"><strong>TOTAL DEL % </strong></div></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<table width="920" border="0" align="center">
<?php
if ($tip == "")
{
$tip = 1;
}
if ($tip == 1)
{
	if ($local == 'all')
	{
	$sql="SELECT sum(invtot) FROM venta where invfec between '$date1' and '$date2'";
	}
	else
	{
	$sql="SELECT sum(invtot) FROM venta where invfec between '$date1' and '$date2' and sucursal = '$local'";
	}
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
	$tot       = $row[0];
	}
	}
	$sumporc = 0;
	//----------------------//
	if ($ord == 1)
	{
		if ($local == 'all')
		{
		$sql="SELECT sum(pripro),codpro FROM detalle_venta where invfec between '$date1' and '$date2' group by codpro order by sum(pripro) asc";
		}
		else
		{
		$sql="SELECT sum(pripro),codpro FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where detalle_venta.invfec between '$date1' and '$date2' and sucursal = '$local' group by codpro order by sum(pripro) asc";
		}
	}
	else
	{
		if ($local == 'all')
		{
		$sql="SELECT sum(pripro),codpro FROM detalle_venta where invfec between '$date1' and '$date2' group by codpro order by sum(pripro) desc";
		}
		else
		{
		$sql="SELECT sum(pripro),codpro FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where detalle_venta.invfec between '$date1' and '$date2' and sucursal = '$local' group by codpro order by sum(pripro) desc";
		}
	}
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
	    $i++;
		$cantidad  = 0;
		$sumcantidad  = 0;
		$sum       = $row[0];
		$codpro    = $row['codpro'];
		if ($local == 'all')
		{
		$sql1="SELECT invnum,canpro,fraccion,factor FROM detalle_venta where invfec between '$date1' and '$date2' and codpro = '$codpro'";
		}
		else
		{
		$sql1="SELECT venta.invnum,canpro,fraccion,factor FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where detalle_venta.invfec between '$date1' and '$date2' and codpro = '$codpro' and sucursal = '$local'";
		}
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$invnum        = $row1['invnum'];
		$canpro        = $row1['canpro'];
		$fraccion      = $row1['fraccion'];
		$factor        = $row1['factor'];
			if ($fraccion == 'T')
			{
			$cantidad = $canpro;
			}
			else
			{
			$cantidad = $canpro * $factor;
			}
			$sumcantidad = $sumcantidad + $cantidad;
		}
		}
		$sql1="SELECT desprod,codmar FROM producto where codpro = '$codpro'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$desprod       = $row1['desprod'];
		$codmar        = $row1['codmar'];
		}
		}
		$sql1="SELECT destab,abrev FROM titultabladet where codtab = '$codmar'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$destab        = $row1['destab'];
		$abrev         = $row1['abrev'];
		if ($abrev <> '')
						{
						$destab = $abrev;
						}
		}
		}
		$porcentaje = ($sum/$tot)*100;
		$sumporc    = $sumporc + $porcentaje;
	?>
	  <tr>
        <td width="35"><?php echo $i;?></td>
        <td width="379"><?php echo $desprod?></td>
        <td width="169"><?php echo $destab?></td>
        <td width="68"><div align="right"><?php echo $sum?></div></td>
        <td width="88"><div align="right"><?php echo $sumcantidad?></div></td>
        <td width="77"><div align="right"><?php echo $numero_formato_frances = number_format($porcentaje, 2, '.', ' ');?> %</div></td>
        <td width="74"><div align="right"><?php echo $numero_formato_frances = number_format($sumporc, 2, '.', ' ');?> %</div></td>
      </tr>
	<?php }
	}
	else
	{
	?>
	<center><u>NO SE LOGRO ENCONTRAR INFORMACION CON LOS DATOS INDICADOS</u></center>
	<?php }
}
	?>
    </table></td>
  </tr>
</table>
</body>
</html>
