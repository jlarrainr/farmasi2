<?php include('../../session_user.php');
require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo1 {
	color: #666666;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<?php $local = $_REQUEST['local'];
$tip   = $_REQUEST['tip'];	////1 = pie y cabecera, 2 = contenido
$tipdocu    = $_REQUEST['tipdocu'];
if ($tip == 1)
{
?>
<table width="700" border="0" bgcolor="#FFFF99">
  <tr>
    <td width="166"><span class="Estilo1">DESCRIPCION</span></td>
    <td width="46"><div align="center" class="Estilo1">LINEA</div></td>
    <td width="56"><div align="center" class="Estilo1">COLUMNA</div></td>
    <td width="204"><div align="center" class="Estilo1">TIPO DOC </div></td>
    <td width="107"><div align="center" class="Estilo1">CANT. LINEAS </div></td>
    <td width="84"><div align="center" class="Estilo1"><div align="left">TITULO</div></div></td>
	<td width="10"></td>
  </tr>
</table>
<table width="700" border="0">
<?php $i=0;
$sql="SELECT codformato,descripcion,linea,columna,tipodoc,cuanto,titulo,descbrev FROM formato where sucursal = '$local' and tipodoc = '$tipdocu' order by titulo,linea,columna";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){	
while ($row = mysqli_fetch_array($result)){
	$i++;
	$codformato  = $row['codformato'];	
	$descripcion = $row['descripcion'];	
	$linea		 = $row['linea'];	
	$columna	 = $row['columna'];	
	$tipodoc	 = $row['tipodoc'];	
	$cuanto		 = $row['cuanto'];	
	$titulo		 = $row['titulo'];	
	$descbrev	 = $row['descbrev'];		
	$sql1="SELECT destab FROM titultabladet where codtab = '$descripcion'";
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result1)){	
	while ($row1 = mysqli_fetch_array($result1)){
	$destab = $row1['destab'];	
	}
	}
	if ($tipodoc==1)
	{
	$desc_doc = "FACTURA";
	}
	if ($tipodoc==2)
	{
	$desc_doc = "BOLETA";
	}
	if ($tipodoc==3)
	{
	$desc_doc = "GUIA REMISION";
	}
	if ($tipodoc==4)
	{
	$desc_doc = "TICKET";
	}
	$t = $i%2;
	if ($t == 1)
	{
	$color = "#E0F4D7";
	}
	else
	{
	$color = "#EAEFF3";
	}
?>
  <tr bgcolor="<?php echo $color;?>" onmouseover="this.style.backgroundColor='#FEFFBF';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='<?php echo $color?>';">
    <td width="162"><?php echo $descbrev?></td>
    <td width="45"><div align="center"><?php echo $linea?></div></td>
    <td width="55"><div align="center"><?php echo $columna?></div></td>
    <td width="201"><div align="center"><?php echo $desc_doc?></div></td>
    <td width="104"><div align="center"><?php echo $cuanto?></div></td>
    <td width="71"><?php echo $titulo?></td>
	<td width="16">
	<a href="local2.php?local=<?php echo $local?>&tip=<?php echo $tip?>&codformato=<?php echo $codformato?>&tipdocu=<?php echo $tipdocu;?>&val=1" target="main"><img src="../../../images/edit_16.png" width="16" height="16" border="0"/></a>	</td>
	<td width="16">
	<a href="delete.php?local=<?php echo $local?>&tip=<?php echo $tip?>&codformato=<?php echo $codformato?>&tipdocu=<?php echo $tipdocu;?>&val=1" target="main"><img src="../../../images/del_16.png" width="16" height="16" border="0"/></a>	</td>
  </tr>
<?php }
}
?>
</table>
<?php }
?>
</body>
</html>
