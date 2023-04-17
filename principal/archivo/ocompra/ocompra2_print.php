<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="css/style1.css" rel="stylesheet" type="text/css" />
<link href="css/style2.css" rel="stylesheet" type="text/css" /><?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../../../titulo_sist.php');
require_once('../../../convertfecha.php');	//CONEXION A BASE DE DATOS
require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUME
$invnum    = $_REQUEST['invnum'];
function formato($c) {
printf("%08d",  $c);
} 
function formato1($c) {
printf("%06d",  $c);
} 
mysqli_query($conexion,"UPDATE ordmae set impreso = '1' where invnum = '$invnum'");
$sql="SELECT invfec,invnum,nrocomp,refere,invtot,codusu,provee,nrocomp,condicio FROM ordmae where invnum = '$invnum'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$invfec    = $row['invfec'];
	$invnum    = $row['invnum'];
	$tipmov    = $row['tipmov'];
	$numdoc    = $row['nrocomp'];
	$cuscod    = $row['cuscod'];
	$refere    = $row['refere'];
	$monto     = $row['invtot'];
	$codusu    = $row['codusu'];
	$provee    = $row['provee'];
	$condicio    = $row['condicio'];
}
}
$scanpro = 0;
$scanbon = 0;
$sql="SELECT canpro,factor FROM ordmov where invnum = '$invnum' and canpro <> '0'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$canpro    = $row['canpro'];
	$factor    = $row['factor'];
	$canpro	   = $canpro * $factor;
	$scanpro   = $scanpro + $canpro;
}
}

$sql="SELECT canbon,factor,tipbon FROM ordmov where invnum = '$invnum' and canpro = '0'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$canbon    = $row['canbon'];
	$factor    = $row['factor'];
	$tipbon    = $row['tipbon'];
	if ($tipbon == 'U')
	{
	$scanbon   = $scanbon + $canbon;
	}
	else
	{
	$canbon	   = $canbon * $factor;
	$scanbon   = $scanbon + $canbon;
	}
}
}
$dcto_bon = ($scanbon/($scanbon + $scanpro))*100;
$vn1 = $monto * 1.19;
$vn2 = $vn1 - $monto;
$vn  = ($monto - $vn2)+$dcto_bon;
$pn  = $monto +$dcto_bon;
$sql="SELECT nomusu FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$nomuser    = $row['nomusu'];
}
}
$sql="SELECT nomusu FROM usuario where usecod = '$codusu'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$users    = $row['nomusu'];
}
}
$sql="SELECT despro,dirpro,rucpro FROM proveedor where codpro = '$provee'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$proveedor   = $row['despro'];
	$dirpro      = $row['dirpro'];
	$rucpro      = $row['rucpro'];
}
}
echo $proveedor;
$sql1="SELECT porcent FROM datagen";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
	$porcent    = $row1['porcent'];
}
}
?><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $desemp?></title>
</head>

<body>
<table width="1013" border="0" align="center">
  <tr>
    <td><table width="914" border="0">
      <tr>
        <td width="260"><strong><?php echo $desemp?> </strong></td>
        <td width="380"><div align="center">
		<a href="javascript:imprimir()"><strong>ORDEN DE COMPRA</strong></a></div></td>
        <td width="260"><div align="right"></div></td>
      </tr>
    </table>
        <table width="914" border="0">
          <tr>
            <td width="176">&nbsp;</td>
            <td width="424">&nbsp;</td>
            <td width="300"><strong>Orden de compra : <?php echo $numdoc;?></strong></td>
          </tr>
        </table>
        <table width="914" border="0">
          <tr>
            <td width="176">&nbsp;</td>
            <td width="424">&nbsp;</td>
            <td width="300"><strong>Fecha de emisi&oacute;n  : <?php echo fecha($invfec);?></strong></td>
          </tr>
        </table>
        <table width="914" border="0">
          <tr>
            <td width="176"><strong>Proveedor </strong></td>
            <td width="457"><div align="left"><b></b><?php echo $proveedor?></div></td>
            <td width="267"><div align="right"></div></td>
          </tr>
        </table>
        <table width="914" border="0">
          <tr>
            <td width="176">&nbsp;</td>
            <td width="424">&nbsp;</td>
            <td width="300">&nbsp;</td>
          </tr>
        </table>
        <table width="914" border="0">
          <tr>
            <td width="176"><strong>Plazo y condici&oacute;n </strong></td>
            <td width="346"><div align="left"><?php echo $condicio;?></div></td>
			<td width="109"><div align="left"><strong>Fecha de entrega</strong></div></td>
			<td width="265"><div align="left"></div></td>
          </tr>
        </table>
    </td>
  </tr>
</table>
<div align="center"></div>
<table width="1019" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="1015"><table width="1019" border="0" align="center">
      <tr>
        <td width="90"><strong>C&oacute;digo</strong></td>
		<td width="209"><strong>Descripci&oacute;n</strong></td>
        <td width="51"><div align="left"><strong>Lab</strong></div></td>
        <td width="59"><div align="right"><strong>Cantidad</strong></div></td>
        <td width="38"><div align="right"><strong>Bonif </strong></div></td>
        <td width="66"><div align="right"><strong>V. Compra </strong></div></td>
		<td width="51"><div align="right"><strong>Dcto1. </strong></div></td>
		<td width="51"><div align="right"><strong>Dcto2</strong></div></td>
		<td width="51"><div align="right"><strong>Dcto3</strong></div></td>
		<td width="51"><div align="right"><strong>Dcto4</strong></div></td>
		<td width="61"><div align="right"><strong>V. Unita. </strong></div></td>
		<td width="61"><div align="right"><strong>SubTotal</strong></div></td>
		<td width="61"><div align="right"><strong>Neto <br />
		  c/igv </strong></div></td>
		<td width="61"><div align="right"><strong>Precio Costo U. </strong></div></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="1019" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="974">
	<?php $sql="SELECT ordmae.invnum,nrocomp,codpro,canpro,canate,mont_total,desc1,desc2,desc3,precio_ref,costod,canbon,tipbon,pfinal FROM ordmov inner join ordmae on ordmov.invnum = ordmae.invnum where ordmae.invnum = '$invnum'";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	?>
	<table width="1019" border="0" align="center">
      <?php while ($row = mysqli_fetch_array($result)){
	  		$invnum     = $row["invnum"];
			$nrocomp    = $row["nrocomp"];
			$codpro     = $row["codpro"];
			$canpro     = $row["canpro"];
			$canate     = $row["canate"];
			$costod     = $row["costod"]; //pripro
			$precio_ref = $row["precio_ref"]; //prisal
			$mont_total = $row["mont_total"];
			$desc1      = $row["desc1"];
			$desc2      = $row["desc2"];
			$desc3      = $row["desc3"];
			$canbon     = $row["canbon"];
			$tipbon     = $row["tipbon"];
			$pfinal     = $row["pfinal"];
			$sql1="SELECT desprod,factor,codmar,igv FROM producto where codpro = '$codpro'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
	  		$desprod    = $row1['desprod'];
			$factor     = $row1['factor'];
			$codmar     = $row1['codmar'];
			$igv        = $row1['igv'];
			}
			}
			$sql1="SELECT destab FROM titultabladet where codtab = '$codmar'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
	  		$destab    = $row1['destab'];
			}
			}
			/////ATENDIDA//////////////////////////////////
			/////////////////////////////////////
			$convert1   = $canate/$factor;
			$div1    	= floor($convert1);
			$mult1		= $factor * $div1;
			$tot1		= $canate - $mult1;
			/////RESULTANTE//////////////////////////////////
			$can_fact   = $canpro * $factor;
			$tot        = $can_fact - $canate;
			/////////////////////////////////////
			$convert    = $tot/$factor;
			$div    	= floor($convert);
			$mult		= $factor * $div;
			$tot		= $tot - $mult;
			/////////////TOTALES
			//////////CALCULO DEL MONTO BRUTO - SIN DESCUENTO CON IGV
			$sum_mont1 = $precio_ref * $canpro;
			$mont_bruto= $mont_bruto + $sum_mont1;
			//////////CALCULO DEL VALOR VENTA
			if ($igv == 1)
			{
			$valor_vent		= ($costod/(($porcent/100)+1))*$canpro;
			$valor_vent1	= $valor_vent1 + $valor_vent;
			}
			else
			{
			$valor_vent     = ($costod * $canpro);
			$valor_vent1	= $valor_vent1 + $valor_vent;
			}
	  ?>
	  <tr>
        <td width="91"><?php echo $codpro;?></td>
		<td width="207"><?php echo $desprod; echo " "; if ($costod == 0){?>(BONIF)
          <?php }?></td>
        <td width="52"><div align="right"></div></td>
        <td width="59"><div align="right">
          <?php if ($mont_total == 0) { echo $canbon; echo " "; echo $tipbon;} else{ echo $canpro;}?>
        </div></td>
        <td width="38"><div align="right">
          <?php if ($mont_total <> 0) { echo $canbon; if ($canbon <> 0){ echo " ";echo $tipbon;}}?>
        </div></td>
        <td width="66"><div align="right"><?php echo $desc3?></div></td>
        <td width="51"><div align="right"><?php echo $desc1?></div></td>
		<td width="51"><div align="right"><?php echo $desc2?></div></td>
		<td width="51"><div align="right"><?php echo $desc3?></div></td>
		<td width="51"><div align="right"><?php echo $desc4?></div></td>
		<td width="61"><div align="right"><?php echo $costod?></div></td>
		<td width="61"><div align="right"></div></td>
        <td width="61"><div align="right"><?php echo $desc3?></div></td>
        <td width="61"><div align="right"><?php echo $costod?></div></td>
	  </tr>
	  <?php }
	  //////////CALCULO DEL IGV
			$total_des		= $mont_bruto - $valor_vent1;
			$sum_igv		= ($monto - $valor_vent1);
			$sum1 			=  $numero_formato_frances = number_format($mont_bruto, 2, '.', ',');
			$sum2 			=  $numero_formato_frances = number_format($total_des, 2, '.', ',');
			$sum3			=  $numero_formato_frances = number_format($valor_vent1, 2, '.', ',');
			$sum4			=  $numero_formato_frances = number_format($sum_igv, 2, '.', ',');
			$sum5			=  $numero_formato_frances = number_format($monto, 2, '.', ',');
	  ?>
    </table>
	<?php }
	?>
	</td>
  </tr>
</table>
<br />
<table width="1019" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="1009" border="0" align="center">
      <tr>
        <td width="52" valign="top"><strong>V. Bruto </strong></td>
        <td width="84" valign="top"><?php echo $sum1?></td>
        <td width="46" valign="top"><strong>Dcto1</strong></td>
        <td width="56" valign="top">&nbsp;</td>
        <td width="43" valign="top"><strong>Dcto2</strong></td>
        <td width="59" valign="top">&nbsp;</td>
        <td width="43" valign="top"><strong>Dcto3</strong></td>
        <td width="59" valign="top">&nbsp;</td>
        <td width="80" valign="top"><strong>Dcto. Bonif. </strong></td>
        <td width="101" valign="top"><?php echo $sum2?></td>
        <td width="57" valign="top"><strong>V. Venta </strong></td>
        <td width="83" valign="top"><?php echo $sum3?></td>
        <td width="27" valign="top"><strong>Igv</strong></td>
        <td width="42" valign="top"><?php echo $sum4?></td>
        <td width="41" valign="top"><strong>Neto a Pagar </strong></td>
        <td width="70" valign="top"><div align="right"><?php echo $monto?></div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
