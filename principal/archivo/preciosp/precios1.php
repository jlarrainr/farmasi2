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
<?php require_once("../../local.php");	//LOCAL DEL USUARIO
$sql="SELECT nomusu FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$user    = $row['nomusu'];
}
}
$val1    = isset($_REQUEST['val1']) ? ($_REQUEST['val1']) : "";
$val2    = isset($_REQUEST['val2']) ? ($_REQUEST['val2']) : "";
$val3    = isset($_REQUEST['val3']) ? ($_REQUEST['val3']) : "";
$produc  = isset($_REQUEST['country']) ? ($_REQUEST['country']) : "";
$local   = isset($_REQUEST['local']) ? ($_REQUEST['local']) : "";
$marca   = isset($_REQUEST['marca']) ? ($_REQUEST['marca']) : "";
if ($val1 == 1)
{
	$sql="SELECT desprod FROM producto where desprod like '$produc%'";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
					$desprod    = $row['desprod'];
	}
	}
	$val = $val1;
	$search = $produc;
}
if ($val2 == 2)
{
	$sql="SELECT destab FROM titultabladet where codtab = '$marca1'";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
					$destab    = $row['destab'];
	}
	}
	$val = $val2;
	$search = $marca;
}
if ($val3 == 3)
{
	$sql="SELECT nomloc FROM xcompa where habil = '1' and codloc = '$local1'";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
					$nomloc    = $row['nomloc'];
	}
	}
	$val = $val3;
	$search = $local;
}
?>
<script type="text/javascript" language="JavaScript1.2" src="/comercial/funciones/control.js"></script>
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
  f.val3.value=0;
  f.val2.value=0;
  f.submit();
}
function lp1()
{
  var f = document.form1;
  f.val1.value=0;
  f.val3.value=0;
  f.submit();
}
function lp2()
{
  var f = document.form1;
  f.val1.value=0;
  f.val2.value=0;
  f.submit();
}
function sf()
{
document.form1.country.focus();
}
var nav4 = window.Event ? true : false;
function ent(evt)
{
	var key = nav4 ? evt.which : evt.keyCode;
	if (key == 13)
	{
		  var f = document.form1;
		  if (f.country.value == "")
 		  { alert("Ingrese el Producto para iniciar la Busqueda"); f.country.focus(); return; }
		  f.val3.value=0;
		  f.val2.value=0;
		  f.submit();
	}
}
</script>
</head>
<body <?php ?>onload="sf();"<?php ?>>
<table width="943" border="0">
    <tr>
      <td width="835"><b><u>PRECIOS DE PRODUCTOS: </u></b>: Se mostraran los Productos con sus respectivos Precios. </td>
      <td width="109">&nbsp;</td>
    </tr>
</table>
  <table width="950" border="0">
    <tr>
�      <td width="944">
	  <form id="form1" name="form1">
	  <table width="943" border="0">
          <tr>
            <td width="58">PRODUCTO</td>
            <td width="529">
			<input name="country" type="text" id="country" size="100" value="<?php echo $produc?>" onkeypress="return ent(event);"/>
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
      <div align="center"><img src="../../../images/line2.png" width="920" height="4" /></div>
      <table width="943" border="0">
        <tr>
          <td width="58">MARCA</td>
          <td width="529">
		  <select name="marca" id="marca">
            <?php 
				$sql = "SELECT codtab,destab FROM titultabladet where tiptab = 'M'"; 
				$result = mysqli_query($conexion,$sql); 
				while ($row = mysqli_fetch_array($result)){ 
				?>
            <option value="<?php echo $row["codtab"]?>" <?php if ($marca == $row["codtab"]){?>selected="selected"<?php }?>><?php echo $row["destab"] ?></option>
            <?php } ?>
          </select>		  
		  </td>
          <td width="342">
		  <div align="right">
            <input name="val2" type="hidden" id="val2" value="2"/>
            <input name="search222" type="submit" id="search222" value="Buscar" class="buscar" onclick="lp1()"/>
            <input name="exit222" type="button" id="exit222" value="Salir"  onclick="salir()" class="salir"/>
          </div></td>
        </tr>
      </table>
	  <div align="center"><img src="../../../images/line2.png" width="920" height="4" /> </div>
	  <table width="943" border="0">
        <tr>
          <td width="58">LOCAL</td>
          <td width="529">
		  <select name="local" id="local">
            <?php 
				$sqlx = "SELECT codloc,nomloc,nombre FROM xcompa where habil = '1'"; 
				$resultx = mysqli_query($conexion,$sqlx); 
				while ($row = mysqli_fetch_array($resultx)){ 
                                    $loc    = $row["codloc"];
                                    $nloc   = $row["nomloc"];
                                    $nombre = $row["nombre"];
                                    if ($nombre == '') {
                                        $locals = $nloc;
                                    } else {
                                        $locals = $nombre;
                                    }
				?>
            <option value="<?php echo $row["codloc"]?>" <?php if ($local == $row["codloc"]){?>selected="selected"<?php }?>><?php echo $locals; ?></option>
            <?php } ?>
          </select>
		  </td>
          <td width="342"><div align="right">
            <input name="val3" type="hidden" id="val3" value="3"/>
            <input name="search22" type="submit" id="search22" value="Buscar" class="buscar"  onclick="lp2()"/>
            <input name="exit22" type="button" id="exit22" value="Salir"  onclick="salir()" class="salir"/>
          </div></td>
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
  <iframe src="precios2.php?search=<?php echo $search?>&val=<?php echo $val?>" name="marco" id="marco" width="954" height="450" scrolling="Automatic" frameborder="0" allowtransparency="0">
  </iframe>
</body>
</html>
