<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<?php
require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once('../../../titulo_sist.php');
?>
<script>
function cerrar(e){
tecla=e.keyCode
	if (tecla == 27)
	{
		window.close();
	}
}
</script>
<?php
function formato($c) {
	printf("%08d",$c);
} 
?>
<title><?php echo $desprod?> - INGRESOS PENDIENTES</title>
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
</head>

<body onkeyup="cerrar(event)">
<table class="tabla2" width="442" border="0">
  <tr>
    <td width="540">
			<table width="438" border="0" align="center" bordercolor="#FFCC00" bgcolor="#CCFF33">
				<tr>
					<td width="63"><strong>NUMERO</strong></td>
					<td width="227"><strong>PROVEEDOR</strong></td>
					<td width="134"><strong>ESTADO</strong></td>
				</tr>
			</table>
			<div align="center"><img src="../../../images/line2.jpg" width="438" height="4" /></div>
			<?php 
				$sql="SELECT invfec,nrocomp,provee,confirmado,preingreso FROM ordmae where pendiente = '1' and borrada = '0'";
				$result = mysqli_query($conexion,$sql);
				if (mysqli_num_rows($result))
				{
			?>
					<table width="438" border="0" align="center">
					<?php
						while ($row = mysqli_fetch_array($result))
						{
							$invfec         = $row['invfec'];
							$nrocomp        = $row['nrocomp'];
							$provee         = $row['provee'];
							$confirmado     = $row['confirmado'];
							$preingreso     = $row['preingreso'];
							$sql1="SELECT despro FROM proveedor where codpro = '$provee'";
							$result1 = mysqli_query($conexion,$sql1);
							if (mysqli_num_rows($result1)){
								while ($row1 = mysqli_fetch_array($result1)){
									$proveedor         = $row1['despro'];
								}
							}
							if ($preingreso == 0)
							{
								if ($confirmado == 1)
								{
									$desc ="NO AUTORIZADO";
								}
								else
								{
									$desc ="AUTORIZADO";
								}
							}
							else
							{
								$desc = "PREINGRESO";
							}
					?>
							<tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
								<td width="63">
									<?php /*?><a href="pendientes1.php?alfa1=<?php echo $provee?>&nrocompra=<?php echo $nrocomp?>"><?php echo formato($nrocomp)?></a><?php */					
									?>
									<?php echo formato($nrocomp)?>
								</td>
								<td width="227"><?php echo $proveedor?></td>
								<td width="134"><?php echo $desc?> </td>
							</tr>
					<?php
						}
					?>
					</table>
			<?php
				}
			?>
		</td>
  </tr>
</table>
</body>
</html>
