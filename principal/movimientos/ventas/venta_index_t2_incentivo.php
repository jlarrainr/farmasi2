<?php require_once('../../session_user.php');
$venta   = $_SESSION['venta'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<style>
	a:link,
	a:visited {
		color: #0066CC;
		border: 0px solid #e7e7e7;
	}
	a:hover {
		background: #fff;
		border: 0px solid #ccc;
	}
	a:focus {
		background-color: #FFFF99;
		color: #0066CC;
		border: 0px solid #ccc;
	}
	a:active {
		background-color: #FFFF99;
		color: #0066CC;
		border: 0px solid #ccc;
	} 
</style>
<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
//require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once('funciones/datos_generales.php'); //////CODIGO Y NOMBRE DEL LOCAL
require_once('../../../funciones/botones.php');	//COLORES DE LOS BOTONES
require_once('../../local.php');	//LOCAL DEL USUARIO
?>
<script>
function getfocus1(){
	document.getElementById('l1').focus();
}
function cerrar(e){
	tecla=e.keyCode
	if (tecla == 27)
	{
		window.close();
	}
}
function cerrar_popup(valor)
{
	//ventana=confirm("Desea Grabar este Cliente");
	var prod = valor;
	document.form1.target = "venta_principal";
	window.opener.location.href="salir.php?prod="+prod;
	self.close();
}
</script>
<title>LISTADO DE PRODUCTOS INCENTIVADOS</title>
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
<!-- style type="text/css">
	.Estilo2 {color: #FFFFFF; font-weight: bold; }
	.Estilo3 {color: #FFFFFF}
</style -->
</head>

<body onload="getfocus1()" onkeyup="cerrar(event)">
<form name="form1">
  <table width="871" border="0" bgcolor="#50ADEA">
  <tr>
    <td width="59"><span class="Estilo3">INCENTIVO</span></td>
	<td width="257"><span class="Estilo3">PRODUCTO</span></td>
	<td width="142"><span class="Estilo3">MARCA</span></td>
	<td width="177"><span class="Estilo3">LINEA DE PRODUCTO</span></td>
	<td width="56"><div align="right"><span class="Estilo3">CANTIDAD</span></div></td>
	<td width="43"><div align="right"><span class="Estilo3">MONTO</span></div></td>
	<td width="58"><div align="right"><span class="Estilo3">P. MINIMO</span></div></td>
	<td width="45"><div align="right"><span class="Estilo3">CUOTA</span></div></td>
  </tr>
</table>
<table width="871" border="0">
  <?php $i=1;
  function formato($s)
  {
	  printf('%05d',$s);
  }
  $sql1="SELECT codloc FROM xcompa where nomloc = 'LOCAL0'";
  $result1 = mysqli_query($conexion,$sql1);
  if (mysqli_num_rows($result1)){
	while ($row1 = mysqli_fetch_array($result1)){
		$localp    = $row1['codloc'];
	}
  }
  $sqlss="SELECT invnum FROM incentivado where estado = '1'";
  $resultss = mysqli_query($conexion,$sqlss);
  if (mysqli_num_rows($resultss)){
	while ($rowss = mysqli_fetch_array($resultss)){
		$invnum    = $rowss['invnum'];
		$sql="SELECT producto.codpro,desprod,canprocaj,canprounid,pripro,pripromin,cuota,codloc,codmar,codfam FROM producto inner join incentivadodet on producto.codpro = incentivadodet.codpro where invnum = '$invnum' and ((codloc = '$codigo_local') or (codloc = '$localp')) and incentivadodet.estado = '1' order by desprod";
		$result = mysqli_query($conexion,$sql);
		if (mysqli_num_rows($result)){
			while ($row = mysqli_fetch_array($result)){
				$codpro         = $row['codpro'];
				$desprod        = $row['desprod'];
				$canprocaj      = $row['canprocaj'];
				$canprounid     = $row['canprounid'];
				$pripro         = $row['pripro'];
				$pripromin      = $row['pripromin'];
				$cuota          = $row['cuota'];
				$codloc         = $row['codloc'];
				$codmar         = $row['codmar'];
				$codfam         = $row['codfam'];
				$sql1="SELECT nomloc FROM xcompa where codloc = '$codloc'";
				$result1 = mysqli_query($conexion,$sql1);
				if (mysqli_num_rows($result1)){
					while ($row1 = mysqli_fetch_array($result1)){
						$nomloc    = $row1['nomloc'];
					}
				}
				$sql1="SELECT destab FROM titultabladet where codtab = '$codmar'";
				$result1 = mysqli_query($conexion,$sql1);
				if (mysqli_num_rows($result1)){
					while ($row1 = mysqli_fetch_array($result1)){
						$mark    = $row1['destab'];
					}
				}
				$sql1="SELECT destab FROM titultabladet where codtab = '$codfam'";
				$result1 = mysqli_query($conexion,$sql1);
				if (mysqli_num_rows($result1)){
					while ($row1 = mysqli_fetch_array($result1)){
						$class    = $row1['destab'];
					}
				}
				if ($canprocaj == 0)
				{
					$cantt = $canprounid;
					$desc = "Unid";
				}
				else
				{
					$cantt = $canprocaj;
					$desc = "Cajas";
				}
			?>
			<tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
				<td width="59"><a id="l1" href="javascript:cerrar_popup(<?php echo $codpro?>)"><?php echo formato($invnum)?></a></td>
				<td width="257"><a id="l1" href="javascript:cerrar_popup(<?php echo $codpro?>)"><?php echo $desprod?></a></td>
				<td width="142"><div align="left"><?php echo substr($mark,0,40);?></div></td>
				<td width="177"><div align="left"><?php echo substr($class,0,50);?></div></td>
				<td width="56"><div align="right"><?php echo $cantt; echo " "; echo $desc;?></div></td>
				<td width="43"><div align="right"><?php echo $pripro?></div></td>
				<td width="58"><div align="right"><?php echo $pripromin?></div></td>
				<td width="45"><div align="right"><?php echo $cuota?></div></td>
			</tr>
			<?php
				++$i;
			}
		}
	}
  }
  ?>
</table>
</form>
<?php
mysqli_free_result($result);
mysqli_free_result($result1);
mysqli_free_result($resultss);
mysqli_close($conexion); 
?>
</body>
</html>
