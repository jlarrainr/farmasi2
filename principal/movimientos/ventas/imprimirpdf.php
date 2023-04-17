<?php 
require_once('../../session_user.php');
require('../../../funciones/fpdf/pdf_js.php');
require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../../../convertfecha.php');	//CONEXION A BASE DE DATOS
$venta 	 = $_REQUEST['vt']; //410
$rd 	 = $_REQUEST['rd']; //2
//$venta 	 = 410; //410
//$rd 	 = 2; //2
$sql="SELECT invnum,nrovent,invfec,cuscod,invtot,pagacon,vuelto,nomcliente,tipdoc,hora FROM venta where invnum = '$venta'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$invnum       = $row['invnum'];		//codgio
		$nrovent      = $row['nrovent'];
		$invfec       = $row['invfec'];
		$cuscod       = $row['cuscod'];
		$invtot       = $row['invtot'];
		$pagacon      = $row['pagacon'];
		$vuelto       = $row['vuelto'];
		$nomcliente   = $row['nomcliente'];
		$tipdoc       = $row['tipdoc'];
		$hora         = $row['hora'];
}
}
$sql1="SELECT anchodocumento,altodocumento,unidmedida,negrita,size FROM impresion where codlocal = '1' and tipodocumento = '4'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){	
while ($row1 = mysqli_fetch_array($result1)){
	$anchodocumento   = $row1['anchodocumento'];
	$altodocumento    = $row1['altodocumento'];
	$unidmedida    	  = $row1['unidmedida'];
	$negrita	  	  = $row1['negrita'];
	$size    	  	  = $row1['size'];
}
}
if($negrita == '1')
{
$fontnegrita = "B";
}
else
{
$fontnegrita = "";
}
if($tipdoc == 1)
{
$documento = "TICKET DE CAJA";
}
if($tipdoc == 2)
{
$documento = "FACTURA";
}
if($tipdoc == 4)
{
$documento = "TICKET DE CAJA";
}
function formato($c) {
printf("%08d",  $c);
} 
/////CLASE PDF
class PDF_AutoPrint extends PDF_JavaScript
{
function Header()
		{
			global $descm;
			$this->SetFont('Arial','B',12);
			$this->Cell(70); ////POSICION DE LA CABECERA
			$this->Cell(10,5,$descm,0,0,'C');
			$this->Ln(10);
		}
function AutoPrint($dialog=false)
{
	//Open the print dialog or start printing immediately on the standard printer
	$param=($dialog ? 'true' : 'false');
	$script="print($param);";
	$this->IncludeJS($script);
}

function AutoPrintToPrinter($server, $printer, $dialog=false)
{
	//Print on a shared printer (requires at least Acrobat 6)
	$script = "var pp = getPrintParams();";
	if($dialog)
		$script .= "pp.interactive = pp.constants.interactionLevel.full;";
	else
		$script .= "pp.interactive = pp.constants.interactionLevel.automatic;";
	$script .= "pp.printerName = '\\\\\\\\".$server."\\\\".$printer."';";
	$script .= "print(pp);";
	$this->IncludeJS($script);
}
}
$pdf=new PDF_AutoPrint('P',$unidmedida, array($anchodocumento,$altodocumento)); 
$pdf->AddPage();
$pdf->SetAutoPageBreak(1,2); ///PASO A OTRA HOJA
$pdf->SetFont('Times',$fontnegrita,$size);
$pdf->Cell(26);
$pdf->Cell(10,8,$documento,0,0);
$pdf->Ln();
$pdf->Cell(28);
$pdf->Cell(20,10,$nrovent,0,0);
$pdf->Ln();
$pdf->Cell(1,4,"NOMBRE",0,0);
$pdf->Cell(26);
$pdf->Cell(35,4,$nomcliente,0,0);
$pdf->Ln();
$pdf->Cell(1,4,"FECHA",0,0);
$pdf->Cell(26);
$pdf->Cell(20,4,fecha($invfec),0,0);
$pdf->Cell(10);
$pdf->Cell(20,4,"HORA",0,0);
$pdf->Cell(10,4,$hora,0,0);
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(1,4,"******************************",0,0);
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(1,4,"MONTO",0,0);
$pdf->Cell(26);
$pdf->Cell(35,4,$invtot,0,0);
$pdf->Ln();
$pdf->Cell(1,4,"PAGADO",0,0);
$pdf->Cell(26);
$pdf->Cell(35,4,$pagacon,0,0);
$pdf->Ln();
$pdf->Cell(1,4,"VUELTO",0,0);
$pdf->Cell(26);
$pdf->Cell(35,4,$vuelto,0,0);
$pdf->Ln();
$pdf->AutoPrint(true);
$pdf->Output();
?>