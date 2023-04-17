<?php include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $desemp?></title>
<link href="../css/css/style1.css" rel="stylesheet" type="text/css" />
<link href="../css/css/tablas.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo3 {color: #3366CC; font-weight: bold; }
-->
</style>
<script>
var popUpWin=0;
function popUpWindow(URLStr, left, top, width, height)
{
  if(popUpWin)
  {
    if(!popUpWin.closed) popUpWin.close();
  }
  popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}
</script>
</head>

<body>
<?php $val     = $_REQUEST['val'];
$p1      = $_REQUEST['p1'];
$ord     = $_REQUEST['ord'];
$tip     = $_REQUEST['tip'];
$inicio  = $_REQUEST['inicio'];
$pagina  = $_REQUEST['pagina'];
$tot_pag = $_REQUEST['tot_pag'];
$registros  = $_REQUEST['registros'];
$sql="SELECT * FROM incentivado";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
?>
<table width="327" border="0">
  <tr>
    <td width="74"><span class="Estilo3"><u>NUMERO</u></span></td>
	<td width="62"><span class="Estilo3"><u>REG</u></span></td>
    <td width="67"><div align="center"><span class="Estilo3"><u>FECHA REG</u></span></div></td>
	<td width="67"><div align="center"><span class="Estilo3"><u>FECHA FIN</u></span></div></td>
	<td width="16"><div align="center"><span class="Estilo3"></span></div></td>
	<td width="15"><div align="center"><span class="Estilo3"></span></div></td>
  </tr>
</table>
<table width="327" border="0">
  <?php while ($row = mysqli_fetch_array($result)){
	$invnum    = $row['invnum'];
	$dateini   = $row['dateini'];
	$datefin   = $row['datefin'];
	$sql1="SELECT count(*) FROM incentivadodet where invnum = '$invnum'";
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result1)){
	while ($row1 = mysqli_fetch_array($result1)){
	$countt    = $row1[0];
	}
	}
  ?>
  <tr>
    <td width="74"><?php echo $invnum;?></td>
	<td width="62">(<?php echo $countt?>)</td>
    <td width="67"><div align="center"><?php echo $dateini;?></div></td>
    <td width="67"><div align="center"><?php echo $datefin;?></div></td>
	<td width="16"><div align="center">
	<a href="incentivohist1.php?invnum=<?php echo $invnum?>&val=<?php echo $val?>&p1=<?php echo $p1?>&ord=<?php echo $ord?>&tip=<?php echo $tip?>&inicio=<?php echo $inicio?>&pagina=<?php echo $pagina?>&tot_pag=<?php echo $tot_pag?>&registros=<?php echo $registros?>" target="marco1"><img src="../../../images/icon-16-checkin.png" width="16" height="16" border="0" title="ACTIVAR"/></a></div></td>
	<td width="15"><div align="center">
	<a href="javascript:popUpWindow('incentivohist2.php?invnum=<?php echo $invnum?>&val=<?php echo $val?>&p1=<?php echo $p1?>&ord=<?php echo $ord?>&&tip=<?php echo $tip?>&inicio=<?php echo $inicio?>&pagina=<?php echo $pagina?>&tot_pag=<?php echo $tot_pag?>&registros=<?php echo $registros?>', 400, 50, 600, 350)"><img src="../../../images/lens.gif" width="15" height="16" border="0" title="VER RELACION"/></a></div></td>
  </tr>
  <?php }
  ?>
</table>
<?php }
else
{
?>
<center><u><font color="#990000">NO EXISTEN REGISTROS</font></u></center>
<?php }
?>
</body>
</html>
