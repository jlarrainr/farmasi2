<?php
//   error_reporting(E_ALL);
// ini_set('display_errors', '1');

require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
//require_once '../../../convertfecha.php';
//require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
//require_once('../../../titulo_sist.php');
include('../../session_user.php');
require 'fpdf/fpdf.php';
include 'barcode.php';



require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS


$invnum = $_SESSION['consulta_comp'];


$codpro1 = isset($_REQUEST['codpro']) ? ($_REQUEST['codpro']) : ""; ///APLICO EL IGV



//echo $codpro1;



$sql = "SELECT codloc,nomusu FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$codloc       = $row['codloc'];			//////OBTENGO EL CODIGO DEL LOCAL ACTUAL O DESTINO
		$user    	  = $row['nomusu'];
	}
}

$sql1 = "SELECT  qtypro,qtyprf FROM movmov as MOV INNER JOIN movmae as MA on MA.invnum=MOV.invnum where MOV.invnum='$invnum' and MOV.codpro='$codpro1'";
$result = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$qtypro       = $row['qtypro'];			//////OBTENGO EL CODIGO DEL LOCAL ACTUAL O DESTINO
		$qtyprf    	  = $row['qtyprf'];
	}
}





$sqlPro = "SELECT desprod,codbar from producto where codpro='$codpro1'";
$resultPro = mysqli_query($conexion, $sqlPro);


if (mysqli_num_rows($resultPro)) {

	$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 20);
$y = $pdf->GetY();

	while ($row1 = mysqli_fetch_array($resultPro)) {
		$desprod         = $row1['desprod'];
		$codbar         = $row1['codbar'];

		barcode('codigos/'.$codbar.'.png', $codbar, 20, 'horizontal', 'code128', true);

$pdf->Image('codigos/'.$codbar.'.png',10,$y,50,0,'PNG');

$y = $y+15;
	}

	$pdf->Output();	
}

//echo $sql; 


//eecho $sqlPro;


?>



<!-- 
<center>
<img src="barcode.php?text=<?php echo $codbar; ?> &size=50&orientation=horizontal&codetype=Code128&print=true">

</center> -->













<!--  DESCOMENTAR EN CASO SEA NECESARIO USAR WHILE PARA CONSUTLAR TODOS LOS PRODUCTOS 

    <form name="form1">
		<table width="100%" border="0">
			<tr>
				<td>

					<?php $sql = "SELECT  codpro,qtypro,qtyprf,codloc,usecod FROM movmov as MOV INNER JOIN movmae as MA on MA.invnum=MOV.invnum where MOV.invnum='$invnum' ";
					$result = mysqli_query($conexion, $sql);

					//echo $sql;
					if (mysqli_num_rows($result)) {
					?>
						<table width="100%" border="0" align="center" id="customers">
							
							<tbody id="gtnp_Listado_Datos">
								<?php while ($row = mysqli_fetch_array($result)) {
									$codpro         = $row['codpro'];
									$usecod         = $row['usecod'];
									$sucursal       = $row['codloc'];
									$qtypro       = $row['qtypro'];
									$qtyprf       = $row['qtyprf'];

									$sqlPro = "SELECT desprod,codbar from producto where codpro='$codpro1'";
									$resultPro = mysqli_query($conexion, $sqlPro);
									if (mysqli_num_rows($resultPro)) {
										while ($row1 = mysqli_fetch_array($resultPro)) {
											$desprod         = $row1['desprod'];
											$codbar         = $row1['codbar'];
										}
									}

									//echo $sqlPro;

									$sql1 = "SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
									$result1 = mysqli_query($conexion, $sql1);
									if (mysqli_num_rows($result1)) {
										while ($row1 = mysqli_fetch_array($result1)) {
											$nomloc         = $row1['nomloc'];
											$nombre         = $row1['nombre'];
										}
									}
									if ($nombre <> "") {
										$nomloc = $nombre;
									}
									$sql1 = "SELECT nomusu FROM usuario where usecod = '$usecod'";
									$result1 = mysqli_query($conexion, $sql1);
									if (mysqli_num_rows($result1)) {
										while ($row1 = mysqli_fetch_array($result1)) {
											$nomusu         = $row1['nomusu'];
										}
									}
								?>

                                            <th>
											
                                            <img src="barcode.php?text=<?php echo $codbar; ?> &size=50&orientation=horizontal&codetype=Code128&print=true" > 
                                                
                                            </th>
									
								<?php }
								?>
							</tbody>
						</table>
					<?php }
					?>
				</td>
			</tr>
		</table>
	</form> -->