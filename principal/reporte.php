<?php

$mes = date('m');
$anio = date('Y');

function convertir_a_numero($str)
{
    $legalChars = "%[^0-9\-\. ]%";
    $str = preg_replace($legalChars, "", $str);
    return $str;
}

// Tomar los datos de tabla "reporteunico" según año y mes actual (del sistema)
$sql = "SELECT mes,anio FROM reporteunico where mes = '$mes' and anio = '$anio' group by mes, anio";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    // Si existen datos, asignar las variables de mes y anio
    while ($row = mysqli_fetch_array($result)) {
        $mes = $row['mes'];
        $anio = $row['anio'];
    }
} else {
    // Si no hay datos, seleccionar todos los meses y años registrados en tabla "kardex"
    $sql = "SELECT MONTH(fecha),YEAR(fecha) FROM kardex group by MONTH(fecha), YEAR(fecha)";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        // Si hay datos en kardex, barrer los registros
        while ($row = mysqli_fetch_array($result)) {
            $mes = $row['0'];
            $anio = $row['1'];

            // Buscar en tabla "reportunico" el año y mes recuperado de "kardex"

            $sqlxx = "SELECT mes, anio FROM reporteunico where mes = '$mes' and anio = '$anio' group by mes, anio";
            $resultxx = mysqli_query($conexion, $sqlxx);
            if (mysqli_num_rows($resultxx)) {
                // Si hay registros, asignar variables de año y mes recuperadas
                while ($rowxx = mysqli_fetch_array($resultxx)) {
                    $mesx = $rowxx['0'];
                    $aniox = $rowxx['1'];
                }
            } else {

                // No hay registros coincidentes entre kardex y reporteunico
                // Buscar nuevamente en "kardex" agrupando por producto y sucursal

                $sql1 = "SELECT codpro,sucursal FROM kardex where MONTH(fecha) = '$mes' and YEAR(fecha) = '$anio' group by codpro,sucursal";
                $result1 = mysqli_query($conexion, $sql1);
                if (mysqli_num_rows($result1)) {
                    // Si se encuentran datos, recuperar los registros
                    while ($row1 = mysqli_fetch_array($result1)) {
                        // Tomar producto y sucursal
                        $producto = $row1[0];
                        $sucursal = $row1[1];

                        // Tomar marca del producto
                        $sqlxx = "SELECT codmar FROM producto where codpro = '$producto'";
                        $resultxx = mysqli_query($conexion, $sqlxx);
                        if (mysqli_num_rows($resultxx)) {
                            while ($rowxx = mysqli_fetch_array($resultxx)) {
                                $marca = $rowxx['0'];
                            }
                        }

                        $saldoactual = 0;
                        $ingresos = 0;
                        $salidas = 0;
                        $signo = "";
                        // Recuperar kardex de segun fecha, producto y sucursal ordenardo por fecha y kardex
                        $sql2 = "SELECT * FROM kardex where MONTH(fecha) = '$mes' and YEAR(fecha) = '$anio' and codpro = '$producto' and sucursal = '$sucursal' order by fecha,codkard";
                        $result2 = mysqli_query($conexion, $sql2);
                        if (mysqli_num_rows($result2)) {
                            // Si se encuentran registros, recuperar el kardex
                            while ($row2 = mysqli_fetch_array($result2)) {
                                $fecha = $row2['fecha'];
                                $nrodoc = $row2['nrodoc'];
                                $tipmov = $row2['tipmov'];
                                $tipdoc = $row2['tipdoc'];
                                $qtypro = $row2['qtypro'];
                                $fraccion = $row2['fraccion'];
                                $factor = $row2['factor'];
                                $sactual = $row2['sactual'];
                                $invnum = $row2['invnum'];
                                $eliminado   = $rowX['eliminado'];

                                //INGRESOS
                                if ($tipmov == 1) {
                                    $sig   = 'mas';
                                }
                                //SALIDAS
                                if ($tipmov == 2) {
                                    $sig   = 'menos';
                                }



                                if (($tipmov == 9) && ($tipdoc == 9) && ($eliminado == 0)) {
                                    $sig        = 'menos';
                                }
                                if (($tipmov == 10) && ($tipdoc == 9) && ($eliminado == 0)) {
                                    $sig   = 'mas';
                                }
                                if (($tipmov == 10) && ($tipdoc == 10) && ($eliminado == 0)) {
                                    $sig        = 'menos';
                                }
                                if (($tipmov == 11) && ($tipdoc == 11) && ($eliminado == 0)) {
                                    $sig   = 'mas';
                                }
                                if (($tipmov == 9) && ($tipdoc == 11) && ($eliminado == 0)) {
                                    $sig        = 'menos';
                                }
                                /////////desde aqui

                                if (($tipmov == 1) && ($tipdoc == 1) && ($eliminado == 0)) {
                                    $sig        = 'mas';
                                }


                                if (($tipmov == 1) && ($tipdoc == 2) && ($eliminado == 0)) {
                                    $sig        = 'mas';
                                }
                                if (($tipmov == 1) && ($tipdoc == 2) && ($eliminado == 0)) {
                                    $sig        = 'mas';
                                }
                                if (($tipmov == 1) && ($tipdoc == 3) && ($eliminado == 0)) {
                                    $sig        = 'mas';
                                }
                                if (($tipmov == 1) && ($tipdoc == 4) && ($eliminado == 0)) {
                                    $sig        = 'mas';
                                }
                                if (($tipmov == 1) && ($tipdoc == 5) && ($eliminado == 0)) {
                                    $sig        = 'mas';
                                }
                                if (($tipmov == 2) && ($tipdoc == 1) && ($eliminado == 0)) {
                                    $sig        = 'menos';
                                }
                                if (($tipmov == 1) && ($tipdoc == 1) && ($eliminado == 2)) {
                                    $sig        = 'menos';
                                }
                                if (($tipmov == 2) && ($tipdoc == 2) && ($eliminado == 0)) {
                                    $sig        = 'menos';
                                }
                                if (($tipmov == 2) && ($tipdoc == 3) && ($eliminado == 0)) {
                                    $sig        = 'menos';
                                }
                                if (($tipmov == 2) && ($tipdoc == 4) && ($eliminado == 0)) {
                                    $sig        = 'menos';
                                }
                                if (($tipmov == 2) && ($tipdoc == 5) && ($eliminado == 0)) {
                                    $sig        = 'menos';
                                }
                                if (($tipmov == 1) && ($tipdoc == 1) && ($eliminado == 1)) {
                                    $sig        = 'menos';
                                }
                                if (($tipmov == 1) && ($tipdoc == 5) && ($eliminado == 1)) {
                                    $sig        = 'menos';
                                }
                                if (($tipmov == 1) && ($tipdoc == 1) && ($eliminado == 3)) {
                                    $sig        = 'mas';
                                }
                                if (($tipmov == 1) && ($tipdoc == 5) && ($eliminado == 3)) {
                                    $sig        = 'mas';
                                }
                                if (($tipmov == 2) && ($tipdoc == 1) && ($eliminado == 1)) {
                                    $sig        = 'mas';
                                }
                                if (($tipmov == 2) && ($tipdoc == 3) && ($eliminado == 1)) {
                                    $sig        = 'mas';
                                }


                                // Define cálculo según factor recuperado (actualmente hace lo mismo)
                                if ($factor == 1) {
                                    if ($qtypro <> "") { // Si se consignó cantidad
                                        $cant = $qtypro;
                                        $descuenta = $cant * $factor;
                                        $car = $descuenta;
                                    }
                                    if ($fraccion <> "") { // Si se consignó fracción
                                        $cant = convertir_a_numero($fraccion);
                                        $descuenta = $cant;
                                        $car = $descuenta;
                                    }
                                } else { // Idem
                                    if ($qtypro <> "") {
                                        $cant = $qtypro;
                                        $descuenta = $cant * $factor;
                                        $car = $descuenta;
                                    }
                                    if ($fraccion <> "") {
                                        $cant = convertir_a_numero($fraccion);
                                        $descuenta = $cant;
                                        $car = $descuenta;
                                    }
                                }
                                // Acumular o descontar según el signo
                                if ($signo == 'mas') {
                                    $saldoactual = $car + $saldoactual;
                                    $ingresos = $car + $ingresos;
                                } else {
                                    $saldoactual = $saldoactual - $car;
                                    $salidas = $salidas + $car;
                                }
                            } // while mysqlfetcharray
                            // Recuperar el primer registro de "reporteunico" para la sucursal correspondiente (stock final)
                            $sqlxx = "SELECT stockfinal FROM reporteunico where mes <= '$mes' and anio <= '$anio' and codpro = '$producto' and codloc = '$sucursal' order by idreporte desc limit 1";
                            $resultxx = mysqli_query($conexion, $sqlxx);
                            if (mysqli_num_rows($resultxx)) {
                                // Si hay registros, tomar el valor de stock inicial
                                while ($rowxx = mysqli_fetch_array($resultxx)) {
                                    $stockini = $rowxx['0'];
                                }
                            }
                            // Agregar registro en "reporteunico" con datos del ingresos y salidas del período
                            mysqli_query($conexion, "INSERT INTO reporteunico (mes,anio,codpro,codmar,stockini,ingresos,salidas,codloc,stockfinal) values ('$mes','$anio','$producto','$marca','$stockini','$ingresos','$salidas','$sucursal','$saldoactual')");
                        } // while mysqlfetcharray
                    } // if mysqlrows
                } // if mysqlrows
            } // else
        } // while mysqlfetcharray
    } // if mysqlrows
} // if mysqlnumrows
