<?php
require('../../../funciones/fpdf/pdf_js.php');
$var_tam_pagina = 'Letter'; //A3, A4, A5, Letter, Legal
$var_medida = 'mm';  //pt, mm, cm, in
$var_orientacion = 'P'; //P, L 
class PDF_AutoPrint extends PDF_JavaScript
{
	function AutoPrint($dialog = false)
	{
		//Open the print dialog or start printing immediately on the standard printer
		$param = ($dialog ? 'true' : 'false');
		$script = "print($param);";
		$this->IncludeJS($script);
	}

	function AutoPrintToPrinter($server, $printer, $dialog = false)
	{
		//Print on a shared printer (requires at least Acrobat 6)
		$script = "var pp = getPrintParams();";
		if ($dialog)
			$script .= "pp.interactive = pp.constants.interactionLevel.full;";
		else
			$script .= "pp.interactive = pp.constants.interactionLevel.automatic;";
		$script .= "pp.printerName = '\\\\\\\\" . $server . "\\\\" . $printer . "';";
		$script .= "print(pp);";
		$this->IncludeJS($script);
	}
}

/*$pdf=new FPDF('P',$unidmedida, array($anchodocumento,$altodocumento)); ////HOJA DEL DOCUMENTO
$pdf->AddPage();
$pdf->SetAutoPageBreak(1,2); ///PASO A OTRA HOJA
$pdf->SetFont('Times','',10);*/
$pdf = new PDF_AutoPrint($var_orientacion, $var_medida, array(100, 100));
$pdf->AddPage();
$pdf->SetAutoPageBreak(1, 2); ///PASO A OTRA HOJA
$pdf->SetFont('Arial', '', 20);
//$pdf->Text(90, 50, 'Print me!');
$pdf->Cell(10, 4, 'holaaaa', 0, 0);
//Open the print dialog
$pdf->AutoPrint(true);
$pdf->Output();
