<?php
include('session_user.php');
require_once('../conexion.php');
require_once('../titulo_sist.php');
require_once('../gestionAlertas2.php');
require_once('../convertfecha.php');
// require('session_filtro.php');
$entra = isset($_REQUEST['entra']) ? ($_REQUEST['entra']) : "";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="gb18030">
    <link rel="icon" type="image/x-icon" href="../iconoNew.ico" />


    <meta http-equiv="cache-control" content="no-store" />
    <title><?php echo $desemp ?></title>
    <link href="css/body.css" rel="stylesheet" type="text/css" />

    <link href="../css/style.css" rel="stylesheet" type="text/css" />

    <?php require_once("../funciones/functions.php");
    ?>
    <script type="text/javascript" language="JavaScript1.2" src="menu_ok/stmenu.js?temp=<?php echo rand(); ?>"></script>
    <link href="../funciones/alertify/alertify.min.css" rel="stylesheet" />
    <script src="../funciones/alertify/alertify.min.js"></script>
    <style type="text/css">
        h1 {
            color: #FF0000;
            font-size: 40px;
            font-weight: bold;
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        }

        h2 {
            margin-top: -40px;
        }
    </style>
</head>

<body>

    <?php
 
$files = glob('movimientos/ventas/temp/*'); // obtiene todos los archivos
foreach($files as $file){
  if(is_file($file)) // si se trata de un archivo
    unlink($file); // lo elimina
}
    
     function fechavenci($fechadata)
    {
        $fecha = explode("-", $fechadata);
        // $dia = $fecha[2];
        $mes = $fecha[1];
        $year = $fecha[0];
        $fecharesult = $mes . '/' . $year;
        return $fecharesult;
    }
    // $sql = "SELECT ingreso2 FROM usuario where usecod = '$usuario' ";
    // $result = mysqli_query($conexion, $sql);
    // if (mysqli_num_rows($result)) {
    //     while ($row = mysqli_fetch_array($result)) {
    //         $ingreso2 = $row['ingreso2'];
    //     }
    // }
    // if ($ingreso2 <> $_SESSION['eduardo']) {
    //     require('logout.php');
    // }

    $n = '0';
    $caomparacion_incentivado = date('Y-m-d');
    $sqlince = "SELECT invnum,datefin FROM incentivado where estado = '1'";
    $resultincen = mysqli_query($conexion, $sqlince);
    if (mysqli_num_rows($resultincen)) {
        while ($rowincen = mysqli_fetch_array($resultincen)) {
            $invnumincen = $rowincen['invnum'];
            $datefin = $rowincen['datefin'];
            if ($datefin < $caomparacion_incentivado) {
                mysqli_query($conexion, "UPDATE incentivado set estado  = '0' where invnum = '$invnumincen'");
                $sqlince2 = "SELECT invnum,datefin FROM incentivado where estado = '1'";
                $resultincen2 = mysqli_query($conexion, $sqlince2);
                if (mysqli_num_rows($resultincen2)) {
                    while ($rowincen2 = mysqli_fetch_array($resultincen2)) {
                        $invnumincen2 = $rowincen2['invnum'];
                        $datefin2 = $rowincen2['datefin'];
                        if ($datefin2 < $caomparacion_incentivado) {
                            mysqli_query($conexion, "UPDATE incentivado set estado  = '0' where invnum = '$invnumincen2'");
                            $sql = "SELECT codpro FROM incentivadodet where invnum = '$invnumincen2'";
                            $result = mysqli_query($conexion, $sql);
                            if (mysqli_num_rows($result)) {
                                while ($row = mysqli_fetch_array($result)) {
                                    $codpro = $row['codpro'];
                                    $sqldet = "SELECT COUNT(*) FROM incentivadodet where codpro = '$codpro'";
                                    $resultdet = mysqli_query($conexion, $sqldet);
                                    if (mysqli_num_rows($resultdet)) {
                                        while ($rowdet = mysqli_fetch_array($resultdet)) {
                                            $sum = $rowdet[0];
                                        }
                                    }
                                    if ($sum == 1) {
                                        mysqli_query($conexion, "UPDATE producto set incentivado  = '0' where codpro = '$codpro'");
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    $sql = "SELECT nomusu,codloc FROM usuario where usecod = '$usuario'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $nomusu = $row['nomusu'];
            $codloc = $row['codloc'];
        }
    }

    $sql = "SELECT recordarsunat,nlicencia,precios_por_local FROM datagen ";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $recordarsunat = $row['recordarsunat'];
            $nlicencia = $row['nlicencia'];
            $precios_por_local = $row['precios_por_local'];
        }
    }

    if (($nlicencia == '1') && ($precios_por_local == '1')) {
        mysqli_query($conexion, "UPDATE datagen set precios_por_local  = '0'  ");
    }
    $fechaComoEntero = strtotime($fechavenci);

    $dia1 = date("d", $fechaComoEntero);
    $dia1res = $dia1 - 1;
    $dia2 = date("d");;
    $COM = $dia1 - $dia2;


    $mess = date('Y-m');
    $Ffecha = date("Y-m", strtotime('+3 month', strtotime($mess)));
    $mesdos = $Ffecha;
    $D1 = $mess . "-00";
    $D2 = $mesdos . "-00";
    $FECHA1 = $mess;
    $FECHA2 = $Ffecha;
  //  $sql1 = "SELECT COUNT(STR_TO_DATE(vencim, '%m/%Y') ) from movlote where STR_TO_DATE(vencim, '%m/%Y') <= '$D1' AND  stock > 0  ";
  $sql1 = "SELECT COUNT(*) from movlote where STR_TO_DATE(vencim, '%m/%Y') = '$D1'   and codloc = '$zzcodloc' AND  stock > 0   ";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $conta1 = $row1[0];
            // $FECHA1 = $row1['FE'];
        }
    }

    $sql1 = "SELECT COUNT(STR_TO_DATE(vencim, '%m/%Y') ) from movlote where STR_TO_DATE(vencim, '%m/%Y') <= '$D2' and STR_TO_DATE(vencim, '%m/%Y') >= '$D1'  AND  stock > 0  ";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $conta2 = $row1[0];
            // $FECHA2 = $row1['FE'];
        }
    }

    $fecha_actual = date("Y-m-d");

    //resto 4 día
    $fecha_4 = date("Y-m-d", strtotime($fecha_actual . "- 3 days"));
    $fecha_5 = date("Y-m-d", strtotime($fecha_actual . "- 2 days"));
    
    //echo($fecha_4) ."<br>";
    //echo($fecha_5) ."<br>";
    

    //echo '$fecha_4 = '.$fecha_4."<br>";
    //echo '$recordarsunat = '.$recordarsunat."<br>";


    $sql_venta_4 = "SELECT COUNT(*) FROM venta WHERE estado ='0' and invtot <> '0' and tipdoc <> 4 and invfec='$fecha_4' and sunat_respuesta_descripcion = '' and sucursal='$codloc' ";
    $result_venta_4 = mysqli_query($conexion, $sql_venta_4);
    if (mysqli_num_rows($result_venta_4)) {
        while ($row_venta_4 = mysqli_fetch_array($result_venta_4)) {
            $conta_venta_4 = $row_venta_4[0];
        }
    }
    //echo '$conta_venta_4 = '.$conta_venta_4."<br>";
    $sql_venta_5 = "SELECT COUNT(*) FROM venta WHERE estado ='0' and invtot <> '0' and tipdoc <> 4 and invfec='$fecha_5' and sunat_respuesta_descripcion = '' and sucursal='$codloc'  ";
    $result_venta_5 = mysqli_query($conexion, $sql_venta_5);
    if (mysqli_num_rows($result_venta_5)) {
        while ($row_venta_5 = mysqli_fetch_array($result_venta_5)) {
            $conta_venta_5 = $row_venta_5[0];
        }
    }
  // echo '$conta_venta_5 = '.$conta_venta_5."<br>";
    $nomlocalG = "";
    $sqlLocal = "SELECT nombre FROM xcompa where habil = '1' and codloc = '$codloc'";
    $resultLocal = mysqli_query($conexion, $sqlLocal);
    if (mysqli_num_rows($resultLocal)) {
        while ($rowLocal = mysqli_fetch_array($resultLocal)) {
            $nomlocalG = $rowLocal['nombre'];
        }
    }

    ?>
    <div class="tabla1">

        <?php
        require_once('reporte.php');
        include('accesosinfiltro.php');
        include('acceso.php');

        include('men.php');

        $today = getdate();
        $hora = $today["hours"];
        if ($hora < 6) {
            $SALUDO = " Hoy has madrugado mucho... ";
        } elseif ($hora < 12) {
            $SALUDO = " Buenos d&iacute;as ";
        } elseif ($hora <= 18) {
            $SALUDO = "Buenas Tardes ";
        } else {
            $SALUDO = "Buenas Noches ";
        }


        $smssunat = 'Se le recuerda enviar sus comprobantes a la SUNAT de la fecha :  ' . fecha($fecha_4) . ' antes de que la fecha plazo se venza, del la sucursal: ' . $nomlocalG . '.';


        if ((($nopaga == 1) || ($nopaga == 2)) && ($entra == 1)) {
        ?>

            <script>
                alertify
                    .alert("FARMASIS", "<h1><strong><center><?php echo $smspago ?></center></strong></h1>", function() {
                        alertify.message('OK');
                        window.location = 'contvisto.php';
                    });
            </script>
        <?php
        } elseif ((($alertaPagoPorLocal == 1) || ($alertaPagoPorLocal == 2)) && ($entra == 1)) { ?>
            <script>
                alertify
                    .alert("FARMASIS", "<h1><strong><center><?php echo $smspagoLocal ?></center></strong></h1>", function() {
                        alertify.message('OK');
                        window.location = 'contvisto.php';
                    });
            </script>

        <?php

        }
        // echo '$recordarsunat = '.$recordarsunat."<br>";
        // echo '$conta_venta_4 = '.$conta_venta_4."<br>";
        if (($recordarsunat == 1) && ($conta_venta_4 > 0)) {
        ?>

            <script>
                alertify
                    .alert("<h1><strong><center>ENVIO DE COMPROBANTES A LA SUNAT</center></strong></h1>", "<h3><?php echo $SALUDO ?>, <?php echo $smssunat; ?></h3> ");
            </script>
        <?php
        }
        if (($alerta_masiva_universal == 1) && ($entra == 1) && ($fecha_actual <> $fecha_mensaje) && ($alerta_masiva_sistema == 0)) {
        ?>



            <script>
                alertify
                    .confirm("<h1 style='color:red;font-family:Arial, Helvetica;font-size:35px;'><strong><center>FARMASIS INFORMA </center></strong></h1>", "<h3 style='font-family:Arial, Helvetica;font-size:20px;margin-top: -50px;'> <?php echo  $mensaje_masiva_universal . "<br><br><br>Si desea mas informacion dele en," . "<a style='color:#33beff;' >" . 'Estoy Interesado.' . "</a>"; ?> </h3>",
                        function() {

                            alertify.prompt("<h1 style='color:red;font-family:Arial, Helvetica;font-size:30px;'><strong><center>FARMASIS INFORMA </center></strong></h1>", "<a style='color:#1c416c;font-size:17px;margin-top: -100px;' > Ingrese su numero de celular para comunicarnos con usted.</a>", '', function(evt, value) {
                                alertify.success('En unos minutos nos comunicaremos con ustd')
                                window.location = 'correo_solicutud.php?telefono=' + value;
                            }, function() {
                                alertify.error('Cancelo')
                            });

                        },
                        function() {
                            alertify.error("<h1 style='color:#FFF;font-family:Arial, Helvetica;font-size:18px;'><center>No se encuentra interesado.</center></h1>")
                        }).set('labels', {
                        ok: 'Estoy Interesado',
                        cancel: 'cancelar'
                    });
            </script>
            <?php
        }
        if ($entra == 1) {
            if ($vencipro == 1) {
                if ($conta1 <> 0) {
            ?>
                    <script>
                        clearTimeout(window.timeout);
                        alertify.error("<p align='center'>Tiene <?php echo $conta1; ?> productos ya vencidos al <?php echo fechavenci($FECHA1); ?> <a align='center' style='color: #ffffff;font-size:17px;' href='reset_movlote.php' >ACTUALIZAR</a></p>", 0)
                        window.timeout = setTimeout(function() {
                            alertify.dismissAll();
                        }, 5000);
                    </script>
                <?php
                }
                if ($conta2 <> 0) {
                ?>
                    <script>
                        clearTimeout(window.timeout);
                        alertify.warning("<p align='center'>Tiene <?php echo $conta2; ?> producto(s) cercano(s) a vencer (3 meses) </p>", 0)
                        window.timeout = setTimeout(function() {
                            alertify.dismissAll();
                        }, 5000);
                    </script>

            <?php
                }
            }
            ?>
            <script>
                alertify.set('notifier', 'position', 'top-right');
                alertify.success("<h3 style='color:White;font-size:12px;font-weight: bold;'><?php echo $SALUDO . " " . $nomusu ?>,  Bienvenido al Sistema FARMASIS.</h3>", alertify.get('notifier', 'position'));
            </script>
        <?php
        }
        ?>
    </div>
</body>

</html>