<?php
require_once('../../../funciones/fpdf/fpdf.php');
require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
$sql="SELECT linea FROM formato where tipodoc = '$rd' and titulo = 'CB' order by linea desc limit 1";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$llinea1       = $row['linea'];
}
}
$sql="SELECT columna FROM formato where tipodoc = '$rd' and titulo = 'CB' order by columna desc limit 1";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$ccolumna1     = $row['columna'];
}
}
$sql="SELECT linea FROM formato where tipodoc = '$rd' and titulo = 'PIE' order by linea desc limit 1";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$llinea2       = $row['linea'];
}
}
$sql="SELECT columna FROM formato where tipodoc = '$rd' and titulo = 'PIE' order by columna desc limit 1";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$ccolumna2     = $row['columna'];
}
}
$rd = 2;
if ($rd == 1)
{
$descm = "FACTURA";
}
if ($rd == 2)
{
$descm = "BOLETA DE VENTA";
}
if ($rd == 3)
{
$descm = "GUIA REMISIÓN";
}
if ($rd == 4)
{
$descm = "TICKET";
}
class PDF extends FPDF
{
//Cabecera de página
function Header()
{
    global $descm;
	$this->SetFont('Arial','B',12);
    $this->Cell(70); ////POSICION DE LA CABECERA
    $this->Cell(10,5,$descm,0,0,'C');
    $this->Ln(10);
}
}
$pdf=new PDF('P','mm', array(180,80)); ////HOJA DEL DOCUMENTO
$pdf->AddPage();
$pdf->SetAutoPageBreak(1,2); ///PASO A OTRA HOJA
$pdf->SetFont('Times','',10);
$pdf->Cell(10,4,'Title',0,0);
$pdf->Cell(30,4,'Hola como estas',0,0);
$pdf->Cell(20,4,'Probando',0,0);
$ii = 1;
$ic = 1;
$llinea1 = 5;
while($ii <= $llinea1)
{
	$pdf->Cell(4,4,'rrrr '.$ii,0,1);
	$ii++;
}
/*for($i=1;$i<=40;$i++)
    $pdf->Cell(4,4,'Imprimiendo hola '.$i,0,1);*/
$pdf->Output();
?>