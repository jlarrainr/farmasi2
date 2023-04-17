<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
include('../../session_user.php');
include('../../local.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../equipos/css/style1.css" rel="stylesheet" type="text/css" />
<link href="../equipos/css/tabla2.css" rel="stylesheet" type="text/css" />
<?php require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUME
?>
<?php
$error = $_REQUEST['error'];
if ($error == 2)
{
	$desc = "LA CLAVE INGRESADA ES INCORRECTA";
	$color = "#990000";
}
?>
<script>
function salir()
{
	 var f = document.form1;
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="../../index.php";
	 f.submit();
}
function grabar()
{
	 var f = document.form1;
	 f.method = "post";
	 f.target = "_top";
	 f.action ="verifica.php";
	 f.submit();
}
function abrir_index1(e)
{
	tecla=e.keyCode;
	/////F11/////
	if (tecla == 13) 
	{
		var f = document.form1;
	 f.method = "post";
	 f.target = "_top";
	 f.action ="verifica.php";
	 f.submit();
	}
}
function sf()
{
 var f = document.form1;
 f.pass.focus();
}
</script>
</head>
<body onload="sf();" onkeyup="abrir_index1(event)">
<div align="left"><img src="../../../images/line2.png" width="100%" height="4" /></div>
<?php if ($desc  <> ''){?><font color="<?php echo $color?>"><?php echo $desc;?></font><br /><?php }?>
<form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
  <table width="100%" border="0">
    <tr>
      <td width="501">
          <table width="70%" border="0" align="center">
        <tr>
          <td width="70"><strong>PASSWORD</strong></td>
          <td width="252">
            <input name="pass" type="password" id="pass" size="40" />
          </td>
          <td width="200"><div align="right">
              <input name="exit" type="button" id="exit" value="Aceptar" onclick="grabar()" class="imprimir"/>
              <input name="exit" type="button" id="exit" value="Salir" onclick="salir()" class="salir"/>
          </div></td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
<div align="left"><img src="../../../images/line2.png" width="100%" height="4" /></div>
</body>
</html>
