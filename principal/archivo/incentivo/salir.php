<?php $val 	 = $_REQUEST['val'];
$p1	 	 = $_REQUEST['p1'];
$ord 	 = $_REQUEST['ord'];
$tip 	 = $_REQUEST['tip'];
$cod     = $_REQUEST['cod'];
$inicio  = $_REQUEST['inicio'];
$pagina  = $_REQUEST['pagina'];
$tot_pag = $_REQUEST['tot_pag'];
$registros  = $_REQUEST['registros'];
?>
<script>
	location.href='incentivo2.php?val=<?php echo $val?>&p1=<?php echo $p1?>&ord=<?php echo $ord?>&tip=<?php echo $tip?>&inicio=<?php echo $inicio?>&pagina=<?php echo $pagina?>&tot_pag=<?php echo $tot_pag?>&registros=<?php echo $registros?>';
</script>