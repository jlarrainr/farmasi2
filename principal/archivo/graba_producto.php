<?php
//  error_reporting(E_ALL);
//  ini_set('display_errors', '1');
include('../session_user.php');
require_once('../../conexion.php');
require_once '../../convertfecha.php';

require_once('../../titulo_sist.php');

$sqlP = "SELECT precios_por_local FROM datagen";
$resultP = mysqli_query($conexion, $sqlP);
if (mysqli_num_rows($resultP)) {
    while ($row = mysqli_fetch_array($resultP)) {
        $precios_por_local = $row['precios_por_local'];
    }
}
if ($precios_por_local  == 1) {
    require_once '../../precios_por_local.php';
}
$date_mov = date('Y-m-d') . "<br>";
$time_mov = date('H:i:s');
$date = date('Y-m-d');
$sql1 = "SELECT codloc FROM usuario where usecod = '$usuario'";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $codloc = $row1['codloc'];
    }
}

$btn            = isset($_REQUEST['btn']) ? ($_REQUEST['btn']) : "";
$paginas        = isset($_REQUEST['pageno']) ? ($_REQUEST['pageno']) : "";

if (isset($_REQUEST['ext']) ? ($_REQUEST['ext']) : "") {
    header("Location: mov_prod.php?pageno=$paginas");
}

// $btn == 4 = GRABAR PRODUCTO
// $val == 1 NUEVO      - INSERTO
// $val == 2 MODIFICO   - ACTUALIZO

// $btn == 5 = ELIMINAR PRODUCTO

if ($btn == 4) {
    /////GARABA O MODIFICA DATOS

    $des                = isset($_REQUEST['des']) ? ($_REQUEST['des']) : "";                //DESCRIPCION DEL PRODUCTO
    $factor             = isset($_REQUEST['factor']) ? ($_REQUEST['factor']) : "";
    $blister            = isset($_REQUEST['blister']) ? ($_REQUEST['blister']) : "";
    $moneda             = isset($_REQUEST['moneda']) ? ($_REQUEST['moneda']) : "";
    $val                = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
    $img                = isset($_REQUEST['img']) ? ($_REQUEST['img']) : "";
    $directorio         = "imagenes/";   //CARGA UNA IMAGEN
    $price              = isset($_REQUEST['price']) ? ($_REQUEST['price']) : "";   //referencial
    $cod_bar            = isset($_REQUEST['cod_bar']) ? ($_REQUEST['cod_bar']) : "";
    $textdesc           = isset($_REQUEST['textdesc']) ? ($_REQUEST['textdesc']) : "";      //INFORMACION DEL PRODUCTO
    $codpres            = isset($_REQUEST['present']) ? ($_REQUEST['present']) : "";
    $categoria          = isset($_REQUEST['categoria']) ? ($_REQUEST['categoria']) : "";
    $cant1              = isset($_REQUEST['cant1']) ? ($_REQUEST['cant1']) : "";
    $cant2              = isset($_REQUEST['cant2']) ? ($_REQUEST['cant2']) : "";
    $cant3              = isset($_REQUEST['cant3']) ? ($_REQUEST['cant3']) : "";
    $cant11             = isset($_REQUEST['cant11']) ? ($_REQUEST['cant11']) : "";
    $cant22             = isset($_REQUEST['cant22']) ? ($_REQUEST['cant22']) : "";
    $cant33             = isset($_REQUEST['cant33']) ? ($_REQUEST['cant33']) : "";
    $marca              = isset($_REQUEST['marca']) ? ($_REQUEST['marca']) : "";
    $line               = isset($_REQUEST['line']) ? ($_REQUEST['line']) : "";
    $clase              = isset($_REQUEST['clase']) ? ($_REQUEST['clase']) : "";
    $rd                 = isset($_REQUEST['rd']) ? ($_REQUEST['rd']) : "";
    $rd1                = isset($_REQUEST['rd1']) ? ($_REQUEST['rd1']) : "";
    $igv                = isset($_REQUEST['igv']) ? ($_REQUEST['igv']) : ""; //si es activo o no
    $inc                = isset($_REQUEST['inc']) ? ($_REQUEST['inc']) : ""; //INCENTIVO DEL PRODUCTO
    $lotec              = isset($_REQUEST['lotec']) ? ($_REQUEST['lotec']) : ""; //INCENTIVO DEL PRODUCTO
    $ncostre            = isset($_REQUEST['ncostre']) ? ($_REQUEST['ncostre']) : ""; //INCENTIVO DEL PRODUCTO
    $nmargene           = isset($_REQUEST['nmargene']) ? ($_REQUEST['nmargene']) : ""; //INCENTIVO DEL PRODUCTO
    $nprevta            = isset($_REQUEST['nprevta']) ? ($_REQUEST['nprevta']) : ""; //INCENTIVO DEL PRODUCTO
    $npreuni            = isset($_REQUEST['npreuni']) ? ($_REQUEST['npreuni']) : ""; //INCENTIVO DEL PRODUCTO
    $npreblister        = isset($_REQUEST['npreblister']) ? ($_REQUEST['npreblister']) : ""; //INCENTIVO DEL PRODUCTO
    $covid              = isset($_REQUEST['covid']) ? ($_REQUEST['covid']) : ""; //INCENTIVO DEL PRODUCTO
    $activoPuntos       = isset($_REQUEST['activoPuntos']) ? ($_REQUEST['activoPuntos']) : ""; //INCENTIVO DEL PRODUCTO
    $icbper             = isset($_REQUEST['icbper']) ? ($_REQUEST['icbper']) : ""; //INCENTIVO DEL PRODUCTO
    $recetaMedica             = isset($_REQUEST['recetaMedica']) ? ($_REQUEST['recetaMedica']) : ""; //INCENTIVO DEL PRODUCTO
    $digemid            = isset($_REQUEST['digemid']) ? ($_REQUEST['digemid']) : ""; //INCENTIVO DEL PRODUCTO
    $cod_generico       = isset($_REQUEST['cod_generico']) ? ($_REQUEST['cod_generico']) : ""; //INCENTIVO DEL PRODUCTO
    $registrosanitario  = isset($_REQUEST['registrosanitario']) ? ($_REQUEST['registrosanitario']) : ""; //INCENTIVO DEL PRODUCTO
    $costpr             = isset($_REQUEST['costpr ']) ? ($_REQUEST['costpr ']) : ""; //INCENTIVO DEL PRODUCTO

 

    
    $healthy=array("ñ","Ñ");
    $yummy =array("&ntilde;","&Ntilde;" );
    
    
   
    
    
    $des = str_replace($healthy, $yummy, $des);


 
    $cod_bar = trim($cod_bar);

    if ($factor == 1) {
        $npreuni = $nprevta;
    }
    
    /*if($icbper==1){
        $igv='0';
    }*/


    $mc = substr($marca, 0, 1);
    $ln = substr($line, 0, 1);
    $cl = substr($clase, 0, 1);
    $pr = substr($codpres, 0, 1);
    $cat_m = substr($categoria, 0, 1);
    //////REGISTRO DE MARCAS


    $sql = "SELECT drogueria FROM datagen_det";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $drogueria = $row['drogueria'];
        }
    }
    if ($drogueria == 1) {
        $lotenombre = "lote";
        $lotec = '1';
    } else {
        $lotenombre = "lotec";
        $lotec = $lotec;
    }



    if (($mc <> "0") and ($mc <> "1") and ($mc <> "2") and ($mc <> "3") and ($mc <> "4") and ($mc <> "5") and ($mc <> "6") and ($mc <> "7") and ($mc <> "8") and ($mc <> "9")) {

        $sql_marca = "SELECT * FROM titultabladet where destab = '$marca' and tiptab = 'M'";
        $result_marca = mysqli_query($conexion, $sql_marca);
        if (mysqli_num_rows($result_marca)) {
        } else {
            mysqli_query($conexion, "INSERT INTO titultabladet (tiptab,destab) values ('M','$marca')");
        }


        $sql = "SELECT codtab FROM titultabladet where destab = '$marca' and tiptab = 'M'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $marca = $row["codtab"];
            }
        }
    }
    //////REGISTRO DE LINEAS
    if (($ln <> "0") and ($ln <> "1") and ($ln <> "2") and ($ln <> "3") and ($ln <> "4") and ($ln <> "5") and ($ln <> "6") and ($ln <> "7") and ($ln <> "8") and ($ln <> "9")) {


        $sql_line = "SELECT * FROM titultabladet where destab = '$line' and tiptab = 'F'";
        $result_line = mysqli_query($conexion, $sql_line);
        if (mysqli_num_rows($result_line)) {
        } else {
            mysqli_query($conexion, "INSERT INTO titultabladet (tiptab,destab) values ('F','$line')");
        }

        $sql = "SELECT codtab FROM titultabladet where destab = '$line' and tiptab = 'F'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $line = $row["codtab"];
            }
        }
    }
    //////REGISTRO DE CLASES
    if (($cl <> "0") and ($cl <> "1") and ($cl <> "2") and ($cl <> "3") and ($cl <> "4") and ($cl <> "5") and ($cl <> "6") and ($cl <> "7") and ($cl <> "8") and ($cl <> "9")) {


        $sql_clase = "SELECT * FROM titultabladet where destab = '$clase' and tiptab = 'U'";
        $result_clase = mysqli_query($conexion, $sql_clase);
        if (mysqli_num_rows($result_clase)) {
        } else {
            mysqli_query($conexion, "INSERT INTO titultabladet (tiptab,destab) values ('U','$clase')");
        }


        $sql = "SELECT codtab FROM titultabladet where destab = '$clase' and tiptab = 'U'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $clase = $row["codtab"];
            }
        }
    }
    //////REGISTRO DE PRESENTACION
    if (($pr <> "0") and ($pr <> "1") and ($pr <> "2") and ($pr <> "3") and ($pr <> "4") and ($pr <> "5") and ($pr <> "6") and ($pr <> "7") and ($pr <> "8") and ($pr <> "9")) {

        $sql_codpres = "SELECT * FROM titultabladet where destab = '$codpres' and tiptab = 'PRES'";
        $result_codpres = mysqli_query($conexion, $sql_codpres);
        if (mysqli_num_rows($result_codpres)) {
        } else {
            mysqli_query($conexion, "INSERT INTO titultabladet (tiptab,destab) values ('PRES','$codpres')");
        }

        $sql = "SELECT codtab FROM titultabladet where destab = '$codpres' and tiptab = 'PRES'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $codpres = $row["codtab"];
            }
        }
    }
    //////REGISTRO DE PRESENTACION
    if (($cat_m <> "0") and ($cat_m <> "1") and ($cat_m <> "2") and ($cat_m <> "3") and ($cat_m <> "4") and ($cat_m <> "5") and ($cat_m <> "6") and ($cat_m <> "7") and ($cat_m <> "8") and ($cat_m <> "9")) {


        $sql_categoria = "SELECT * FROM titultabladet where destab = '$categoria' and tiptab = 'CAT'";
        $result_categoria = mysqli_query($conexion, $sql_categoria);
        if (mysqli_num_rows($result_categoria)) {
        } else {
            mysqli_query($conexion, "INSERT INTO titultabladet (tiptab,destab) values ('CAT','$categoria')");
        }



        $sql = "SELECT codtab FROM titultabladet where destab = '$categoria' and tiptab = 'CAT'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $categoria = $row["codtab"];
            }
        }
    }


    ////GRABO DATOS
    if (($marca <> "") && ($line <> "") && ($clase <> "")) {
        if ($val == 1) {

            $cod = $_POST['cod_nuevo'];
            if ($cod_bar !== '') {
                $sql = "SELECT codbar, desprod FROM producto WHERE codbar like '$cod_bar%' and eliminado='0' ";
                $numero = '1';
            } else {
                $sql = "SELECT codbar, desprod FROM producto WHERE desprod='$des'  and codmar ='$marca' and eliminado='0'";
                $numero = '2';
            }
            $result = mysqli_query($conexion, $sql);
            if (mysqli_num_rows($result)) {
                header("Location: mov_prod.php?error=$numero&pageno=$paginas&country_ID=$cod");
            } else {
                /////////VERIFICO QUE ESTE CODIGO NO SEA UTILIZADO
                $sql = "SELECT codpro FROM producto where codpro = '$cod' and eliminado='0'";
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
                    $cod = $cod + 1;
                    $t = 0;
                    while ($t == 1) {
                        $sql1 = "SELECT codpro FROM producto where codpro = '$cod' and eliminado='0'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            $cod = $cod + 1;
                        } else {
                            $t = 1;
                        }
                    }
                }


                if ($img != "") {
                    $valor = $cod . ".jpg";
                    copy($_FILES["img"]['tmp_name'], $directorio . $cod . ".jpg");
                    //Actualizamos el registro en la tabla Evento
                }

                if ($precios_por_local == 1) {

                    if (($zzcodloc == 1)) {

                        mysqli_query($conexion, "INSERT INTO producto (codpro,desprod,codbar,factor   ,moneda   ,imapro,detpro,       cant1   ,cant2   ,cant3   ,desc1   ,desc2     ,desc3   ,activo,datcre,codmar, coduso,    codfam,   igv, stopro ,costod,costpr,codusu   ,prelis,incentivado,s000,s001,s002,s003,s004,s005,s006,s007,s008,s009,s010,s011,s012,s013,s014,s015,s016,blister,$lotenombre,codpres,activo1,mardis,costre,utlcos,margene,prevta,preuni,preblister,digemid,cod_generico,registrosanitario,covid,activoPuntos,icbper,recetaMedica,codcatp) values  ('$cod','$des' ,'$cod_bar','$factor','$moneda','$valor','$textdesc','$cant1','$cant2','$cant3','$cant11','$cant22','$cant33','$rd','$date','$marca','$clase','$line','$igv','0'    ,'0'   ,'$ncostre'   ,'$usuario','0','$inc','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','$blister','$lotec','$codpres','$rd1','5','$ncostre','$ncostre','$nmargene','$nprevta','$npreuni','$npreblister','$digemid','$cod_generico','$registrosanitario','$covid','$activoPuntos','$icbper','$recetaMedica','$categoria')");

                        mysqli_query($conexion, "INSERT INTO mov_producto (codpro,local_add,usuario_add,fecha_add,hora_add) values ('$cod','$codloc','$usuario','$date_mov','$time_mov')");

                        mysqli_query($conexion, "INSERT INTO precios_por_local (codpro ) values ('$cod')");
                    } else {

                        mysqli_query($conexion, "INSERT INTO producto (codpro,desprod,codbar,factor   ,moneda   ,imapro,detpro,       cant1   ,cant2   ,cant3   ,desc1   ,desc2     ,desc3   ,activo,datcre,codmar, coduso,    codfam,   igv, stopro ,costod,codusu ,prelis,incentivado,s000,s001,s002,s003,s004,s005,s006,s007,s008,s009,s010,s011,s012,s013,s014,s015,s016,$lotenombre,codpres,activo1,digemid,cod_generico,registrosanitario,covid,activoPuntos,icbper,recetaMedica,codcatp) values  ('$cod','$des' ,'$cod_bar','$factor','$moneda','$valor','$textdesc','$cant1','$cant2','$cant3','$cant11','$cant22','$cant33','$rd','$date','$marca','$clase','$line','$igv','0'    ,'0','$usuario','0','$inc','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','$lotec','$codpres','$rd1','$digemid','$cod_generico','$registrosanitario','$covid','$activoPuntos','$icbper','$recetaMedica','$categoria')");

                        mysqli_query($conexion, "INSERT INTO mov_producto (codpro,local_add,usuario_add,fecha_add,hora_add) values ('$cod','$codloc','$usuario','$date_mov','$time_mov')");

                        mysqli_query($conexion, "INSERT INTO precios_por_local (codpro,$mardis_p,$costre_p,$costpr_p,$utlcos_p,$margene_p,$prevta_p,$preuni_p,$preblister_p,$blister_p ) values ('$cod','5','$ncostre','$ncostre','$ncostre','$nmargene','$nprevta','$npreuni','$npreblister','$blister')");
                    }
                } else {

                    mysqli_query($conexion, "INSERT INTO producto (codpro,desprod,codbar,factor   ,moneda   ,imapro,detpro,       cant1   ,cant2   ,cant3   ,desc1   ,desc2     ,desc3   ,activo,datcre,codmar, coduso,    codfam,   igv, stopro ,costod,costpr,codusu   ,prelis,incentivado,s000,s001,s002,s003,s004,s005,s006,s007,s008,s009,s010,s011,s012,s013,s014,s015,s016,blister,$lotenombre,codpres,activo1,mardis,costre,utlcos,margene,prevta,preuni,preblister,digemid,cod_generico,registrosanitario,covid,activoPuntos,icbper,recetaMedica,codcatp) values  ('$cod','$des' ,'$cod_bar','$factor','$moneda','$valor','$textdesc','$cant1','$cant2','$cant3','$cant11','$cant22','$cant33','$rd','$date','$marca','$clase','$line','$igv','0'    ,'0'   ,'$ncostre'   ,'$usuario','0','$inc','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','$blister','$lotec','$codpres','$rd1','5','$ncostre','$ncostre','$nmargene','$nprevta','$npreuni','$npreblister','$digemid','$cod_generico','$registrosanitario','$covid','$activoPuntos','$icbper','$recetaMedica','$categoria')");

                    mysqli_query($conexion, "INSERT INTO mov_producto (codpro,local_add,usuario_add,fecha_add,hora_add) values ('$cod','$codloc','$usuario','$date_mov','$time_mov')");

                    mysqli_query($conexion, "INSERT INTO precios_por_local (codpro ) values ('$cod')");
                }




                header("Location: mov_prod.php?ok=1&pageno=$paginas&ultimo=1&country_ID=$cod");
            }
        }
        ////MODIFICO DATOS
        if ($val == 2) {

            $codigo = $_POST['cod_modif_del'];
            $sql = "SELECT codpro,desprod,codbar,codmar,costre,factor,stopro,SUM(s000+s001+s002+s003+s004+s005+s006+s007+s008+s009+s010+s011+s012+s013+s014+s015+s016+s017+s018+s019+s020) as sumatotal FROM producto where codpro = '$codigo' and eliminado='0'";
            $result = mysqli_query($conexion, $sql);
            if (mysqli_num_rows($result)) {
                while ($row = mysqli_fetch_array($result)) {
                    $descripcion_prod   = $row["desprod"];
                    $marca_prod         = $row["codmar"];
                    $codigo_barra       = $row["codbar"];
                    $costre             = $row["costre"];
                    $factorori          = $row["factor"];
                    $stopro             = $row["stopro"];
                    $sumato             = $row["sumatotal"];
                }
            }
            if (($factorori <> $factor) and ($sumato <> 0)) {
                header("Location: mov_prod.php?error=3&pageno=$paginas&country_ID=$codigo");
            } else {
                
             /*    echo '$codigo_barra '.$codigo_barra . "<br>";
                 echo '$cod_bar '.$cod_bar . "<br>";
                 echo '$des '.$des . "<br>";
                 echo '$descripcion_prod '.$descripcion_prod . "<br>";
                 echo '$marca '.$marca . "<br>";
                 echo '$marca_prod '.$marca_prod . "<br>";
                 echo '$factorori '.$factorori . "<br>";
                 echo '$factor '.$factor . "<br>";*/
                if (($cod_bar == $codigo_barra) and  ($des == $descripcion_prod) and ($marca == $marca_prod) and ($factorori == $factor)) {
                    
                    
                    mysqli_query($conexion, "update producto set factor = '$factor', moneda = '$moneda', detpro = '$textdesc', cant1 = '$cant1', cant2 = '$cant2', cant3 = '$cant3', desc1 = '$cant11', desc2 = '$cant22', desc3 = '$cant33', activo = '$rd',  codmar = '$marca', codfam = '$line', coduso = '$clase',igv = '$igv', codusu = '$usuario',incentivado = '$inc',blister = '$blister',$lotenombre='$lotec',codpres = '$codpres',codcatp = '$categoria',prelis = '$price',activo1='$rd1',digemid ='$digemid',cod_generico='$cod_generico',registrosanitario='$registrosanitario',covid='$covid',activoPuntos='$activoPuntos',icbper='$icbper',recetaMedica='$recetaMedica' where codpro = '$codigo'");

                    $sql = "SELECT * FROM mov_producto where codpro = '$codigo'";
                    $result = mysqli_query($conexion, $sql);
                    if (mysqli_num_rows($result)) {
                        mysqli_query($conexion, "update mov_producto  set local_up='$codloc',usuario_up='$usuario',fecha_up='$date_mov',hora_up='$time_mov' where codpro = '$codigo'");
                    } else {
                        mysqli_query($conexion, "INSERT INTO mov_producto (codpro,local_up,usuario_up,fecha_up,hora_up) values ('$codigo','$codloc','$usuario','$date_mov','$time_mov')");
                    }

                    header("Location: mov_prod.php?ok=2&pageno=$paginas&country_ID=$codigo");
                } else { 


                if ($cod_bar !== '') {
                    $sql_actualiza = "SELECT codpro FROM producto WHERE codbar like '$cod_bar%'  and eliminado='0' ";
                    $numero = '4';
                } else {
                    $sql_actualiza = "SELECT codpro FROM producto WHERE desprod='$des' and codmar ='$marca' and  eliminado='0'";
                    $numero = '5';
                }
                $result_actualiza = mysqli_query($conexion, $sql_actualiza);
                if (mysqli_num_rows($result_actualiza)) {

                    while ($row = mysqli_fetch_array($result_actualiza)) {
                        $codpro_obtengo             = $row["codpro"];
                    }
                }else{
                    $codpro_obtengo=$codigo;
                }
                    
                   // echo '$codpro_obtengo = ' . $codpro_obtengo."<br>";
                  //  echo '$codigo = ' . $codigo."<br>";
                   // echo '$numero = ' . $numero."<br>";

                    if ($codpro_obtengo <> $codigo) {
                        header("Location: mov_prod.php?error=$numero&pageno=$paginas&country_ID=$codigo");
                    } else {

                        mysqli_query($conexion, "update producto set desprod = '$des',codbar = '$cod_bar', factor = '$factor', moneda = '$moneda', detpro = '$textdesc', cant1 = '$cant1', cant2 = '$cant2', cant3 = '$cant3', desc1 = '$cant11', desc2 = '$cant22', desc3 = '$cant33', activo = '$rd', codmar = '$marca', codfam = '$line', coduso = '$clase',igv = '$igv', codusu = '$usuario',incentivado = '$inc',blister = '$blister',$lotenombre='$lotec',codpres = '$codpres',codcatp = '$categoria',prelis = '$price',activo1='$rd1',digemid ='$digemid',cod_generico='$cod_generico',registrosanitario='$registrosanitario',covid='$covid',activoPuntos='$activoPuntos',icbper='$icbper',recetaMedica='$recetaMedica'  where codpro = '$codigo'");

                        $sql = "SELECT * FROM mov_producto where codpro = '$codigo'";
                        $result = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($result)) {
                            mysqli_query($conexion, "update mov_producto  set local_up='$codloc',usuario_up='$usuario',fecha_up='$date_mov',hora_up='$time_mov' where codpro = '$codigo'");
                        } else {
                            mysqli_query($conexion, "INSERT INTO mov_producto (codpro,local_up,usuario_up,fecha_up,hora_up) values ('$codigo','$codloc','$usuario','$date_mov','$time_mov')");
                        }

                         header("Location: mov_prod.php?ok=3&pageno=$paginas&country_ID=$codigo");
                    }
                
                 }
            }
        }
    } ////SI CIERRO LA MARCA, LINEA O CLASE

}


if ($btn == 5) {
    /////ELIMINA DATOS
    $codigo = $_POST['cod_modif_del'];

    $sql = "SELECT SUM(s000+s001+s002+s003+s004+s005+s006+s007+s008+s009+s010+s011+s012+s013+s014+s015+s016+s017+s018+s019+s020) as sumatotal FROM producto where codpro = '$codigo' and eliminado='0'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $sumato             = $row["sumatotal"];
        }
    }
    if ($sumato <> 0) {

        header("Location: mov_prod.php?error=6&pageno=$paginas&country_ID=$codigo");
    } else {

        mysqli_query($conexion, "update producto  set eliminado='1' where codpro = '$codigo'");

        mysqli_query($conexion, "update precios_por_local  set eliminado='1' where codpro = '$codigo'");

        $sql = "SELECT * FROM mov_producto where codpro = '$codigo'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            mysqli_query($conexion, "update mov_producto  set local_d='$codloc',usuario_d='$usuario',fecha_d='$date_mov',hora_d='$time_mov' where codpro = '$codigo'");
        } else {
            mysqli_query($conexion, "INSERT INTO mov_producto (codpro,local_d,usuario_d,fecha_d,hora_d) values ('$codigo',$codloc','$usuario','$date_mov','$time_mov')");
        }
        header("Location: mov_prod.php?del=1");
    }
}
if ($btn == 6) {
    /////REGRESA AL MENU PRINCIPAL
    header("Location: ../index.php");
}
