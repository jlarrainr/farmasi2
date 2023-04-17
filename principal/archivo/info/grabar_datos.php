<?php include('../../session_user.php');
require_once('../../../conexion.php');

$codpro   = $_REQUEST['codpro'];
$val      = $_REQUEST['val'];
$search   = $_REQUEST['search'];

      
      
         $sql1="SELECT codtemp,codprod,desinf FROM temp_info where codprod ='$codpro' ";
        $result1 = mysqli_query($conexion,$sql1);
        if (mysqli_num_rows($result1)){
        while ($row1 = mysqli_fetch_array($result1)){
                $codtemp    = $row1['codtemp'];
                $codprod    = $row1['codprod'];
                $desinf    = $row1['desinf'];
               
        }
        }
 

  

mysqli_query($conexion,"INSERT INTO infopro (codprod,desinf) values ('$codprod','$desinf')");

 mysqli_query($conexion,"truncate TABLE temp_info");

header("Location:info2.php?search=$search&val=1");
?>