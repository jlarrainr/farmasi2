<?php include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $desemp?></title>
<link href="../css/css/style1.css" rel="stylesheet" type="text/css" />
<link href="../css/css/tablas.css" rel="stylesheet" type="text/css" />
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
f.method = "post";
f.action="grabar_datos.php";
f.submit();
}
function sf()
{
document.form1.p1.focus();
}
</script>
</head>
<?php require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUME
require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
require_once("../../local.php");	//LOCAL DEL USUARIO
$codpro = $_REQUEST['codpro'];
$val    = $_REQUEST['val'];
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
<table width="932" border="0" class="tabla2">
  <tr>
    <td width="951"><table width="99%" border="0" align="center">
      <tr>
	  <td width="9"></td>
	  <td width="116">&nbsp;</td>
	  <td width="10">	  </td>
	  <td width="191">&nbsp;</td>
        <td width="300"><div align="right"><span class="text_combo_select"><strong>LOCAL:</strong> <img src="../../../images/controlpanel.png" width="16" height="16" /> <?php echo $nombre_local?></span></div></td>
        <td width="263"><div align="right"><span class="text_combo_select"><strong>USUARIO :</strong> <img src="../../../images/user.gif" width="15" height="16" /> <?php echo $user?></span></div></td>
      </tr>
    </table>
	<img src="../../../images/line2.png" width="920" height="4" />
      <table width="915" border="0" align="center">
      <tr>
        <td width="336"><strong>PRODUCTO</strong></td>
        <td width="80"><div align="right"><strong>P. COSTO</strong></div></td>
        <td width="80"><div align="right"><strong>PRECIO 1</strong></div></td>
        <td width="80"><div align="right"><strong>PRECIO 2</strong></div></td>
        <td width="80"><div align="right"><strong>PRECIO 3</strong></div></td>
		<td width="80"><div align="right"><strong>PRECIO 4</strong></div></td>
		<td width="80"><div align="right"><strong>PRECIO 5</strong></div></td>
		<td width="65"><div align="center"><strong>MODIFICAR</strong></div></td>
		</tr>
    </table>
      <div align="center"><img src="../../../images/line2.png" width="920" height="4" />
	  <?php if ($val == 1)
	  {
	  $sql="SELECT codpro,desprod,pcostouni,pcomp1,pcomp2,pcomp3,pcomp4,pcomp5 FROM producto where codpro = '$codpro'";
	  $result = mysqli_query($conexion,$sql);
	  if (mysqli_num_rows($result)){
	  ?>
        <table width="915" border="0" align="center">
          <?php while ($row = mysqli_fetch_array($result)){
				$codpro         = $row['codpro'];
				$desprod        = $row['desprod'];
				$pcostouni      = $row['pcostouni'];
				$pcomp1         = $row['pcomp1'];
				$pcomp2         = $row['pcomp2'];
				$pcomp3         = $row['pcomp3'];
				$pcomp4         = $row['pcomp4'];
				$pcomp5         = $row['pcomp5'];
		  ?>
		  <tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
            <td width="336"><?php echo $desprod?></td>
            <td width="80">
			<div align="right">
			<?php echo $pcostouni;
			?>
			</div></td>
            <td width="80">
			<div align="right">
			<?php if (($valform == 1) and ($codpros == $codpro)){?>
			    <input name="p1" type="text" id="p1" size="8" value="<?php echo $pcomp1?>" onkeypress="return decimal(event);"/>
			<?php }
			else
			{
			echo $pcomp1;
			}
			?>
			</div>
			</td>
            <td width="80">
			<div align="right">
			<?php if (($valform == 1) and ($codpros == $codpro)){?>
			    <input name="p2" type="text" id="p2" size="8" value="<?php echo $pcomp2?>" onkeypress="return decimal(event);"/>
			<?php }
			else
			{
			echo $pcomp2;
			}
			?>
			</div>
			</td>
			<td width="80">
			<div align="right">
			<?php if (($valform == 1) and ($codpros == $codpro)){?>
			    <input name="p3" type="text" id="p3" size="8" value="<?php echo $pcomp3?>" onkeypress="return decimal(event);"/>
			<?php }
			else
			{
			echo $pcomp3;
			}
			?>
			</div>
			</td>
            <td width="80">
			<div align="right">
			<?php if (($valform == 1) and ($codpros == $codpro)){?>
			    <input name="p4" type="text" id="p4" size="8" value="<?php echo $pcomp4?>" onkeypress="return decimal(event);"/>
			<?php }
			else
			{
			echo $pcomp4;
			}
			?>
		    </div></td>
            <td width="80">
			<div align="right">
			<?php if (($valform == 1) and ($codpros == $codpro)){?>
			    <input name="p5" type="text" id="p5" size="8" value="<?php echo $pcomp5?>" onkeypress="return decimal(event);"/>
			<?php }
			else
			{
			echo $pcomp5;
			}
			?>
			</div>
			</td>
            <td width="65"><div align="center">
              <?php if (($valform == 1) and ($codpros == $codpro)){?>
			  <input name="val" type="hidden" id="val" value="1" />
			  <input name="codpro" type="hidden" id="codpro" value="<?php echo $codpro?>" />
			  <input name="button" type="button" id="boton" onclick="validar_prod()" alt="GUARDAR"/>
              <input name="button2" type="button" id="boton1" onclick="validar_grid()" alt="ACEPTAR"/>
			  <?php }
			  else
			  {
			  ?>
			  <a href="pcompetencia2.php?valform=1&codpros=<?php echo $codpro?>&codpro=<?php echo $codpro?>&val=1">
			  <img src="../../../images/add1.gif" width="14" height="15" border="0"/>			  </a>
			  <?php }
			  ?>
            </div>			</td>
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
