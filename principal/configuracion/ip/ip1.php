<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<script type="text/javascript" language="JavaScript1.2" src="menu/stmenu.js"></script>
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/select_pro.css" rel="stylesheet" type="text/css" />
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
require_once("funciones/ip.php");	//COLORES DE LOS BOTONES
?>
</head>
<body onload="sf();">
<div class="mask1">
	<div class="mask2">
		<div class="mask3">
		<table width="659" border="0">
		  <tr>
			<td width="653"><span class="text_combo_select"><strong>ASIGNAMIENTO DE IP&acute;S POR LOCALES </strong></span><img src="../../../images/line2.jpg" width="650" height="4" /></td>
		  </tr>
		</table>
		<table width="658" border="0">
          <tr>
            <td>
			<form id="form1" name="form1" method = "post" action="" onKeyUp="highlight(event)" onClick="highlight(event)">
              <table width="616" border="0" align="center">
			  <tr>
				<td width="56">LOCAL</td>
				<td width="362">
				<div id="demoMed">
				<select name="local" class="Estilodany" id="local">
				  <?php 
					$sql = "SELECT * FROM xcompa order by codloc"; 
					$result = mysqli_query($conexion,$sql); 
					while ($row = mysqli_fetch_array($result)){ 
					?>
				  <option value="<?php echo $row["codloc"] ?>" class="Estilodany"><?php echo strtoupper($row["nomloc"]) ?></option>
				  <?php } ?>
				</select>
				</div>
				</td>
				<td width="184">&nbsp;</td>
			  </tr>
			  <tr>
				<td>IP</td>
				<td><input name="ip" type="text" id="ip" onkeypress="return decimal(event)" size="70" maxlength="15"/></td>
				<td>
				<input type="button" name="Submit" value="Grabar" onclick="validar()" class="grabar"/>
				<input type="button" name="exit" value="Salir" onclick="salir()" class="salir"/>
				</td>
			  </tr>
			</table>
            </form>
            </td>
          </tr>
        </table>
		<table width="659" border="0">
          <tr>
            <td width="653"><img src="../../../images/line2.jpg" width="650" height="4" /></td>
          </tr>
        </table>
		<iframe src="ip2.php" name="iFrame1" width="660" height="370" scrolling="Automatic" frameborder="No" id="iFrame1" allowtransparency="True"></iframe>
        </div>
	</div>
</div>
</body>
</html>
