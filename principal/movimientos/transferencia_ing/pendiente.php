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
$sql="SELECT codloc,nomusu FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$codloc       = $row['codloc'];			//////OBTENGO EL CODIGO DEL LOCAL ACTUAL O DESTINO
	$user    	  = $row['nomusu'];
}
}
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
<title><?php echo $desprod?> - HOLA</title>
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
</head>

<body onkeyup="cerrar(event)">
<table class="tabla2" width="442" border="0">
  <tr>
    <td width="540"><table width="438" border="0" align="center" bordercolor="#FFCC00" bgcolor="#CCFF33">
      <tr>
        <td width="63"><strong>NUMERO</strong></td>
        <td width="227"><strong>SUCURSAL</strong></td>
        <td width="134"><strong>USUARIO</strong></td>
      </tr>
    </table>
    <div align="center"><img src="../../../images/line2.jpg" width="438" height="4" /></div>
    <?php $sql="SELECT numdoc,sucursal,usecod FROM movmae where sucursal1 = '$codloc' and tipmov = '2' and tipdoc = '3' and estado = '0' and proceso = '0' and val_habil = '0'";					/////OBTENGO EL DOCUMENTO
	 $result = mysqli_query($conexion,$sql);
	 if (mysqli_num_rows($result)){
	?>
	<table width="438" border="0" align="center">
      <?php while ($row = mysqli_fetch_array($result)){
			$numdoc         = $row['numdoc'];
			$sucursal       = $row['sucursal'];
			$usecod         = $row['usecod'];
			$sql1="SELECT nomloc FROM xcompa where codloc = '$sucursal'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
			   $nomloc         = $row1['nomloc'];
			}
			}
			$sql1="SELECT nomusu FROM usuario where usecod = '$usecod'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
			   $nomusu         = $row1['nomusu'];
			}
			}
	  ?>
	  <tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
        <td width="63"><?php echo formato($numdoc)?></td>
        <td width="227"><?php echo $nomloc?></td>
        <td width="134"><?php echo $nomusu?></td>
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
