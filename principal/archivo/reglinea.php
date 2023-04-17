<?php include('../session_user.php');
require_once('../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../../titulo_sist.php');
$des = "REGISTRO DE PRINCIPIO ACTIVO";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $des?></title>
<link href="css/tablas.css" rel="stylesheet" type="text/css" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
<script>
function sf()
{
document.popupForm.myTextField.focus();
}
function cerrar(e){
tecla=e.keyCode
	if (tecla == 27)
	{
	window.close();
	}
}
function conmayus(field) {
  field.value = field.value.toUpperCase()
}
</script>
</head>
<body onload="sf();" onkeyup="cerrar(event)">
<form name="popupForm">
  <table width="444" border="0" class="tabla2">
    <tr>
      <td><b><u><?php echo $des?></u></b></td>
    </tr>
  </table>
  <br />
  <table width="444" border="0" class="tabla2">
    <tr>
      <td><table width="436" border="0">
        <tr>
          <td width="79">DESCRIPCION</td>
          <td width="347">
		  <input name="myTextField" type="text" id="myTextField" size="50" onChange="conmayus(this)"/>
          <input name="button" type="button" onclick="opener.copyForm2()" value="Grabar" />
          </td>
        </tr>
      </table></td>
    </tr>
  </table>
  </form>
</body>
</html>
