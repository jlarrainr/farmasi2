<?php include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $desemp?></title>
<link href="../css/style1.css" rel="stylesheet" type="text/css" />
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
<style>
#boton { background:url('../../../images/save_16.png') no-repeat; border:none; width:16px; height:16px; }
#boton1 { background:url('../../../images/icon-16-checkin.png') no-repeat; border:none; width:16px; height:16px; }
</style>
<script>
function validar_grid()
{
document.form1.method = "post";
document.form1.submit();
}
function validar_prod()
{
var f = document.form1;
if ((f.pventa.value == 0) || (f.pventa.value == ""))
{
alert("DEBE INGRESAR UN PRECIO DE VENTA");f.pventa.focus();return;
}
f.method = "post";
f.action="ingresos2_grab.php";
f.submit();
}
function sf()
{
document.form1.pventa.focus();
}
</script>
</head>
<?php require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUME
require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
require_once("../../local.php");	//LOCAL DEL USUARIO
$marca = $_REQUEST['marca'];
$val   = $_REQUEST['val'];
$sql="SELECT * FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$user    = $row['nomusu'];
}
}
function formato($c) {
printf("%08d",$c);
} 
$codpros = $_REQUEST['codpros'];
$valform = $_REQUEST['valform'];
?>
<body <?php if ($valform==1){ ?>onload="sf();"<?php }?>>
<form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">
<table width="100%" border="0" class="tabla2">
  <tr>
    <td width="951"><table width="100%" border="0" align="center">
      <tr>
	  <td width="9" bgcolor="#FFCC00"></td>
	  <td width="116">P. NO MODIFICADO</td>
	  <td width="10" bgcolor="#00CC33">	  </td>
	  <td width="191">P. MODIFICADO</td>
        <td width="300"><div align="right"><span class="text_combo_select"><strong>LOCAL:</strong> <img src="../../../images/controlpanel.png" width="16" height="16" /> <?php echo $nombre_local?></span></div></td>
        <td width="263"><div align="right"><span class="text_combo_select"><strong>USUARIO :</strong> <img src="../../../images/user.gif" width="15" height="16" /> <?php echo $user?></span></div></td>
      </tr>
    </table>
	<img src="../../../images/line2.png" width="100%" height="4" />
      <table width="100%" border="0" align="center">
      <tr>
        <td width="370"><strong>PRODUCTO</strong></td>
        <td width="76"><div align="right"><strong>P. COSTO </strong></div></td>
        <td width="103"><div align="right"><strong>ULT P. COSTO </strong></div></td>
        <td width="89"><div align="right"><strong>MARGEN UT % </strong></div></td>
        <td width="72"><div align="right"><strong>PRECIO VTA </strong></div></td>
		<td width="100"><div align="center"><strong>ESTADO</strong></div></td>
		<td width="75"><div align="center"><strong>MODIFICAR</strong></div></td>
		</tr>
    </table>
      <div align="center"><img src="../../../images/line2.png" width="920" height="4" />
	  <?php if ($val == 1)
	  {
	  $sql="SELECT codpro,desprod,margene,pcostouni,ultpcostouni,prevta,factor,modifpcosto FROM producto where codmar = '$marca'";
	  $result = mysqli_query($conexion,$sql);
	  if (mysqli_num_rows($result)){
	  ?>
        <table width="100%" border="0" align="center">
          <?php while ($row = mysqli_fetch_array($result)){
				$codpro         = $row['codpro'];
				$desprod        = $row['desprod'];
				$margene        = $row['margene'];
				$pcostouni      = $row['pcostouni'];
				$factor         = $row['factor'];
				$ultpcostouni   = $row['ultpcostouni'];
				$prevta         = $row['prevta'];
				$modifpcosto    = $row['modifpcosto'];
				if ($pcostouni == $ultpcostouni)
				{
				$desc = "SE MANTIENE";
				}
				else
				{
					if ($pcostouni < $ultpcostouni)
					{
					$desc = "BAJA DE PRECIO";
					}
					else
					{
					$desc = "AUMENTO DE PRECIO";
					}
				}
		  ?>
		  <tr 
		  <?php if (($modifpcosto == 0) and ($pcostouni <> $ultpcostouni)){?> 
		  bgcolor="#FFCC66"<?php } else{ if (($modifpcosto == 1) and ($pcostouni <> $ultpcostouni)){?>bgcolor="#00CC33"<?php } else{?>onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';"
		   <?php }}?>>
            <td width="370"><?php echo $desprod?></td>
            <td width="76"><div align="right"><?php echo $pcostouni?></div></td>
            <td width="103"><div align="right"><?php echo $ultpcostouni?></div></td>
            <td width="89"><div align="right"><?php echo $margene?></div></td>
            <td width="72">
			<div align="right">
			<?php if (($valform == 1) and ($codpros == $codpro)){?>
			<input name="pventa" type="text" id="pventa" size="12" value="<?php echo $prevta?>" onkeypress="return numeros1(event);"/>
			<?php }
			else
			{
			echo $prevta;
			}
			?>
			</div>
			</td>
            <td width="100"><div align="center"><?php echo $desc;?></div></td>
            <td width="75"><div align="center">
              <?php if (($valform == 1) and ($codpros == $codpro)){?>
			  <input name="marca" type="hidden" id="marca" value="<?php echo $marca?>" />
			  <input name="factor" type="hidden" id="factor" value="<?php echo $factor?>" />
			  <input name="val" type="hidden" id="val" value="1" />
			  <input name="codpro" type="hidden" id="codpro" value="<?php echo $codpro?>" />
			  <input name="button" type="button" id="boton" onclick="validar_prod()" alt="GUARDAR"/>
              <input name="button2" type="button" id="boton1" onclick="validar_grid()" alt="ACEPTAR"/>
			  <?php }
			  else
			  {
			  ?>
			  <a href="ingresos2.php?valform=1&codpros=<?php echo $codpro?>&marca=<?php echo $marca?>&val=1">
			  <img src="../../../images/add1.gif" width="14" height="15" border="0"/>			  </a>
			  <?php }
			  ?>
            </div>			
			
			</td>
          </tr>
		  <?php }
		  ?>
        </table>
      <?php }
	  }
	  ?>
    </div></td>
  </tr>
</table>
</form>
</body>
</html>
