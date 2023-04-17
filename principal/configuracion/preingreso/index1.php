<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="css/style1.css" rel="stylesheet" type="text/css" />
<link href="css/tabla2.css" rel="stylesheet" type="text/css" />
<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUME
$sql1="SELECT valor FROM preing";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
		    $valor        = $row1['valor'];
}
}
if ($valor == '')
{
$valor = 0;
}
?>
<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
.Estilo2 {color: #0066CC}
.Estilo3 {color: #009900}
.Estilo4 {color: #0066CC; font-weight: bold; }
.Estilo5 {	color: #666666;
	font-weight: bold;
}
-->
</style>
<script>
function salir()
{
	 var f = document.form1;
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="../../index.php";
	 f.submit();
}
function validar(){
  var f = document.form1;
  f.method = "post";
  f.action ="index2.php";
  f.submit();
}
</script>
</head>
<body onload="sf();">
<form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
  <table width="568" border="0">
    <tr>
      <td width="562"><table width="552" border="0">
        <tr>
          <td width="177">PREINGRESOS</td>
          <td width="365">
            <select name="valor">
              <option value="1" <?php if ($valor == 1){?>selected="selected"<?php }?>>ACTIVAR PREINGRESOS</option>
              <option value="0" <?php if ($valor == 0){?>selected="selected"<?php }?>>DESACTIVAR PREINGRESOS</option>
            </select>
            <input type="button" name="Submit" value="Actualizar" class="grabar" onclick="validar()"/>
            <input name="exit" type="button" id="exit" value="Salir" onclick="salir()" class="salir"/>		  </td>
        </tr>
      </table>
	   <br>
        <div align="left"><img src="../../../images/line2.png" width="500" height="4" /></div>
      </td>
    </tr>
  </table>
</form>
</body>
</html>
