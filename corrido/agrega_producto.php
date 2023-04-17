<?php
require_once('conexion.php');

    
       
       
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

    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array(
            "\\", "¨", "º", "-", "~",
            "#", "@", "|", "!", "\"",
            "·", "$", "%", "&", "/",
            "(", ")", "?", "'", "¡",
            "¿", "[", "^", "`", "]",
            "+", "}", "{", "¨", "´",
            ">", "< ", ";", ",", ":",
            ".", " "
        ),
        ' ',
        $string
    );


    return $string;
}

$sql= "SELECT producto, Precio_uni, Precio_Fraccion, Digemid, Ref_Sanit, Factor, codigo_marca, codigo_presen,total FROM producto_farmasol  ";
$result = mysqli_query($conexion,$sql);	
if (mysqli_num_rows($result))
{
    while ($row = mysqli_fetch_array($result)){
        $producto   = $row['producto'];
        $Precio_caja   = $row['Precio_uni'];
        $Precio_unidad   = $row['Precio_Fraccion'];
        $Digemid   = $row['Digemid'];
        $Ref_Sanit   = $row['Ref_Sanit'];
        $Factor   = $row['Factor'];
        $codigo_marca   = $row['codigo_marca'];
        $codigo_presen   = $row['codigo_presen'];
        $total   = $row['total'];
        
        
        
  
       
       
   


      $producto= remplazar_string($producto);
       
      // echo $codigo_presen."<br>";
        mysqli_query($conexion, "INSERT INTO producto (desprod,prevta,costpr,utlcos,costre,preuni,digemid,registrosanitario,factor,codmar,codpres,s000,stopro,igv,activo,activo1,lotec) values ('$producto','$Precio_caja','$Precio_caja','$Precio_caja','$Precio_caja','$Precio_unidad','$Digemid','$Ref_Sanit','$Factor','$codigo_marca','$codigo_presen','$total','$total','1','1','1','1')");
    
        
    }
}