<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
$BASE_PATCH_4 = dirname(__FILE__);
$BASE_PATCH_3 = dirname($BASE_PATCH_4);
$BASE_PATCH_2 = dirname($BASE_PATCH_3);
$BASE_PATCH_1 = dirname($BASE_PATCH_2);
$BASE_PATCH_0 = dirname($BASE_PATCH_1);
$BASE_PATCH_SUNAT = $BASE_PATCH_0 . "/principal/sunat/ApiFacturacion/";

include_once $BASE_PATCH_0 . '/conexion.php';
include_once $BASE_PATCH_0 . '/function_sunat.php';

//principal/sunat/ApiFacturacion

$accion = $_POST['action'];

controlador($accion, $conexion);

/**
 * 
 * @param type $accion
 * @param type $conexion
 */
function controlador($accion, $conexion) {


    //==================================================================
    //AUTOR ROMMEL MERCADO
    //FECHA: 19-12-2021
    //==================================================================
    switch ($accion) {

        case 'GUARDAR_NC':
            $id = addslashes($_POST['id']);
            FnGenerateXmlAndSendNc($id, $conexion);
            break;
        case 'GUARDAR_NC_MASIVO':

            $date = addslashes($_POST['date']);
            $sucursal = addslashes($_POST['sucursal']);
            FnDeclaracionMasivaNCFactura($date, $sucursal, $conexion);
            break;
        case 'GUARDAR_VENTA':
            $id = addslashes($_POST['id']);
            FnGenerateXmlAndSend($id, $conexion);
            break;

        case 'GUARDAR_VENTA_MASIVO':

            $date = addslashes($_POST['date']);
            $sucursal = addslashes($_POST['sucursal']);
            FnDeclaracionMasivaFactura($date, $sucursal, $conexion);
            break;

        case "ENVIO_RESUMEN":
            $date = addslashes($_POST['date']);
            $sucursal = addslashes($_POST['sucursal']);
            $typesummary = addslashes($_POST['typesummary']);
            FnSendGenerateSummary($date, $sucursal, $typesummary, $conexion);
            break;
        case "ENVIO_RESUMEN_NC":
            $date = addslashes($_POST['date']);
            $sucursal = addslashes($_POST['sucursal']);
            $typesummary = addslashes($_POST['typesummary']);
            FnSendGenerateSummary($date, $sucursal, $typesummary, $conexion);
            break;
            case 'GUARDAR_GUIA':
                $id = addslashes($_POST['id']);
                FnGenerateGuiaXmlAndSend($id, $conexion);
                break;
        default:
            # code...
            break;
    }
}
