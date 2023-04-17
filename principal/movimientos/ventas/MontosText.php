 <?php
/* Asi funciona
$numero = 13041111.22;
$cambio = valorEnLetras($numero);

echo "numero = $numero";
echo "<br>";
echo "cambio = $cambio";
*/
function valorEnLetras($x)
{
    if ($x<0)
    { 
        $signo = "menos ";
    }
    else      
    { 
        $signo = "";
    }
    $x  = abs ($x);
    $C1 = $x;
    $G6 = floor($x/(1000000));  // 7 y mas
    $E7 = floor($x/(100000));
    $G7 = $E7-$G6*10;   // 6
    $E8 = floor($x/1000);
    $G8 = $E8-$E7*100;   // 5 y 4
    $E9 = floor($x/100);
    $G9 = $E9-$E8*10;  //  3
    $E10 = floor($x);
    $G10 = $E10-$E9*100;  // 2 y 1
    $G11 = round(($x-$E10)*100,0);  // Decimales
    //////////////////////
    $H6 = unidades($G6);
    if($G7==1 AND $G8==0) 
    { 
        $H7 = "Cien "; 
    }
    else 
    {   
        $H7 = decenas($G7);
    }
    $H8 = unidades($G8);
    if($G9==1 AND $G10==0) 
    { 
        $H9 = "Cien ";
    }
    else 
    {    
        $H9 = decenas($G9);
    }
    $H10 = unidades($G10);

    if($G11 < 10) 
    { 
        $H11 = "0".$G11;
    }
    else 
    { 
        $H11 = $G11;
    }

    /////////////////////////////
    if($G6==0) 
    { 
        $I6=" ";
    }
    elseif($G6==1) 
    { 
        $I6="Mill�n ";
    }
    else 
    { 
        $I6="Millones "; 
    }

    if ($G8==0 AND $G7==0) 
    { 
        $I8=" "; 
    }
    else 
    { 
        $I8="Mil "; 
    }

    $I10 = "Soles";
    $I11 = "/100 ";
    $C3 = $signo.$H6.$I6.$H7.$H8.$I8.$H9.$H10.' y '.$H11.$I11.$I10;
    return $C3; //Retornar el resultado
}




function unidades($u)
{
    if ($u==0)  {$ru = " ";}
    elseif ($u==1)  {$ru = "Un ";}
    elseif ($u==2)  {$ru = "Dos ";}
    elseif ($u==3)  {$ru = "Tres ";}
    elseif ($u==4)  {$ru = "Cuatro ";}
    elseif ($u==5)  {$ru = "Cinco ";}
    elseif ($u==6)  {$ru = "Seis ";}
    elseif ($u==7)  {$ru = "Siete ";}
    elseif ($u==8)  {$ru = "Ocho ";}
    elseif ($u==9)  {$ru = "Nueve ";}
    elseif ($u==10) {$ru = "Diez ";}

    elseif ($u==11) {$ru = "Once ";}
    elseif ($u==12) {$ru = "Doce ";}
    elseif ($u==13) {$ru = "Trece ";}
    elseif ($u==14) {$ru = "Catorce ";}
    elseif ($u==15) {$ru = "Quince ";}
    elseif ($u==16) {$ru = "Dieciseis ";}
    elseif ($u==17) {$ru = "Decisiete ";}
    elseif ($u==18) {$ru = "Dieciocho ";}
    elseif ($u==19) {$ru = "Diecinueve ";}
    elseif ($u==20) {$ru = "Veinte ";}

    elseif ($u==21) {$ru = "Veintiun ";}
    elseif ($u==22) {$ru = "Veintidos ";}
    elseif ($u==23) {$ru = "Veintitres ";}
    elseif ($u==24) {$ru = "Veinticuatro ";}
    elseif ($u==25) {$ru = "Veinticinco ";}
    elseif ($u==26) {$ru = "Veintiseis ";}
    elseif ($u==27) {$ru = "Veintisiete ";}
    elseif ($u==28) {$ru = "Veintiocho ";}
    elseif ($u==29) {$ru = "Veintinueve ";}
    elseif ($u==30) {$ru = "Treinta ";}

    elseif ($u==31) {$ru = "Treinta y un ";}
    elseif ($u==32) {$ru = "Treinta y dos ";}
    elseif ($u==33) {$ru = "Treinta y tres ";}
    elseif ($u==34) {$ru = "Treinta y cuatro ";}
    elseif ($u==35) {$ru = "Treinta y cinco ";}
    elseif ($u==36) {$ru = "Treinta y seis ";}
    elseif ($u==37) {$ru = "Treinta y siete ";}
    elseif ($u==38) {$ru = "Treinta y ocho ";}
    elseif ($u==39) {$ru = "Treinta y nueve ";}
    elseif ($u==40) {$ru = "Cuarenta ";}

    elseif ($u==41) {$ru = "Cuarenta y un ";}
    elseif ($u==42) {$ru = "Cuarenta y dos ";}
    elseif ($u==43) {$ru = "Cuarenta y tres ";}
    elseif ($u==44) {$ru = "Cuarenta y cuatro ";}
    elseif ($u==45) {$ru = "Cuarenta y cinco ";}
    elseif ($u==46) {$ru = "Cuarenta y seis ";}
    elseif ($u==47) {$ru = "Cuarenta y siete ";}
    elseif ($u==48) {$ru = "Cuarenta y ocho ";}
    elseif ($u==49) {$ru = "Cuarenta y nueve ";}
    elseif ($u==50) {$ru = "Cincuenta ";}

    elseif ($u==51) {$ru = "Cincuenta y un ";}
    elseif ($u==52) {$ru = "Cincuenta y dos ";}
    elseif ($u==53) {$ru = "Cincuenta y tres ";}
    elseif ($u==54) {$ru = "Cincuenta y cuatro ";}
    elseif ($u==55) {$ru = "Cincuenta y cinco ";}
    elseif ($u==56) {$ru = "Cincuenta y seis ";}
    elseif ($u==57) {$ru = "Cincuenta y siete ";}
    elseif ($u==58) {$ru = "Cincuenta y ocho ";}
    elseif ($u==59) {$ru = "Cincuenta y nueve ";}
    elseif ($u==60) {$ru = "Sesenta ";}

    elseif ($u==61) {$ru = "Sesenta y un ";}
    elseif ($u==62) {$ru = "Sesenta y dos ";}
    elseif ($u==63) {$ru = "Sesenta y tres ";}
    elseif ($u==64) {$ru = "Sesenta y cuatro ";}
    elseif ($u==65) {$ru = "Sesenta y cinco ";}
    elseif ($u==66) {$ru = "Sesenta y seis ";}
    elseif ($u==67) {$ru = "Sesenta y siete ";}
    elseif ($u==68) {$ru = "Sesenta y ocho ";}
    elseif ($u==69) {$ru = "Sesenta y nueve ";}
    elseif ($u==70) {$ru = "Setenta ";}

    elseif ($u==71) {$ru = "Setenta y un ";}
    elseif ($u==72) {$ru = "Setenta y dos ";}
    elseif ($u==73) {$ru = "Setenta y tres ";}
    elseif ($u==74) {$ru = "Setenta y cuatro ";}
    elseif ($u==75) {$ru = "Setenta y cinco ";}
    elseif ($u==76) {$ru = "Setenta y seis ";}
    elseif ($u==77) {$ru = "Setenta y siete ";}
    elseif ($u==78) {$ru = "Setenta y ocho ";}
    elseif ($u==79) {$ru = "Setenta y nueve ";}
    elseif ($u==80) {$ru = "Ochenta ";}

    elseif ($u==81) {$ru = "Ochenta y un ";}
    elseif ($u==82) {$ru = "Ochenta y dos ";}
    elseif ($u==83) {$ru = "Ochenta y tres ";}
    elseif ($u==84) {$ru = "Ochenta y cuatro ";}
    elseif ($u==85) {$ru = "Ochenta y cinco ";}
    elseif ($u==86) {$ru = "Ochenta y seis ";}
    elseif ($u==87) {$ru = "Ochenta y siete ";}
    elseif ($u==88) {$ru = "Ochenta y ocho ";}
    elseif ($u==89) {$ru = "Ochenta y nueve ";}
    elseif ($u==90) {$ru = "Noventa ";}

    elseif ($u==91) {$ru = "Noventa y un ";}
    elseif ($u==92) {$ru = "Noventa y dos ";}
    elseif ($u==93) {$ru = "Noventa y tres ";}
    elseif ($u==94) {$ru = "Noventa y cuatro ";}
    elseif ($u==95) {$ru = "Noventa y cinco ";}
    elseif ($u==96) {$ru = "Noventa y seis ";}
    elseif ($u==97) {$ru = "Noventa y siete ";}
    elseif ($u==98) {$ru = "Noventa y ocho ";}
    else            {$ru = "Noventa y nueve ";}
    return $ru; //Retornar el resultado
}

function decenas($d)
{
    if ($d==0)  {$rd = "";}
    elseif ($d==1)  {$rd = "Ciento ";}
    elseif ($d==2)  {$rd = "Doscientos ";}
    elseif ($d==3)  {$rd = "Trescientos ";}
    elseif ($d==4)  {$rd = "Cuatrocientos ";}
    elseif ($d==5)  {$rd = "Quinientos ";}
    elseif ($d==6)  {$rd = "Seiscientos ";}
    elseif ($d==7)  {$rd = "Setecientos ";}
    elseif ($d==8)  {$rd = "Ochocientos ";}
    else            {$rd = "Novecientos ";}
    return $rd; //Retornar el resultado
}


function convertNumberToWord1($xcifra, $currency){

    $xarray = array(0 => "Cero",

        1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",

        "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",

        "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",

        100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"

    );

//

    $xcifra = trim($xcifra);

    $xlength = strlen($xcifra);

    $xpos_punto = strpos($xcifra, ".");

    $xaux_int = $xcifra;

    $xdecimales = "00";

    if (!($xpos_punto === false)) {

        if ($xpos_punto == 0) {

            $xcifra = "0" . $xcifra;

            $xpos_punto = strpos($xcifra, ".");

        }

        $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir

        $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales

    }

 

    $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)

    $xcadena = "";

    for ($xz = 0; $xz < 3; $xz++) {

        $xaux = substr($XAUX, $xz * 6, 6);

        $xi = 0;

        $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera

        $xexit = true; // bandera para controlar el ciclo del While

        while ($xexit) {

            if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros

                break; // termina el ciclo

            }

 

            $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda

            $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)

            for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden

                switch ($xy) {

                    case 1: // checa las centenas

                        if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas

                             

                        } else {

                            $key = (int) substr($xaux, 0, 3);

                            if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)

                                $xseek = $xarray[$key];

                                $xsub = subfijo1($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)

                                if (substr($xaux, 0, 3) == 100)

                                    $xcadena = " " . $xcadena . " CIEN " . $xsub;

                                else

                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;

                                $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades

                            }

                            else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)

                                $key = (int) substr($xaux, 0, 1) * 100;

                                $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)

                                $xcadena = " " . $xcadena . " " . $xseek;

                            } // ENDIF ($xseek)

                        } // ENDIF (substr($xaux, 0, 3) < 100)

                        break;

                    case 2: // checa las decenas (con la misma lógica que las centenas)

                        if (substr($xaux, 1, 2) < 10) {

                             

                        } else {

                            $key = (int) substr($xaux, 1, 2);

                            if (TRUE === array_key_exists($key, $xarray)) {

                                $xseek = $xarray[$key];

                                $xsub = subfijo1($xaux);

                                if (substr($xaux, 1, 2) == 20)

                                    $xcadena = " " . $xcadena . " VEINTE " . $xsub;

                                else

                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;

                                $xy = 3;

                            }

                            else {

                                $key = (int) substr($xaux, 1, 1) * 10;

                                $xseek = $xarray[$key];

                                if (20 == substr($xaux, 1, 1) * 10)

                                    $xcadena = " " . $xcadena . " " . $xseek;

                                else

                                    $xcadena = " " . $xcadena . " " . $xseek . " Y ";

                            } // ENDIF ($xseek)

                        } // ENDIF (substr($xaux, 1, 2) < 10)

                        break;

                    case 3: // checa las unidades

                        if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada

                             

                        } else {

                            $key = (int) substr($xaux, 2, 1);

                            $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)

                            $xsub = subfijo1($xaux);

                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;

                        } // ENDIF (substr($xaux, 2, 1) < 1)

                        break;

                } // END SWITCH

            } // END FOR

            $xi = $xi + 3;

        } // ENDDO

 

        if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE

            $xcadena.= " DE";

 

        if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE

            $xcadena.= " DE";

 

        // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------

        if (trim($xaux) != "") {

            switch ($xz) {

                case 0:

                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")

                        $xcadena.= "UN BILLON ";

                    else

                        $xcadena.= " BILLONES ";

                    break;

                case 1:

                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")

                        $xcadena.= "UN MILLON ";

                    else

                        $xcadena.= " MILLONES ";

                    break;

                case 2:

                    if ($xcifra < 1) {

                        $xcadena = "CERO CON $xdecimales/100 ";

                    }

                    if ($xcifra >= 1 && $xcifra < 2) {

                        $xcadena = "UNO CON $xdecimales/100 ";

                    }

                    if ($xcifra >= 2) {

                        $xcadena.= " CON $xdecimales/100 "; //

                    }

                    break;

            } // endswitch ($xz)

        } // ENDIF (trim($xaux) != "")

        // ------------------      en este caso, para México se usa esta leyenda     ----------------

        $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc

        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles

        $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad

        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles

        $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda

        $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda

        $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda

    } // ENDFOR ($xz)



    if($currency == 'PEN'){

        $last = 'SOLES';

    }else if($currency == 'USD'){

        $last = ' DOLARES AMERICANOS';

    }else{

        $last = 'SOLES';

    }



    return trim($xcadena.$last);

}


function subfijo1($xx){ // esta función regresa un subfijo para la cifra

    $xx = trim($xx);

    $xstrlen = strlen($xx);

    if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)

        $xsub = "";

    //

    if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)

        $xsub = "MIL";

    //

    return $xsub;

}
?> 


