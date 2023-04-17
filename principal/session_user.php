<?php 
header('P3P: CP="CAO PSA OUR"'); 
session_start();
define("SEG_RAIZ", "/demo");
session_set_cookie_params(86400);
ini_set("session.cookie_lifetime", 86400);
ini_set('session.gc_maxlifetime', 86400);
if (!isset($_SESSION['codigo_user'])) {
    $url = SEG_RAIZ . "/index.php";
    header('Location: ' . $url);
    exit;
}else{
    $usuario = $_SESSION['codigo_user'];
}

?>
