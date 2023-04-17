<?php

function fecha($fechadata)
{
    $fecha = explode("-", $fechadata);
    $dia = $fecha[2];
    $mes = $fecha[1];
    $year = $fecha[0];
    $fecharesult = $dia . '/' . $mes . '/' . $year;
    return $fecharesult;
}

function fecha1($fechadata)
{
    $fecha = explode("/", $fechadata);
    $dia = $fecha[0];
    $mes = $fecha[1];
    $year = $fecha[2];
    $fecharesult = $year . '-' . $mes . '-' . $dia;
    return $fecharesult;
}

function stockcaja($stock, $factor)
{
    if ($factor > 1) {
        $convert1 = $stock / $factor;
        $caja = ((int) ($convert1));
        $unidad = ($stock - ($caja * $factor));
        $stocknuevo = "<b>C</b>" . $caja . "<b> + F</b>" . $unidad;
        return $stocknuevo;
    } else {
        $convert1 = $stock / $factor;
        $caja = ((int) ($convert1));

        $stocknuevo = "<b>C </b>" . $caja;
        return $stocknuevo;
    }
}

function remplazar_string($string)
{
    $string = trim($string);

    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );

    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );

    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );

    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );

    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );

    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        // array('n', 'N', 'c', 'C',),
        array('ñ', 'Ñ', 'c', 'C',),
        $string
    );

    // //Esta parte se encarga de eliminar cualquier caracter extraño
    // $string = str_replace(
    //     array(
    //         "\\", "¨", "º", "-", "~",
    //         "#", "@", "|", "!", "\"",
    //         "·", "$", "%", "&", "/",
    //         "(", ")", "?", "'", "¡",
    //         "¿", "[", "^", "`", "]",
    //         "+", "}", "{", "¨", "´",
    //         ">", "< ", ";", ",", ":",
    //         "."
    //     ),
    //     '',
    //     $string
    // );

    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array(
            "\\", "¨", "º",  "~",
            "@", "|", "!", "\"",
            "$", "?",  "¡",
            "¿", "[", "^", "`", "]",
            "}", "{", "¨", "´",
            ">", "< ", ";", ",", "'", ":"

        ),
        '',
        $string
    );


    return $string;
}

//============= ELIMINAR UN DIRECTORIO ==========
/*
function eliminar_directorio($dir){
$result = false;
if ($handle = opendir($dir)){
$result = true;
while ((($file=readdir($handle))!==false) && ($result)){
if ($file!='.' && $file!='..'){
if (is_dir($dir/$file»)){
$result = eliminar_directorio($dir/$file»);
} else {
$result = unlink($dir/$file»);}}}
closedir($handle);
if ($result){
$result = rmdir($dir);
}}
return $result;
}*/

