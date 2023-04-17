<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once("../funciones/consulta_compras.php");	//FUNCIONES DE ESTA PANTALLA
require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
?>
<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
-->
</style>
</head>
<body onload="fc()">
<?php $invnum = $_REQUEST['invnum'];
	$upd    = $_REQUEST['upd'];
	$numero = $_REQUEST['numero'];
    $sql="SELECT count(*) FROM movmov where invnum = '$invnum'";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
			$count        = $row[0];	
	}	
	}
	else
	{
	$count = 0;
	}
	$sql="SELECT * FROM movmov where invnum = '$invnum'";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
?>
<form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">
<table class="celda2" width="939">
    <tr>
      <td width="355" bgcolor="#50ADEA" class="titulos_movimientos">DESCRIPCION</td>
	  <td width="47" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">CANT</div></td>
	  <td width="208" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">MARCA</div></td>
	  <td width="52" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">P. UNIT</div></td>
	  <td width="41" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">DESC1</div></td>
	  <td width="41" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">DESC2</div></td>
	  <td width="41" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">DESC3</div></td>
      <td width="54" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">P. VTA</div></td>
	  <td width="60" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">SUB TOT</div></td>
    </tr>
  </table>
  <table class="celda2" width="939">
    <?php $i = 0;
	while ($row = mysqli_fetch_array($result)){
			$i++;
			$codpro         = $row['codpro'];
			$qtypro         = $row['qtypro'];	
			$qtyprf         = $row['qtyprf'];
			$desc1          = $row['desc1'];	
			$desc2          = $row['desc2'];	
			$desc3          = $row['desc3'];
			$prisal         = $row['prisal'];
			$pripro         = $row['pripro'];	
			$costre         = $row['costre'];	
			$sql1="SELECT porcent FROM datagen";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$porcent    = $row1['porcent'];
			}
			}
			$sql1="SELECT desprod,codmar,factor,igv,costpr,stopro FROM producto where codpro = '$codpro'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$desprod    = $row1['desprod'];
				$codmar     = $row1['codmar'];
				$factor     = $row1['factor'];	
				$igv        = $row1['igv'];
				$costpr     = $row1['costpr'];  ///COSTO PROMEDIO
				$stopro     = $row1['stopro'];	///STOCK EN UNIDADES 
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
	 
      <td width="355" valign="bottom">
	  <?php if (($costre == 0) || ($costre == "")){?>
	  <span class="Estilo1">BONIF</span>
	  <?php }?>
		<a title="EL FACTOR ES <?php echo $factor?>"><?php echo $desprod?></a></td>
      <td width="47" valign="bottom"><div align="right">
	  <?php if (($valform == 1) && ($cod == $codpro)) { ?> 
        <input type="hidden" name="costpr" value="<?php echo $costpr;?>"/>
        <input type="hidden" name="stockpro" value="<?php echo $stopro;?>"/>
		<input type="hidden" name="factor" value="<?php echo $factor;?>"/>
        <input type="hidden" name="porcentaje" value="<?php if ($igv == 1){echo $porcent;}?>"/>
        <input name="text1" type="text" class="input_text1" id="text1" value="<?php if ($qtyprf <> ""){echo $qtyprf; } else { echo $qtypro;}?>" size="4" onKeyUp ="precio();" onKeyPress="return f(event)" />
      <?php } else { if ($qtyprf <> ""){ echo $qtyprf; } else {echo $qtypro;}}?></div></td>
	   <td width="208" valign="bottom"><?php echo $marca?></td>
	 
	  <td width="52" valign="bottom">
	  <div align="right">
	  <?php if (($valform == 1) && ($cod == $codpro)) { ?> 
	    <input name="text2" type="text" class="input_text1" id="text2" value="<?php echo $prisal?>" size="4" maxlength="6" onKeyPress="return decimal(event)" onKeyUp ="precio();"/>
	  <?php } else { echo $prisal;}?>
	  </div>	  </td>
	  <td width="41" valign="bottom">
	  <div align="right">
	  <?php if (($valform == 1) && ($cod == $codpro)) { ?> 
	    <input name="text3" type="text" class="input_text1" id="text3" value="<?php echo $desc1?>" size="4" maxlength="3" onKeyPress="return acceptNum(event)" onKeyUp ="precio();"/>
	  <?php } else { echo $desc1;}?>
	  </div>	  </td>
	  <td width="41" valign="bottom">
	  <div align="right">
	  <?php if (($valform == 1) && ($cod == $codpro)) { ?> 
	    <input name="text4" type="text" class="input_text1" id="text4" value="<?php echo $desc2?>" size="4" maxlength="3" onKeyPress="return acceptNum(event)" onKeyUp ="precio();"/>
	  <?php } else { echo $desc2;}?></div>	  </td>
	  <td width="41" valign="bottom">
	  <div align="right">
	  <?php if (($valform == 1) && ($cod == $codpro)) { ?> 
	    <input name="text5" type="text" class="input_text1" id="text5" value="<?php echo $desc3?>" size="4" maxlength="3" onKeyPress="return acceptNum(event)" onKeyUp ="precio();"/>
	  <?php } else { echo $desc3;}?></div>	  </td>
	  <td width="54" valign="bottom">
	  <div align="right">
	  <?php if (($valform == 1) && ($cod == $codpro)) { ?> 
	    <input name="text6" type="text" id="text6" size="4" class="pvta" value="<?php echo $pripro?>" onclick="blur()"/>
	  <?php } else { echo $pripro;}?></div>	  </td>
      <td width="60" valign="bottom">
	  <div align="right">
	  <?php if (($valform == 1) && ($cod == $codpro)) { ?> 
	    <input name="text7" type="text" id="text7" size="4" class="pvta" value="<?php echo $costre?>" onclick="blur()"/>
	  <?php } else { echo $costre;}?></div>	  </td>
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
</body>
</html>
