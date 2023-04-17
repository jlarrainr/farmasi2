<?php $numdoc = $_REQUEST['numdoc'];
echo  '<center><br><br><br><br><br><br><br><br><br><br><br><br><br>El Numero generado es: ';
echo $numdoc; echo " ";
echo '</center>';
$url = '../ing_salid.php';
echo '<META HTTP-EQUIV="Refresh" CONTENT="2;URL=' . $url . '">';
exit;
?>