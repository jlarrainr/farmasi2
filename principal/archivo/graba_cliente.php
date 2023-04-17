<?php

include('../session_user.php');
require_once ('../../conexion.php');
$btn = $_POST['btn'];
$val = $_POST['val'];
$sql = "SELECT codloc FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codloc = $row["codloc"];
    }
}

function quitar($mensaje) {
    $mensaje = str_replace("<", "&lt;", $mensaje);
    $mensaje = str_replace(">", "&gt;", $mensaje);
    $mensaje = str_replace("\'", "&#39;", $mensaje);
    $mensaje = str_replace('\"', "&quot;", $mensaje);
    $mensaje = str_replace("\\\\", "&#92;", $mensaje);
    return $mensaje;
}

if ($_POST['ext']) {
    header("Location: mov_cliente.php");
}
if ($btn == 4) {
/////GARABA O MODIFICA DATOS
    $nom = $_POST['nom'];
    $propietario = $_POST['propietario'];
    $direccion = $_POST['direccion'];
    $departamento = $_POST['departamento'];
    $provincia = $_POST['provincia'];
    $distrito = $_POST['distrito'];
    $ruc = $_POST['ruc'];
    $fono = $_POST['fono'];
    $fono1 = $_POST['fono1'];
    $email = $_POST['email'];
    $dni = $_POST['dni'];
    $transport = $_POST['transport'];
    $tipo = $_POST['tipo'];
    $credito = $_POST['credito'];
    $state = $_POST['state'];
    $vendedor = $_POST['vendedor'];
    $cobrador = $_POST['cobrador'];
    $obs = $_POST['obs'];
    $delivery = $_POST['delivery'];
    $limiteCredito = $_POST['limiteCredito'];

    if ($departamento == 0) {   ////PARA EL CASO DE MODIFICAR
        $departamento = $_POST['dpto'];
        $provincia = $_POST['prov'];
        $distrito = $_POST['dist'];
    }

    if ($dni <> '') {
        $filtrante = $dni;
        $campo = 'dnicli';
        $error = '1';
    } else {
        $filtrante = $ruc;
        $campo = 'ruccli';
        $error = '2';
    }
    
    $sql = "SELECT * FROM cliente where $campo = '$filtrante'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
    
        header("Location: mov_cliente.php?error=$error");



    } else {


    ////GRABO DATOS
    if ($val == 1) {


        $cod = $_POST['cod_nuevo'];
        $sql = "SELECT ruccli, descli, dnicli FROM cliente WHERE ruccli <> '' and dnicli <> '' and (ruccli = '" . quitar($HTTP_POST_VARS["nom"]) . "' or descli='" . quitar($HTTP_POST_VARS["nom"]) . "' or dnicli='" . quitar($HTTP_POST_VARS["dni"]) . "')";
        $result = mysqli_query($conexion, $sql);
        if ($row = mysqli_fetch_array($result)) {
            header("Location: mov_cliente.php?error=2");
        } else {
            $sql = "SELECT codcli FROM cliente where codcli = '$cod'";
            $result = mysqli_query($conexion, $sql);
            if (mysqli_num_rows($result)) {
                $cod = $cod + 1;
                $t = 0;
                while ($t == 1) {
                    $sql1 = "SELECT codcli FROM cliente where codcli = '$cod'";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        $cod = $cod + 1;
                    } else {
                        $t = 1;
                    }
                }
            }
            mysqli_query($conexion, "INSERT INTO cliente (codcli,descli,contact,dircli,dptcli,procli,discli,ruccli,telcli,telcli1,dnicli,tracli,tipcli,limite,estatus,vencli,cobcli,codusu,obs,email,sucursal,delivery,limiteCredito) values ('$cod','$nom','$propietario','$direccion','$departamento','$provincia','$distrito','$ruc','$fono','$fono1','$dni','$transport','$tipo','$credito','$state','$vendedor','$cobrador','$usuario','$obs','$email','$codloc','$delivery','$limiteCredito')");
            header("Location: mov_cliente.php?ok=1&search=1&country_ID=$cod");
        }
    }
}

    
    ////MODIFICO DATOS
    if ($val == 2) {
        $codigo = $_POST['cod_modif_del'];
        $sql = "SELECT descli,ruccli,dnicli FROM cliente where codcli = '$codigo'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $descripcion_cli = $row["descli"];
                $ruc_cli = $row["ruccli"];
                $dni_cli = $row["dnicli"];
            }
        }
        if ($descripcion_cli == 'PUBLICO EN GENERAL') {
            header("Location: mov_cliente.php?publico_general=1");
        } else {
            if (($ruc == $ruc_cli) and ( $nom == $descripcion_cli) and ( $dni == $dni_cli)) {
                mysqli_query($conexion, "update cliente set contact = '$propietario', dircli = '$direccion', dptcli = '$departamento', procli = '$provincia', discli = '$distrito', telcli = '$fono', telcli1 = '$fono1',email = '$email', tracli = '$transport', tipcli = '$tipo', limite = '$credito', estatus = '$state',vencli = '$vendedor',cobcli = '$cobrador',obs = '$obs',delivery = '$delivery',limiteCredito='$limiteCredito' where codcli = '$codigo'");
                header("Location: mov_cliente.php?up=1&search=1&country_ID=$codigo");
                //echo "SI EL RUC ES =";
            } else {
                if (($ruc == $ruc_cli) && ($ruc <> "")) {
                    if ($nom == $descripcion_cli) { /////SI EL RUC Y EL NOMBRE SON IGUALES
                        $sql = "SELECT dnicli FROM cliente WHERE dnicli <> '' and dnicli='" . quitar($HTTP_POST_VARS["dni"]) . "'";
                        $result = mysqli_query($conexion, $sql);
                        if ($row = mysqli_fetch_array($result)) {
                            header("Location: mov_cliente.php?error=2");
                            //echo "ESTE DNI YA EXISTE";
                        } else {
                            mysqli_query($conexion, "update cliente set dnicli = '$dni', contact = '$propietario', dircli = '$direccion', dptcli = '$departamento', procli = '$provincia', discli = '$distrito', telcli = '$fono', telcli1 = '$fono1',email = '$email', tracli = '$transport', tipcli = '$tipo', limite = '$credito', estatus = '$state', vencli = '$vendedor',cobcli = '$cobrador',obs = '$obs',delivery = '$delivery',limiteCredito='$limiteCredito' where codcli = '$codigo'");
                            header("Location: mov_cliente.php?up=1&search=1&country_ID=$codigo");
                            //echo "AQUI INGRESO EL DNI";
                        }
                    } else {
                        if (($dni == $dni_cli) && ($dni <> "")) { ////SI EL RUC Y EL DNI SON IGUALES
                            $sql = "SELECT descli FROM cliente WHERE descli='" . quitar($HTTP_POST_VARS["nom"]) . "'";
                            $result = mysqli_query($conexion, $sql);
                            if ($row = mysqli_fetch_array($result)) {
                                header("Location: mov_cliente.php?error=2");
                                //echo "ESTE NOMBRE YA EXISTE";
                            } else {
                                mysqli_query($conexion, "update cliente set descli = '$nom', contact = '$propietario', dircli = '$direccion', dptcli = '$departamento', procli = '$provincia', discli = '$distrito', telcli = '$fono', telcli1 = '$fono1',email = '$email', tracli = '$transport', tipcli = '$tipo', limite = '$credito', estatus = '$state', vencli = '$vendedor',cobcli = '$cobrador',obs = '$obs',delivery = '$delivery',limiteCredito='$limiteCredito' where codcli = '$codigo'");
                                header("Location: mov_cliente.php?up=1&search=1&country_ID=$codigo");
                                //echo "SI CAMBIO TODO INCLUIDO OTRO NOMBRE";
                            }
                        } else {    /////SI EL RUC ES = Y EL NOM Y EL DNI NO SON IGUALES
                            mysqli_query($conexion, "update cliente set descli = '$nom',dnicli = '$dni', contact = '$propietario', dircli = '$direccion', dptcli = '$departamento', procli = '$provincia', discli = '$distrito', telcli = '$fono', telcli1 = '$fono1',email = '$email', tracli = '$transport', tipcli = '$tipo', limite = '$credito', estatus = '$state', vencli = '$vendedor',cobcli = '$cobrador',obs = '$obs',delivery = '$delivery',limiteCredito='$limiteCredito' where codcli = '$codigo'");
                            header("Location: mov_cliente.php?up=1&search=1&country_ID=$codigo");
                        }
                    }
                } else {
                    if ($nom == $descripcion_cli) {
                        if (($ruc == $ruc_cli) && ($ruc <> "")) {  ///SI EL NOMBRE Y EL RUC ES IGUAL
                            $sql = "SELECT dnicli FROM cliente WHERE dnicli <> '' and dnicli='" . quitar($HTTP_POST_VARS["dni"]) . "'";
                            $result = mysqli_query($conexion, $sql);
                            if ($row = mysqli_fetch_array($result)) {
                                header("Location: mov_cliente.php?error=2");
                                //echo "ESTE DNI YA EXISTE";
                            } else {
                                mysqli_query($conexion, "update cliente set dnicli = '$dni', contact = '$propietario', dircli = '$direccion', dptcli = '$departamento', procli = '$provincia', discli = '$distrito', telcli = '$fono', telcli1 = '$fono1',email = '$email', tracli = '$transport', tipcli = '$tipo', limite = '$credito', estatus = '$state', vencli = '$vendedor',cobcli = '$cobrador',obs = '$obs',delivery = '$delivery',limiteCredito='$limiteCredito' where codcli = '$codigo'");
                                header("Location: mov_cliente.php?up=1&search=1&country_ID=$codigo");
                                //echo "SI CAMBIO TODO INCLUIDO OTRO RUC";
                            }
                        } else {
                            if (($dni == $dni_cli) && ($dni <> "")) { ///SI EL NOMBRE Y EL DNI ES IGUAL
                                $sql = "SELECT ruccli FROM cliente WHERE ruccli <> '' and ruccli='" . quitar($HTTP_POST_VARS["ruc"]) . "'";
                                $result = mysqli_query($conexion, $sql);
                                if ($row = mysqli_fetch_array($result)) {
                                    header("Location: mov_cliente.php?error=2");
                                    //echo "ESTE DNI YA EXISTE";
                                } else {
                                    mysqli_query($conexion, "update cliente set ruccli = '$ruc', contact = '$propietario', dircli = '$direccion', dptcli = '$departamento', procli = '$provincia', discli = '$distrito', telcli = '$fono', telcli1 = '$fono1',email = '$email', tracli = '$transport', tipcli = '$tipo', limite = '$credito', estatus = '$state', vencli = '$vendedor',cobcli = '$cobrador',obs = '$obs',delivery = '$delivery',limiteCredito='$limiteCredito' where codcli = '$codigo'");
                                    header("Location: mov_cliente.php?up=1&search=1&country_ID=$codigo");
                                    //echo "SI CAMBIO TODO INCLUIDO OTRO RUC";
                                }
                            } else {
                                mysqli_query($conexion, "update cliente set ruccli = '$ruc',dnicli = '$dni', contact = '$propietario', dircli = '$direccion', dptcli = '$departamento', procli = '$provincia', discli = '$distrito', telcli = '$fono', telcli1 = '$fono1',email = '$email', tracli = '$transport', tipcli = '$tipo', limite = '$credito', estatus = '$state', vencli = '$vendedor',cobcli = '$cobrador',obs = '$obs',delivery = '$delivery',limiteCredito='$limiteCredito' where codcli = '$codigo'");
                                header("Location: mov_cliente.php?up=1&search=1&country_ID=$codigo");
                            }
                        }
                    } else {
                        if (($dni == $dni_cli) && ($dni <> "")) {
                            if (($ruc == $ruc_cli) && ($ruc <> "")) {
                                $sql = "SELECT descli FROM cliente WHERE descli='" . quitar($HTTP_POST_VARS["nom"]) . "'";
                                $result = mysqli_query($conexion, $sql);
                                if ($row = mysqli_fetch_array($result)) {
                                    header("Location: mov_cliente.php?error=2");
                                    //echo "ESTE DNI YA EXISTE";
                                } else {
                                    mysqli_query($conexion, "update cliente set descli = '$nom', contact = '$propietario', dircli = '$direccion', dptcli = '$departamento', procli = '$provincia', discli = '$distrito', telcli = '$fono', telcli1 = '$fono1',email = '$email', tracli = '$transport', tipcli = '$tipo', limite = '$credito', estatus = '$state', vencli = '$vendedor',cobcli = '$cobrador',obs = '$obs',delivery = '$delivery',limiteCredito='$limiteCredito' where codcli = '$codigo'");
                                    header("Location: mov_cliente.php?up=1&search=1&country_ID=$codigo");
                                    //echo "SI CAMBIO TODO INCLUIDO OTRO RUC";
                                }
                            } else {
                                if ($nom == $nom_cli) {
                                    $sql = "SELECT ruccli FROM cliente WHERE ruccli <> '' and ruccli='" . quitar($HTTP_POST_VARS["ruc"]) . "'";
                                    $result = mysqli_query($conexion, $sql);
                                    if ($row = mysqli_fetch_array($result)) {
                                        header("Location: mov_cliente.php?error=2");
                                        //echo "ESTE DNI YA EXISTE";
                                    } else {
                                        mysqli_query($conexion, "update cliente set ruccli = '$ruc', contact = '$propietario', dircli = '$direccion', dptcli = '$departamento', procli = '$provincia', discli = '$distrito', telcli = '$fono', telcli1 = '$fono1',email = '$email', tracli = '$transport', tipcli = '$tipo', limite = '$credito', estatus = '$state', vencli = '$vendedor',cobcli = '$cobrador',obs = '$obs',delivery = '$delivery',limiteCredito='$limiteCredito' where codcli = '$codigo'");
                                        header("Location: mov_cliente.php?up=1&search=1&country_ID=$codigo");
                                        //echo "SI CAMBIO TODO INCLUIDO OTRO RUC";
                                    }
                                } else {
                                    mysqli_query($conexion, "update cliente set ruccli = '$ruc',descli = '$nom', contact = '$propietario', dircli = '$direccion', dptcli = '$departamento', procli = '$provincia', discli = '$distrito', telcli = '$fono', telcli1 = '$fono1',email = '$email', tracli = '$transport', tipcli = '$tipo', limite = '$credito', estatus = '$state', vencli = '$vendedor',cobcli = '$cobrador',obs = '$obs',delivery = '$delivery',limiteCredito='$limiteCredito' where codcli = '$codigo'");
                                    header("Location: mov_cliente.php?up=1&search=1&country_ID=$codigo");
                                }
                            }
                        } else {
                            mysqli_query($conexion, "update cliente set dnicli = '$dni',ruccli = '$ruc',descli = '$nom', contact = '$propietario', dircli = '$direccion', dptcli = '$departamento', procli = '$provincia', discli = '$distrito', telcli = '$fono', telcli1 = '$fono1',email = '$email', tracli = '$transport', tipcli = '$tipo', limite = '$credito', estatus = '$state', vencli = '$vendedor',cobcli = '$cobrador',obs = '$obs',delivery = '$delivery',limiteCredito='$limiteCredito' where codcli = '$codigo'");
                            header("Location: mov_cliente.php?up=1&search=1&country_ID=$codigo");
                        }
                    }
                }
            }
        }
    }
}
if ($btn == 5) {
    /////ELIMINA DATOS
    $codigo = $_POST['cod_modif_del'];

    $sql = "SELECT descli FROM cliente WHERE codcli='$codigo' and descli = 'PUBLICO EN GENERAL'";
    $result = mysqli_query($conexion, $sql);
    if ($row = mysqli_fetch_array($result)) {

        header("Location: mov_cliente.php?publico_general=1");
        //echo "no se puede eliminar publico en general";
    } else {
        mysqli_query($conexion, "DELETE from cliente where codcli = '$codigo'");
        header("Location: mov_cliente.php?del=1");
    }
}
if ($btn == 6) {
    /////REGRESA AL MENU PRINCIPAL
    header("Location: ../index.php");
}
