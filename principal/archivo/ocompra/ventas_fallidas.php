<?php include('../../session_user.php');
$ord_compra   = $_SESSION['ord_compra'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="css/style1.css" rel="stylesheet" type="text/css" />
<link href="css/style2.css" rel="stylesheet" type="text/css" />
<link href="css/tabla2.css" rel="stylesheet" type="text/css" />
<link href="css/boton_marco.css" rel="stylesheet" type="text/css" />
<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../../../convertfecha.php');	//CONEXION A BASE DE DATOS
require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
?>
<style type="text/css">

.Estilo1 {
	color: #666666;
	font-weight: bold;
}

</style>
</head>
<body>
  <table width="100%" border="0" align="center" class="tabla2">
    <tr>
      <td ><table width="100%" border="0" align="center">
        <tr>
          <td width="144" class="text_gris"><span class="Estilo1">TIENDA</span></td>
          <td width="166" class="text_gris"><div align="right" class="Estilo1">
            <div align="left">FECHA </div>
          </div></td>
          <td width="322" class="text_gris"><div align="right" class="Estilo1">CANTIDAD</div></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <?php $codpro = $_REQUEST['codpro'];
if ($codpro <> "")
{
$sql="SELECT codpro,desprod,stopro,factor FROM producto where codpro = '$codpro'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
			$codpro     = $row['codpro'];
			$desprod    = $row['desprod'];
			$stopro     = $row['stopro'];
			$factor     = $row['factor'];
}
?>
  <table width="100%" border="0" align="center" class="tabla2">
	<tr>
      <td >
	  <table width="100%" border="0" align="center">
        <?php $sql1="SELECT codloc,nomloc FROM xcompa where habil = '1'order by codloc";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$codloc     = $row1['codloc'];
		$nomloc     = $row1['nomloc'];
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$sql2="SELECT invfec,sum(canpro),fraccion,factor,codpro FROM agotados where sucursal = '$codloc' and codpro = '$codpro' group by invfec,fraccion,factor,codpro";
			$result2 = mysqli_query($conexion,$sql2);
			if (mysqli_num_rows($result2)){
			while ($row2 = mysqli_fetch_array($result2)){
				$invfec        = $row2["invfec"];
				$canpro        = $row2[1];
				$fraccion      = $row2["fraccion"];
				$factor        = $row2["factor"];
			}
			}
			else
			{
			$invfec = "";
			$canpro = 0;
			}
		?>
		<tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
          <td width="144" class="text_combo_select"><?php echo $nomloc?></td>
          <td width="166">
		    <div align="left"><?php echo fecha($invfec);?></div></td>
          <td width="322">
		  <div align="right">
		  <?php echo $canpro;
		  ?>
		  </div></td>
          </tr>
		<?php $c++;
		}
		}
		?>
      </table></td>
    </tr>
  </table>
  <?php }
  }
  ?>
</body>
</html>
