<?php
if (isset($_SESSION['venta'])) {
    $venta = $_SESSION['venta'];
} else {
    $venta = "";
}


if (!(strlen($venta) > 0))
{
    $url = SEG_RAIZ . "/index.php";
    header('Location: ' . $url);
    exit;
}
?>