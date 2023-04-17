<?php

include('../../session_user.php');
require_once ('../../../conexion.php');
require_once ('../../../convertfecha.php');
$invnum = $_SESSION['compras'];
$date1 = fecha1($_REQUEST['date1']);
$n1 = $_REQUEST['n1'];
$n2 = $_REQUEST['n2'];
//$moneda = $_REQUEST['moneda'];
$plazo = $_REQUEST['plazo'];
$date2 = fecha1($_REQUEST['date2']);
$fpag1 = $_REQUEST['fpag'];

$dafecto = $_REQUEST['dafecto'];
$dinafecto = $_REQUEST['dinafecto'];
$digv = $_REQUEST['digv'];
$dtotal = $_REQUEST['dtotal'];

$fpag = strtoupper($fpag1);

mysqli_query($conexion, "UPDATE movmae set fecdoc = '$date1', numero_documento = '$n1', numero_documento1 = '$n2', moneda = 'S',plazo = '$plazo',fecven = '$date2', dafecto ='$dafecto',dinafecto='$dinafecto',digv='$digv',dtotal='$dtotal',forpag = '$fpag' where invnum = '$invnum'");
echo $invnum;
