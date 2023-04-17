<?php $codigo_busk = $_REQUEST['codigo_busk'];
$add   = $_REQUEST['add'];
$typpe = $_REQUEST['typpe'];
$val   = $_REQUEST['val'];
$tipo  = $_REQUEST['tipo'];
?>
<script>
	location.href='../venta_index2.php?add=<?php echo $add?>&typpe=<?php echo $typpe?>&val=<?php echo $val?>&tipo=<?php echo $tipo?>&codigo_busk=<?php echo $codigo_busk?>';
</script>