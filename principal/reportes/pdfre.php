<?php

require_once('fpdf/fpdf.php');

class PDF extends FPDF {

// Cabecera de página
    function Header() {

        $this->SetFont('Arial', 'B', 8);
        // Movernos a la derecha
        $this->Cell(40);
        // Título
        $this->Cell(115, 10, 'REPORTE DE REGISTRO DE VENTA', 1, 0, 'C');
        // Salto de línea
        $this->Ln(20);

        $this->cell(13, 8, 'FECHA', 1, 0, 'L', 0);
        $this->cell(5, 8, 'TH', 1, 0, 'R', 0);
        $this->cell(11, 8, 'SERIE', 1, 0, 'L', 0);
        $this->cell(9, 8, 'COR', 1, 0, 'L', 0);
        $this->cell(7, 8, 'ACT', 1, 0, 'L', 0);
        $this->cell(16, 8, 'RUC O DNI', 1, 0, 'L', 0);
        $this->cell(35, 8, 'CLI', 1, 0, 'C', 0);
        $this->cell(12, 8, 'C.PRO', 1, 0, 'L', 0);
        $this->cell(52, 8, 'PRODUCTO', 1, 0, 'L', 0);
        $this->cell(11, 8, 'IMPU', 1, 0, 'R', 0);
        $this->cell(11, 8, 'V.VEN', 1, 0, 'L', 0);

        $this->cell(11, 8, 'TOTAL', 1, 1, 'R', 0);
    }

// Pie de página
    function Footer() {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

}

include('../session_user.php');
require_once('../../conexion.php'); //CONEXION A BASE DE DATOS
require_once('../../titulo_sist.php');
require_once('../../convertfecha.php'); //CONEXION A BASE DE DATOS


$dat1 = $_REQUEST['date1'];
$dat2 = $_REQUEST['date2'];

$date1 = fecha1($dat1);
$date2 = fecha1($dat2);

$sql = "SELECT codloc FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        //$nomusu       = $row['nomusu'];
        $local = $row['codloc'];
    }
}

$sql = "SELECT V.invtot,V.sucursal,V.invfec,V.igv, V.tipdoc,V.nrofactura,V.correlativo,V.cuscod,D.costpr,D.codpro,D.canpro,D.fraccion,D.factor,D.prisal FROM venta as V INNER JOIN detalle_venta AS D ON D.invnum = V.invnum WHERE D.invfec between '$date1' and '$date2' and V.sucursal = '$local'  ";
$result = mysqli_query($conexion, $sql);

$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 6);

while ($row = mysqli_fetch_array($result)) {

    $invfec = $row['invfec'];
    $invnum = $row['invnum'];
    $tipdoc = $row['tipdoc'];
    $nrofactura = $row['nrofactura'];
    $correlativo = $row["correlativo"];
    $cuscod = $row["cuscod"];
    $codpro = $row["codpro"];
    $sucursal = $row["sucursal"];
    $igv = $row["igv"];
    $canpro = $row["canpro"];
    $fraccion = $row["fraccion"];
    $factor = $row["factor"];
    $prisal = $row["prisal"];
    $costpr = $row["costpr"];
    $invtot = $row["invtot"];

    $nrofactura2 = substr($nrofactura, 0, 4);

    $sql3 = "SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
    $result3 = mysqli_query($conexion, $sql3);
    while ($row3 = mysqli_fetch_array($result3)) {
        $nloc = $row3["nomloc"];
        $nombre = $row3["nombre"];
        if ($nombre == '') {
            $sucur = $nloc;
        } else {
            $sucur = $nombre;
        }
    }
    $sql2 = "SELECT activo,desprod,igv,icbper FROM producto WHERE codpro='$codpro' and eliminado='0' ";
    $result1 = mysqli_query($conexion, $sql2);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $activo = $row1['activo'];
            $desprod = $row1['desprod'];
            $igvp = $row1['igv'];
            $icbper = $row1['icbper'];
        }
    }

    $sql2 = "SELECT descli,dnicli,ruccli FROM cliente WHERE codcli='$cuscod' ";
    $result1 = mysqli_query($conexion, $sql2);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $descli = $row1['descli'];
            $dnicli = $row1['dnicli'];
            $ruccli = $row1['ruccli'];
        }
    }

    $sql1 = "SELECT nomusu FROM usuario where usecod = '$usecod'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $user = $row1['nomusu'];
        }
    }
    if (($igvp == 0) && ($icbper == 0)) {
        $MontoDetalle = $prisal * $canpro;
        $SumInafectos = $SumInafectos + $MontoDetalle;
    }

    $SumGrabado = $invtot - ($igv + $SumInafectos);

    if ($dnicli <> "") {
        $VA = "DNI" . "--" . $dnicli;
    } else {
        $VA = "RUC" . "--" . $ruccli;
    }


    $pdf->cell(13, 5, fecha($invfec), 1, 0, 'L', 0);
    $pdf->cell(5, 5, $tipdoc, 1, 0, 'C', 0);
    $pdf->cell(11, 5, $nrofactura2, 1, 0, 'C', 0);
    $pdf->cell(9, 5, $correlativo, 1, 0, 'C', 0);
    $pdf->cell(7, 5, $activo, 1, 0, 'C', 0);
    $pdf->cell(16, 5, $VA, 1, 0, 'L', 0);
    $pdf->cell(35, 5, $descli, 1, 0, 'L', 0);
    $pdf->cell(12, 5, $codpro, 1, 0, 'C', 0);
    $pdf->cell(52, 5, $desprod, 1, 0, 'L', 0);
    $pdf->cell(11, 5, $igv, 1, 0, 'R', 0);
    $pdf->cell(11, 5, $SumGrabado, 1, 0, 'L', 0);

    $pdf->cell(11, 5, $invtot, 1, 1, 'R', 0);
}


$pdf->Output();
?>
