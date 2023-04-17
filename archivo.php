 
<?php


$array= array(
    
    "NomPersona" => 0, "CodigoSistema" => 0,"CodigoPerfil" => 0 ,"CodigoModulo" => 0, "NomModulo" => 0, "CodigoPersona" => 0  
    );

    foreach ($array as $lItem) {
        
        
        //echo '$lItem = '.$lItem."<br>";
            if (method_exists($lItem, "Free"))
                //$lItem->Free();
                echo $lItem;
                unset($lItem);
        }
        
        
?>