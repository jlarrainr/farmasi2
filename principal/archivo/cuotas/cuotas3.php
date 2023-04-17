<?php include('../../session_user.php');
require_once('../../../conexion.php');
$anio    = $_REQUEST['anio'];
$mes     = $_REQUEST['meses'];
$anio    = $_REQUEST['anio'];
$text0 = $_REQUEST['text0'];
$text1 = $_REQUEST['text1'];
$text2 = $_REQUEST['text2'];
$text3 = $_REQUEST['text3'];
$text4 = $_REQUEST['text4'];
$text5 = $_REQUEST['text5'];
$text6 = $_REQUEST['text6'];
$text7 = $_REQUEST['text7'];
$text8 = $_REQUEST['text8'];
$text9 = $_REQUEST['text9'];
$text10 = $_REQUEST['text10'];
$text11 = $_REQUEST['text11'];
$text12 = $_REQUEST['text12'];
$text13 = $_REQUEST['text13'];
$text14 = $_REQUEST['text14'];
$text15 = $_REQUEST['text15'];
$text16 = $_REQUEST['text16'];
if ($mes == 1)
{
$dmes = "ENERO";
}
if ($mes == 2)
{
$dmes = "FEBRERO";
}
if ($mes == 3)
{
$dmes = "MARZO";
}
if ($mes == 4)
{
$dmes = "ABRIL";
}
if ($mes == 5)
{
$dmes = "MAYO";
}
if ($mes == 6)
{
$dmes = "JUNIO";
}
if ($mes == 7)
{
$dmes = "JULIO";
}
if ($mes == 8)
{
$dmes = "AGOSTO";
}
if ($mes == 9)
{
$dmes = "SETIEMBRE";
}
if ($mes == 10)
{
$dmes = "OCTUBRE";
}
if ($mes == 11)
{
$dmes = "NOVIEMBRE";
}
if ($mes == 12)
{
$dmes = "DICIEMBRE";
}
//echo $dmes;
//echo $anio;
$sql="SELECT mes,anio FROM cuota where mes = '$dmes' and anio = '$anio'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result) )
{
mysqli_query($conexion,"UPDATE cuota set s000 = '$text0',s001 = '$text1',s002 = '$text2',s003 = '$text3',s004 = '$text4',s005 = '$text5',s006 = '$text6',s007 = '$text7',s008 = '$text8',s009 = '$text9',s010 = '$text10',s011 = '$text11',s012 = '$text12',s013 = '$text13',s014 = '$text14',s015 = '$text15',s016 = '$text16' where mes = '$dmes' and anio = '$anio'");
}
else
{
mysqli_query($conexion,"INSERT INTO cuota (mes,anio,s000,s001,s002,s003,s004,s005,s006,s007,s008,s009,s010,s011,s012,s013,s014,s015,s016) values ('$dmes','$anio','$text0','$text1','$text2','$text3','$text4','$text5','$text6','$text7','$text8','$text9','$text10','$text11','$text12','$text13','$text14','$text15','$text16')");
}
header("Location: cuotas2.php?meses=$mes&anio=$anio");
?>