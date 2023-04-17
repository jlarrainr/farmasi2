<?php
if (isset($_SESSION['tventa'])) {
    $tventa = $_SESSION['tventa'];
} else {
    $tventa = "";
}


if (!(strlen($tventa) > 0))
{
    $url = SEG_RAIZ . "/index.php";
    header('Location: ' . $url);
    exit;
}
?>