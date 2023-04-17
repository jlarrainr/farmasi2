<?php $prod  = $_REQUEST['prod'];
$marca = $_REQUEST['marca'];
$cr    = $_REQUEST['cr'];
?>
<script>
	location.href='stockmin2.php?codpro=<?php echo $prod?>&marca=<?php echo $marca?>&cr=<?php echo $cr?>&val=1';
</script>
<?php ?>