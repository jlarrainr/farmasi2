<?php include('../session_user.php');
require_once('../../conexion.php');
require_once '../../convertfecha.php';
$btn        = $_POST['btn'];
$paginas    = $_POST['paginas'];
function quitar($mensaje)
{
    $mensaje = str_replace("<", "&lt;", $mensaje);
    $mensaje = str_replace(">", "&gt;", $mensaje);
    $mensaje = str_replace("\'", "&#39;", $mensaje);
    $mensaje = str_replace('\"', "&quot;", $mensaje);
    $mensaje = str_replace("\\\\", "&#92;", $mensaje);
    return $mensaje;
}
if ($_POST['ext']) {
    header("Location: mov_proveedor.php?pageno=$paginas");
}
if ($btn == 4) {
    /////GARABA O MODIFICA DATOS
    $nom            = $_POST['nom'];
    $ruc            = $_POST['ruc'];
    $direccion        = $_POST['direccion'];
    $departamento    = $_POST['departamento'];
    $provincia        = $_POST['provincia'];
    $representante    = $_POST['representante'];
    $distrito        = $_POST['distrito'];
    $fono            = $_POST['fono'];
    $tipo            = $_POST['tipo'];
    $val            = $_POST['val'];
    $lcredito        = $_POST['lcredito'];
    $nextel          = $_POST['nextel'];
    $mail           = $_POST['mail'];
    if ($departamento == 0)            ////PARA EL CASO DE MODIFICAR
    {
        $departamento    = $_POST['dpto'];
        $provincia        = $_POST['prov'];
        $distrito        = $_POST['dist'];
    }

    if ($fono == 0) {
        $fono  = $_POST['fon'];
    }

    $nom = trim(remplazar_string($nom));
    $direccion = trim(remplazar_string($direccion));


    if ($val == 1) {
        $cod        = $_POST['cod_nuevo'];
        //////////////////////////////////////////////////

        $sql = "SELECT rucpro, despro FROM proveedor WHERE rucpro <> '' and rucpro='$ruc'";
        $result = mysqli_query($conexion, $sql);
        if ($row = mysqli_fetch_array($result)) {
            header("Location: mov_proveedor.php?error=2&pageno=$paginas");
        } else {
            /////////VERIFICO QUE ESTE CODIGO NO SEA UTILIZADO
            $sql = "SELECT codpro FROM proveedor where codpro = '$cod'";
            $result = mysqli_query($conexion, $sql);
            if (mysqli_num_rows($result)) {
                $cod = $cod + 1;
                $t = 0;
                while ($t == 1) {
                    $sql1 = "SELECT codpro FROM proveedor where codpro = '$cod'";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        $cod = $cod + 1;
                    } else {
                        $t = 1;
                    }
                }
            }
            mysqli_query($conexion, "INSERT INTO proveedor (codpro,despro,dirpro,dptpro,propro,dispro,rucpro,telpro,tipcli,codusu,lcredito,representante,nextel,mail) values ('$cod','$nom','$direccion','$departamento','$provincia','$distrito','$ruc','$fono','$tipo','$usuario','$lcredito','$representante','$nextel','$mail')");
            header("Location: mov_proveedor.php?ok=1&ultimo=1&pageno=$paginas");
        }
    }


    ////MODIFICO DATOS
    if ($val == 2) {

        $codigo = isset($_REQUEST['cod_modif_del']) ? $_REQUEST['cod_modif_del'] : "";


        $sql = "SELECT despro,rucpro,codpro FROM proveedor where rucpro = '$ruc' ";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $descripcionProveedor    = $row["despro"];
                $rucProveedor            = $row["rucpro"];
                $codigoProveedor            = $row["codpro"];
            }
            $existe=1;
        }
        $nombreProveedor = trim($nom);
        $representante = trim($representante);

if($existe==1){

        if ($codigoProveedor == $codigo) {
            mysqli_query($conexion, "update proveedor set    rucpro = '$ruc',despro = '$nombreProveedor',dirpro = '$direccion', dptpro = '$departamento', propro = '$provincia', dispro = '$distrito', telpro = '$fono', tipcli = '$tipo',lcredito = '$lcredito',representante = '$representante',nextel = '$nextel',mail = '$mail'  where codpro = '$codigo'");

            header("Location: mov_proveedor.php?up=1&pageno=$paginas&country_ID=$codigo&search=1");
        } else {

            header("Location: mov_proveedor.php?error=2&pageno=$paginas&country_ID=$codigo&search=1");
        }
}else{
    
    
    mysqli_query($conexion, "update proveedor set    rucpro = '$ruc',despro = '$nombreProveedor',dirpro = '$direccion', dptpro = '$departamento', propro = '$provincia', dispro = '$distrito', telpro = '$fono', tipcli = '$tipo',lcredito = '$lcredito',representante = '$representante',nextel = '$nextel',mail = '$mail'  where codpro = '$codigo'");

            header("Location: mov_proveedor.php?up=1&pageno=$paginas&country_ID=$codigo&search=1");
}
    }
}
if ($btn == 5) {
    $codigo        = $_POST['cod_modif_del'];
    mysqli_query($conexion, "DELETE from proveedor where codpro = '$codigo'");
    header("Location: mov_proveedor.php?del=1");
}
if ($btn == 6) {
    header("Location: ../index.php");
}
