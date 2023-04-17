<?php include('../../session_user.php');
$ord_compra   = $_SESSION['ord_compra'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="css/style1.css" rel="stylesheet" type="text/css" />
<link href="css/style2.css" rel="stylesheet" type="text/css" />
<link href="css/tabla2.css" rel="stylesheet" type="text/css" />
<link href="css/boton_marco.css" rel="stylesheet" type="text/css" />
<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once("../../../funciones/highlight.php");	//ILUMINA CAJAS DE TEXTOS
require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
?>
<style type="text/css">

.Estilo1 {
	color: #666666;
	font-weight: bold;
}

</style>
</head>
<body>
<?php $codpro = $_REQUEST['codpro'];
for($i=0;$i<=5;$i++){
    $dates[$i] =  date("d-m-Y",mktime(0,0,0,date("m")-$i,date("d"),date("Y"))).'<br>';
	list($dcar,$mcar,$ycar) = split( '[/.-]',$dates[$i]);
	$m[$i] = $mcar;
	$y[$i] = $ycar;
	if ($m[$i]== 1)
	{
	$mes[$i] = "ENE";
	}
	if ($m[$i]== 2)
	{
	$mes[$i] = "FEB";
	}
	if ($m[$i]== 3)
	{
	$mes[$i] = "MAR";
	}
	if ($m[$i]== 4)
	{
	$mes[$i] = "ABR";
	}
	if ($m[$i]== 5)
	{
	$mes[$i] = "MAY";
	}
	if ($m[$i]== 6)
	{
	$mes[$i] = "JUN";
	}
	if ($m[$i]== 7)
	{
	$mes[$i] = "JUL";
	}
	if ($m[$i]== 8)
	{
	$mes[$i] = "AGO";
	}
	if ($m[$i]== 9)
	{
	$mes[$i] = "SET";
	}
	if ($m[$i]== 10)
	{
	$mes[$i] = "OCT";
	}
	if ($m[$i]== 11)
	{
	$mes[$i] = "NOV";
	}
	if ($m[$i]== 12)
	{
	$mes[$i] = "DIC";
	}
}  
if ($codpro <> "")
{
$sql="SELECT codpro,desprod,stopro,factor FROM producto where codpro = '$codpro'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
			$codpro     = $row['codpro'];
			$desprod    = $row['desprod'];
			$stopro     = $row['stopro'];
			$factor     = $row['factor'];
}
?>
<form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)" method = "post">
  <table width="100%" border="0" align="center" class="tabla2" >
    <tr>
      <td width="662"><table width="100%" border="0" align="center">
        <tr>
          <td width="74"><span class="Estilo1">PRODUCTO</span></td>
          <td width="567"><b><font color="#990000"><?php echo $desprod?></font></b></td>
        </tr>
      </table></td>
    </tr>
  </table>
 
  <table width="100%" border="0" align="center" class="tabla2" style='width:99%;'>
	<tr>
      <td width="100%">
	  <table width="100%" border="0" align="center">
	      <tr>
          <th width="74" class="text_gris"><span class="Estilo1">TIENDA</span></th>
          <th width="38" class="text_gris"><div align="right" class="Estilo1"><?php echo $mes[5]?></div></th>
          <th width="38" class="text_gris"><div align="right" class="Estilo1"><?php echo $mes[4]?></div></th>
          <th width="41" class="text_gris"><div align="right" class="Estilo1"><?php echo $mes[3]?></div></th>
          <th width="39" class="text_gris"><div align="right" class="Estilo1"><?php echo $mes[2]?></div></th>
          <th width="41" class="text_gris"><div align="right" class="Estilo1"><?php echo $mes[1]?></div></th>
          <th width="39" class="text_gris"><div align="right" class="Estilo1"><?php echo $mes[0]?></div></th>
          <th width="85" class="text_gris"><div align="right" class="Estilo1">MINIMO</div></th>
          <th width="64" class="text_gris"><div align="right" class="Estilo1">STOCK </div></th>
          <th width="73" class="text_gris"><div align="right" class="Estilo1">SUGER </div></th>
          <th width="73" class="text_gris"><div align="right" class="Estilo1">PEDIDO</div></th>
        </tr>
        <?php $sql1="SELECT codloc,nomloc FROM xcompa where habil = '1' order by codloc";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
		$codloc     = $row1['codloc'];
		$nomloc     = $row1['nomloc'];
		if ($nomloc == 'LOCAL0')
		{
		$tabla_stock = 's000';
		$tabla_min   = 'm00';
		}
		if ($nomloc == 'LOCAL1')
		{
		$tabla_stock = 's001';
		$tabla_min   = 'm01';
		}
		if ($nomloc == 'LOCAL2')
		{
		$tabla_stock = 's002';
		$tabla_min   = 'm02';
		}
		if ($nomloc == 'LOCAL3')
		{
		$tabla_stock = 's003';
		$tabla_min   = 'm03';
		}
		if ($nomloc == 'LOCAL4')
		{
		$tabla_stock = 's004';
		$tabla_min   = 'm04';
		}
		if ($nomloc == 'LOCAL5')
		{
		$tabla_stock = 's005';
		$tabla_min   = 'm05';
		}
		if ($nomloc == 'LOCAL6')
		{
		$tabla_stock = 's006';
		$tabla_min   = 'm06';
		}
		if ($nomloc == 'LOCAL7')
		{
		$tabla_stock = 's007';
		$tabla_min   = 'm07';
		}
		if ($nomloc == 'LOCAL8')
		{
		$tabla_stock = 's008';
		$tabla_min   = 'm08';
		}
		if ($nomloc == 'LOCAL9')
		{
		$tabla_stock = 's009';
		$tabla_min   = 'm09';
		}
		if ($nomloc == 'LOCAL10')
		{
		$tabla_stock = 's010';
		$tabla_min   = 'm10';
		}
		if ($nomloc == 'LOCAL11')
		{
		$tabla_stock = 's011';
		$tabla_min   = 'm11';
		}
		if ($nomloc == 'LOCAL12')
		{
		$tabla_stock = 's012';
		$tabla_min   = 'm12';
		}
		if ($nomloc == 'LOCAL13')
		{
		$tabla_stock = 's013';
		$tabla_min   = 'm13';
		}
		if ($nomloc == 'LOCAL14')
		{
		$tabla_stock = 's014';
		$tabla_min   = 'm14';
		}
		if ($nomloc == 'LOCAL15')
		{
		$tabla_stock = 's015';
		$tabla_min   = 'm15';
		}
		if ($nomloc == 'LOCAL16')
		{
		$tabla_stock = 's016';
		$tabla_min   = 'm16';
		}
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$sql2="SELECT $tabla_stock,$tabla_min FROM producto where codpro = '$codpro'";
			$result2 = mysqli_query($conexion,$sql2);
			if (mysqli_num_rows($result2)){
			while ($row2 = mysqli_fetch_array($result2)){
				$stock_act     = $row2[0];
				$stock_min     = $row2[1];
			}
			}
			else
			{
				$stock_act = 0;
				$stock_min = 0;
			}
		/////OBTENGO Y CONVIERTO A FACTOR Y RESIDUO EL STOCK ACTUAL///////////////////////////////////////////////
		$convert    = $stock_act/$factor;
		$div    	= floor($convert);			////PARTE ENTERA DEL STOCK GENERAL
		$mult		= $factor * $div;	
		$tot		= $stock_act - $mult;			/////OBTENGO EL RESIDUO DEL STOCK GENERAL
		/////OBTENGO Y CONVIERTO A FACTOR Y RESIDUO EL STOCK MINIMO//////////////////////////////////////////////
		$convert1   = $stock_min/$factor;
		$div1    	= floor($convert1);			////PARTE ENTERA DEL STOCK GENERAL
		$mult1		= $factor * $div1;	
		$tot1		= $stock_min - $mult1;			/////OBTENGO EL RESIDUO DEL STOCK GENERAL
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		$r			= $stock_min - $stock_act;
		if ($r<0)
		{
		$c    = 0;
		$r    = $r * (-1);
		}
		else
		{
		$c    = 1;
		}
		$div2       = $r/$factor;
		$div2    	= floor($div2);
		$mult2      = $factor * $div2;
		$tot2       = $r - $mult2;
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		$sum0 = 0;
		$sum1 = 0;
		$sum2 = 0;
		$sum3 = 0;
		$sum4 = 0;
		$sum5 = 0;
		?>
		<tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
          <td width="74" class="text_combo_select"><?php echo $nomloc?></td>
          <td width="38">
		    <div align="right">
			<?php $mes		= $m[5];
			$year		= $y[5];
		    $sql2="SELECT sum(canpro * factor) FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where val_habil = '0' and sucursal = '$codloc' and month(venta.invfec) = '$mes' and year(venta.invfec) = '$year' and codpro = '$codpro' and fraccion = 'F'";
			$result2 = mysqli_query($conexion,$sql2);
			if (mysqli_num_rows($result2)){
			while ($row2 = mysqli_fetch_array($result2)){
				$sum5     = $row2[0];
			}
			}
			$sql2="SELECT sum(canpro) FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where val_habil = '0' and sucursal = '$codloc' and month(venta.invfec) = '$mes' and year(venta.invfec) = '$year' and codpro = '$codpro' and fraccion = 'T'";
			$result2 = mysqli_query($conexion,$sql2);
			if (mysqli_num_rows($result2)){
			while ($row2 = mysqli_fetch_array($result2)){
				$sum55     = $row2[0];
			}
			}
			echo ($sum5 + $sum55);
		    ?>
			</div>
			</td>
          <td width="40">
		  <div align="right">
		    <?php $mes		= $m[4];
			$year		= $y[4];
		    $sql2="SELECT sum(canpro * factor) FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where val_habil = '0' and sucursal = '$codloc' and month(venta.invfec) = '$mes' and year(venta.invfec) = '$year' and codpro = '$codpro' and fraccion = 'F'";
			$result2 = mysqli_query($conexion,$sql2);
			if (mysqli_num_rows($result2)){
			while ($row2 = mysqli_fetch_array($result2)){
				$sum4     = $row2[0];
			}
			}
			$sql2="SELECT sum(canpro) FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where val_habil = '0' and sucursal = '$codloc' and month(venta.invfec) = '$mes' and year(venta.invfec) = '$year' and codpro = '$codpro' and fraccion = 'T'";
			$result2 = mysqli_query($conexion,$sql2);
			if (mysqli_num_rows($result2)){
			while ($row2 = mysqli_fetch_array($result2)){
				$sum44     = $row2[0];
			}
			}
			echo ($sum4 + $sum44);
		    ?>	
		  </div>
		  </td>
          <td width="40">
		    <div align="right">
			<?php $mes		= $m[3];
			$year		= $y[3];
		    $sql2="SELECT sum(canpro * factor) FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where val_habil = '0' and sucursal = '$codloc' and month(venta.invfec) = '$mes' and year(venta.invfec) = '$year' and codpro = '$codpro' and fraccion = 'F'";
			$result2 = mysqli_query($conexion,$sql2);
			if (mysqli_num_rows($result2)){
			while ($row2 = mysqli_fetch_array($result2)){
				$sum3     = $row2[0];
			}
			}
			$sql2="SELECT sum(canpro) FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where val_habil = '0' and sucursal = '$codloc' and month(venta.invfec) = '$mes' and year(venta.invfec) = '$year' and codpro = '$codpro' and fraccion = 'T'";
			$result2 = mysqli_query($conexion,$sql2);
			if (mysqli_num_rows($result2)){
			while ($row2 = mysqli_fetch_array($result2)){
				$sum33     = $row2[0];
			}
			}
			echo ($sum3 + $sum33);
		    ?>
			</div>
			</td>
          <td width="40">
		    <div align="right">
			<?php $mes		= $m[2];
			$year		= $y[2];
		    $sql2="SELECT sum(canpro * factor) FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where val_habil = '0' and sucursal = '$codloc' and month(venta.invfec) = '$mes' and year(venta.invfec) = '$year' and codpro = '$codpro' and fraccion = 'F'";
			$result2 = mysqli_query($conexion,$sql2);
			if (mysqli_num_rows($result2)){
			while ($row2 = mysqli_fetch_array($result2)){
				$sum2     = $row2[0];
			}
			}
			$sql2="SELECT sum(canpro) FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where val_habil = '0' and sucursal = '$codloc' and month(venta.invfec) = '$mes' and year(venta.invfec) = '$year' and codpro = '$codpro' and fraccion = 'T'";
			$result2 = mysqli_query($conexion,$sql2);
			if (mysqli_num_rows($result2)){
			while ($row2 = mysqli_fetch_array($result2)){
				$sum22     = $row2[0];
			}
			}
			echo ($sum2 + $sum22);
		    ?>
			</div></td>
          <td width="40">
		    <div align="right">
			<?php $mes		= $m[1];
			$year		= $y[1];
		    $sql2="SELECT sum(canpro * factor) FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where val_habil = '0' and sucursal = '$codloc' and month(venta.invfec) = '$mes' and year(venta.invfec) = '$year' and codpro = '$codpro' and fraccion = 'F'";
			$result2 = mysqli_query($conexion,$sql2);
			if (mysqli_num_rows($result2)){
			while ($row2 = mysqli_fetch_array($result2)){
				$sum1     = $row2[0];
			}
			}
			$sql2="SELECT sum(canpro) FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where val_habil = '0' and sucursal = '$codloc' and month(venta.invfec) = '$mes' and year(venta.invfec) = '$year' and codpro = '$codpro' and fraccion = 'T'";
			$result2 = mysqli_query($conexion,$sql2);
			if (mysqli_num_rows($result2)){
			while ($row2 = mysqli_fetch_array($result2)){
				$sum11     = $row2[0];
			}
			}
			echo ($sum1 + $sum11);
		    ?>
			</div></td>
          <td width="40">
		    <div align="right">
			<?php $mes		= $m[0];
			$year		= $y[0];
		    $sql2="SELECT sum(canpro * factor) FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where val_habil = '0' and sucursal = '$codloc' and month(venta.invfec) = '$mes' and year(venta.invfec) = '$year' and codpro = '$codpro' and fraccion = 'F'";
			$result2 = mysqli_query($conexion,$sql2);
			if (mysqli_num_rows($result2)){
			while ($row2 = mysqli_fetch_array($result2)){
				$sum0     = $row2[0];
			}
			}
			$sql2="SELECT sum(canpro) FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where val_habil = '0' and sucursal = '$codloc' and month(venta.invfec) = '$mes' and year(venta.invfec) = '$year' and codpro = '$codpro' and fraccion = 'T'";
			$result2 = mysqli_query($conexion,$sql2);
			if (mysqli_num_rows($result2)){
			while ($row2 = mysqli_fetch_array($result2)){
				$sum00     = $row2[0];
			}
			}
			echo ($sum0 + $sum00);
		    ?>
			</div></td>
          <td width="85">
		    <div align="right"><?php echo $stock_min?></div></td>
          <td width="65">
		    <div align="right"><?php echo $stock_act?></div></td>
          <td width="73">
		  <div align="right">
		  <?php $prom = ($sum0 + $sum1 + $sum2 + $sum3 + $sum4 + $sum5 + $sum00 + $sum11 + $sum22 + $sum33 + $sum44 + $sum55)/6;
		  echo $numero_formato_frances = number_format($prom, 2, '.', ' ');
		  ?>
		  </div></td>
          <td width="70">
		  <div align="right">
		    <?php if ($c==1)
			{
			?>
			<font color="#990000"><b><?php echo $div2?> F <?php echo $tot2?></b></font>
			<?php }
			else
			{
			?>
			<font color="#009933"><?php echo $div2?> F <?php echo $tot2?></font>
			<?php }
			?>
		  </div>
		  </td>
          </tr>
		<?php $c++;
		}
		}
		?>
      </table></td>
    </tr>
  </table>
</form>
<?php }	////CIERRO EL IF DE LA CONSULTA
else
{
?>
<table width="100%" border="0" align="center" class="tabla2">
  <tr>
    <td ><table width="100%" border="0" align="center">
      <tr>
        <td width="74"><span class="Estilo1">PRODUCTO</span></td>
        <td width="567">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="100%" border="0" align="center" class="tabla2">
  <tr>
    <td ><table width="100%" border="0" align="center">
      <tr>
        <td width="74" class="text_gris"><span class="Estilo1">TIENDA</span></td>
        <td width="38" class="text_gris"><div align="right" class="Estilo1"><?php echo $mes[5]?></div></td>
        <td width="38" class="text_gris"><div align="right" class="Estilo1"><?php echo $mes[4]?></div></td>
        <td width="41" class="text_gris"><div align="right" class="Estilo1"><?php echo $mes[3]?></div></td>
        <td width="39" class="text_gris"><div align="right" class="Estilo1"><?php echo $mes[2]?></div></td>
        <td width="41" class="text_gris"><div align="right" class="Estilo1"><?php echo $mes[1]?></div></td>
        <td width="39" class="text_gris"><div align="right" class="Estilo1"><?php echo $mes[0]?></div></td>
        <td width="85" class="text_gris"><div align="right" class="Estilo1">MINIMO</div></td>
        <td width="64" class="text_gris"><div align="right" class="Estilo1">STOCK </div></td>
        <td width="73" class="text_gris"><div align="right" class="Estilo1">SUGER </div></td>
        <td width="73" class="text_gris"><div align="right" class="Estilo1">PEDIDO</div></td>
      </tr>
    </table></td>
  </tr>
</table>
<?php }
}
else
{
?>
<table width="100%" border="0" align="center" class="tabla2">
  <tr>
    <td ><table width="100%" border="0" align="center">
      <tr>
        <td width="74"><span class="Estilo1">PRODUCTO</span></td>
        <td width="567">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="100%" border="0" align="center" class="tabla2">
  <tr>
    <td ><table width="100%" border="0" align="center">
      <tr>
        <td width="74" class="text_gris"><span class="Estilo1">TIENDA</span></td>
        <td width="38" class="text_gris"><div align="right" class="Estilo1"><?php echo $mes[5]?></div></td>
        <td width="38" class="text_gris"><div align="right" class="Estilo1"><?php echo $mes[4]?></div></td>
        <td width="41" class="text_gris"><div align="right" class="Estilo1"><?php echo $mes[3]?></div></td>
        <td width="39" class="text_gris"><div align="right" class="Estilo1"><?php echo $mes[2]?></div></td>
        <td width="41" class="text_gris"><div align="right" class="Estilo1"><?php echo $mes[1]?></div></td>
        <td width="39" class="text_gris"><div align="right" class="Estilo1"><?php echo $mes[0]?></div></td>
        <td width="85" class="text_gris"><div align="right" class="Estilo1">MINIMO</div></td>
        <td width="64" class="text_gris"><div align="right" class="Estilo1">STOCK </div></td>
        <td width="73" class="text_gris"><div align="right" class="Estilo1">SUGER </div></td>
        <td width="73" class="text_gris"><div align="right" class="Estilo1">PEDIDO</div></td>
      </tr>
    </table></td>
  </tr>
</table>
<?php }
?>
</body>
</html>
