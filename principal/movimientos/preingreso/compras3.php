<?php include('../../session_user.php');
$invnum  = $_SESSION['compraspreg'];
$ok 	 = $_REQUEST['ok'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
<link href="../../../css/autocomplete.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../funciones/ajax.js"></script>
<script type="text/javascript" src="../../../funciones/ajax-dynamic-list.js"></script>
<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once("../funciones/compras.php");	//FUNCIONES DE ESTA PANTALLA
require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
?>
<script>
function letrau(evt){
var key = nav4 ? evt.which : evt.keyCode;
return (key == 85 || key == 117 ||key <= 13 || (key >= 48 && key <= 57));	
}
function tippbon()
{
	var tip = document.form2.tipbonif.value;
	if (tip == 1)
	{
	document.form2.country.disabled = true;
	document.form2.country.value = "";
	}
	if (tip == 2)
	{
	document.form2.country.disabled = false;
	document.form2.country.focus();
	}
}
var popUpWin=0;
function popUpWindows(URLStr, left, top, width, height)
{
  pcosto = document.form1.text6.value;
  if(popUpWin)
  {
    if(!popUpWin.closed) popUpWin.close();
  }
  URLStr = URLStr+'&costo='+pcosto;
  popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
  //alert(URLStr+'&costo='+pcosto);
}
function validar_bonif()
{
	var tip = document.form2.tipbonif.value;
	if (tip == 2)
	{
		if (document.form2.country_ID.value == "")
	  	{ alert("Ingrese el nombre del Producto"); document.form2.country.focus(); return; }
	}
	if (document.form2.bonif_can.value == "")
	{ alert("Ingrese la Cantidad a Ingresar"); document.form2.bonif_can.focus(); return; }
	var v1= document.form2.bonif_can.value;		//CANTIDAD 
	var valor   = isNaN(v1);
	if (valor == true)									////NO ES NUMERO
	{
	document.form2.nnum.value=1;		////avisa que no es numero
	}
	else
	{
	document.form2.nnum.value=0;		////avisa que es numero
	} 
	document.form2.method = "post";
	document.form2.action ="compras33.php";
	document.form2.submit();
}
</script>
</head>
<body onload="fc()">
<?php $sql="SELECT nro_compra FROM movmae where usecod = '$usuario' and proceso = '1'";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result) ){
	while ($row = mysqli_fetch_array($result)){
			$ncompra         = $row["nro_compra"];		//codigo
	}
	}
	$sql="SELECT count(*) FROM tempmovmov where invnum = '$invnum'";
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
    $sql="SELECT * FROM tempmovmov where invnum = '$invnum' order by codtemp";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
?>
<?php $codtemp = $_REQUEST['codtemp'];
$codprod = $_REQUEST['codprod'];
$bon	 = $_REQUEST['bon'];
if ($bon == 1)
{
?>
<table width="939" class="celda2">
  <tr>
    <td class="titulos_movimientos" bgcolor="#50ADEA">INGRESO  DE BONIFICACIONES </td>
  </tr>
</table>
<form id="form2" name="form2" onKeyUp="highlight(event)" onClick="highlight(event)">
	<?php $sqlq="SELECT codpro,canbon,tipbon FROM tempmovmov where codtemp = '$codtemp' and invnum = '$invnum'";
	$resultq = mysqli_query($conexion,$sqlq);
	if (mysqli_num_rows($resultq)){
	while ($rowq = mysqli_fetch_array($resultq)){
			$codprobon        = $rowq["codpro"];
			$canbonbon        = $rowq["canbon"];
			$tipbon           = $rowq["tipbon"];	
	}	
	}
	$sqlq="SELECT codpro,canbon,tipbon FROM tempmovmov_bonif where codtemp = '$codtemp' and invnum = '$invnum'";
	$resultq = mysqli_query($conexion,$sqlq);
	if (mysqli_num_rows($resultq)){
	while ($rowq = mysqli_fetch_array($resultq)){
			$codprobon1        = $rowq["codpro"];
			$canbonbon1        = $rowq["canbon"];
			$tipbon1           = $rowq["tipbon"];	
			$tyt			   = 1;
	}	
	}
	else
	{
	$tyt = 0;
	}
	$sqlq="SELECT desprod FROM producto where codpro = '$codprobon'";
	$resultq = mysqli_query($conexion,$sqlq);
	if (mysqli_num_rows($resultq)){
	while ($rowq = mysqli_fetch_array($resultq)){
			$desprodbon       = $rowq["desprod"];
	}	
	}
	if ($tyt == 1)
	{
	$sqlq="SELECT desprod FROM producto where codpro = '$codprobon1'";
	$resultq = mysqli_query($conexion,$sqlq);
	if (mysqli_num_rows($resultq)){
	while ($rowq = mysqli_fetch_array($resultq)){
			$desprodbon1      = $rowq["desprod"];
	}	
	}
	}
	?>
<table width="939" border="0" class="celda2">
  <tr>
    <td width="86"><strong>PRODUCTO</strong></td>
    <td width="479"><?php echo $desprodbon?></td>
	<td width="94"><div align="right"><strong>TIPO DE BONIF </strong></div></td>
    <td width="260">
      <select name="tipbonif" onchange="tippbon()">
        <option value="1">EL MISMO PRODUCTO</option>
        <option value="2">OTRO PRODUCTO</option>
      </select>
	</td>
  </tr>
</table>
<table width="939" border="0" class="celda2">
  <tr>
    <td width="86"><strong>BONIFICACION</strong></td>
    <td width="510">
	  <input name="country" type="text" id="country" onkeyup="ajax_showOptions(this,'getCountriesByLetters',event)" size="90" disabled="disabled" value="<?php if ($tyt == 1){echo $desprodbon1;} else { echo $desprodbon;}?>"/>
      <input type="hidden" id="country_hidden" name="country_ID" value="<?php if ($tyt == 1){echo $codprobon1;}?>"/></td>
    <td width="63"><div align="right"><strong>CANTIDAD </strong></div></td>
    <td width="260">
      <input name="bonif_can" type="text" id="bonif_can" size="5" onkeypress="return letrau(event)" value="<?php if ($tyt == 1){echo $canbonbon1; if ($tipbon1 == "U"){ echo "U";}} else { echo $canbonbon; if ($tipbon == "U"){ echo "U";}}?>"/>
      <input name="nnum" type="hidden" id="nnum" />
      <input name="codprobon" type="hidden" id="codprobon" value="<?php echo $codprobon?>"/>
      <input name="codtemp" type="hidden" id="codtemp" value="<?php echo $codtemp?>"/>
	  <input name="ok" type="hidden" id="ok" value="<?php echo $ok?>"/>
      <input type="button" name="Submit" value="Grabar" onclick="validar_bonif()"/>
      <input type="submit" name="Submit2" value="Cancelar" />
    </td>
  </tr>
</table>
</form>
<?php }
?>
<form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">
<table class="celda2" width="939">
    <tr>
      <td width="284" bgcolor="#50ADEA" class="titulos_movimientos">DESCRIPCION</td>
	  <td width="43" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">CANT</div></td>
	  <td width="33" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">BONIF</div></td>
	  <td width="150" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">MARCA</div></td>
	  <td width="43" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">P. UNIT</div></td>
	  <td width="43" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">DESC1</div></td>
	  <td width="43" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">DESC2</div></td>
	  <td width="43" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">DESC3</div></td>
      <td width="43" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">P. VTA</div></td>
	  <td width="61" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">SUB TOT</div></td>
      <td width="32" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">PREC</div></td>
	  <td width="27" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">LOTE</div></td>
	  <td width="38" bgcolor="#50ADEA" class="titulos_movimientos">&nbsp;</td>
    </tr>
  </table>
  <table class="celda2" width="939">
    <?php $i = 0;
	while ($row = mysqli_fetch_array($result)){
			$i++;
			$codtemp        = $row['codtemp'];
			$codpro         = $row['codpro'];
			$qtypro         = $row['qtypro'];	
			$qtyprf         = $row['qtyprf'];
			$desc1          = $row['desc1'];	
			$desc2          = $row['desc2'];	
			$desc3          = $row['desc3'];
			$prisal         = $row['prisal'];
			$pripro         = $row['pripro'];	
			$costre         = $row['costre'];
			$canbon         = $row['canbon'];
			$sql1="SELECT porcent FROM datagen";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$porcent    = $row1['porcent'];
			}
			}
			$sql1="SELECT canbon FROM tempmovmov_bonif where codprobon = '$codpro'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
				$ccbon = 1;
			}
			else
			{
				$ccbon = 0;
			}
			$sql1="SELECT desprod,codmar,factor,igv,costpr,stopro,lote FROM producto where codpro = '$codpro'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
				$desprod    = $row1['desprod'];
				$codmar     = $row1['codmar'];
				$factor     = $row1['factor'];	
				$igv        = $row1['igv'];
				$costpr     = $row1['costpr'];  ///COSTO PROMEDIO
				$stopro     = $row1['stopro'];	///STOCK EN UNIDADES 
				$lote       = $row1['lote'];	///STOCK EN UNIDADES 
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
			if ($costre > 0)
			{
			   $bg		="#ffff66";
			   $over	="#ffff66";
			   $out		="#ffff66";
			} 
			else
			{
				$bg		="#ffffff";
				$over	="#EAEDEF";
				$out	="#ffffff";
			} 
			$valform = $_REQUEST['valform'];
			$cod     = $_REQUEST['cod'];
	?>
	 <tr  bgcolor="<?php echo $bg;?>" onMouseOver="this.style.backgroundColor='<?php echo $over;?>';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='<?php echo $out;?>';">
      <td width="284" valign="bottom">
		<a href="javascript:popUpWindow('ver_prod.php?cod=<?php echo $codpro?>&invnum=<?php echo $invnum?>', 435, 110, 560, 200)" title="EL FACTOR ES <?php echo $factor?>"><?php echo substr($desprod,0,65); echo " ";?></a></td>
      <td width="43" valign="bottom"><div align="right">
	  <?php if (($valform == 1) && ($cod == $codpro)) { ?> 
        <input type="hidden" name="costpr" value="<?php echo $costpr;?>"/>
        <input type="hidden" name="stockpro" value="<?php echo $stopro;?>"/>
		<input type="hidden" name="ok" value="<?php echo $ok;?>"/>
		<input type="hidden" name="factor" value="<?php echo $factor;?>"/>
        <input type="hidden" name="porcentaje" value="<?php if ($igv == 1){echo $porcent;}?>"/>
        <input name="text1" type="text" class="input_text1" id="text1" value="<?php if ($qtyprf <> ""){echo $qtyprf; } else { echo $qtypro;}?>" size="4" onKeyUp ="precio();" onKeyPress="return f(event)" />
      <?php } else { if ($qtyprf <> ""){ echo $qtyprf; } else {echo $qtypro;}}?></div></td>
	  <td width="33">
	  <center>
	  <?php if ($canbon <> 0){?>
	  <a href="compras3.php?codtemp=<?php echo $codtemp?>&codprod=<?php echo $codpro?>&bon=1&ok=<?php echo $ok?>">
	  <img src="<?php if ($ccbon == 0){?>../../../images/tickr.gif<?php } else { ?>../../../images/tickg.gif<?php }?>" border="0" title="REGISTRO DE BONIFICACION"/>	  </a>
	  <?php }?>
	  </center></td>
	  <td width="150" valign="bottom"><?php echo $marca?></td>
	  <td width="43" valign="bottom">
	  <div align="right">
	  <?php if (($valform == 1) && ($cod == $codpro)) { ?> 
	    <input name="text2" type="text" class="input_text1" id="text2" value="<?php echo $prisal?>" size="4" maxlength="6" onKeyPress="return decimal(event)" onKeyUp ="precio();"/>
	  <?php } else { echo $prisal;}?>
	  </div>	  </td>
	  <td width="43" valign="bottom">
	  <div align="right">
	  <?php if (($valform == 1) && ($cod == $codpro)) { ?> 
	    <input name="text3" type="text" class="input_text1" id="text3" value="<?php echo $desc1?>" size="4" maxlength="3" onKeyPress="return acceptNum(event)" onKeyUp ="precio();"/>
	  <?php } else { echo $desc1;}?>
	  </div>	  </td>
	  <td width="43" valign="bottom">
	  <div align="right">
	  <?php if (($valform == 1) && ($cod == $codpro)) { ?> 
	    <input name="text4" type="text" class="input_text1" id="text4" value="<?php echo $desc2?>" size="4" maxlength="3" onKeyPress="return acceptNum(event)" onKeyUp ="precio();"/>
	  <?php } else { echo $desc2;}?></div>	  </td>
	  <td width="43" valign="bottom">
	  <div align="right">
	  <?php if (($valform == 1) && ($cod == $codpro)) { ?> 
	    <input name="text5" type="text" class="input_text1" id="text5" value="<?php echo $desc3?>" size="4" maxlength="3" onKeyPress="return acceptNum(event)" onKeyUp ="precio();"/>
	  <?php } else { echo $desc3;}?></div>	  </td>
	  <td width="43" valign="bottom">
	  <div align="right">
	  <?php if (($valform == 1) && ($cod == $codpro)) { ?> 
	    <input name="text6" type="text" id="text6" size="4" class="pvta" value="<?php echo $pripro?>" onclick="blur()"/>
	  <?php } else { echo $pripro;}?></div>	  </td>
      <td width="61" valign="bottom">
	  <div align="right">
	  <?php if (($valform == 1) && ($cod == $codpro)) { ?> 
	    <input name="text7" type="text" id="text7" size="8" class="pvta" value="<?php echo $costre?>" onclick="blur()"/>
	  <?php } else { echo $costre;}?></div>	  </td>
	  <td width="32">
	  <div align="center">
	  <?php if (($valform == 1) && ($cod == $codpro)) { ?>
	   <a href="javascript:popUpWindows('price/price.php?cod=<?php echo $codpro?>&invnum=<?php echo $invnum?>&ncompra=<?php echo $ncompra?>&ok=<?php echo $ok?>', 205, 40, 468, 200)" title="PRECIO DE PRODUCTOS">
	  <img src="../../../images/tickg.gif" width="19" height="18" border="0"/> 
	  </a>
	  <?php }
	  ?>
	  </div></td>
	  <td width="27">
	  <a href="javascript:popUpWindow('lote/lote.php?cod=<?php echo $codpro?>&invnum=<?php echo $invnum?>&ncompra=<?php echo $ncompra?>&ok=<?php echo $ok?>', 435, 110, 560, 200)" title="LOTE DE PRODUCTOS">
	  <div align="center"><?php if ($lote==1){?><img src="../../../images/add.gif" width="14" height="15" border="0"/><?php }?></div>
	  </a>	  </td>
      <td width="38" valign="bottom">
	    <div align="center">
	      <?php if (($valform == 1) && ($cod == $codpro)) { ?> 
	      <input name="number" type="hidden" id="number" />
	      <input name="codtemp" type="hidden" id="codtemp" value="<?php echo $codtemp?>" />
	      <input type="button" id="boton" onClick="validar_prod()" alt="GUARDAR"/>
		  <input type="button" id="boton1" onClick="validar_grid()" alt="ACEPTAR"/>
          <?php } else { ?>
	      <a href="compras3.php?cod=<?php echo $codpro?>&valform=1&ok=<?php echo $ok?>">
		  <img src="../../../images/edit_16.png" width="16" height="16" border="0"/>		  </a>
		  <a href="compras4.php?cod=<?php echo $codtemp?>&ok=<?php echo $ok?>" target="comp_principal"><img src="../../../images/del_16.png" width="16" height="16" border="0"/>		  </a>
          <?php }?>
       </div>	 </td>
	 </tr>
	 
	<?php }
	?>
  </table>
  <?php }
  else
  {
  ?>
  <br><br><br><br><br><br><br><br><center>NO SE LOGRO ENCONTRAR INFORMACION CON LOS DATOS INGRESADOS</center>
  <?php }
  ?> 
</form>
</body>
</html>
