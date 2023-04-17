<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../archivo/css/css/style.css" rel="stylesheet" type="text/css" />
<link href="../../archivo/css/css/tablas.css" rel="stylesheet" type="text/css" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<link href="../../../css/calendar/calendar.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../funciones/js/mootools.js"></script>
<script type="text/javascript" src="../../../funciones/js/calendar.js"></script>
<script type="text/javascript">
    window.addEvent('domready', function() 
	{ 
	myCal = new Calendar({ date1: 'Y-m-d' });
	myCal = new Calendar({ date2: 'Y-m-d' }); 
	
myCal3 = new Calendar({ date3: 'd/m/Y' }, { classes: ['i-heart-ny'], direction: 1 }); 
	}
	)
	;
</script>
<style>
 a:link,
 a:visited {
 color: #0066CC;
 border: 0px solid #e7e7e7;
 }
 a:hover {
 background: #fff;
 border: 0px solid #ccc;
 }
 a:focus {
 background-color: #FFFF99;
 color: #0066CC;
 border: 0px solid #ccc;
 }
 a:active {
 background-color: #FFFF99;
 color: #0066CC;
 border: 0px solid #ccc;
 } 
</style>
<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS?>
<?php require_once("../../../funciones/calendar.php");?>
<?php require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS?>
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
$sql="SELECT utldmin FROM datagen_det";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$utldmin    = $row['utldmin'];
}
}
$val = $_REQUEST['val'];
$p1  = $_REQUEST['p1'];
if ($val == "")
{
$val = 3;
}
////////////////////////////
$registros = 40;
$pagina = $_REQUEST["pagina"];
if (!$pagina) {
$inicio = 0;
$pagina = 1;
}
else 
{
$inicio = ($pagina - 1) * $registros;
} 
////////////////////////////
if ($val == 1)
{
$sql="SELECT codpro FROM producto where desprod like '$p1%'";
}
else
{
$sql="SELECT codpro FROM producto";
}
$sql			 = mysqli_query($conexion,$sql);
$total_registros = mysqli_num_rows($sql);
$total_paginas   = ceil($total_registros/$registros); 
////////////////////////////
?>
<script language="JavaScript">
function sf(){
var f = document.form1;
document.form1.p1.focus();
}
var nav4 = window.Event ? true : false;
function enter(evt){
// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
var key = nav4 ? evt.which : evt.keyCode;
	if (key == 13)
	{
	document.form1.submit();
	}
}
function validar()
{
	var f = document.form1;
	if (f.p1.value == "")
	 { alert("Ingrese la descripcion para Iniciar la B�squeda"); f.p1.focus(); return; }
	 f.method = "post";
	 f.submit();
}
function limpia()
{
	var f = document.form1;
	 f.method = "post";
	 f.target = "_self";
	 f.action = "limpia_kardex.php";
	 f.submit();
}
function corregir()
{
	var f = document.form1;
	 f.method = "post";
	 f.target = "_self";
	 if (f.date1.value == "")
	 { alert("Ingrese una Fecha"); f.date1.focus(); return; }
	 f.action = "arregla_kardex.php";
	 f.submit();
}
function salir()
{
	 var f = document.form1;
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="../../index.php";
	 f.submit();
}
</script>
<style type="text/css">
<!--
.Estilo1 {color: #0B55C4}
-->
</style>
</head>
<body <?php if ($val <> 1){?>onload="sf();"<?php }?>>
 <table width="954" border="0">
    <tr>
      <td>
	  <b><u>CORRECCI&Oacute;N  DE STOCK DE ART&Iacute;CULOS </u></b>
	  <form id="form1" name="form1" method = "post">
        <table width="927" border="0">
          <tr>
            <td width="76">PRODUCTO</td>
            <td width="363">
			<input name="p1" type="text" id="p1" size="50" value="<?php echo $p1?>" onkeypress="enter(event)"/></td>
			<td width="241"><input name="val" type="hidden" id="val" value="1" />
              <input type="button" name="Submit" value="Buscar" onclick="validar()" class="buscar"/>
              <input type="button" name="Submit32" value="Salir" onclick="salir()" class="salir"/>		    </td>
			<td width="229"><div align="right"><span class="blues Estilo1"><strong>LOCAL:</strong> <?php echo $nombre_local?></span></div></td>
          </tr>
        </table>
        <table width="927" border="0">
          <tr>
            <td width="76">FECHA INICIAL </td>
            <td width="363"><input type="text" name="date1" id="date1" size="12">
              <select name="local" id="local">
                <?php 
				$sql = "SELECT codloc,nomloc,nombre FROM xcompa order by codloc"; 
				$result = mysqli_query($conexion,$sql); 
				while ($row = mysqli_fetch_array($result)){ 
				$loc	= $row["codloc"];
				$nloc	= $row["nomloc"];
				$nombre	= $row["nombre"];
				if ($nombre == '')
				{
				$locals = $nloc;
				}
				else
				{
				$locals = $nombre;
				}
				?>
                <option value="<?php echo $row["codloc"]?>" <?php if ($loc == $local){?> selected="selected"<?php }?>><?php echo $locals; ?></option>
                <?php } ?>
              </select>
              <input type="button" name="Submit2" value="Limpiar Stocks" onclick="limpia()" class="buscar"/>
            <input type="button" name="Submit22" value="Corregir" onclick="corregir()" class="buscar"/></td>
            <td width="241">&nbsp;</td>
            <td width="229"><div align="right"><span class="blues Estilo1"><strong>LOCAL:</strong> <?php echo $nombre_local?></span></div></td>
          </tr>
        </table>
        <div align="left"><img src="../../../images/line2.png" width="940" height="4" /></div>
        <table width="928" border="0">
          <tr>
            <td width="23"><div align="left">
              <?php if(($pagina - 1) > 0) 
			  {
			  ?>
              <a href="master1.php?p1=<?php echo $p1?>&val=<?php echo $val?>&inicio=<?php echo $inicio?>&registros=<?php echo $registros?>&pagina=<?php echo $pagina-1?>"><img src="../../../images/play1.gif" width="16" height="16" border="0"/> </a>
              <?php }
			  ?>
            </div></td>
			<td width="662"><div align="left">
			  <?php if(($pagina + 1)<=$total_paginas) 
			  {
			  ?>
              <a href="master1.php?p1=<?php echo $p1?>&val=<?php echo $val?>&inicio=<?php echo $inicio?>&registros=<?php echo $registros?>&pagina=<?php echo $pagina+1?>"> <img src="../../../images/play.gif" width="16" height="16" border="0"/> </a>
              <?php }
			  ?>
			</div></td>
            <td width="229"><div align="right"><span class="blues Estilo1"><b>USUARIO:</b> <?php echo $user?></span></div></td>
          </tr>
        </table>
        <div align="left"><img src="../../../images/line2.png" width="940" height="4" /></div>
        <div align="left"></div>
	    </form>
      </td>
    </tr>
  </table>
  <br>
  <iframe src="master2.php?p1=<?php echo $p1?>&val=<?php echo $val?>&inicio=<?php echo $inicio?>&registros=<?php echo $registros?>&pagina=<?php echo $pagina?>&tot_pag=<?php echo $total_paginas?>" name="marco" id="marco" width="954" height="490" scrolling="Automatic" frameborder="0" allowtransparency="0">
  </iframe>
</body>
</html>
