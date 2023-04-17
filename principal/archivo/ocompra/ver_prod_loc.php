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
$mesact   = date('n');
$yeartact = date('Y');
if ($mesact<=3)
{
	if ($mesact == 3)
	{
	$mesact1   = 12;
	}
	if ($mesact == 2)
	{
	$mesact1   = 11;
	}
	if ($mesact == 1)
	{
	$mesact1   = 10;
	}
	$yeartact1 = $yeartact - 1;
}
else
{
$mesact1 = $mesact - 3;
$yeartact1 = $yeartact;
}
$sql="SELECT codloc FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    	$codloc    = $row['codloc'];
}
}
$sql="SELECT nomloc FROM xcompa where habil = '1' and codloc = '$codloc'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    	$nomloc    = $row['nomloc'];
}
}
$cod	 = $_REQUEST['cod'];
$sql="SELECT codfam FROM producto where codpro = '$cod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
			$codfam         = $row['codfam'];
}
}
?>
<script>
function getfocus1(){
document.getElementById('l1').focus();
}
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
<style type="text/css">
.Estilo1 {color: #FFFFFF}
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
background-color: #FFFF66;
color: #0066CC;
border: 0px solid #ccc;
}
a:active {
background-color: #FFFF66;
color: #0066CC;
border: 0px solid #ccc;
} 
</style>
</head>

<body onload="getfocus1()" onkeyup="cerrar(event)">
<form name="form1" id="form1">
<table width="1400" border="0" bgcolor="#50ADEA">
     <tr>
        <td width="24" height="25">
       <div align="left" class="Estilo1">N�</div>       </td>
		<td width="258">
       <div align="left" class="Estilo1">PRODUCTO</div>       </td>
		<td width="56">
       <div align="right" class="Estilo1">P.PROM</div>	   </td>
		<td width="56">
       <div align="right" class="Estilo1">PCOMP1</div>	   </td>
		<td width="56">
       <div align="right" class="Estilo1">PCOMP2</div>	   </td>
		<td width="56">
       <div align="right" class="Estilo1">PCOMP3</div>	   </td>
		<td width="56">
       <div align="right" class="Estilo1">PCOMP4</div>	   </td>
		<td width="56">
       <div align="right" class="Estilo1">PCOMP5</div>	   </td>
		<td width="40">
       <div align="right" class="Estilo1">L0</div>	   </td>
		<td width="40">
       <div align="right" class="Estilo1">L1</div>	   </td>
		<td width="40">
       <div align="right" class="Estilo1">L2</div>	   </td>
		<td width="40">
       <div align="right" class="Estilo1">L3</div>	   </td>
		<td width="40">
       <div align="right" class="Estilo1">L4</div>	   </td>
		<td width="40">
       <div align="right" class="Estilo1">L5</div>	   </td>
		<td width="40">
       <div align="right" class="Estilo1">L6</div>	   </td>
		<td width="40">
       <div align="right" class="Estilo1">L7</div>	   </td>
		<td width="40">
       <div align="right" class="Estilo1">L8</div>	   </td>
		<td width="40">
       <div align="right" class="Estilo1">L9</div>	   </td>
		<td width="40">
       <div align="right" class="Estilo1">L10</div>	   </td>
		<td width="40">
       <div align="right" class="Estilo1">L11</div>	   </td>
		<td width="40">
       <div align="right" class="Estilo1">L12</div>	   </td>
		<td width="40">
       <div align="right" class="Estilo1">L13</div>	   </td>
		<td width="40">
       <div align="right" class="Estilo1">L14</div>	   </td>
		<td width="40">
       <div align="right" class="Estilo1">L15</div>	   </td>
		<td width="40">
       <div align="right" class="Estilo1">L16</div>	   </td>
    </tr>
</table>
<?php function UltimoDia($anho,$mes){
   if (((fmod($anho,4)==0) and (fmod($anho,100)!=0)) or (fmod($anho,400)==0)) {
       $dias_febrero = 29;
   } else {
       $dias_febrero = 28;
   }
   switch($mes) {
       case 01: return 31; break;
       case 02: return $dias_febrero; break;
       case 03: return 31; break;
       case 04: return 30; break;
       case 05: return 31; break;
       case 06: return 30; break;
       case 07: return 31; break;
       case 08: return 31; break;
       case 09: return 30; break;
       case 10: return 31; break;
       case 11: return 30; break;
       case 12: return 31; break;
   }
}
$dd = UltimoDia($yeartact,09);
$date1 = $yeartact.'-'.$mesact.'-'.$dd;
$date2 = $yeartact1.'-'.$mesact1.'-01';
$i = 1;
$sql="SELECT codpro,desprod,codmar,codfam,factor,margene,costre,prevta,preuni,m00,m01,m02,m03,m04,m05,m06,m07,m08,m09,m10,m11,m12,m13,m14,m15,m16,pcomp1,pcomp2,pcomp3,pcomp4,pcomp5 FROM producto where codfam = '$codfam'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
?>
    <table width="1400" border="0">
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
			$pcomp1         = $row['pcomp1'];
			$pcomp2         = $row['pcomp2'];
			$pcomp3         = $row['pcomp3'];
			$pcomp4         = $row['pcomp4'];
			$pcomp5         = $row['pcomp5'];
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
			$sumpripro		= 0;
			//echo $date1;
			//echo '<br>';
			//echo $date2;
			$sql1="SELECT sum(pripro) FROM detalle_venta where (codpro = '$codigo') and ((invfec >='$date2') and (invfec <='$date1'))";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
			$sumpripro         = $row1[0];
			}
			}
			if ($factor == 0)
			{
			$factor = 1;
			}
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
      <tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
	    <td width="24"><?php echo $i++?>-</td>
		<td width="258">
		<a id="l1" href="javascript:cerrar_popup(<?php echo $codigo?>,<?php echo $codmar?>)">
		  <?php if ($codigo == $cod){ ?>
          <b><?php echo substr($desprod,0,55);?></b>
          <?php } else {echo substr($desprod,0,55);}?>
		</a>		</td>
		<td width="56"><div align="right"><?php echo $sumpripro;?></div></td>
		<td width="56"><div align="right"><?php echo $pcomp1;?></div></td>
		<td width="56"><div align="right"><?php echo $pcomp2;?></div></td>
		<td width="56"><div align="right"><?php echo $pcomp3;?></div></td>
		<td width="56"><div align="right"><?php echo $pcomp4;?></div></td>
		<td width="56"><div align="right"><?php echo $pcomp5;?></div></td>
		<td width="39"><div align="right"><?php echo "C".$caja0; echo " "; echo "f".$frac0;?></div></td>
		<td width="40"><div align="right"><?php echo "C".$caja1; echo " "; echo "f".$frac1;?></div></td>
		<td width="40"><div align="right"><?php echo "C".$caja2; echo " "; echo "f".$frac2;?></div></td>
		<td width="40"><div align="right"><?php echo "C".$caja3; echo " "; echo "f".$frac3;?></div></td>
		<td width="40"><div align="right"><?php echo "C".$caja4; echo " "; echo "f".$frac4;?></div></td>
		<td width="40"><div align="right"><?php echo "C".$caja5; echo " "; echo "f".$frac5;?></div></td>
		<td width="40"><div align="right"><?php echo "C".$caja6; echo " "; echo "f".$frac6;?></div></td>
		<td width="40"><div align="right"><?php echo "C".$caja7; echo " "; echo "f".$frac7;?></div></td>
		<td width="40"><div align="right"><?php echo "C".$caja8; echo " "; echo "f".$frac8;?></div></td>
		<td width="40"><div align="right"><?php echo "C".$caja9; echo " "; echo "f".$frac9;?></div></td>
		<td width="40"><div align="right"><?php echo "C".$caja10; echo " "; echo "f".$frac10;?></div></td>
		<td width="40"><div align="right"><?php echo "C".$caja11; echo " "; echo "f".$frac11;?></div></td>
		<td width="40"><div align="right"><?php echo "C".$caja12; echo " "; echo "f".$frac12;?></div></td>
		<td width="40"><div align="right"><?php echo "C".$caja13; echo " "; echo "f".$frac13;?></div></td>
		<td width="40"><div align="right"><?php echo "C".$caja14; echo " "; echo "f".$frac14;?></div></td>
		<td width="40"><div align="right"><?php echo "C".$caja15; echo " "; echo "f".$frac15;?></div></td>
		<td width="40"><div align="right"><?php echo "C".$caja16; echo " "; echo "f".$frac16;?></div></td>
      </tr>
      <?php }
?>
  </table>
    <?php }
?>
</form>
</body>
</html>
