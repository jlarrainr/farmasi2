<?php include('../../session_user.php');
$total_paginas = 0;
$pagina        = 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href=".style.css" rel="stylesheet" type="text/css" />
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<link href="../../../css/calendar/calendar.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="../../../funciones/js/mootools.js"></script>
<script type="text/javascript" src="../../../funciones/js/calendar.js"></script>





<script type="text/javascript">
    window.addEvent('domready', function() { myCal = new Calendar({ date1: 'd/m/Y' }); myCal = new Calendar({ date2: 'd/m/Y' }); });
</script>
<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS?>
<?php require_once('../../../convertfecha.php');	//CONEXION A BASE DE DATOS?>
<?php require_once("../../../funciones/calendar.php");?>
<?php require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS?>
<?php require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES?>
<?php require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES?>
<?php require_once("../local.php");	//OBTENGO EL NOMBRE Y CODIGO DEL LOCAL?>
<script language="JavaScript">
function buscar()
{
	  var f = document.form1;
	  var tip = document.form1.report.value;
	  if (tip ==1)
	  {
	  f.action = "venxma1.php";
	  }
	  else
	  {
	  f.action = "venxma_prog.php";
	  }
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
function selected()
{
	 var f = document.form1;
	 var l = document.form1.local.value;
	 if (l == "LOCAL0")
	 {
	 document.form1.local1.disabled = false;
	 }
	 else
	 {
	 document.form1.local1.disabled = true;
	 }
}
function sf()
{
	 var f = document.form1;
	 document.form1.local1.disabled = true;
}
function printer()
{
window.marco.print();
}
</script>
</head>
<?php $date  = date('d/m/Y');
$val   = isset($_REQUEST['val'])? ($_REQUEST['val']) : "";
$date1 = isset($_REQUEST['date1'])? ($_REQUEST['date1']) : "";
$date2 = isset($_REQUEST['date2'])? ($_REQUEST['date2']) : "";
$local = isset($_REQUEST['local'])? ($_REQUEST['local']) : "";
$marca = isset($_REQUEST['marca'])? ($_REQUEST['marca']) : "";
$det   = isset($_REQUEST['det'])? ($_REQUEST['det']) : "";
$doc   = isset($_REQUEST['doc']) ? ($_REQUEST['doc']) : "";
$ven   = isset($_REQUEST['ven']) ? ($_REQUEST['ven']) : "";
$doc  = $_REQUEST['doc'];

$sql="SELECT export FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$export    = $row['export'];
}
}
/////////////////////////////////
$registros = 3;
$pagina = isset($_REQUEST['pagina'])? ($_REQUEST['pagina']) : "";
if (!$pagina) {
$inicio = 0;
$pagina = 1;
}
else 
{
$inicio = ($pagina - 1) * $registros;
} 
/////////////////////////////////
$sql="SELECT ltdgen FROM titultabla where dsgen = 'MARCA'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$ltdgen    = $row['ltdgen'];
}
}
$sql="SELECT destab FROM titultabladet where tiptab = '$ltdgen' order by destab asc limit 1";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$marca1    = $row['destab'];
}
}
$sql="SELECT destab FROM titultabladet where tiptab = '$ltdgen' order by destab desc limit 1";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$marca2    = $row['destab'];
}
}
?>
<body>
<link rel='STYLESHEET' type='text/css' href='../../css/calendar.css'>
 <table width="954" border="0">
    <tr>
      <td><b><u>REPORTE POR  LABORATORIO EN UNIDADES DE PRODUCTO </u></b>
        <form id="form1" name="form1" method = "post" action="">
          <table width="927" border="0">
            <tr>
              <td width="3">SALIDA</td>
              <td width="80"><label>
                <select name="report" id="report">
                  <option value="1">POR PANTALLA</option>
                  <?php if ($export == 1){?>
                  <option value="2">EN ARCHIVO XLS</option>
				  <?php }?>
                </select>
              </label></td>
              <td width="210"><div align="right"></div></td>
              <!--<td width="269">
			  <select name="local" id="local" onchange="selected()">
                <?php if ($nombre_local == 'LOCAL0'){?>
				<option value="all" <?php if ($local == 'all'){?> selected="selected"<?php }?>>TODOS LOS LOCALES</option>
				<?php }?>
                <?php 
				if ($nombre_local == 'LOCAL0')
				{
				$sql = "SELECT * FROM xcompa order by codloc"; 
				}
				else
				{
				$sql = "SELECT * FROM xcompa where codloc = '$codigo_local'"; 
				}
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
                <option value="<?php echo $row["codloc"]; ?>" <?php if ($loc == $local){?> selected="selected"<?php }?>><?php echo $locals ?></option>
                <?php } ?>
              </select>
              </td>-->
              
          

             <td width="120"></td>
         
            </tr>
          </table>
            
            <table width="927" border="0">
                <tr>
                              	 <td width="60">POR FROMATO</td>
            <td width="150">
              <select name="ven" id="ven">
                <!--<option value="3" <?php if ($ven == 3){?> selected="selected"<?php }?>>SELECIONAR TODOS</option>-->
                <option value="1" <?php if ($ven == 1){?> selected="selected"<?php }?>>POR VENDEDOR</option>
                <option value="2" <?php if ($ven == 2){?> selected="selected"<?php }?>>POR LOCAL</option>
                
                
              </select>            
            </td>
               	 <td width="60">T. VENTAS</td>
            <td width="200">
              <select name="doc" id="doc">
                <!--<option value="3" <?php if ($doc == 3){?> selected="selected"<?php }?>>SELECIONAR TODOS</option>-->
                <option value="1" <?php if ($doc == 1){?> selected="selected"<?php }?>>POR UNIDADES VENDIDAS</option>
                <option value="2" <?php if ($doc == 2){?> selected="selected"<?php }?>>POR SOLES VENDIDOS</option>
                
                
              </select>            
            </td>
              
           <td width="269">
			  <select name="local" id="local" onchange="selected()"  >
                <?php if ($nombre_local == 'LOCAL0'){?>
				<option value="all" <?php if ($local == 'all'){?> selected="selected"<?php }?>>TODOS LOS LOCALES</option>
				<?php }?>
                <?php 
				if ($nombre_local == 'LOCAL0')
				{
				$sql = "SELECT * FROM xcompa order by codloc"; 
				}
				else
				{
				$sql = "SELECT * FROM xcompa where codloc = '$codigo_local'"; 
				}
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
                <option value="<?php echo $row["codloc"]; ?>" <?php if ($loc == $local){?> selected="selected"<?php }?>><?php echo $locals ?></option>
                <?php } ?>
              </select>
              </td>
                 
               
            <td width="100">&nbsp;</td>
            <td width="70">&nbsp;</td>
             
                </tr>
            </table>
<!--          <table width="929" border="0">
            <tr>
              <td width="77">MARCA DESDE</td>
              <td width="137"><?php echo $marca1?></td>
             
              <td width="113">DETALLADA/RESUMIDA</td>
              <td width="133"><label>
                <select name="det" id="det">
                  <option value="1" <?php if ($det == 1){?> selected="selected"<?php }?>>DETALLADA</option>
                  <option value="2" <?php if ($det == 2){?> selected="selected"<?php }?>>RESUMIDA</option>
                </select>
              </label></td>
            </tr>
          </table>-->
          <table width="929" border="0">
            <tr>
<!--              <td width="77">HASTA</td>
              <td width="137"><?php echo $marca2?></td>-->
              <td width="94">PERIODO DESDE </td>
              <td width="120"><input type="text" name="date1" id="date1" size="12" value="<?php if ($date1 == ""){ echo $date;} else{ echo $date1;}?>" /></td>
              
                <td width="20">HASTA</td>
              <td width="97"><input type="text" name="date2" id="date2" size="12" value="<?php if ($date2 == ""){ echo $date;} else {echo $date2;}?>" /></td>
              
              <td width="73"><div align="right">MARCA</div></td>
                <td width="153">
                    <select name="marca" id="marca">
                 <option value="all" <?php if ($marca == 'all'){?> selected="selected"<?php }?>>TODAS LAS MARCAS</option>
                 <?php 
				$sql = "SELECT codtab,destab FROM titultabladet where tiptab = 'M' order by destab"; 
				$result = mysqli_query($conexion,$sql); 
				while ($row = mysqli_fetch_array($result)){ 
				$codtab	= $row["codtab"];
				$destab	= $row["destab"];
				?>
                 <option value="<?php echo $row["codtab"]; ?>" <?php if ($marca == $codtab){?> selected="selected"<?php }?>><?php echo $destab ?></option>
                 <?php } ?>
               </select>
                </td>
              <td width="217">
                  <input name="val" type="hidden" id="val" value="1" />
              <input type="button" name="Submit" value="Buscar" class="buscar" onclick="buscar()"/>
             
              <input type="button" name="Submit2" value="Salir" onclick="salir()" class="salir"/>			  </td>
			  <td width="18"><?php if(($pagina - 1) > 0) 
			  {
			  ?>
                <a href="../marcas1.php?val=<?php echo $val?>&amp;&amp;tipo=<?php echo $tipo?>&amp;&amp;tipo1=<?php echo $tipo1?>&amp;&amp;ltdgen=<?php echo $ltdgen?>&amp;&amp;local=<?php echo $local?>&amp;&amp;inicio=<?php echo $inicio?>&amp;&amp;registros=<?php echo $registros?>&amp;&amp;pagina=<?php echo $pagina-1?>&amp;&amp;marca=<?php echo $marca?>"> <img src="../../images/play1.gif" width="16" height="16" border="0"/> </a>
                <?php }
			  ?></td>
			  <td width="23"><?php if(($pagina + 1)<=$total_paginas) 
			  {
			  ?>
                <a href="../marcas1.php?val=<?php echo $val?>&amp;&amp;tipo=<?php echo $tipo?>&amp;&amp;tipo1=<?php echo $tipo1?>&amp;&amp;ltdgen=<?php echo $ltdgen?>&amp;&amp;local=<?php echo $local?>&amp;&amp;inicio=<?php echo $inicio?>&amp;&amp;registros=<?php echo $registros?>&amp;&amp;pagina=<?php echo $pagina+1?>&amp;&amp;marca=<?php echo $marca?>"> <img src="../../images/play.gif" width="16" height="16" border="0"/> </a>
                <?php }
			  ?></td>
            </tr>
          </table>
        </form>
      <div align="center"><img src="../../../images/line2.png" width="910" height="4" /></div></td>
    </tr>
  </table>
  <br>
  <?php if ($val == 1)
  {
  ?>
      <iframe src="venxma2.php?val=<?php echo $val?>&date1=<?php echo $date1?>&date2=<?php echo $date2?>&local=<?php echo $local?>&det=<?php echo $det?>&ltdgen=<?php echo $ltdgen?>&amp;&amp;marca=<?php echo $marca?>&doc=<?php echo $doc?>&ven=<?php echo $ven?>" name="marco" id="marco" width="954" height="430" scrolling="Automatic" frameborder="0" allowtransparency="0">
  </iframe>
  <?php }
  ?>
</body>
</html>
