<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
<link href="/css/ip.css" rel="stylesheet" type="text/css" />
</head>
<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
//require_once("../../../funciones/functions.php");
require_once("../../../funciones/funct_principal.php");	//IMPRIMIR-NUMEROS ENTEROS-DECIMALES
require_once("funciones/ip.php");
?>
<body>
<table width="640" border="0" align="center" class="tabla2">
  <tr>
    <td width="640"><table width="624" border="0" align="center">
      <tr>
        <td width="18" class="text_combo_select">N&ordm;</td>
        <td width="211" class="text_combo_select">LOCAL</td>
        <td width="293" class="text_combo_select">IP</td>
        <td width="40" class="text_combo_select">&nbsp;</td>
        <td width="40" class="text_combo_select">&nbsp;</td>
      </tr>
    </table>
      <div align="center"><img src="../../../images/line.jpg" width="620" height="1"/></div>
      <form id="form1" name="form1" method="post" action="">
	  <?php $cod = $_REQUEST['cod'];
	  $add = $_REQUEST['add'];
	  $sql="SELECT codip,ip,codloc FROM numberip order by codloc";
	  $result = mysqli_query($conexion,$sql);
	  if (mysqli_num_rows($result)){
	  ?>
        <table width="624" border="0" align="center">
          <?php while ($row = mysqli_fetch_array($result)){
			$codip         	= $row['codip'];
			$ip         	= $row['ip'];		
			$codloc         = $row['codloc'];	
			  $sql1="SELECT nomloc FROM xcompa where codloc = '$codloc'";
			  $result1 = mysqli_query($conexion,$sql1);
			  if (mysqli_num_rows($result1)){	
			  while ($row1 = mysqli_fetch_array($result1)){
					$nomloc = $row1['nomloc'];		
			  }
			  }
		   $i++;
		  ?>
		  <tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
            <td width="18"><?php echo $i?></td>
            <td width="211"><?php echo $nomloc?></td>
            <td width="333">
			<?php if ($add == 1){ ?>
            <input type="text" name="ip" onkeypress="return decimal(event)" value="<?php echo $ip?>"/>
            <?php } else { echo $ip; }?>
			</td>
            <td width="20"><div align="center">
			<?php if ($add == 1){ ?>
			<input name="codip" type="hidden" id="codip" value="<?php echo $codip?>" />
			<input name="button" type="button" id="boton" onclick="validar_ip()" alt="GUARDAR"/>
			<?php }
			else
			{
			?>
			<a href="ip2.php?cod=<?php echo $codip?>&add=1"><img src="../../../images/edit_16.png" width="16" height="16" border="0"/></a>
			 <?php }
			 ?>
            </div></td>
            <td width="20">
			<div align="center">
			<?php if ($add == 1){ ?>
			<input name="button2" type="button" id="boton1" onclick="validar_grid()" alt="ACEPTAR"/>
			<?php }
			else
			{
			?>
			<a href="del_ip.php?cod=<?php echo $codip?>"><img src="../../../images/del_16.png" width="16" height="16" border="0"/></a>
            <?php }
			?>
            </div></td>
          </tr>
		  <?php }
		  ?>
        </table>
		<?php }
		else
		{
		?>
		<center>NO EXISTEN IP CONFIGURADAS EN EL SISTEMA</center>
		<?php }
		?>
      </form>
      </td>
  </tr>
</table>
</body>
</html>
