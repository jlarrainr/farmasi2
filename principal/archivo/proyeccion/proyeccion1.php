<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>Documento sin t&iacute;tulo</title>
<link href="../css/css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/css/tablas.css" rel="stylesheet" type="text/css" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<link href="../../../css/autocomplete.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../funciones/ajax.js"></script>
<script type="text/javascript" src="../../../funciones/ajax-dynamic-list.js"></script>
<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS?>
<?php require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS?>
<?php require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES?>
<?php require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES?>
<?php require_once("../../local.php");	//LOCAL DEL USUARIO
$sql="SELECT * FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$user    = $row['nomusu'];
}
}
$val     = $_REQUEST['val'];
$codpro  = $_REQUEST['country_ID'];
$sql="SELECT desprod FROM producto where codpro = '$codpro'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
				$desprod    = $row['desprod'];
}
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
function buscar()
{
  var f = document.form1;
  if (f.country.value == "")
  { alert("Ingrese el Producto para iniciar la Busqueda"); f.country.focus(); return; }
  f.mehod = "post";
  f.submit();
}
function sf()
{
document.form1.country.focus();
}
</script>
<script type="text/javascript" language="JavaScript1.2" src="/comercial/funciones/control.js"></script>
</head>
<body onload="sf();">
 <table width="954" border="0">
    <tr>
      <td><b><u>PROYECCION DE PRODUCTOS </u></b>
	    <form id="form1" name="form1"><table width="943" border="0">
          <tr>
            <td width="58">PRODUCTO</td>
            <td><input name="country" type="text" id="country" onkeyup="ajax_showOptions(this,'getCountriesByLetters',event),this.value = this.value.toUpperCase();
" size="100" onclick="this.value=''" value="<?php echo $desprod?>"/>
                <input name="val" type="hidden" id="val" value="1"/>
                <input type="hidden" id="country_hidden" name="country_ID" value="<?php echo $codpro?>"/>
                <input name="search" type="button" id="search" value="Buscar" onclick="buscar()" class="buscar"/>
                <input name="exit" type="button" id="exit" value="Salir"  onclick="salir()" class="salir"/>
			</td>
            <td width="189"><div align="right"></div></td>
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
  <iframe src="proyeccion2.php?val=<?php echo $val?>&codpro=<?php echo $codpro?>" name="marco" id="marco" width="953" height="553" scrolling="Automatic" frameborder="0" allowtransparency="0">
  </iframe>
  <?php }
  ?>
</body>
</html>
