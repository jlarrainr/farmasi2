<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/tablas.css" rel="stylesheet" type="text/css" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS?>
<?php require_once("../../../funciones/calendar.php");?>
<?php require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS?>
<?php require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES?>
<?php require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES?>
<script language="JavaScript">
function validar()
{
	  var f = document.form1;
	  if (f.anio.value == "")
	  {
	  alert("Ingrese el año, para realizar el analisis de la Venta");f.anio.focus(); return;
	  }
	  f.submit();
}
function sf(){
var f = document.form1;
document.form1.desc.focus();
}
function salir()
{
	 var f = document.form1;
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="../../index.php";
	 f.submit();
}
function printer()
{
window.marco.print();
}
</script>
<?php $anio = $_REQUEST['anio'];
$val  = $_REQUEST['val'];
if ($anio == "")
{
$anio = date('Y');
}
?>
<script type="text/javascript" language="JavaScript1.2" src="/comercial/funciones/control.js"></script>
</head>
<body>
 <table width="954" border="0">
    <tr>
      <td><b><u>CUOTA DE VENTAS POR LOCAL</u></b>
	  <form id="form1" name="form1" method = "post" action="">
        <table width="927" border="0">
          <tr>
            <td width="119">SELECCIONE A&Ntilde;O </td>
            <td>
			  <input name="anio" type="text" id="anio" value="<?php echo $anio?>" size="8" maxlength="4"/>
              <input name="val" type="hidden" id="val" value="1" />
              <input type="button" name="Submit" value="Buscar" onclick="validar()" class="buscar"/>
              <input type="button" name="Submit32" value="Salir" onclick="salir()" class="salir"/></td>
		  </tr>
        </table>
        <div align="left"><img src="../../../images/line2.png" width="940" height="4" /></div>
	    </form>
      </td>
    </tr>
</table>
  <?php if ($val == 1)
  {
  ?>
  <iframe src="cuotas2.php?val=<?php echo $val?>&anio=<?php echo $anio?>" name="marco" id="marco" width="953" height="553" scrolling="Automatic" frameborder="0" allowtransparency="0">
  </iframe>
  <?php }
  ?>
</body>
</html>
