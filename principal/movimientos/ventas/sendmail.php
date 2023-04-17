<?php 
$venta      = $_SESSION['venta'];
$CVendedor  = $_REQUEST['CVendedor'];
$correo     = $_REQUEST['correo'];
$Cliente    = $_REQUEST['country'];
$ClienteID  = $_REQUEST['country_ID'];
$RUC        = $_REQUEST['ruc'];

if (strlen($ClienteID)>0)
{
    $sql="SELECT codcli,descli,dnicli FROM cliente where codcli = '$ClienteID'";
    $result = mysqli_query($conexion,$sql);
    if (mysqli_num_rows($result))
    {
        while ($row = mysqli_fetch_array($result))
        {
            $codcli         = $row["codcli"];
            $descli         = $row["descli"];
            $dnicli         = $row["dnicli"];
            mysqli_query($conexion, "UPDATE venta set cuscod = '$codcli' where invnum = '$venta'");

            if (isset($_SESSION['arr_detalle_venta'])) {
                $arr_detalle_venta = $_SESSION['arr_detalle_venta'];
            } else {
                $arr_detalle_venta = array();
            }
            $arrAux = array();
            foreach ($arr_detalle_venta as $detalle) {
                $detalle['cuscod'] = $codcli;
                $arrAux[] = $detalle;
            }
            $_SESSION['arr_detalle_venta'] = $arrAux;
        }
    }
}

if (strlen($correo)>0)
{
    $mail       = "Estimado(a). $Cliente, a continuaci�n se le remite una copia de su comprobante, debido a la compra realizada en nuestra empresa.<br><br>"
            . "<table style='width:100%;'><tr><td><b>Cliente:</b></td><td>$Cliente</td><tr><td><b>RUC:</b></td><td>$RUC</td></tr></table><br>"
            . "Muchas gracias por su preferencia.<br><br>Atentamente<br><br>FARMASIS";
    $titulo     = "Informaci�n de compra";
    $headers    = "MIME-Version: 1.0\r\n"; 
    $headers    .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
    $headers    .= "From: FARMASIS <admin@farmasis.net>\r\n";
    $bool       = mail($correo,$titulo,$mail,$headers);
}
if (strlen($CVendedor)>0)
{
    header("Location: preimprimir.php?CodClaveVendedor=$CVendedor");
}
else
{
    header("Location: preimprimir.php");
}

?>