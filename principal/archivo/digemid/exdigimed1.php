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
<?php //require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS?>
<?php require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES?>
<?php require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES?>

<script>
function salir()
{
	 var f = document.form1;
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="../../index.php";
	 f.submit();
}


function focus()
{
     var f = document.form1;
f.text.focus();
}
function validar()
{
  var f = document.form1;
//  if (f.user.value == "")
//  { alert("Ingrese un login de Usuario"); f.user.focus(); return; }
//  if (f.user.value == "Login o clave no validos")
//  { alert("Ingrese un login de Usuario"); f.user.value = "";f.user.focus(); return; }
  if (f.text.value == "")
  { alert("Ingrese una clave de Usuario"); f.text.focus(); return; }
  f.submit();
}
</script>

</head>
<body <?php ?>onload="focus();"<?php ?>>

 	
	 
	  <table width="1000" height="2" border="0" align="center">
        <tr>
        
          <td width="442" valign="top">
		    <table width="285" height="83" border="0" align="left" class="tabla2">
            <tr>
              <td width="435">
		<form id="form1" name="form1" method="post" action="verifica.php">
                <table width="174" border="0" align="center">
                 
                  <tr>
                    <td class="text_login">Contrase&ntilde;a</td>
                    <td>
                      <input name="text" type="password" id="text"  size="30"/>                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>
                      <input type="button" name="Submit" value="Ingresar" onclick="validar()"/>                    </td>
                  </tr>
                </table>
                       
              </form>
              </td>
            </tr>
          </table></td>
        </tr>
</table>
<!--  <iframe src="digemid2.php?search=<?php echo $search?>&val=<?php echo $val?>" name="marco" id="marco" width="954" height="450" scrolling="Automatic" frameborder="0" allowtransparency="0">
  </iframe>-->
</body>
</html>
