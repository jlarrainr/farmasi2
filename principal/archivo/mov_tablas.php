<?php include('../session_user.php');
require_once('../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title><?php echo $desemp ?></title>
	<link rel="icon" type="image/x-icon" href="../../iconoNew.ico" />
	<link href="../css/body.css" rel="stylesheet" type="text/css" />
	<link href="css/tablas.css" rel="stylesheet" type="text/css" />
	<link href="../../css/tables_consult.css" rel="stylesheet" type="text/css" />
	<?php require_once("../../funciones/functions.php"); ?>
	<script type="text/javascript" language="JavaScript1.2" src="/comercial/funciones/control.js"></script>
	<!-- <script type="text/javascript" language="JavaScript1.2" src="../menu_block/stmenu.js"></script> -->
</head>

<body>
	<div class="tabla1">
		<script type="text/javascript" language="JavaScript1.2" src="../menu_block/men.js"></script>
		<table width="100%" border="0" align="center">
			<tr>
				<td>
					<!-- <br><br> -->
					<center>
						<iframe src="mov_tablas1.php" name="iFrame1" width="100%" height="615" scrolling="Automatic" frameborder="No" id="iFrame1" allowtransparency="True"></iframe>
					</center>
				</td>
			</tr>
		</table>
	</div>
</body>

</html>