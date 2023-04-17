<?php 
require_once('../../../conexion.php');
require_once('../../session_user.php');
$venta      = $_SESSION['venta'];
$CVendedor  = $_REQUEST['CVendedor'];
$correo     = $_REQUEST['correo'];
$Cliente    = $_REQUEST['cliente'];
$ClienteID  = $_REQUEST['cliente_ID'];
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
            mysqli_query($conexion, "UPDATE cliente set email = '$correo',ruccli='$RUC' where codcli = '$ClienteID'");
            mysqli_query($conexion, "UPDATE venta set cuscod = '$codcli' where invnum = '$venta'");
            mysqli_query($conexion, "UPDATE temp_venta set cuscod = '$codcli' where invnum = '$venta'");
        }
    }
}
if (strlen($correo)>0)
{
    $enviaMail = 1;
}
else
{
    $enviaMail = 0;
}
if (strlen($CVendedor)>0)
{
    header("Location: preimprimir.php?CodClaveVendedor=$CVendedor&&EstMail=$enviaMail");
}
else
{
    header("Location: preimprimir.php?EstMail=$enviaMail");
}

?>