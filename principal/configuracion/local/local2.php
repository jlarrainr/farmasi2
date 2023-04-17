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
var f = document.form1;
	if (f.nom.value == "")
	{ alert("INGRESE UNA DESCRIPCION"); f.nom.focus();return;}
	f.action = "local4.php";
	f.method = "post";
	f.submit();
}
function validar1()
{
var f = document.form2;
	
	if (f.dbrev.value == "")
	{ alert("INGRESE UNA DESCRIPCION"); f.dbrev.focus();return;}
	if ((f.linea.value == "") && (f.linea.value == 0))
	{ alert("INGRESE UN VALOR"); f.linea.focus();return;}
	if ((f.col.value == "") && (f.linea.value == 0))
	{ alert("INGRESE UN VALOR"); f.col.focus();return;}
	if (f.cuant.value == "")
	{ alert("INGRESE UN VALOR"); f.cuant.focus();return;}
	if (f.cuant.value == '')
	{ alert("EL LA LONGITUD DEL TEXTO");f.cuant.focus();return;}
	f.action = "local3.php";
	f.method = "post";
	f.submit();
}
function validar2()
{
var f = document.form3;
	if (f.disp.value == "")
	{ alert("INGRESE UN VALOR"); f.linea.focus();return;}
	if (f.lin1.value == "")
	{ alert("INGRESE UN VALOR"); f.lin1.focus();return;}
	if (f.lin2.value == "")
	{ alert("INGRESE UN VALOR"); f.lin2.focus();return;}
	if (f.lin3.value == "")
	{ alert("INGRESE UN VALOR"); f.lin3.focus();return;}
	if (f.lin4.value == "")
	{ alert("INGRESE UN VALOR"); f.lin4.focus();return;}
	if (f.lin5.value == "")
	{ alert("INGRESE UN VALOR"); f.lin5.focus();return;}
	if (f.lin6.value == "")
	{ alert("INGRESE UN VALOR"); f.lin6.focus();return;}
	if (f.lin7.value == "")
	{ alert("INGRESE UN VALOR"); f.lin7.focus();return;}
	if (f.lin8.value == "")
	{ alert("INGRESE UN VALOR"); f.lin8.focus();return;}
	if ((f.lin1.value >= 30)||(f.lin1.value<1))
	{ alert("EL NUMERO MAXIMO DE LINEAS ES 30");f.lin1.focus();return;}
	if ((f.lin2.value>8))
	{ alert("EL NUMERO DE LINEAS ES DEL 0 AL 8");f.lin2.focus();return;}
	if ((f.lin3.value>8))
	{ alert("EL NUMERO DE COLUMNAS ES DEL 1 AL 8");f.lin3.focus();return;}
	if ((f.lin4.value>8))
	{ alert("EL NUMERO DE COLUMNAS ES DEL 1 AL 8");f.lin4.focus();return;}
	if ((f.lin5.value>8))
	{ alert("EL NUMERO DE COLUMNAS ES DEL 1 AL 8");f.lin5.focus();return;}
	if ((f.lin6.value>8))
	{ alert("EL NUMERO DE COLUMNAS ES DEL 1 AL 8");f.lin6.focus();return;}
	if ((f.lin7.value>8))
	{ alert("EL NUMERO DE COLUMNAS ES DEL 1 AL 8");f.lin7.focus();return;}
	if ((f.lin8.value>8))
	{ alert("EL NUMERO DE COLUMNAS ES DEL 1 AL 8");f.lin8.focus();return;}
	if ((f.lin9.value>8))
	{ alert("EL NUMERO DE COLUMNAS ES DEL 1 AL 8");f.lin9.focus();return;}
	if ((f.lin9.value>8))
	{ alert("EL NUMERO DE COLUMNAS ES DEL 1 AL 8");f.lin10.focus();return;}
	f.action = "local3.php";
	f.method = "post";
	f.submit();
}
function det(a)
{
	var f  = document.form3;
	var tt = a;
	texto = document.getElementById('lin'+tt).value;
	i = 3;
	while(i <= 10)
	{
		if (i != tt)
		{
			rtexto = document.getElementById('lin'+i).value;
			if (texto == rtexto)
			{
			//alert("EXISTEN VALORES IGUALES");return;
			}
		}
		else
		{
		}
	i = i + 1;
	}
}
</script>
</head>
<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
//require_once("../../../funciones/functions.php");
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
?>
<body>
<?php 
$local 		= $_REQUEST['local'];
$error 		= $_REQUEST['error'];
$val   		= $_REQUEST['val'];
$tip   		= $_REQUEST['tip'];	////1 = pie y cabecera, 2 = contenido
$codformato = $_REQUEST['codformato'];
$tipdocu    = $_REQUEST['tipdocu'];


if ($val == 1)
{
	$sql1="SELECT nomloc,nombre FROM xcompa where codloc = '$local'";
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result1)){	
	while ($row1 = mysqli_fetch_array($result1)){
		$nomloc  	= $row1['nomloc'];	
		$nombre  	= $row1['nombre'];
	}
	}
	$sql1="SELECT fdisp,flinpag,fini,fcanti,fcodpro,fmarca,fpreuni,fmonto,fdescuento,fnom,fref,contit,anchocod,anchonom,anchomarca,anchoreferencial,anchodescuento,anchocantidad,anchoprecio,anchosubtotal, coddet FROM xcompadetalle where codloc = '$local' and tipdoc = '$tipdocu'";
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result1)){	
	while ($row1 = mysqli_fetch_array($result1)){
		$fdisp   	= $row1['fdisp'];
		$flinpag 	= $row1['flinpag'];
		$fini    	= $row1['fini'];
		$fcanti  	= $row1['fcanti'];
		$fcodpro 	= $row1['fcodpro'];	
		$fmarca  	= $row1['fmarca'];	
		$fpreuni 	= $row1['fpreuni'];	
		$fmonto  	= $row1['fmonto'];	
		$contit  	= $row1['contit'];	
		$fdescuento = $row1['fdescuento'];		
		$fnom		= $row1['fnom'];
		$fref		= $row1['fref'];
		$anchocod		= $row1['anchocod'];
		$anchonom		= $row1['anchonom'];
		$anchomarca		= $row1['anchomarca'];
		$anchoreferencial		= $row1['anchoreferencial'];
		$anchodescuento		= $row1['anchodescuento'];
		$anchocantidad		= $row1['anchocantidad'];
		$anchoprecio		= $row1['anchoprecio'];
		$anchosubtotal		= $row1['anchosubtotal'];
		$coddet				= $row1['coddet'];
	}
	}
	if ($codformato <> "")
	{
	$sql="SELECT codformato,descripcion,linea,columna,tipodoc,cuanto,titulo,descbrev,contitcampo FROM formato where sucursal = '$local' and codformato = '$codformato' and tipodoc = '$tipdocu'";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){	
	while ($row = mysqli_fetch_array($result)){
	$codformato  = $row['codformato'];	
	$descripcion = $row['descripcion'];	
	$linea		 = $row['linea'];	
	$columna	 = $row['columna'];	
	$tipodoc	 = $row['tipodoc'];	
	$cuanto		 = $row['cuanto'];	
	$titulo		 = $row['titulo'];
	$descbrev	 = $row['descbrev'];
	$contitcampo	 = $row['contitcampo'];
	}
	}	
	}
?>
<table width="100%" border="0" align="center" class="tabla2">
  <tr>
    <td width="731">
	<br>
	<b>DESCRIPCION : <?php echo $nomloc ;?></b>
	<br />
	<img src="../../../images/line2.png" width="100%" height="4" /><br />
	<br />
      <form id="form1" name="form1" onkeyup="highlight(event)" onclick="highlight(event)">
        <table width="100%" border="0" align="center">
          <tr>
            <td>NOMBRE</td>
            <td><input name="nom" type="text" id="nom" size="70" value="<?php echo $nombre?>" onkeyup="this.value = this.value.toUpperCase();"/></td>
          </tr>
          <tr>
            <td width="120">T&Iacute;TULOS DEL CUERPO </td>
            <td width="595">
              <select name="contit">
                <option value="1" <?php if ($contit == 1){?> selected="selected"<?php }?>>CON T&Iacute;TULOS</option>
                <option value="0" <?php if ($contit == 0){?> selected="selected"<?php }?>>SIN T&Iacute;TULOS</option>
              </select>
              <input name="local" type="hidden" id="local" value="<?php echo $local?>" />
              <input name="val" type="hidden" id="val" value="<?php echo $val?>" />
              <input name="tip" type="hidden" id="tip" value="<?php echo $tip?>" />
              <input name="tipdocu" type="hidden" id="tipdocu" value="<?php echo $tipdocu;?>" />
<input type="button" name="Submit2" value="Actualizar" onclick="validar()"/>			</td>
          </tr>
        </table>
	  </form>
	  <?php if ($tip == 1)
	  {
	  ?>
	  <br />
      <b>FORMATEADOR DE DOCUMENTOS</b>
	  - PIE DE PAGINA Y CABECERA <?php if ($error == 1){?><font color="#FF0000"> - ERROR AL INGRESAR DATOS, LINEAS Y COLUMNAS YA INGRESADAS</font><?php }?><br />
	  <img src="../../../images/line2.png" width="720" height="4" /><br />
	  <br />
	  <form id="form2" name="form2" onkeyup="highlight(event)" onclick="highlight(event)">
      <table width="100%" border="0" align="center">
        <tr>
          <td width="120">DESCRIPCION</td>
          <td width="595">
		  <select name="desc" id="desc">
              <?php 
					$sql = "SELECT codtab,destab FROM titultabladet where tiptab = 'TDOC' order by destab"; 
					$result = mysqli_query($conexion,$sql); 
					while ($row = mysqli_fetch_array($result)){ 
					?>
              <option value="<?php echo $row["codtab"];?>" <?php if ($descripcion == $row["codtab"]){ ?>selected="selected"<?php }?>><?php echo strtoupper($row["destab"]) ?></option>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td>DESC BREVE </td>
          <td><input name="dbrev" type="text" id="dbrev" value="<?php echo $descbrev?>" size="60" onKeyUp="this.value = this.value.toUpperCase();"/></td>
        </tr>
        <tr>
          <td>LINEA</td>
          <td>
            <input name="linea" type="text" id="linea" onkeypress="return acceptNum(event)" value="<?php echo $linea?>" maxlength="3"/></td>
        </tr>
        <tr>
          <td>COLUMNA</td>
          <td>
            <input name="col" type="text" id="col" onkeypress="return acceptNum(event)" value="<?php echo $columna?>" maxlength="3"/></td>
        </tr>
        <tr>
          <td>TIPO DOCUMENTO </td>
          <td><select name="doc" id="doc">
            <?php /*?><option value="1" <?php if ($tipodoc == 1){?>selected="selected"<?php }?>>FACTURA</option>
              <option value="2" <?php if ($tipodoc == 2){?>selected="selected"<?php }?>>BOLETA</option>
              <option value="3" <?php if ($tipodoc == 3){?>selected="selected"<?php }?>>GUIA REMISION</option>
              <option value="4" <?php if ($tipodoc == 4){?>selected="selected"<?php }?>>NOTA CREDITO</option><?php */?>
            <?php if ($tipdocu == 1)
			  {
			  ?>
            <option value="1" <?php if ($tipodoc == 1){?>selected="selected"<?php }?>>FACTURA</option>
            <?php }
			  if ($tipdocu == 2)
			  {
			  ?>
            <option value="2" <?php if ($tipodoc == 2){?>selected="selected"<?php }?>>BOLETA</option>
            <?php }
			  if ($tipdocu == 3)
			  {
			  ?>
            <option value="3" <?php if ($tipodoc == 3){?>selected="selected"<?php }?>>GUIA</option>
            <?php }
			if ($tipdocu == 4)
			  {
			  ?>
            <option value="4" <?php if ($tipodoc == 4){?>selected="selected"<?php }?>>TICKET</option>
            <?php }
			  ?>
          </select></td>
        </tr>
        <tr>
          <td>POSICI&Oacute;N</td>
          <td><select name="posicion" id="posicion">
              <option value="CB" <?php if ($titulo == "CB"){?>selected="selected"<?php }?>>CABECERA</option>
              <option value="PIE" <?php if ($titulo == "PIE"){?>selected="selected"<?php }?>>PIE</option>
            </select>          </td>
        </tr>
        <tr>
          <td>TITULO</td>
          <td><select name="titulo" id="titulo">
            <option value="1" <?php if ($contitcampo == 1){?> selected="selected"<?php }?>>CON T&Iacute;TULOS</option>
            <option value="0" <?php if ($contitcampo == 0){?> selected="selected"<?php }?>>SIN T&Iacute;TULOS</option>
          </select></td>
        </tr>
        <tr>
          <td>LONGITUD</td>
          <td>
            <input name="cuant" type="text" id="cuant" onkeypress="return acceptNum(event)" value="<?php echo $cuanto?>" maxlength="3"/>
            <input name="local" type="hidden" id="local" value="<?php echo $local?>" />
            <input name="val" type="hidden" id="val" value="<?php echo $val?>" />
            <input name="tip" type="hidden" id="tip" value="<?php echo $tip?>" />
            <input name="tipdocu" type="hidden" id="tipdocu" value="<?php echo $tipdocu;?>" />
            <input type="button" name="Submit" value="Actualizar" onclick="validar1()"/></td>
        </tr>
      </table>
      </form>
	  <?php }
	  if ($tip == 2)
	  {
	  ?>
      <b>FORMATEADOR DE DOCUMENTOS</b> - CONTENIDO DEL DOCUMENTO - N&ordm; M&Aacute;XIMO DE COLUMNAS = <strong>8</strong> <br />
      <img src="../../../images/line2.png" width="720" height="4" /><br />
      <br />
      <form id="form3" name="form3" onkeyup="highlight(event)" onclick="highlight(event)">
        <table width="100%" border="0" align="center">
          <tr>
            <td width="321">DISPOSITIVO</td>
            <td width="378" valign="middle">
			<input name="disp" type="text" id="disp" size="70" onKeyUp="this.value = this.value.toUpperCase();" value="<?php echo $fdisp?>"/>			</td>
          </tr>
          <tr>
            <td>NUMERO DE LINEAS DEL CUERPO DEL DOCUMENTO </td>
            <td valign="middle"><input name="lin1" type="text" id="lin1" onkeypress="return acceptNum(event)" value="<?php echo $flinpag?>" maxlength="2"/>			</td>
          </tr>
          <tr>
            <td>LINEA DE INICIO PARA IMPRESION EL CUERPO DEL DOCUMENTO </td>
            <td valign="middle"><input name="lin2" type="text" id="lin2" onkeypress="return acceptNum(event)" value="<?php echo $fini?>" maxlength="2"/>
&nbsp; 
            DEL 0 AL 8 </td>
          </tr>
          <tr>
            <td>COLUMNA DONDE SE IMPRIME CODIGO DE PRODUCTO</td>
            <td valign="middle"><input name="lin3" type="text" id="lin3" onkeypress="return acceptNum(event)" value="<?php echo $fcodpro?>" maxlength="1" onkeyup="det(3)"/> 
              &nbsp;DEL 1 AL 8             </td>
          </tr>
          <tr>
            <td>COLUMNA DONDE SE IMPRIME NOMBRE DE PRODUCTO</td>
            <td valign="middle"><input name="lin4" type="text" id="lin4" onkeypress="return acceptNum(event)" value="<?php echo $fnom?>" maxlength="1" onkeyup="det(4)"/>&nbsp;
DEL 1 AL 8 </td>
          </tr>
          <tr>
            <td>COLUMNA DONDE SE IMPRIME ABREV DE MARCA</td>
            <td valign="middle"><input name="lin5" type="text" id="lin5" onkeypress="return acceptNum(event)" value="<?php echo $fmarca?>" maxlength="1" onkeyup="det(5)"/>&nbsp;
DEL 1 AL 8 </td>
          </tr>
          <tr>
            <td>COLUMNA DONDE SE IMPRIME PRECIO REFERENCIAL </td>
            <td valign="middle"><input name="lin6" type="text" id="lin6" onkeypress="return acceptNum(event)" value="<?php echo $fref?>" maxlength="1" onkeyup="det(6)"/>&nbsp;
DEL 1 AL 8 </td>
          </tr>
          <tr>
            <td>COLUMNA DONDE SE IMPRIME EL DESCUENTO </td>
            <td valign="middle"><input name="lin7" type="text" id="lin7" onkeypress="return acceptNum(event)" value="<?php echo $fdescuento?>" maxlength="1" onkeyup="det(7)"/>&nbsp;
DEL 1 AL 8 </td>
          </tr>
          <tr>
            <td>COLUMNA DONDE SE IMPRIME CANTIDAD DE PRODUCTOS </td>
            <td valign="middle"><input name="lin8" type="text" id="lin8" onkeypress="return acceptNum(event)" value="<?php echo $fcanti?>" maxlength="1" onkeyup="det(8)"/>&nbsp;
DEL 1 AL 8 </td>
          </tr>
          <tr>
            <td>COLUMNA DONDE SE IMPRIME PRECIO DE VENTA</td>
            <td valign="middle"><input name="lin9" type="text" id="lin9" onkeypress="return acceptNum(event)" value="<?php echo $fpreuni?>" maxlength="1" onkeyup="det(9)"/>&nbsp;
DEL 1 AL 8 </td>
          </tr>
          <tr>
            <td>COLUMNA DONDE SE IMPRIME SUB TOTAL</td>
            <td valign="middle"><input name="lin10" type="text" id="lin10" onkeypress="return acceptNum(event)" value="<?php echo $fmonto?>" maxlength="1" onkeyup="det(10)"/>&nbsp;
               
              DEL 1 AL 8             
            </td>
          </tr>
        </table>
		<img src="../../../images/line2.png" width="100%" height="4" /><br />
		<table width="100%" border="0" align="center">
          <tr>
            <td width="321"><strong>ANCHO DE COLUMNAS </strong></td>
            <td width="378" valign="middle">&nbsp;</td>
          </tr>
          <tr>
            <td>ANCHO CODIGO DE PRODUCTO</td>
            <td valign="middle"><input name="anchocod" type="text" id="anchocod" onkeypress="return acceptNum(event)" value="<?php echo $anchocod?>" maxlength="3"/></td>
          </tr>
          <tr>
            <td>ANCHO NOMBRE DE PRODUCTO</td>
            <td valign="middle"><input name="anchonom" type="text" id="anchonom" onkeypress="return acceptNum(event)" value="<?php echo $anchonom?>" maxlength="3" />&nbsp;</td>
          </tr>
          <tr>
            <td>ANCHO ABREV DE MARCA</td>
            <td valign="middle"><input name="anchomarca" type="text" id="anchomarca" onkeypress="return acceptNum(event)" value="<?php echo $anchomarca?>" maxlength="3"/></td>
          </tr>
          <tr>
            <td>ANCHO  PRECIO REFERENCIAL </td>
            <td valign="middle"><input name="anchoreferencial" type="text" id="anchoreferencial" onkeypress="return acceptNum(event)" value="<?php echo $anchoreferencial?>" maxlength="3"/>&nbsp;</td>
          </tr>
          <tr>
            <td>ANCHO  DESCUENTO </td>
            <td valign="middle"><input name="anchodescuento" type="text" id="anchodescuento" onkeypress="return acceptNum(event)" value="<?php echo $anchodescuento?>" maxlength="3"/>&nbsp;</td>
          </tr>
          <tr>
            <td>ANCHO CANTIDAD DE PRODUCTOS </td>
            <td valign="middle"><input name="anchocantidad" type="text" id="anchocantidad" onkeypress="return acceptNum(event)" value="<?php echo $anchocantidad?>" maxlength="3" />&nbsp;</td>
          </tr>
          <tr>
            <td>ANCHO  PRECIO DE VENTA</td>
            <td valign="middle"><input name="anchoprecio" type="text" id="anchoprecio" onkeypress="return acceptNum(event)" value="<?php echo $anchoprecio?>" maxlength="3" />&nbsp;</td>
          </tr>
          <tr>
            <td>ANCHO SUB TOTAL</td>
            <td valign="middle"><input name="anchosubtotal" type="text" id="anchosubtotal" onkeypress="return acceptNum(event)" value="<?php echo $anchosubtotal?>" maxlength="3"/>&nbsp;             
              <input name="local" type="hidden" id="local" value="<?php echo $local?>" />
              <input name="val" type="hidden" id="val" value="<?php echo $val?>" />
              <input name="tip" type="hidden" id="tip" value="<?php echo $tip?>" />
              <input name="tipdocu" type="hidden" id="tipdocu" value="<?php echo $tipdocu;?>" />
              <input name="btt" type="button" id="btt" onclick="validar2()" value="Actualizar"/></td>
          </tr>
        </table>
    </form>
	
	<?php }
	?>
	
	<?php if ($tip == 1)
	{
	?>
	<iframe src="local5.php?tip=<?php echo $tip?>&tipdocu=<?php echo $tipdocu;?>&local=<?php echo $local?>" name="iFrame1" width="730" height="150" scrolling="Automatic" frameborder="No" id="main1" allowtransparency="True"></iframe>
	<?php }
	?>
	</td>
  </tr>
</table>
<?php }
?>
</body>
</html>
