<?php include('../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="css/body.css" rel="stylesheet" type="text/css" />
	<link href="css/tablas.css" rel="stylesheet" type="text/css" />
	<link href="../../css/tables_consult.css" rel="stylesheet" type="text/css" />
	<link href="../../css/style.css" rel="stylesheet" type="text/css" />
	<title>Documento sin t&iacute;tulo</title>
	<?php require_once("../../conexion.php"); ?>
	<?php require_once("funciones/mov_tablas.php"); ?>
	<?php require_once("../../funciones/functions.php"); ?>
	<?php require_once("../../funciones/funct_principal.php"); ?>
	<?php require_once("../../funciones/botones.php");	//COLORES DE LOS BOTONES
	?>
	<script type="text/javascript" language="JavaScript1.2" src="/comercial/funciones/control.js"></script>
	<style type="text/css">
		.Estilo1 {
			font-family: Tahoma;
			font-weight: 900;
			font-size: 15px;
			line-height: normal;
			color: #ffffff;
			margin-left: 10px;
		}
	</style>
</head>

<body>
	<?php $cod = $_REQUEST['cod'];
	$error = $_REQUEST['error'];
	$del = $_REQUEST['del'];
	$up  = $_REQUEST['up'];
	$ok  = $_REQUEST['ok'];
	?>
	<!-- <br> -->
	<!-- <table width="100%" align="center" class="demoTable"> -->
	<table width="100%" align="center" class="demoTable" id="customers">
		<caption>
			<span class="Estilo1">MANTENIMIENTO DE BASE DE DATOS - TABLAS AUXILIARES
				<b>
					<?php if ($error == '1') {
					?>
						<font color="#FF0000">ERROR!</font>
						<font color="#FFFF66"> - NO SE PUDO GRABAR!. LOS DATOS INGRESADOS YA SE ENCUENTRAN REGISTRADOS.</font>
					<?php }
					if ($ok == 1) {
					?>
						<font color="#FFFF66">- SE LOGRO GRABAR EXITOSAMENTE LOS DATOS</font>
					<?php }
					if ($up == 1) {
					?>
						<font color="#FFFF66">- SE LOGRO ACTUALIZAR EL PRODUCTO SELECCIONADO</font>
					<?php }
					if ($del == 1) {
					?>
						<font color="#FFFF66">- SE LOGRO ELIMINAR EL PRODUCTO INDICADO</font>
					<?php }
					?>
				</b></span>
		</caption>

		<tr>
			<td colspan="4">
				<div align="center">
					<form name="form1" id="form1">
						<div align="right">
							<input type="button" name="Submit22" value="Imprimir" onclick="imprimir()" class="imprimir" />

							<input type="button" name="Submit2" value="Nuevo" class="nuevo" onclick="nuevo_movtablas1()" />

							<input type="button" name="Submit" value="Salir" onclick="salir_movtablas1()" class="salir" />
						</div>
					</form>
				</div>
			</td>
		</tr>

		<tr>
			<th width="33">
				<div align="center">N&ordm;</div>
			</th>
			<th width="372">
				<div align="left">Nombre </div>
			</th>
			<th width="54">
				<div align="left">Abrev. </div>
			</th>
			<th width="91">
				<div align="center">Registros </div>
			</th>
		</tr>


		<?php $i = 0;
		$sql = "SELECT * FROM titultabla order by dsgen";
		$result = mysqli_query($conexion, $sql);
		if (mysqli_num_rows($result)) {
			while ($row = mysqli_fetch_array($result)) {
				$i++;
				$cdgen                  = $row["cdgen"];
				$ltdgen                 = $row["ltdgen"];
				$dsgen                  = $row["dsgen"];
				$sql1 = "SELECT count(*) FROM titultabladet where tiptab ='$ltdgen'";
				$result1 = mysqli_query($conexion, $sql1);
				if (mysqli_num_rows($result1)) {
					while ($row1 = mysqli_fetch_array($result1)) {
						$count                  = $row1[0];
					}
				} else {
					$count                  = 0;
				}
		?>
				<tr>
					<td align="center">
						<div align="center"><?php echo $i ?> -</div>
					</td>
					<td onclick="location.href='mov_tablas2.php?cod=<?php echo $cdgen ?>'">
						<a href="mov_tablas2.php?cod=<?php echo $cdgen ?>"><?php echo $dsgen ?></a>
					</td>
					<td>
						<center><?php echo $ltdgen ?></center>
					</td>
					<td>
						<div align="center"><?php echo $count ?></div>
					</td>
				</tr>
			<?php }
		}
		$i++;
		$sql = "SELECT count(*) FROM transporte";
		$result = mysqli_query($conexion, $sql);
		if (mysqli_num_rows($result)) {
			while ($row = mysqli_fetch_array($result)) {
				$countt                 = $row[0];
			}
			?>
			<tr>
				<td>
					<div align="center"><?php echo $i ?> -</div>
				</td>
				<td><a href="mov_transp1.php">TRANSPORTISTAS</a></td>
				<td>
					<center></center>
				</td>
				<td>
					<div align="center"><?php echo $countt ?></div>
				</td>
			<?php } else {
			$countt = 0;
			?>
				<td>
					<div align="center"><?php echo $countt ?></div>
				</td>
			</tr>
		<?php }
		
			$sql = "SELECT count(*) FROM tarjeta";
		$result = mysqli_query($conexion, $sql);
		if (mysqli_num_rows($result)) {
			while ($row = mysqli_fetch_array($result)) {
				$countt                 = $row[0];
			}
			?>
			<tr>
				<td>
					<div align="center"><?php echo $i ?> -</div>
				</td>
				<td><a href="mov_tarjeta1.php">TARJETAS DE CREDITO</a></td>
				<td>
					<center></center>
				</td>
				<td>
					<div align="center"><?php echo $countt ?></div>
				</td>
			<?php } else {
			$countt = 0;
			?>
				<td>
					<div align="center"><?php echo $countt ?></div>
				</td>
			</tr>
		<?php }
		/*
	  $i++;
	  $sql="SELECT count(*) FROM local";
      $result = mysqli_query($conexion,$sql);
      if (mysqli_num_rows($result) ){
	  while ($row = mysqli_fetch_array($result)){
             $countt                 = $row[0];
	  }
	  ?>
	  	<tr>
          <td><div align="left"><?php echo $i?> -</div></td>
          <td><a href="mov_local1.php">LOCALES</a></td>
		  <td><center></center></td>
          <td><div align="right"><?php echo $countt?></div></td>
	  <?php }
	  else
	  {
	  $countt = 0;
	  ?>
	     <td><div align="right"><?php echo $countt?></div></td>
        </tr>
	  <?php }
	  */
		?>

	</table>
</body>

</html>