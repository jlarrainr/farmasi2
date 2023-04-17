<?php include('../../session_user.php');
$remesa   	  = $_SESSION['remesa'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
require_once("../../local.php");	//LOCAL DEL USUARIO
/////////////////////////////////////////////////////////////////////////////////////////////////
$sql="SELECT invnum,codusu,fecha,numremesa,turno FROM remesa where codusu = '$usuario' and estado ='1'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$invnum    = $row['invnum'];
	$codusu    = $row['codusu'];
	$date      = $row['fecha'];
	$numremesa = $row['numremesa'];
	$turno     = $row['turno'];
}
}
$_SESSION['remesa']			= $invnum; 
$sql1="SELECT nomusu FROM usuario where usecod = '$usuario'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
	$user    = $row1['nomusu'];
}
}
$sql1="SELECT dolar FROM datagen";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
	$dolar    = $row1['dolar'];
}
}
$date = date("Y-m-d");
//$hour   = date(G);
//$date	= CalculaFechaHora($hour);
//////NUMERO DE VENTAS INICIAL Y FINAL
$sql1="SELECT nrovent FROM venta where invfec = '$fecha' order by nrovent asc limit 1";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
	$ventinic    = $row1['nrovent'];
}
}
else
{
$ventinic = 0;
}
$sql1="SELECT nrovent FROM venta where invfec = '$fecha' order by nrovent desc limit 1";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
	$ventfin     = $row1['nrovent'];
}
}
else
{
$ventfin = 0;
}
//////NUMERO DE COBRANZAS INICIAL Y FINAL
//////VENTAS EN EFECTIVO
$sql1="SELECT sum(invtot) FROM venta where nrovent like '$ventinic' and '$ventfin' and forpag = 'E'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
	$sumefectivo     = $row1[0];
}
}
if ($sumefectivo == "")
{
$sumefectivo = 0;
}
//////VENTAS AL CREDITO
$sql1="SELECT sum(invtot) FROM venta where nrovent like '$ventinic' and '$ventfin' and forpag = 'C'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
	$sumcredito     = $row1[0];
}
}
if ($sumcredito == "")
{
$sumcredito = 0;
}
//////VENTAS CON TARJETA
$sql1="SELECT sum(invtot) FROM venta where nrovent like '$ventinic' and '$ventfin' and forpag = 'T'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
	$sumtarjeta     = $row1[0];
}
}
if ($sumtarjeta == "")
{
$sumtarjeta = 0;
}
///////COBRANZAS REALIZADAS

////TOTAL EFECTIVO Y COBRANZAS
$tot_efect = $sumefectivo;
//////INGRESOS EN SOLES
$sql1="SELECT sum(monto) FROM gasres where invnum = '$remesa' and tiptab = 'I' and moneda = 'S'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
	$sumingresosoles     = $row1[0];
}
}
if ($sumingresosoles == "")
{
$sumingresosoles = 0;
}
//////INGRESOS EN DOLARES
$sql1="SELECT sum(monto) FROM gasres where invnum = '$remesa' and tiptab = 'I' and moneda = 'D'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
	$sumingresodolar     = $row1[0];
}
}
if ($sumingresodolar == "")
{
$sumingresodolar = 0;
}
//////GASTOS EN SOLES
$sql1="SELECT sum(monto) FROM gasres where invnum = '$remesa' and tiptab = 'G' and moneda = 'S'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
	$sumgastosoles     = $row1[0];
}
}
if ($sumgastosoles == "")
{
$sumgastosoles = 0;
}
//////GASTOS EN DOLARES
$sql1="SELECT sum(monto) FROM gasres where invnum = '$remesa' and tiptab = 'G' and moneda = 'D'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
	$sumgastodolar     = $row1[0];
}
}
if ($sumgastodolar == "")
{
$sumgastodolar = 0;
}
/////EFECTIVO EN SOLES
$efectivo_sol = $tot_efect + $sumingresosoles - $sumgastosoles;
$efectivo_dol = $sumingresodolar - $sumgastodolar;
function formato($c) {
printf("%08d",  $c);
} 
function formato1($c) {
printf("%04d",  $c);
} 
function redondear_dos_decimal($valor) {
$float_redondeado=round($valor * 100) / 100;
return $float_redondeado;
}
?>
<script>
function salir1()
{
	 var f = document.form1;
	 f.method = "POST";
	 f.target = "_top";
	 //f.action ="../../index.php";
	 f.action = "remesas_exit.php";
	 f.submit();
}
function grabar1()
{
	 var f = document.form1;
	 if (f.turno.value == "")
	 {
	 alert("Ingrese el Turno de la Operacion"); f.turno.focus(); return;
	 }
	 f.method = "post";
	 f.target = "_top";
	 //f.action ="../../index.php";
	 f.action = "remesas_grabar.php";
	 f.submit();
}
function sf()
{
	 var f = document.form1;
	 f.turno.focus();
}
var nav4 = window.Event ? true : false;
function turn(evt){
// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
var key = nav4 ? evt.which : evt.keyCode;
//alert(key);8 49 50 51 52 53
if (key == 13)
{
	var f = document.form1;
	var t = f.turno.value;
	if ((t == 1) || (t == 2) || (t == 3) || (t == 4) || (t == 5))
	{
	f.method = "post";
	f.action = "remesas_upd.php";
	f.submit();
	}
	else
	{
	return (key == 8 || key == 13 || (key > 48 && key <= 53));
	}
}
else
{
return (key == 8 || key == 13 || (key > 48 && key <= 53));
}
}
function ventana(e) {
tecla=e.keyCode
  if (tecla == 117)
  {
    window.open('f6.php','PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=160,left=120,width=705,height=280');
  }
  if (tecla == 118)
  {
    window.open('f7.php','PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=160,left=120,width=705,height=280');
  }
  if (tecla == 119)
  {
    window.open('f8.php','PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=160,left=120,width=705,height=280');
  }
}
</script>
<style type="text/css">
<!--
.Estilo1 {font-size: 10px}
.Estilo5 {color: #990000}
-->
</style>
</head>
<body onload="sf();" onkeyup="ventana(event)">
<form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
  <table width="100%" border="0">
    <tr>
      <td width="692"><span class="text_combo_select"><strong>LOCAL: </strong><?php echo $desc_local?></span></td>
      <td width="252"><div align="right"><span class="text_combo_select"><strong>USUARIO :</strong> 
	  <img src="../../../images/user.gif" width="15" height="16" /> <?php echo $user?></span></div></td>
    </tr>
    <tr>
      <td><span class="text_combo_select"><strong>REMESA N&ordm;</strong> <?php echo formato($numremesa);?></span> </td>
      <td><div align="right"><span class="text_combo_select"><strong>LOCAL:</strong> <?php echo $nombre_local?></span></div></td>
    </tr>
  </table>
<table width="100%" border="0" class="tabla2">
  <tr>
    <td><table width="100%" border="0" align="center">
      <tr>
        <td width="153"><span class="text_combo_select Estilo1"><strong>TURNO</strong></span></td>
        <td width="137"><input name="turno" type="text" id="turno" onkeypress="return turn(event);" value="<?php echo $turno;?>"/></td>
        <td width="607">
		<div align="right"><span class="Estilo5"><u>DIGITAR TURNO DEL CIERRE DE CAJA: (1 = MA&Ntilde;ANA) (2 = TARDE) (3 = NOCHE) (4 = AMANECIDA) (5 = ESPECIAL)</u></span></div>
		</td>
      </tr>
    </table>
    <table width="100%" border="0" align="center">
      <tr>
        <td width="153"><span class="text_combo_select Estilo1"><strong>CAJERO</strong></span></td>
        <td width="748">
          <input type="text" name="textfield2" disabled="disabled" value="<?php echo formato1($usuario);?>"/>
          <input name="cajero" type="hidden" id="cajero" value="<?php echo $usuario?>"/>        </td>
      </tr>
      <tr>
        <td bgcolor="#FFFFCC"><span class="text_combo_select Estilo1"><strong>INICIO DE VENTAS </strong></span></td>
        <td bgcolor="#FFFFCC">
          <input type="text" name="textfield3" disabled="disabled" value="<?php echo $ventinic?>"/>
          <input name="ventinic" type="hidden" id="ventinic" value="<?php echo $ventinic?>"/>        </td>
      </tr>
      <tr>
        <td bgcolor="#FFFFCC"><span class="text_combo_select Estilo1"><strong>FIN DE VENTAS </strong></span></td>
        <td bgcolor="#FFFFCC">
          <input type="text" name="textfield4" disabled="disabled" value="<?php echo $ventfin?>"/>
          <input name="ventfin" type="hidden" id="ventfin" value="<?php echo $ventfin?>"/>        </td>
      </tr>
      <tr>
        <td bgcolor="#CCFFCC"><span class="text_combo_select Estilo1"><strong>BOLETA INICIAL </strong></span></td>
        <td bgcolor="#CCFFCC">
          <input type="text" name="textfield3" disabled="disabled" value="<?php echo $ventinic?>"/>
          <input name="bolini" type="hidden" id="bolini" value="<?php echo $ventinic?>"/>        </td>
      </tr>
      <tr>
        <td bgcolor="#CCFFCC"><span class="text_combo_select Estilo1"><strong>BOLETA FINAL </strong></span></td>
        <td bgcolor="#CCFFCC">
          <input type="text" name="textfield4" disabled="disabled" value="<?php echo $ventfin?>"/>
          <input name="bolfin" type="hidden" id="bolfin" value="<?php echo $ventfin?>"/>        </td>
      </tr>
      <tr>
        <td bgcolor="#FFCCCC"><span class="text_combo_select Estilo1"><strong>FACTURA INICIAL </strong></span></td>
        <td bgcolor="#FFCCCC">
          <input type="text" name="textfield3" disabled="disabled" value="<?php echo $ventinic?>"/>
          <input name="facini" type="hidden" id="facini" value="<?php echo $ventinic?>"/>        </td>
      </tr>
      <tr>
        <td bgcolor="#FFCCCC"><span class="text_combo_select Estilo1"><strong>FACTURA FINAL </strong></span></td>
        <td bgcolor="#FFCCCC">
          <input type="text" name="textfield4" disabled="disabled" value="<?php echo $ventfin?>"/>
          <input name="facfin" type="hidden" id="facfin" value="<?php echo $ventfin?>"/>        </td>
      </tr>
      <tr>
        <td bgcolor="#CCFF99"><span class="text_combo_select Estilo1"><strong>INICIO COBRANZAS </strong></span></td>
        <td bgcolor="#CCFF99">
          <input type="text" name="textfield6" disabled="disabled"/>
          <input name="cobrainic" type="hidden" id="cobrainic" />        </td>
      </tr>
      <tr>
        <td bgcolor="#CCFF99"><span class="text_combo_select Estilo1"><strong>FIN COBRANZAS </strong></span></td>
        <td bgcolor="#CCFF99"><input type="text" name="textfield7" disabled="disabled"/>
            <input name="cobrafin" type="hidden" id="cobrafin" />
        </td>
      </tr>
      <tr>
        <td><span class="text_combo_select Estilo1"><strong>FECHA</strong></span></td>
        <td><input type="text" name="textfield5" disabled="disabled" value="<?php echo date('d-m-Y');?>"/>        </td>
      </tr>
    </table>
      <table width="100%" border="0" align="center">
        <tr>
          <td width="153"><span class="text_combo_select Estilo1"><strong>EFECTIVO VENTAS </strong></span></td>
          <td width="160">
            <input type="text" name="textfield8" value="<?php echo $sumefectivo;?>" disabled="disabled"/>
            <input name="ventefect" type="hidden" id="ventefect" value="<?php echo $sumefectivo;?>"/>
          </td>
          <td width="76"><span class="text_combo_select Estilo1"><strong>PLANILLAS</strong></span></td>
          <td width="184">
            <input type="text" name="textfield10" value="<?php ?>" disabled="disabled"/>
            <input name="planilla" type="hidden" id="planilla" />
          </td>
          <td width="69"><span class="text_combo_select Estilo1"><strong>TOTAL</strong></span></td>
          <td width="243">
            <input type="text" name="textfield12" value="<?php echo $tot_efect?>" disabled="disabled"/>
            <input name="total" type="hidden" id="total" value="<?php echo $tot_efect?>"/>
          </td>
        </tr>
        <tr>
          <td><span class="text_combo_select Estilo1"><strong>CREDITOS</strong></span></td>
          <td>
            <input type="text" name="textfield9" value="<?php echo $sumcredito;?>" disabled="disabled"/>
            <input name="creditos" type="hidden" id="creditos" value="<?php echo $sumcredito;?>"/>          
		  </td>
          <td><span class="text_combo_select Estilo1"><strong>CHEQUE</strong></span></td>
          <td>
            <input type="text" name="textfield11" disabled="disabled"/>
            <input name="cheque" type="hidden" id="cheque" />
          </td>
          <td><span class="text_combo_select Estilo1"><strong>TARJETAS</strong></span></td>
          <td>
            <input type="text" name="textfield13" value="<?php echo $sumtarjeta;?>" disabled="disabled"/>
            <input name="tarjetas" type="hidden" id="tarjetas" value="<?php echo $sumtarjeta;?>"/>
          </td>
        </tr>
      </table>
      <table width="100%" border="0" align="center" bgcolor="#FFFF00">
        <tr>
          <td width="153" height="20"><span class="text_combo_select Estilo1"><strong>OTROS INGRESOS </strong></span></td>
          <td width="748">
            <input type="submit" name="Submit2" value="F6" disabled="disabled"/>
          </td>
        </tr>
      </table>
      <table width="100%" border="0" align="center">
        <tr>
          <td width="153"><span class="text_combo_select Estilo1"><strong>TOTAL DE INGRESOS </strong></span></td>
          <td width="160">
		  <span class="text_combo_select Estilo1"><strong>S/.</strong></span>
            <input type="text" name="textfield14" disabled="disabled" value="<?php echo $sumingresosoles?>"/>
            <input name="totingsol" type="hidden" id="totingsol" value="<?php echo $sumingresosoles?>"/>
          </td>
          <td width="76"><div align="right"><span class="text_combo_select Estilo1"><strong>$/</strong></span></div></td>
          <td width="504">
            <input type="text" name="textfield15" disabled="disabled" value="<?php echo $sumingresodolar?>"/>
            <input name="totingdol" type="hidden" id="totingdol" value="<?php echo $sumingresodolar?>"/>
          </td>
          </tr>
      </table>
      <table width="100%" border="0" align="center" bgcolor="#FFFF00">
        <tr>
          <td width="153" height="20"><span class="text_combo_select Estilo1"><strong>GASTOS</strong></span></td>
          <td width="748"><input type="submit" name="Submit22" value="F7" disabled="disabled"/></td>
        </tr>
      </table>
      <table width="100%" border="0" align="center">
        <tr>
          <td width="153"><span class="text_combo_select Estilo1"><strong>TOTAL DE GASTOS </strong></span></td>
          <td width="160">
		  <span class="text_combo_select Estilo1"><strong>S/.</strong></span>
            <input type="text" name="textfield16" disabled="disabled" value="<?php echo $sumgastosoles?>"/>
            <input name="totgastsol" type="hidden" id="totgastsol" value="<?php echo $sumgastosoles?>"/>          </td>
          <td width="76"><div align="right"><span class="text_combo_select Estilo1"><strong>$/</strong></span></div></td>
          <td width="504">
            <input type="text" name="textfield17" disabled="disabled" value="<?php echo $sumgastodolar;?>"/>
            <input name="ttgastdol" type="hidden" id="ttgastdol" value="<?php echo $sumgastodolar;?>"/>          </td>
        </tr>
        <tr>
          <td bgcolor="#FFFF99"><span class="text_combo_select Estilo1"><strong>CAMBIO DE DOLAR </strong></span></td>
          <td bgcolor="#FFFF99">
		  <span class="text_combo_select Estilo1"><strong>S/.</strong></span>
            <input type="text" name="textfield18" disabled="disabled" value="<?php echo $dolar?>"/>
            <input name="dolar" type="hidden" id="dolar" value="<?php echo $dolar?>"/>          </td>
          <td bgcolor="#FFFFFF"><div align="right"></div></td>
          <td bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
        <tr>
          <td><span class="text_combo_select Estilo1"><strong>TOTAL EFECTIVO </strong></span></td>
          <td>
		  <span class="text_combo_select Estilo1"><strong>S/.</strong></span>
            <input type="text" name="textfield19" disabled="disabled" value="<?php echo $efectivo_sol?>"/>
            <input name="totefectsol" type="hidden" id="totefectsol" value="<?php echo $efectivo_sol?>"/>          </td>
          <td><div align="right"><span class="text_combo_select Estilo1"><strong>$/</strong></span></div></td>
          <td>
            <input type="text" name="textfield20" disabled="disabled" value="<?php echo $efectivo_dol?>"/>
            <input name="totefectdol" type="hidden" id="totefectdol" value="<?php echo $efectivo_dol?>"/>          </td>
        </tr>
      </table>
      <table width="100%" border="0" align="center" bgcolor="#FFFF00">
        <tr>
          <td width="153" height="20"><span class="text_combo_select Estilo1"><strong>DEPOSITOS</strong></span></td>
          <td width="748"><input type="submit" name="Submit23" value="F8" disabled="disabled"/></td>
        </tr>
      </table>
      <table width="100%" border="0" align="center">

        <tr>
          <td width="153"><span class="text_combo_select Estilo1"><strong>DEPOSITOS </strong></span></td>
          <td width="160"><span class="text_combo_select Estilo1"><strong>S/.</strong></span>
              <input type="text" name="textfield212" disabled="disabled" value="<?php echo $efectivo_sol?>"/>
              <input name="depsoles" type="hidden" id="depsoles" value="<?php echo $efectivo_sol?>"/>          </td>
          <td width="76"><div align="right"><span class="text_combo_select Estilo1"><strong>$/</strong></span></div></td>
          <td width="504"><input type="text" name="textfield232" disabled="disabled" value="<?php echo $efectivo_dol?>"/>
              <input name="depdolar" type="hidden" id="depdolar" value="<?php echo $efectivo_dol?>"/>          </td>
        </tr>
        <tr>
          <td><span class="text_combo_select Estilo1"><strong>ENTREGAS </strong></span></td>
          <td><span class="text_combo_select Estilo1"><strong>S/.</strong></span>
              <input type="text" name="textfield222" disabled="disabled"/>
              <input name="entregassol" type="hidden" id="entregassol" />          </td>
          <td><div align="right"><span class="text_combo_select Estilo1"><strong>$/</strong></span></div></td>
          <td><input type="text" name="textfield242" disabled="disabled"/>
              <input name="entregasdol" type="hidden" id="entregasdol" />          </td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="100%" border="0" class="tabla2">
  <tr>
    <td><table width="100%" border="0" align="center">
        <tr>
          <td width="302">&nbsp;</td>
          <td width="116">&nbsp;</td>
          <td width="500">
              <div align="right">
                <input name="printer" type="button" id="printer" value="Imprimir" class="imprimir" onclick="imprimir()"/>
                <input name="nuevo" type="button" id="nuevo" value="Nuevo" class="nuevo" disabled="disabled"/>
                <input name="modif" type="button" id="modif" value="Modificar" class="modificar" disabled="disabled"/>
                <input name="save" type="button" id="save" value="Grabar" onclick="grabar1()" class="grabar"/>
                <input type="submit" name="Submit" value="Salir" onclick="salir1();" class="salir"/>
              </div>
            </td>
        </tr>
      </table></td>
  </tr>
</table>
</form>
</body>
</html>
