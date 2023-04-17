<?php require_once('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function salirx()
{
	 var f = document.form1;
	 //alert("hola");
	 f.method = "POST";
	 f.target = "_top";
	 f.action ="../../index.php";
	 f.submit();
}
</script>
<?php require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../../../convertfecha.php');	//CONEXION A BASE DE DATOS
require_once('../../../funciones/highlight.php');	//ILUMINA CAJAS DE TEXTOS
require_once('../../../funciones/functions.php');	//DESHABILITA TECLAS
require_once('../../../funciones/botones.php');	//COLORES DE LOS BOTONES
require_once('../../../funciones/funct_principal.php');	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
require_once('../funciones/venta.php');	//FUNCIONES DE ESTA PANTALLA
require_once('../../local.php');	//LOCAL DEL USUARIO



$sql1="SELECT nomusu FROM usuario where usecod = '$usuario'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
				$user    = $row1['nomusu'];
}
}
$pag= $_REQUEST['pageno'];
if (isset($_REQUEST['pageno'])) 
{
   $pageno = $_REQUEST['pageno'];
} 
else
{
   $pageno = 1;
} 
$sql="SELECT count(*) FROM cotizacion where estado = '0'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result) ){
while ($row = mysqli_fetch_array($result)){
		$numrows             = $row[0];
}
}
$num  = $_REQUEST['num'];
$tip  = $_REQUEST['tip'];
if ($tip == 1)
{
	$sql="SELECT count(*) FROM venta where estado = '0' and tipvta = '0' and invnum <= '$num'";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result) ){
	while ($row = mysqli_fetch_array($result)){
			$pageno             = $row[0];
	}
	}
}
?>
</head>
<body onload="fc();">
<form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
  <table width="968" border="0">
    <tr>
      <td width="958"><table width="954" border="0">
        <tr>
          <td width="130">NUMERO DE DOCUMENTO</td>
          <td width="496">
		  <input name="num" type="text" id="num" size="15"/>
		  <input name="tip" type="hidden" id="tip" value="1" />
          <input type="button" name="Submit" value="BUSCAR" class="buscar" onclick="buscar_venta()"/></td>
          <td width="314"><div align="right" class="text_combo_select">USUARIO : <img src="../../../images/user.gif" width="15" height="16" /><?php echo $user?></div>
		  </td>
        </tr>
      </table>
<?php /////////////////////////////////
$rows_per_page = 1;
$lastpage      = ceil($numrows/$rows_per_page);
$pageno = (int)$pageno;
if ($pageno > $lastpage) {
   $pageno = $lastpage;
} // if
if ($pageno < 1) {
   $pageno = 1;
} // if
$limit = 'LIMIT ' .($pageno - 1) * $rows_per_page .',' .$rows_per_page;
if ($tip == 1)
{
	if ($nombre_local == 'LOCAL0')
	{
	$sql="SELECT invnum,invfec,cuscod,usecod,bruto,valven,invtot,igv,forpag,estado,hora,sucursal FROM cotizacion where invnum = '$num' and estado = '0'";
	}
	else
	{
	$sql="SELECT invnum,invfec,cuscod,usecod,bruto,valven,invtot,igv,forpag,estado,hora,sucursal FROM cotizacion where invnum = '$num' and estado = '0' and sucursal = '$codigo_local'";
	}
}
else
{
	if ($nombre_local == 'LOCAL0')
	{
	$sql="SELECT invnum,invfec,cuscod,usecod,bruto,valven,invtot,igv,forpag,estado,hora,sucursal FROM cotizacion where estado = '0' order by invnum asc $limit";
	}
	else
	{
	$sql="SELECT invnum,invfec,cuscod,usecod,bruto,valven,invtot,igv,forpag,estado,hora,sucursal FROM venta where estado = '0' and sucursal = '$codigo_local' order by invnum asc $limit";
	}
}
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
			$invnum       = $row['invnum'];		//codigo
			$invfec       = $row['invfec'];
			$cuscod       = $row['cuscod'];
			$usecod       = $row['usecod'];
			//$numdoc       = $row['nrovent'];
			$bruto        = $row['bruto'];
			$valven       = $row['valven'];
			$invtot       = $row['invtot'];
			$igv          = $row['igv'];
			$forpag       = $row['forpag'];
			//$val_habil    = $row['val_habil'];
			$estado       = $row['estado'];
			$hora         = $row['hora'];
			$sucursal     = $row['sucursal'];
			$encontrado	  = 1;
			$dctos 		  = $bruto - $valven;
	}
		$sql1="SELECT nomusu FROM usuario where usecod = '$usecod'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
			$user_venta    = $row1['nomusu'];
		}
		}
		$sql1="SELECT descli FROM cliente where codcli = '$cuscod'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
			$cliente_venta  = $row1['descli'];
		}
		}
		$sql1="SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
			$nomloc1    = $row1['nomloc'];
			$nomloc2    = $row1['nombre'];
		}
		}
		if ($nomloc2 == "")
		{
		$nomloc = $nomloc1;
		}
		else
		{
		$nomloc = $nomloc2;
		}
		///FORMA DE PAGO
		if ($forpag == 'E')
		{
			$fpag = 'EFECTIVO';
		}
		if ($forpag == 'T')
		{
			$fpag = 'TARJETA';
		}
		if ($forpag == 'C')
		{
			$fpag = 'CREDITO';
		}
	}
function formato($c) {
printf("%08d",  $c);
} 
function formato1($c) {
printf("%06d",  $c);
} 

if ($encontrado == 1)
{

?>
      <table width="954" border="0">
        <tr>
          <td width="58">NUMERO</td>
          <td width="140"><input name="textfield" type="text" size="15" disabled="disabled" value="<?php echo formato($invnum)?>"/></td>
          <td width="37">FECHA</td>
          <td width="158"><input name="textfield2" type="text" size="15" disabled="disabled" value="<?php echo fecha($invfec)?>"/></td>
          <td width="85">CLIENTE</td>
          <td width="329"><input name="textfield23" type="text" size="50" disabled="disabled" value="<?php echo $cliente_venta?>"/></td>
          <td width="117"><div align="right" class="text_combo_select"><strong>LOCAL: <?php echo $nombre_local?></strong></div></td>
        </tr>
      </table>
      <table width="954" border="0">
        <tr>
          <td width="58">VENDEDOR</td>
          <td width="341"><input name="textfield232" type="text" size="50" disabled="disabled" value="<?php echo $user_venta?>"/></td>
          <td width="87">FORMA DE PAGO</td>
          <td width="150"><input name="textfield22" type="text" size="20" disabled="disabled" value="<?php echo $fpag?>"/></td>
          <td width="296"><div align="right"><strong>
		  
            <?php /*if ($val_habil == 1)
			{
			?>
            <span class="login">ANULADO</span>
            <?php } 
			else
			{
			?>
            <span class="login">ACTIVADO</span>
            <?php }
			*/
			?>
          </strong></div></td>
        </tr>
      </table>
      <table width="954" border="0">
        <tr>
          <td width="58">FECHA</td>
          <td width="341"><input name="textfield2322" type="text" size="20" disabled="disabled" value="<?php echo $invfec?>"/></td>
          <td width="87"><p>HORA</p></td>
          <td width="176"><input name="textfield222" type="text" size="20" disabled="disabled" value="<?php echo $hora?>"/></td>
          <td width="72"><div align="left">SUCURSAL</div></td>
          <td width="194"><div align="left">
              <input name="textfield2222" type="text" disabled="disabled" value="<?php echo $nomloc?>" size="35"/>
          </div></td>
        </tr>
      </table>
      <?php }
?>

<div align="center"><img src="../../../images/line2.png" width="950" height="4" /></div>
		<?php if ($encontrado == 1){?>
        <table width="962" border="0">
            <tr>
              <td width="955">
			  <iframe src="ventas2.php?invnum=<?php echo $invnum?>" name="iFrame2" width="954" height="410" scrolling="Automatic" frameborder="0" id="iFrame2" allowtransparency="0"> </iframe>
			  </td>
            </tr>
        </table>
		<div align="center"><img src="../../../images/line2.png" width="950" height="4" /></div>
		<?php } else {?>
        <table width="962" border="0">
            <tr>
              <td width="955">
			  <iframe src="ventas3.php" name="iFrame2" width="954" height="460" scrolling="Automatic" frameborder="0" id="iFrame2" allowtransparency="0"> </iframe>
			  </td>
            </tr>
        </table>
		  <div align="center"><img src="../../../images/line2.png" width="950" height="4" /></div>
		<?php }
		?>
		  <table width="955" border="0" align="center">
            <tr>
              <td width="73"><div align="right">V. BRUTO </div></td>
              <td width="132">
              <input name="mont1" class="sub_totales" type="text" id="mont1" onclick="blur()" size="15" value="<?php if ($bruto > 0){?> <?php echo $bruto?> <?php }else{?>0.00<?php }?>" />              </td>
              <td width="50"><div align="right">DCTOS</div></td>
              <td width="132">
			  <input name="mont2" class="sub_totales" type="text" id="mont2" onclick="blur()" size="15"  value="<?php if ($dctos > 0){?> <?php echo $dctos?> <?php }else{?>0.00<?php }?>">			  </td>
              <td width="50"><div align="right">V. VENTA </div></td>
              <td width="132">
			  <input name="mont3" class="sub_totales" type="text" id="mont3" onclick="blur()" size="15" value="<?php if ($valven > 0){?> <?php echo $valven?> <?php }else{?>0.00<?php }?>"/></td>
              <td width="50"><div align="right">IGV</div></td>
              <td width="132">
			  <input name="mont4" class="sub_totales" type="text" id="mont4" onclick="blur()" size="15" value="<?php if ($igv > 0){?> <?php echo $igv?> <?php }else{?>0.00<?php }?>"/></td>
              <td width="50"><div align="right">TOTAL</div></td>
              <td width="112">
			  <input name="mont5" class="sub_totales" type="text" id="mont5" onclick="blur()" size="15" value="<?php if ($invtot > 0){?> <?php echo $invtot?> <?php }else{?>0.00<?php }?>"/></td>
            </tr>
        </table>
		  <div align="center"><img src="../../../images/line2.png" width="950" height="4" /> </div>
		  <br>
		  <div class="botones">
            <table width="932" border="0">
              <tr>
                <td width="321"><div align="center">
				
                <?php $firstpage = 1;
				$prevpage = $pageno-1;
				$nextpage = $pageno+1;
				$lastpage = $lastpage;
 				?>
                  <input name="firstpage" type="hidden" id="firstpage" value="<?php echo $firstpage?>"/>
                  <input name="nextpage" type="hidden" id="nextpage" value="<?php echo $nextpage?>"/>
                  <input name="prevpage" type="hidden" id="prevpage" value="<?php echo $prevpage?>"/>
                  <input name="lastpage" type="hidden" id="lastpage" value="<?php echo $lastpage?>"/>
                  <input name="pageno" type="hidden" id="pageno"/>
                  <input name="first" type="button" id="first" value="Primero" <?php if (($pageno == 1)||($numrows == 0) ||($encontrado <> 1)){ ?> disabled="disabled" <?php } ?> class="primero" onclick="primero()" />
                  <input name="prev" type="button" id="prev" value="Anterior" <?php if (($pageno == 1) ||($numrows == 0) ||($encontrado <> 1)){ ?> disabled="disabled" <?php } ?> class="anterior" onclick="anterior()"/>
                  <input name="next" type="button" id="next" value="Siguiente" <?php if (($pageno == $lastpage) ||($numrows == 0) ||($encontrado <> 1)){ ?> disabled="disabled" <?php } ?> class="siguiente" onclick="siguiente()"/>
                  <input name="fin" type="button" id="fin" value="Ultimo" <?php if (($pageno == $lastpage) ||($numrows == 0) ||($encontrado <> 1)){ ?> disabled="disabled" <?php } ?> class="ultimo" onclick="ultimo()"/>
</div></td>
                <td width="17">&nbsp;</td>
                <td width="580"><label>
				<div align="right">
                      <input name="printer" type="button" id="printer" value="Imprimir" class="imprimir" onclick="imprimir()"/>
                      <input name="nuevo" type="button" id="nuevo" value="Nuevo" class="nuevo" onclick="nueva_venta()"/>
                      <input name="modif" type="button" id="modif" value="Modificar" class="modificar" disabled="disabled" onclick="modificar()"/>
                      <input name="cod" type="hidden" id="cod" value="<?php echo $invnum?>" />
					  <?php /*if ($val_habil == 1){
					  ?>
					  
					  <input name="del" type="button" id="del" value="Recuperar" class="eliminar" <?php if ($encontrado <>1){?>disabled="disabled" <?php }?> onclick="eliminar()"/>
					  <?php } else {
					  ?>
					  <input name="del1" type="button" id="del1" value="Eliminar" class="eliminar" <?php if ($encontrado<>1){?> disabled="disabled" <?php }?> onclick="eliminar1()"/>
					  <?php }
					  */
					  ?>
					  <input name="save" type="button" id="save" value="Grabar" onclick="grabar1()" class="grabar" <?php if (($count == 0)||($count1>0)){?>disabled="disabled" <?php }?>/>
                      <input name="ext" type="button" id="ext" value="Cancelar" onclick="cancelar_consult()" class="cancelar"  <?php if ($find <>1){?>disabled="disabled" <?php }?>/>
					   <input tabindex="20" name="exit" type="button" id="exit" value="Salir" onclick="salirx()" class="salir"/>
                  </div>
                    
                </label></td>
              </tr>
            </table>
      </div></td>
    </tr>
  </table>
</form>
<?php mysqli_free_result($result);
mysqli_free_result($result1);
mysqli_close($conexion); 
?>
</body>
</html>
