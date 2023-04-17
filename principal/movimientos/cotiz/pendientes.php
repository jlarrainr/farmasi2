<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once('../../../titulo_sist.php');
include('../../local.php');
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
<?php function formato($c) {
printf("%08d",$c);
} 
?>
<title>COTIZACIONES PENDIENTES</title>
<link href="../css/tablas.css" rel="stylesheet" type="text/css" /></head>

<body onkeyup="cerrar(event)">
<table class="tabla2" width="442" border="0">
  <tr>
    <td width="540"><table width="438" border="0" align="center" bordercolor="#FFCC00" bgcolor="#CCFF33">
      <tr>
        <td width="63"><strong>NUMERO</strong></td>
        <td width="227"><strong>FECHA</strong></td>
        <td width="134"><div align="right"><strong>MONTO</strong></div></td>
      </tr>
    </table>
    <div align="center"><img src="../../../images/line2.jpg" width="438" height="4" /></div>
    <?php $sql="SELECT invnum,invfec,invtot FROM cotizacion where baja = '0' and estado = '0' and sucursal = '$codigo_local'";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	?>
	<table width="438" border="0" align="center">
      <?php while ($row = mysqli_fetch_array($result)){
			$invfec         = $row['invfec'];
			$invnum         = $row['invnum'];
			$invtot         = $row['invtot'];
	  ?>
	  <tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
        <td width="63">
		<?php /*?><a href="pendientes1.php?alfa1=<?php echo $provee?>&nrocompra=<?php echo $nrocomp?>"><?php echo formato($nrocomp)?></a><?php */					
		?>
		<?php echo formato($invnum)?>		</td>
        <td width="227"><?php echo $invfec?></td>
        <td width="134"><div align="right"><?php echo $invtot?> </div></td>
      </tr>
	  <?php }
	  ?>
    </table>
	<?php }
	?>
	</td>
  </tr>
</table>
</body>
</html>
