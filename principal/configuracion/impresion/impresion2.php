<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
<?php require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
require_once("../../../funciones/funct_principal.php");
?>
<script>
function validar()
{
	var f = document.form2;
	if (f.size.value == "")
	{ alert("INGRESE UNA VALOR"); f.size.focus();return;}
	if (f.numlineas.value == "")
	{ alert("INGRESE UNA VALOR"); f.numlineas.focus();return;}
	f.action = "impresion3.php";
	f.method = "post";
	f.submit();
}
</script>
</head>
<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
?>
<body>
<?php 
$local 		= $_REQUEST['local'];
$error 		= $_REQUEST['error'];
$val   		= $_REQUEST['val'];
$tipdocu    = $_REQUEST['tipdocu'];
if ($val == 1)
{
	$sql1="SELECT nomloc,nombre FROM xcompa where codloc = '$local'";
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result1)){	
	while ($row1 = mysqli_fetch_array($result1)){
		$nomloc  = $row1['nomloc'];
		$nomloc1  = $row1['nombre'];	
		if($nomloc1<>"")
		{
		$nomloc = $nomloc1;
		}
	}
	}
	$sql1="SELECT codimpresion,codlocal,tipodocumento,negrita,imprapida,size,numlineas,impresora FROM impresion where codlocal = '$local' and tipodocumento = '$tipdocu'";
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result1)){	
	while ($row1 = mysqli_fetch_array($result1)){
		$codimpresion  = $row1['codimpresion'];	
		$codlocal  		  = $row1['codlocal'];
		$tipodocumento    = $row1['tipodocumento'];
		$negrita       = $row1['negrita'];
		$imprapida     = $row1['imprapida'];
		$size	       = $row1['size'];
		$numlineas     = $row1['numlineas'];
		$impresora     = $row1['impresora'];
		$exist = 1;
	}
	}
	else
	{
	$exist = 0;
	}
?>
<table width="739" border="0" align="center" class="tabla2">
  <tr>
    <td width="731">
	<br>
	<b>DESCRIPCION : <?php echo $nomloc?></b><?php if ($error == 1){?><font color="#FF0000"> - ERROR AL INGRESAR DATOS</font><?php }?><br />
	<br />
	<img src="../../../images/line2.png" width="720" height="4" /><br />
	  <br />
	  <form id="form2" name="form2" onkeyup="highlight(event)" onclick="highlight(event)">
      <table width="725" border="0" align="center">
        <tr>
          <td width="120">LETRA NEGRITA </td>
          <td width="595"><select name="negrita" id="negrita">
              <option value="1" <?php if ($negrita == "1"){?>selected="selected"<?php }?>>Si</option>
              <option value="0" <?php if ($negrita == "0"){?>selected="selected"<?php }?>>No</option>
          </select></td>
        </tr>
        <tr>
          <td>TAMA&Ntilde;O DE LETRA </td>
          <td><input name="size" type="text" id="size"  onkeypress="return acceptNum(event)" value="<?php echo $size?>" maxlength="4"/></td>
        </tr>
        <tr>
          <td>NUMERO DE LINEAS </td>
          <td><input name="numlineas" type="text" id="numlineas"  onkeypress="return acceptNum(event)" value="<?php echo $numlineas?>" maxlength="4"/></td>
        </tr><tr>
          <td>PUERTO IMPRESORA  </td>
          <td>
            <select name="impresora" id="impresora">
              <option value="lpt1" <?php if ($impresora == "lpt1"){?>selected="selected"<?php }?>>LPT1</option>
              <option value="lpt2" <?php if ($impresora == "lpt2"){?>selected="selected"<?php }?>>LPT2</option>
			  <option value="lpt3" <?php if ($impresora == "lpt3"){?>selected="selected"<?php }?>>LPT3</option>
			  <option value="lpt4" <?php if ($impresora == "lpt4"){?>selected="selected"<?php }?>>LPT4</option>
            </select>
            <input name="local" type="hidden" id="local" value="<?php echo $local?>" />
            <input name="val" type="hidden" id="val" value="<?php echo $val?>" />
			<input name="exist" type="hidden" id="exist" value="<?php echo $exist?>" />
            <input name="tipdocu" type="hidden" id="tipdocu" value="<?php echo $tipdocu;?>" />
			<input name="codimpresion" type="hidden" id="codimpresion" value="<?php echo $codimpresion;?>" />
            <input type="button" name="Submit" value="Actualizar" onclick="validar()"/></td>
        </tr>
      </table>
      </form>
	  </td>
	  </tr>
	  </table>
	 <?php }?>
</body>
</html>