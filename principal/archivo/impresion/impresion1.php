<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../css/css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/css/tablas.css" rel="stylesheet" type="text/css" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS?>
<?php require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS?>
<?php require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES?>
<?php require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES?>
<?php require_once("../../local.php");	//LOCAL DEL USUARIO
?>
<script>
function sal()
{
	 var f = document.form6;
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="../../index.php";
	 f.submit();
}
</script>
</head>
<body>
<table width="100%" border="0">
    <tr>
      <td width="1090"><b><u>IMPRESION DE VENTAS: </u></b>: Se mostraran las ventas a imprimir. </td>
      <td width="131">
	  <form id="form6" name="form6">
        <div align="right">
          <input type="button" name="Submit" value="Salir" onclick="sal()" class="buscar"/>
          </div>
	  </form></td>
    </tr>
</table>
  <table width="950" border="0">
    <tr>
      <td width="944"><table width="943" border="0">
            <tr>
              <td></td>
              <td width="189"><div align="right"></div></td>
            </tr>
          </table>
        <div align="center"><img src="../../../images/line2.png" width="935" height="4" /></div></td>
    </tr>
  </table>
<?php 
require_once("impresion2.php");
?>
</body>
</html>
