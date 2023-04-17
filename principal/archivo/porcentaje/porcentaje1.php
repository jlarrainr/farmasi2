<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../css/css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/css/tablas.css" rel="stylesheet" type="text/css" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS?>
<?php require_once("../../../funciones/calendar.php");?>
<?php require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS?>
<?php require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES?>
<?php require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES?>
<?php require_once("../../local.php");	//LOCAL DEL USUARIO
$sql="SELECT nomusu FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$user    = $row['nomusu'];
}
}
$sql="SELECT utldmin FROM datagen_det";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$utldmin    = $row['utldmin'];
}
}
?>
<script language="JavaScript">
function sf(){
var f = document.form1;
document.form1.p1.focus();
}
function validar()
{
	var f = document.form1;
	if (f.p1.value == "")
	 { alert("Ingrese un Margen Inicial"); f.p1.focus(); return; }
	if (f.p2.value == "")
	 { alert("Ingrese un Margen Final"); f.p2.focus(); return; }
	 f.method = "post";
	 f.submit();
}
function salir()
{
	 var f = document.form1;
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="../../index.php";
	 f.submit();
}
</script>
<script type="text/javascript" language="JavaScript1.2" src="/comercial/funciones/control.js"></script>
<style type="text/css">
<!--
.Estilo1 {color: #0B55C4}
-->
</style>
</head>
<?php $val = $_REQUEST['val'];
$p1	 = $_REQUEST['p1'];
$p2	 = $_REQUEST['p2'];
?>
<body onload="sf();">
 <table width="954" border="0">
    <tr>
      <td>
	  <b><u>PORCENTAJE DE UTILIDADES</u></b>
	  <form id="form1" name="form1" method = "post">
        <table width="927" border="0">
          <tr>
            <td width="119">PORCENTAJE INICIAL</td>
            <td width="124">
			<input name="p1" type="text" id="p1" onkeypress="return acceptNum(event)" size="8" maxlength="8" value="<?php echo $p1?>"/> 
			% 
			</td>
			<td width="106">PORCENTAJE  FINAL</td>
			<td width="135">
			<input name="p2" type="text" id="p2" onkeypress="return acceptNum(event)" size="8" maxlength="8" value="<?php echo $p2?>"/> 
			% 
			</td>
			<td width="166"><input name="val" type="hidden" id="val" value="1" />
              <input type="button" name="Submit" value="Buscar" onclick="validar()" class="buscar"/>
              <input type="button" name="Submit32" value="Salir" onclick="salir()" class="salir"/>
		    </td>
		<td width="251"><div align="right"><span class="blues Estilo1"><strong>LOCAL:</strong> <?php echo $nombre_local?></span></div></td>
          </tr>
        </table>
        <div align="left"><img src="../../../images/line2.png" width="940" height="4" /></div>
        <table width="928" border="0">
          <tr>
            <td><div align="left"><u>PORCENTAJE DE UTILIDAD MINIMO : <b><?php echo $utldmin?> %</b></u></div></td>
            <td width="249"><div align="right"><span class="blues Estilo1"><b>USUARIO:</b> <?php echo $user?></span></div></td>
          </tr>
        </table>
	    <div align="left"><img src="../../../images/line2.png" width="940" height="4" /></div>
	    </form>
      </td>
    </tr>
  </table>
  <br>
  <iframe src="porcentaje2.php?p1=<?php echo $p1?>&p2=<?php echo $p2?>&val=<?php echo $val?>" name="marco" id="marco" width="954" height="490" scrolling="Automatic" frameborder="0" allowtransparency="0">
  </iframe>
</body>
</html>
