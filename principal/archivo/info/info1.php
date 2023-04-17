<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

<title>Documento sin t&iacute;tulo</title>
<link href="../../archivo/css/css/style.css" rel="stylesheet" type="text/css" />
<link href="../../archivo/css/css/tablas.css" rel="stylesheet" type="text/css" />
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
$val1    = isset($_REQUEST['val1']) ? ($_REQUEST['val1']) : "";
$val2    = isset($_REQUEST['val2']) ? ($_REQUEST['val2']) : "";
$val3    = isset($_REQUEST['val3']) ? ($_REQUEST['val3']) : "";
$codpro  = isset($_REQUEST['country_ID']) ? ($_REQUEST['country_ID']) : "";
$local   = isset($_REQUEST['local']) ? ($_REQUEST['local']) : "";
$marca   = isset($_REQUEST['marca']) ? ($_REQUEST['marca']) : "";
$descli = "";
$search  = "";
$val     = "";
if ($val1 == 1)
{
	$sql="SELECT desprod,codpro FROM producto where codpro = '$codpro'";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
            $desprod    = $row['desprod'];
            $codpro    = $row['codpro'];
	}
	}
	$val = $val1;
	$search = $codpro;
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
  f.submit();
}

function ent(evt)
{
	var key = nav4 ? evt.which : evt.keyCode;
	if (key == 13)
	{
		   var f = document.form1;
  if (f.country.value == "")
  { alert("Ingrese el Producto para iniciar la Busqueda"); f.country.focus(); return; }
//		 
		  f.submit();
	}
}
function sf()
{
document.form1.country.focus();
}
</script>
<script type="text/javascript" language="JavaScript1.2" src="/comercial/funciones/control.js"></script>
</head>
<body onload="sf();">
<table width="943" border="0">
    <tr>
      <td width="835"><b><u>LITERATURA DE PRODUCTOS: </u></b>: Se mostraran los Productos para diguitar sus instrucciones. </td>
      <td width="109">&nbsp;</td>
    </tr>
</table>
  <table width="950" border="0">
    <tr>
´      <td width="944">
	  <form id="form1" name="form1">
	  <table width="943" border="0">
          <tr>
            <td width="58">PRODUCTO</td>
            <td width="529">
			<input name="country" type="text" id="country" onkeyup="ajax_showOptions(this,'getCountriesByLetters',event)" size="100" onkeypress="return ent(event);" onclick="this.value=''" value="<?php echo $desprod;?>"/>
			</td>
            <td width="342">
			<div align="right">
              <input name="val1" type="hidden" id="val1" value="1"/>
              <input type="hidden" id="country_hidden" name="country_ID" value="<?php echo $codpro?>"/>
              <input name="search" type="button" id="search" value="Buscar" onclick="buscar()" class="buscar"/>
              <input name="exit" type="button" id="exit" value="Salir"  onclick="salir()" class="salir"/>
            </div>
			</td>
          </tr>
        </table>
      </form>
          <table width="943" border="0">
            <tr>
              <td><?php /*if ($val == 1){?>MARCA BUSCADA POR: <b><u><?php echo $marca;?></u></b><?php }*/?></td>
              <td width="189"><div align="right"></div></td>
            </tr>
          </table>
        <div align="center"><img src="../../../images/line2.png" width="935" height="4" /></div></td>
    </tr>
  </table>
    <iframe src="info2.php?search=<?php echo $search?>&&val=<?php echo $val?>" name="marco" id="marco" width="954" height="450" scrolling="Automatic" frameborder="0" allowtransparency="0">
  </iframe>
</body>
</html>
