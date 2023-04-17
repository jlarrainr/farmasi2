<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/seleccion.css" rel="stylesheet" type="text/css" />
<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
//require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
require_once ('funciones/datos_generales.php'); //////CODIGO Y NOMBRE DEL LOCAL
require_once("../../../funciones/botones.php");	//COLORES DE LOS BOTONES
?>
<?php $sql="SELECT * FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    	$codloc    = $row['codloc'];
}
}
$sql="SELECT * FROM xcompa where codloc = '$codloc'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    	$nomloc    = $row['nomloc'];
}
}
$cod	 = $_REQUEST['cod'];
$sql="SELECT desprod,codfam FROM producto where codpro = '$cod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
			$desprod        = $row['desprod'];
			$codfam         = $row['codfam'];
}
}
?>
<script>
function cerrar(e){
tecla=e.keyCode
	if (tecla == 27)
	{
	window.close();
	}
}
</script>
<title><?php echo $desprod?></title>
<script>
function cerrar_popup(valor,marca)
{
var prod = valor;
var marc = marca;
document.form1.target = "mark";
window.opener.location.href="salir1.php?prod="+prod+"&marca="+marc;
self.close();
}
</script>
</head>

<body onkeyup="cerrar(event)">
<form name="form1" id="form1">
<table id="table" cellspacing="0" onselectstart="return false">
     <thead>
  		<tr id="head">
        <th width="10">
            <div align="left">N�</div>
        </th>
		<th width="264">
            <div align="left">PRODUCTO</div>
        </th>
		<th width="38">
            <div align="right">L0</div>
		</th>
		<th width="38">
            <div align="right">L1</div>
		</th>
		<th width="38">
            <div align="right">L2</div>
		</th>
		<th width="38">
            <div align="right">L3</div>
		</th>
		<th width="38">
            <div align="right">L4</div>
		</th>
		<th width="38">
            <div align="right">L5</div>
		</th>
		<th width="38">
            <div align="right">L6</div>
		</th>
		<th width="38">
            <div align="right">L7</div>
		</th>
		<th width="38">
            <div align="right">L8</div>
		</th>
		<th width="38">
            <div align="right">L9</div>
		</th>
		<th width="38">
            <div align="right">L10</div>
		</th>
		<th width="38">
            <div align="right">L11</div>
		</th>
		<th width="38">
            <div align="right">L12</div>
		</th>
		<th width="38">
            <div align="right">L13</div>
		</th>
		<th width="38">
            <div align="right">L14</div>
		</th>
		<th width="38">
            <div align="right">L15</div>
		</th>
		<th width="38">
            <div align="right">L16</div>
		</th>
      </tr>
    </thead>
    <?php $i = 1;
$sql="SELECT codpro,desprod,codmar,codfam,factor,margene,costre,prevta,preuni,m00,m01,m02,m03,m04,m05,m06,m07,m08,m09,m10,m11,m12,m13,m14,m15,m16 FROM producto where codfam = '$codfam'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
?>
    <tbody id="tbody">
      <?php while ($row = mysqli_fetch_array($result)){
			$codigo         = $row['codpro'];
			$desprod        = $row['desprod'];
			$codmar         = $row['codmar'];
			$codfam         = $row['codfam'];
			$factor         = $row['factor'];
			$margene        = $row['margene'];
			$costre         = $row['costre'];
			$prevta         = $row['prevta'];
			$preuni         = $row['preuni'];
			$s000	        = $row['m00'];
			$s001	        = $row['m01'];
			$s002           = $row['m02'];
			$s003           = $row['m03'];
			$s004           = $row['m04'];
			$s005           = $row['m05'];
			$s006           = $row['m06'];
			$s007           = $row['m07'];
			$s008           = $row['m08'];
			$s009           = $row['m09'];
			$s010           = $row['m10'];
			$s011           = $row['m11'];
			$s012           = $row['m12'];
			$s013           = $row['m13'];
			$s014           = $row['m14'];
			$s015           = $row['m15'];
			$s016           = $row['m16'];
			$caja0			= 0;
			$frac0			= 0;
			$caja1			= 0;
			$frac1			= 0;
			$caja2			= 0;
			$frac2			= 0;
			$caja3			= 0;
			$frac3			= 0;
			$caja4			= 0;
			$frac4			= 0;
			$caja5			= 0;
			$frac5			= 0;
			$caja6			= 0;
			$frac6			= 0;
			$caja7			= 0;
			$frac7			= 0;
			$caja8			= 0;
			$frac8			= 0;
			$caja9			= 0;
			$frac9			= 0;
			$caja10			= 0;
			$frac10			= 0;
			$caja11			= 0;
			$frac11			= 0;
			$caja12			= 0;
			$frac12			= 0;
			$caja13			= 0;
			$frac13			= 0;
			$caja14			= 0;
			$frac14			= 0;
			$caja15			= 0;
			$frac15			= 0;
			$caja16			= 0;
			$frac16			= 0;
			////////////////////////////////////////////////////////////////
			$caja0 = intval($s000/$factor);
			$frac0 = (($s000/$factor) - intval($s000/$factor)) * $factor;
			
			////////////////////////////////////////////////////////////////
			$caja1 = intval($s001/$factor);
			$frac1 = (($s001/$factor) - intval($s001/$factor)) * $factor;
			
			////////////////////////////////////////////////////////////////
			$caja2 = intval($s002/$factor);
			$frac2 = (($s002/$factor) - intval($s002/$factor)) * $factor;
			
			////////////////////////////////////////////////////////////////
			$caja3 = intval($s003/$factor);
			$frac3 = (($s003/$factor) - intval($s003/$factor)) * $factor;
			
			////////////////////////////////////////////////////////////////
			$caja4 = intval($s004/$factor);
			$frac4 = (($s004/$factor) - intval($s004/$factor)) * $factor;
			
			////////////////////////////////////////////////////////////////
			$caja5 = intval($s005/$factor);
			$frac5 = (($s005/$factor) - intval($s005/$factor)) * $factor;
			
			////////////////////////////////////////////////////////////////
			$caja6 = intval($s006/$factor);
			$frac6 = (($s006/$factor) - intval($s006/$factor)) * $factor;
			
			////////////////////////////////////////////////////////////////
			$caja7 = intval($s007/$factor);
			$frac7 = (($s007/$factor) - intval($s007/$factor)) * $factor;
			
			////////////////////////////////////////////////////////////////
			$caja8 = intval($s008/$factor);
			$frac8 = (($s008/$factor) - intval($s008/$factor)) * $factor;
			
			////////////////////////////////////////////////////////////////
			$caja9 = intval($s009/$factor);
			$frac9 = (($s009/$factor) - intval($s009/$factor)) * $factor;
			
			////////////////////////////////////////////////////////////////
			$caja10 = intval($s010/$factor);
			$frac10 = (($s010/$factor) - intval($s010/$factor)) * $factor;
			
			////////////////////////////////////////////////////////////////
			$caja11 = intval($s011/$factor);
			$frac11 = (($s011/$factor) - intval($s011/$factor)) * $factor;
			
			////////////////////////////////////////////////////////////////
			$caja12 = intval($s012/$factor);
			$frac12 = (($s012/$factor) - intval($s012/$factor)) * $factor;
			
			////////////////////////////////////////////////////////////////
			$caja13 = intval($s013/$factor);
			$frac13 = (($s013/$factor) - intval($s013/$factor)) * $factor;
			
			////////////////////////////////////////////////////////////////
			$caja14 = intval($s014/$factor);
			$frac14 = (($s014/$factor) - intval($s014/$factor)) * $factor;
			
			////////////////////////////////////////////////////////////////
			$caja15 = intval($s015/$factor);
			$frac15 = (($s015/$factor) - intval($s015/$factor)) * $factor;
			
			////////////////////////////////////////////////////////////////
			$caja16 = intval($s016/$factor);
			$frac16 = (($s016/$factor) - intval($s016/$factor)) * $factor;
			
			////////////////////////////////////////////////////////////////
?>
      <tr>
	    <td><?php echo $i++?>-</td>
		<td width="264">
		<a id="l1" href="javascript:cerrar_popup(<?php echo $codigo?>,<?php echo $codmar?>)">
		  <?php if ($codigo == $cod){ ?>
          <b><?php echo substr($desprod,0,55);?></b>
          <?php } else {echo substr($desprod,0,55);}?>
		</a>		
		</td>
		<td width="38"><div align="right">
		<?php if ($factor == 1){echo "C".$caja0;}else{echo "C".$caja0; echo " "; echo "f".$frac0;}?></div></td>
		<td width="38"><div align="right">
		<?php if ($factor == 1){echo "C".$caja1;}else{echo "C".$caja1; echo " "; echo "f".$frac1;}?></div></td>
		<td width="38"><div align="right">
		<?php if ($factor == 1){echo "C".$caja2;}else{echo "C".$caja2; echo " "; echo "f".$frac2;}?></div></td>
		<td width="38"><div align="right">
		<?php if ($factor == 1){echo "C".$caja3;}else{echo "C".$caja3; echo " "; echo "f".$frac3;}?></div></td>
		<td width="38"><div align="right">
		<?php if ($factor == 1){echo "C".$caja4;}else{echo "C".$caja4; echo " "; echo "f".$frac4;}?></div></td>
		<td width="38"><div align="right">
		<?php if ($factor == 1){echo "C".$caja5;}else{echo "C".$caja5; echo " "; echo "f".$frac5;}?></div></td>
		<td width="38"><div align="right">
		<?php if ($factor == 1){echo "C".$caja6;}else{echo "C".$caja6; echo " "; echo "f".$frac6;}?></div></td>
		<td width="38"><div align="right">
		<?php if ($factor == 1){echo "C".$caja7;}else{echo "C".$caja7; echo " "; echo "f".$frac7;}?></div></td>
		<td width="38"><div align="right">
		<?php if ($factor == 1){echo "C".$caja8;}else{echo "C".$caja8; echo " "; echo "f".$frac8;}?></div></td>
		<td width="38"><div align="right">
		<?php if ($factor == 1){echo "C".$caja9;}else{echo "C".$caja9; echo " "; echo "f".$frac9;}?></div></td>
		<td width="38"><div align="right">
		<?php if ($factor == 1){echo "C".$caja10;}else{echo "C".$caja10; echo " "; echo "f".$frac10;}?></div></td>
		<td width="38"><div align="right">
		<?php if ($factor == 1){echo "C".$caja11;}else{echo "C".$caja11; echo " "; echo "f".$frac11;}?></div></td>
		<td width="38"><div align="right">
		<?php if ($factor == 1){echo "C".$caja12;}else{echo "C".$caja12; echo " "; echo "f".$frac12;}?></div></td>
		<td width="38"><div align="right">
		<?php if ($factor == 1){echo "C".$caja13;}else{echo "C".$caja13; echo " "; echo "f".$frac13;}?></div></td>
		<td width="38"><div align="right">
		<?php if ($factor == 1){echo "C".$caja14;}else{echo "C".$caja14; echo " "; echo "f".$frac14;}?></div></td>
		<td width="38"><div align="right">
		<?php if ($factor == 1){echo "C".$caja15;}else{echo "C".$caja15; echo " "; echo "f".$frac15;}?></div></td>
		<td width="38"><div align="right">
		<?php if ($factor == 1){echo "C".$caja16;}else{echo "C".$caja16; echo " "; echo "f".$frac16;}?></div></td>
      </tr>
      <?php }
?>
   </tbody>
   <?php include('funciones/teclas.php');?>
    <?php }
?>
</table>
</form>
</body>
</html>
