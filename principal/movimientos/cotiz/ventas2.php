<?php require_once('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../funciones/consulta_compras.php');	//FUNCIONES DE ESTA PANTALLA
require_once('../../../funciones/highlight.php');	//ILUMINA CAJAS DE TEXTOS
require_once('../../../funciones/functions.php');	//DESHABILITA TECLAS
require_once('../../../funciones/funct_principal.php');	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
?>
</head>
<body onload="fc()">
<?php $invnum = $_REQUEST['invnum'];
	$sql="SELECT codpro,canpro,fraccion,prisal,pripro FROM cotizacion_det where invnum = '$invnum'";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
?>
<form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">
<table class="celda2" width="939">
    <tr>
      <td width="425" bgcolor="#50ADEA" class="titulos_movimientos">DESCRIPCION</td>
	  <td width="59" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">CAJA</div></td>
	  <td width="59" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">UNID</div></td>
	  <td width="282" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">MARCA</div></td>
	  <td width="78" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">P.PROMEDIO</div></td>
	  <td width="71" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">SUB TOT</div></td>
    </tr>
  </table>
  <table class="celda2" width="939">
    <?php $i = 0;
	while ($row = mysqli_fetch_array($result)){
			++$i;
			$codpro         = $row['codpro'];
			$canpro         = $row['canpro'];	
			$fraccion       = $row['fraccion'];
			$prisal         = $row['prisal'];	
			$pripro         = $row['pripro'];	
			$sql1="SELECT porcent FROM datagen";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$porcent    = $row1['porcent'];
			}
			}
			$sql1="SELECT desprod,codmar,factor FROM producto where codpro = '$codpro'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$desprod    = $row1['desprod'];
				$codmar     = $row1['codmar'];
				$factor     = $row1['factor'];	
			}
			}
			$sql1="SELECT ltdgen FROM titultabla where dsgen = 'MARCA'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$ltdgen     = $row1['ltdgen'];	
			}
			}
			$sql1="SELECT destab FROM titultabladet where codtab = '$codmar' and tiptab = '$ltdgen'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$marca     = $row1['destab'];	
			}
			}
			$valform = $_REQUEST['valform'];
			$cod     = $_REQUEST['cod'];
	?>
	 <tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
      <td width="425" valign="bottom">
		<a title="EL FACTOR ES <?php echo $factor?>"><?php echo $desprod?></a>
	  </td>
      <td width="59" valign="bottom"><div align="right"><?php if ($fraccion == "F"){echo $canpro;}else{ echo "0";}?></div></td>
	  <td width="59" valign="bottom"><div align="right"><?php if ($fraccion == "T"){echo $canpro;}else{ echo "0";}?></div></td>
	  <td width="282" valign="bottom"><?php echo $marca?></td>
	  <td width="78" valign="bottom"><div align="right"><?php echo $prisal;?></div></td>
      <td width="71" valign="bottom"><div align="right"><?php echo $pripro;?></div></td>
     </tr>
	<?php }
	?>
  </table>
  <?php }
  else
  {
  ?>
  <br><br><br><br><br><br><br><br><center>NO EXISTEN PRODUCTOS PARA ESTE DOCUMENTO</center>
  <?php }
  ?> 
</form>
<?php mysqli_free_result($result);
mysqli_free_result($result1);
mysqli_close($conexion); 
?>
</body>
</html>
