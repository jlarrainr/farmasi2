<?php
require_once 'conexion.php';

 



$tipmov=1 ;
$tipdoc=1 ;


$sqlmovmae = "SELECT * FROM `movmae` WHERE tipmov=$tipmov and tipdoc=$tipdoc ";
$resultmovmae = mysqli_query($conexion, $sqlmovmae);
if (mysqli_num_rows($resultmovmae)) {
    while ($rowmovmae = mysqli_fetch_array($resultmovmae)) {
         $transferencia_ing = $rowmovmae['invnum'];
        
        
        
        $sqlmovmae = "SELECT * FROM kardex WHERE tipmov=$tipmov and tipdoc=$tipdoc and invnum = '$transferencia_ing' ";
        $resultmovmae = mysqli_query($conexion, $sqlmovmae);
        if (mysqli_num_rows($resultmovmae)) {
          
            
        }else{
            
            
            
$sql = "SELECT  `invnum`, `invfec`, `codpro`,`qtypro`, `qtyprf`,  `numlote` FROM movmov where invnum = '$transferencia_ing' order by orden";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $invnum = $row['invnum'];
        $invfec = $row['invfec'];
        $codpro = $row['codpro'];
        $qtypro = $row['qtypro'];
        $qtyprf = $row['qtyprf'];
        $numlote = $row['numlote'];

        $sqlFactor = "SELECT  factor FROM producto where codpro = '$codpro'  ";
        $resultFactor = mysqli_query($conexion, $sqlFactor);
        if (mysqli_num_rows($resultFactor)) {
            while ($rowFactor = mysqli_fetch_array($resultFactor)) {
                $factor = $rowFactor['factor'];
            }
        }


echo '$invnum = '.$invnum  .' *** '.$invnum."<br>";
        // $sql1 = "UPDATE kardex set factor = $factor where codpro = '$codpro' and invnum='$transferencia_ing' ";
        // mysqli_query($conexion, $sql1);
       //  $sql1 = "INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual,sucursal,numlote) values ('1162','$codpro','$invfec','1','2','$qtypro','$qtyprf','$factor','$transferencia_ing','7742','0','2','$numlote')";
       //  mysqli_query($conexion, $sql1);
       
    }
}


        }
        
        
        
        
        
        


}
    
}