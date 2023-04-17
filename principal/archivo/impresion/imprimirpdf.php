<?php 
require_once('../../session_user.php');
//require_once('../../../funciones/fpdf/fpdf.php');
require('../../../funciones/fpdf/pdf_js.php');
require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../../../convertfecha.php');	//CONEXION A BASE DE DATOS
require_once('../../movimientos/montos_text.php');
//$venta   = $_SESSION['venta'];
$venta 	 = $_REQUEST['invnum'];
//require_once('venta_reg1.php');	//CONEXION A BASE DE DATOS
mysqli_query($conexion,"update venta set impreso = '1' where invnum = '$venta'");
$sql="SELECT invnum,nrovent,invfec,invfec,cuscod,usecod,codven,forpag,fecven,sucursal,correlativo,tipdoc FROM venta where invnum = '$venta'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$invnum       = $row['invnum'];		//codgio
		$nrovent      = $row['nrovent'];
		$invfec       = fecha($row['invfec']);
		$cuscod       = $row['cuscod'];
		$usecod       = $row['usecod'];
		$codven       = $row['codven'];
		$forpag       = $row['forpag'];
		$fecven       = $row['fecven'];
		$sucursal     = $row['sucursal'];
		$correlativo  = $row['correlativo'];
		$rd			  = $row['tipdoc'];
		if ($forpag == 'E')
		{
		$forma_pago = 'EFECTIVO';
		}
		if ($forpag == 'T')
		{
		$forma_pago = 'TARJETA';
		}
		if ($forpag == 'C')
		{
		$forma_pago = 'correlativo';
		}
		$var[nrovent] = $nrovent;
		$var[invfec]  = $invfec;
		$var[cuscod]  = $cuscod;
		$var[usecod]  = $usecod;
		$var[forpag]  = $forma_pago;
		$var[mont_bruto]   = $mont_bruto;
		$var[total_es]     = $total_es;
		$var[valor_vent1]  = $valor_vent1;
		$var[sum_igv]      = $sum_igv;
		$var[monto_total]  = $monto_total;
}
}
$sql="SELECT nomusu,abrev FROM usuario where usecod = '$usecod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		//$nomusu       = $row['nomusu'];
		$nomusu       = $row['abrev'];
		$var[nomusu]  = $nomusu;
}
}
$sql="SELECT desemp,rucemp,telefonoemp FROM datagen";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$desemp       = $row['desemp'];
		//$direccionemp = $row['direccionemp'];
		$rucemp       = $row['rucemp'];
		$telefonoemp  = $row['telefonoemp'];
		$var[desemp]  = $desemp;
		//$var[direccionemp]  = $direccionemp;
		$var[rucemp]  = $rucemp;
		$var[telefonoemp]  = $telefonoemp;
}
}
$sql="SELECT descli,dircli,ruccli FROM cliente where codcli = '$cuscod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$descli       = $row['descli'];
		$dircli       = $row['dircli'];
		$ruccli       = $row['ruccli'];
		$var[descli]  = $descli;
		$var[dircli]  = $dircli;
		$var[ruccli]  = $ruccli;
}
}
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
$sql="SELECT fdisp,flinpag,fini,fcanti,fcodpro,fmarca,fpreuni,fmonto,fdescuento,fnom,fref,fuente,contit,anchocod,anchonom,anchomarca,anchoreferencial,anchodescuento,anchocantidad,anchoprecio,anchosubtotal,dirloc FROM xcompa inner join xcompadetalle on xcompa.codloc = xcompadetalle.codloc where xcompa.codloc = '$sucursal' and tipdoc = '$rd'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$fdisp         = $row['fdisp'];
		$flinpag       = $row['flinpag'];
		$fini          = $row['fini'];
		$fcanti        = $row['fcanti'];
		$fmarca        = $row['fmarca'];
		$fcodpro       = $row['fcodpro'];
		$fpreuni       = $row['fpreuni'];
		$fmonto        = $row['fmonto'];
		$fdescuento    = $row['fdescuento'];
		$fnom          = $row['fnom'];
		$fref          = $row['fref'];
		$fuente        = $row['fuente'];
		$contit        = $row['contit'];
		$anchocod		= $row['anchocod'];
		$anchonom		= $row['anchonom'];
		$anchomarca		= $row['anchomarca'];
		$anchoreferencial	= $row['anchoreferencial'];
		$anchodescuento		= $row['anchodescuento'];
		$anchocantidad		= $row['anchocantidad'];
		$anchoprecio		= $row['anchoprecio'];
		$anchosubtotal		= $row['anchosubtotal'];
		$direccionemp		= $row['dirloc'];
		$var[direccionemp]  = $direccionemp;
		if ($fuente == 0)
		{
		$fuente = 12;
		}
}
}
$sql="SELECT count(invnum) FROM detalle_venta where invnum = '$venta'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$countdetventa     = $row[0];
}
}

if ($countdetventa <> 0)
{
$numpags1 = intval($countdetventa/$flinpag);
$numpags2 = intval($countdetventa%$flinpag);
}
if($numpags1==0)
{
$numpags1 = $numpags1 + 1;
}
else
{
	if($numpags2>0)
	{
	$numpags1 = $numpags1 + 1;
	}
}
function formato($c) {
printf("%08d",  $c);
} 
function formato1($c) {
printf("%06d",  $c);
} 
function orden($g)
{
	global $fcanti;
	global $fmarca;
	global $fcodpro;
	global $fpreuni;
	global $fmonto;
	global $fdescuento;
	global $fnom;
	global $fref;
	if ($fcanti == $g)
	{
	$vae = "CANTIDAD";
	}
	if ($fmarca == $g)
	{
	$vae = "MARCA";
	}
	if ($fcodpro == $g)
	{
	$vae = "CODIGO";
	}
	if ($fpreuni == $g)
	{
	$vae = "PRECIO";
	}
	if ($fmonto == $g)
	{
	$vae = "SUB TOTAL";
	}
	if ($fdescuento == $g)
	{
	$vae = "DCTOS";
	}
	if ($fnom == $g)
	{
	$vae = "DESCRIPCION";
	}
	if ($fref == $g)
	{
	$vae = "PRECIO REF";
	}
	return $vae;
}
function ancho($u)
{
	global $fcanti;
	global $fmarca;
	global $fcodpro;
	global $fpreuni;
	global $fmonto;
	global $fdescuento;
	global $fnom;
	global $fref;
	global $anchocod;
	global $anchonom;
	global $anchomarca;
	global $anchoreferencial;
	global $anchodescuento;
	global $anchocantidad;
	global $anchoprecio;
	global $anchosubtotal;
	if ($fcanti == $u)
	{
	$vae = $anchocantidad;
	//$vae = 5;
	}
	if ($fmarca == $u)
	{
	$vae = $anchomarca;
	//$vae = 5;
	}
	if ($fcodpro == $u)
	{
	$vae = $anchocod;
	//$vae = 5;
	}
	if ($fpreuni == $u)
	{
	$vae = $anchoprecio;
	//$vae = 5;
	}
	if ($fmonto == $u)
	{
	$vae = $anchosubtotal;
	//$vae = 5;
	}
	if ($fdescuento == $u)
	{
	$vae = $anchodescuento;
	//$vae = 5;
	}
	if ($fnom == $u)
	{
	$vae = $anchonom;
	//$vae = 5;
	}
	if ($fref == $u)
	{
	$vae = $anchoreferencial;
	//$vae = 5;
	}
	return $vae;
}
function muestra($y)
{
	global $codpro;
	global $desprod;
	global $marca;
	global $precio_ref;
	global $descuento;
	global $fraccion;
	global $canpro;
	global $prisal;
	global $pripro;
	global $fcanti;
	global $fmarca;
	global $fcodpro;
	global $fpreuni;
	global $fmonto;
	global $fdescuento;
	global $fnom;
	global $fref;
	if ($fcanti == $y)
	{
		if ($fraccion == "T")
		{ 
		$vea = $canpro; 
		} 
		if ($fraccion == "F") 
		{
		$canpro = "c".$canpro; 
		$vea = $canpro;
		}
	}
	if ($fmarca == $y)
	{
		$vea = $marca;
	}
	if ($fcodpro == $y)
	{
		$vea = $codpro;
	}
	if ($fpreuni == $y)
	{
		$vea = $prisal;
	}
	if ($fmonto == $y)
	{
		$vea = $pripro;
	}
	if ($fdescuento == $y)
	{
		$vea = $numero_formato_frances = number_format($descuento, 0, '.', ' ');
	}
	if ($fnom == $y)
	{
		$vea = $desprod;
	}
	if ($fref == $y)
	{
		$vea = $numero_formato_frances = number_format($precio_ref, 2, '.', ' ');
	}
	return $vea;
}
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
$descm = "GUIA REMISI�N";
}
if ($rd == 4)
{
$descm = "TICKET";
}
$sql1="SELECT anchodocumento,altodocumento,unidmedida,negrita FROM impresion where codlocal = '$sucursal' and tipodocumento = '$rd'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){	
while ($row1 = mysqli_fetch_array($result1)){
	$anchodocumento   = $row1['anchodocumento'];
	$altodocumento    = $row1['altodocumento'];
	$unidmedida    	  = $row1['unidmedida'];
	$negrita    	  = $row1['negrita'];
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
require_once('calcula_monto.php');	//CONEXION A BASE DE DATOS
$paginas = 1;
$limitpaginas = 1;
$totallineas = 0;
/////CLASE PDF
/*class PDF extends FPDF
{
	//Cabecera de p�gina
		function Header()
		{
			global $descm;
			$this->SetFont('Arial','B',12);
			$this->Cell(70); ////POSICION DE LA CABECERA
			$this->Cell(10,5,$descm,0,0,'C');
			$this->Ln(10);
		}
}*/
class PDF_AutoPrint extends PDF_JavaScript
{
function Header()
		{
			global $descm;
			$this->SetFont('Arial','B',12);
			$this->Cell(70); ////POSICION DE LA CABECERA
			//$this->Cell(10,5,$descm,0,0,'C');
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
while ($paginas <= $numpags1){
$limitpaginas = ($paginas - 1) * $flinpag;
/////////////
//$pdf=new FPDF('P',$unidmedida, array($anchodocumento,$altodocumento)); ////HOJA DEL DOCUMENTO
$pdf=new PDF_AutoPrint('P',$unidmedida, array($anchodocumento,$altodocumento)); 
$pdf->AddPage();
$pdf->SetAutoPageBreak(1,2); ///PASO A OTRA HOJA
$pdf->SetFont('Times',$fontnegrita,10);
$ii = 1;
$ic = 1;
while($ii <= $llinea1)
{
/*$pdf->Cell(10,4,'Title',0,0);
$pdf->Cell(30,4,'Hola como estas',0,0);
$pdf->Cell(20,4,'Probando',0,0);*/
/*for($i=1;$i<=40;$i++)
$pdf->Cell(4,4,'Imprimiendo hola '.$i,0,1);*/
					$ic = 1;
					$sql="SELECT columna,descbrev,campo,cuanto,linea,contitcampo FROM formato inner join titultabladet on formato.descripcion = titultabladet.codtab where sucursal = '$sucursal' and tipodoc = '$rd' and titulo = 'CB' and state = '1' and linea = '$ii' order by linea, columna";
					$result = mysqli_query($conexion,$sql);
					if (mysqli_num_rows($result)){
					while ($row = mysqli_fetch_array($result)){
							$lin           = $row['linea'];
							$col   		   = $row['columna'];
							$desc   	   = $row['descbrev'];
							$cam	       = $row['campo'];
							$long	       = $row['cuanto'];
							$contitcampo   = $row['contitcampo'];
							if ($ic == $col)
							{
								$sumlet = 0;
								$ddate  = 0;
								if($contitcampo == 1)
								{
								$sumlet = strlen($desc) + 1;
								$pdf->Cell($sumlet,4,$desc,0,0);
								}						
								if ($cam == 'hora'){ 
								//$hora  = (date('h:i')-1);
                                                                $hour  = date(G);
                                                                //$hour  = CalculaHora($hour);
                                                                $min   = date(i);
                                                                $hora  = $hour.":".$min;
								//$hora  = date('h:i');
								$ddate = strlen($hora) + 1;
								$pdf->Cell($ddate,4,$hora,0,0);
								}
								else
								{
									if ($cam == '***'){ 
										$pdf->Cell($long,4,$desc,0,0);
									}
									else
									{
									$long++;
									$pdf->Cell($long,4,$var[$cam],0,0);
									}
								}
								$totlet = $sumlet + $long + $ddate;
								$ic     = $totlet;
							}
							else
							{
								while($ic <= $col)
								{
								$pdf->Cell(1,4,' ',0,0);
								$ic++;
								}
								$sumlet = 0;
								$ddate  = 0;
								if($contitcampo == 1)
								{
								$sumlet = strlen($desc) + 1;
								$pdf->Cell($sumlet,4,$desc,0,0);
								}		
								if ($cam == 'hora')
								{ 
								//$hora  = (date('h:i')-1);
                                                                $hour  = date(G);  
                                                                //$hour  = CalculaHora($hour);
                                                                $min   = date(i);
                                                                $hora  = $hour.":".$min;
								//$hora  = date('h:i');
								$ddate = strlen($hora) + 1;
								$pdf->Cell($ddate,4,$hora,0,0);
								}
								else
								{
									if ($cam == '***'){ 
									$pdf->Cell($long,4,$desc,0,0);
									}
									else
									{
									$long++;
									$pdf->Cell($long,4,$var[$cam],0,0);
									}
								} 								
								$ic++;
								$totlet = $sumlet + $long + $ddate;
								$ic     = $totlet;
							}
					}
					//$pdf->Ln();
					}
					else
					{
						while($ic <= $ccolumna1)
						{
						$pdf->Cell(1,4,' ',0,0);
						//$pdf->Ln();
						$ic++;
						}
					}
$ii++;
$pdf->Ln();
}
$co = 0;
while($co < $fini)
{
$pdf->Ln();
$co++;
}
 if($contit == 1)
	  {
$pdf->Cell(ancho(1),4,orden(1),0,0);
$pdf->Cell(ancho(2),4,orden(2),0,0);
$pdf->Cell(ancho(3),4,orden(3),0,0);
$pdf->Cell(ancho(4),4,orden(4),0,0);
$pdf->Cell(ancho(5),4,orden(5),0,0);
$pdf->Cell(ancho(6),4,orden(6),0,0);
$pdf->Cell(ancho(7),4,orden(7),0,0);
$pdf->Cell(ancho(8),4,orden(8),0,0);
$pdf->Ln();
}

			$i = 1;
	        $sql="SELECT codpro,canpro,fraccion,factor,prisal,pripro,fraccion FROM detalle_venta where invnum = '$venta' limit $limitpaginas,$flinpag";
		    $result = mysqli_query($conexion,$sql);
		    if (mysqli_num_rows($result)){
			while ($row = mysqli_fetch_array($result)){
				$codpro       = $row['codpro'];	
				$canpro       = $row['canpro'];
				$fraccion     = $row['fraccion'];
				$factor       = $row['factor'];
				$prisal       = $row['prisal'];	
				$pripro       = $row['pripro'];	
				$fraccion     = $row['fraccion'];
				if ($fraccion == "F")
				{
				$cantemp = $canpro * $factor;
				}
				else
				{
				$cantemp = $canpro;
				}
				$sql1="SELECT codpro,desprod,codmar,factor,costpr,stopro,incentivado,prelis,prevta,preuni FROM producto where codpro = '$codpro'";
				$result1 = mysqli_query($conexion,$sql1);
				if (mysqli_num_rows($result1)){
				while ($row1 = mysqli_fetch_array($result1)){
					$codpro     = $row1['codpro'];
					$desprod    = $row1['desprod'];
					$codmar     = $row1['codmar'];
					$factor     = $row1['factor'];	
					$costpr     = $row1['costpr'];  ///COSTO PROMEDIO
					$stopro     = $row1['stopro'];	///STOCK EN UNIDADES DEL PRODUCTO GENERAL
					$cant       = $row1['cant'];	///STOCK EN UNIDADES DEL PRODUCTO POR LOCAL
					$idlocal    = $row1['idlocal'];	///CODIGO DEL LOCAL
					$inc	    = $row1['incentivado'];	
					$referencial= $row1['prelis'];	
					$prevta		= $row1['prevta'];
					$preuni     = $row1['preuni'];
				}
				}
				if (($referencial <> 0) and ($referencial <> $prevta))
				{
				$margenes       = ($margene/100)+1;
				$precio_ref     = $referencial/$factor;
				$precio_ref		= $precio_ref * $margenes;
				$precio_ref		= number_format($precio_ref,2,'.',',');
				$desc1	        = $precio_ref - $preuni;
					if ($desc1 < 0)
					{
					$descuento = 0;
					}
					else
					{
					$descuento      = (($precio_ref - $preuni)/$precio_ref)*100;
					}
				}
				else
				{
				$precio_ref		= $preuni;
				$descuento		= 0;
				}
				$sql1="SELECT ltdgen FROM titultabla where dsgen = 'MARCA'";
				$result1 = mysqli_query($conexion,$sql1);
				if (mysqli_num_rows($result1)){
				while ($row1 = mysqli_fetch_array($result1)){
					$ltdgen     = $row1['ltdgen'];	
				}
				}
				$sql1="SELECT destab,abrev FROM titultabladet where codtab = '$codmar' and tiptab = '$ltdgen'";
				$result1 = mysqli_query($conexion,$sql1);
				if (mysqli_num_rows($result1)){
				while ($row1 = mysqli_fetch_array($result1)){
					$marca     = $row1['destab'];
					$abrev     = $row1['abrev'];	
					if ($abrev == '')
					{
					$marca = substr($marca,0,6);
					}
					else
					{
					$marca = $abrev;
					}
				}
				}
				$pdf->Cell(ancho(1),4,muestra(1),0,0);
				$pdf->Cell(ancho(2),4,muestra(2),0,0);
				$pdf->Cell(ancho(3),4,muestra(3),0,0);
				$pdf->Cell(ancho(4),4,muestra(4),0,0);
				$pdf->Cell(ancho(5),4,muestra(5),0,0);
				$pdf->Cell(ancho(6),4,muestra(6),0,0);
				$pdf->Cell(ancho(7),4,muestra(7),0,0);
				$pdf->Cell(ancho(8),4,muestra(8),0,0);
				$pdf->Ln();
$i++;
}
}
///SI NO COMPLETO LAS LINEAS DEL CUERPO DEL DOCUMENTO flinpag = NUMERO DE LINEAS
if($i<($flinpag+1))
{
	while($i<=$flinpag)
	{
	$pdf->Ln();
	$i++;
	}
}
$ii = 1;
$ic = 1;
while($ii <= $llinea2)
{
					$ic = 1;
					$sql="SELECT columna,descbrev,campo,cuanto,linea,contitcampo FROM formato inner join titultabladet on formato.descripcion = titultabladet.codtab where sucursal = '$sucursal' and tipodoc = '$rd' and titulo = 'PIE' and state = '1' and linea = '$ii' and campo <> 'montext' order by linea, columna";
					$result = mysqli_query($conexion,$sql);
					if (mysqli_num_rows($result)){
					while ($row = mysqli_fetch_array($result)){
							$lin           = $row['linea'];
							$col   		   = $row['columna'];
							$desc   	   = $row['descbrev'];
							$cam	       = $row['campo'];
							$long	       = $row['cuanto'];
							$contitcampo   = $row['contitcampo'];
							if ($ic == $col)
							{
								$sumlet = 0;
								$sumtext = 0;
								if($contitcampo == 1)
								{
								$sumlet = strlen($desc) + 1;
								$pdf->Cell($sumlet,4,$desc,0,0);
								}	
								if ($cam == 'montext')
								{ 
								$text_letra = strtoupper(letras2($monto_total)); 
								$sumtext 	= strlen($text_letra) + 18;
								$pdf->Cell($sumtext,4,'Son: '.$text_letra.' Nuevos Soles',0,0);
								}	
								else
								{
									if ($cam == 'gracias')
									{ 
									$pdf->Cell($long,4,$desc,0,0);
									}
									else
									{
										if ($cam == 'gracias2')
										{ 
										$pdf->Cell($long,4,$desc,0,0);
										}	
										else
										{
											
											if ($cam == 'pagocon')
											{
											$text_letra = '0.00'; 
											$sumtext 	= strlen($text_letra) + 12;
											$pdf->Cell($sumtext,4,'S/. '.$text_letra,0,0);
											}
											else
											{
												if ($cam == 'vuelto')
												{
												$text_letra = $numero_formato_frances = number_format($monto_total, 2, '.', ' '); 
												$sumtext 	= strlen($text_letra) + 12;
												$pdf->Cell($sumtext,4,'S/. -'.$text_letra,0,0);
												}
												else
												{
												$vi = $numero_formato_frances = number_format($var[$cam], 2, '.', ' ');
												$countvi = strlen($vi) + 1;
												$pdf->Cell($countvi,4,$vi,0,0);
												}
											}
										}
									}
								}
								$totlet = $sumlet + $long + $sumtext;
								$ic     = $totlet;
							}
							else
							{
								while($ic <= $col)
								{
									$pdf->Cell(1,4,' ',0,0);
									 $ic++;
								}
								$sumlet = 0;
								if($contitcampo == 1)
								{
								$sumlet = strlen($desc) + 1;
								$pdf->Cell($sumlet,4,$desc,0,0);
								}
								if ($cam1 == 'montext')
								{ 
								$text_letra = strtoupper(letras2($monto_total)); 
								$sumtext 	= strlen($text_letra) + 18;
								$pdf->Cell($sumtext,4,'Son: '.$text_letra.' Nuevos Soles',0,0);
								}	
								else
								{
									if ($cam == 'gracias')
									{ 
									$pdf->Cell($long,4,$desc,0,0);
									}
									else
									{
										if ($cam == 'gracias2')
										{ 
										$pdf->Cell($long,4,$desc,0,0);
										}	
										else
										{
										$vi = $numero_formato_frances = number_format($var[$cam], 2, '.', ' ');
										$countvi = strlen($vi) + 1;
										$pdf->Cell($countvi,4,$vi,0,0);
										}
									}
								}
								$totlet = $sumlet + $long + $sumtext;
								$ic     = $totlet;
							}
					}
					$pdf->Ln();
					}
					else
					{
						while($ic <= $ccolumna2)
						{
						$pdf->Cell(1,4,' ',0,0);
						$ic++;
						}
					}
$ii++;
$pdf->Ln();
}
$paginas++;

}
$pdf->AutoPrint(true);
$pdf->Output();
?>