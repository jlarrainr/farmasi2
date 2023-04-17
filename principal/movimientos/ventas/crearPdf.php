<?php
require_once('../../../conexion.php');
$invnum     = $_REQUEST['invnum'];



require_once 'dompdf/autoload.inc.php';
// Reference the Dompdf namespace
use Dompdf\Dompdf;

// Instantiate and use the dompdf class
$dompdf = new Dompdf();
// Load HTML content
//echo $invnum;
$dompdf->loadHtml('  <table style="border-collapse: collapse;" border="1"; width="520"> 

        <tr>
           
            <td  height="18">
                <p align="center">
                 <font size=1>   PROCESO DE IMPRESION DE PDF</font>
                </p>
            </td>
            <td  height="18">
                <p><strong>SIGO PROBANDO ESTOY DESARROLLO, ESTE ES EL INVNUM PARA JALAR LOS DATOS: </strong>' . $invnum . '</p>
            </td>
           
        </tr>
        
</tbody>
</table>
</font>
   ');

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();
