<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../conexion.php';


for ($i = 1; $i <= 5; $i++) {

    $xmldasd .= '<cac:PaymentTerms>
                        <cbc:ID>FormaPago</cbc:ID>
                        <cbc:PaymentMeansID>Cuota' . $i . '</cbc:PaymentMeansID>
                        <cbc:Amount currencyID="PEN">120</cbc:Amount>
                     </cac:PaymentTerms><br>';
}
echo $xmldasd;
