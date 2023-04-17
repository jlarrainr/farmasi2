<?php
//   error_reporting(E_ALL);
// ini_set('display_errors', '1');

require_once('../../../conexion.php');    //CONEXION A BASE DE DATOS
//require_once '../../../convertfecha.php';
//require_once("../../../funciones/functions.php");	//DESHABILITA TECLAS
//require_once('../../../titulo_sist.php');
include('../../session_user.php');




require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS




$invnum = $_SESSION['consulta_comp'];


$codpro1 = isset($_REQUEST['codpro']) ? ($_REQUEST['codpro']) : ""; ///APLICO EL IGV



//echo $codpro1;



$sql = "SELECT codloc,nomusu FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codloc       = $row['codloc'];            //////OBTENGO EL CODIGO DEL LOCAL ACTUAL O DESTINO
        $user          = $row['nomusu'];
    }
}

$sql1 = "SELECT  qtypro,qtyprf FROM movmov as MOV INNER JOIN movmae as MA on MA.invnum=MOV.invnum where MOV.invnum='$invnum' and MOV.codpro='$codpro1'";
$result = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $qtypro       = $row['qtypro'];            //////OBTENGO EL CODIGO DEL LOCAL ACTUAL O DESTINO
        $qtyprf          = $row['qtyprf'];
    }
}





$sqlPro = "SELECT desprod,codbar from producto where codpro='$codpro1'";
$resultPro = mysqli_query($conexion, $sqlPro);


if (mysqli_num_rows($resultPro)) {


    while ($row1 = mysqli_fetch_array($resultPro)) {
        $desprod         = $row1['desprod'];
        $codbar         = $row1['codbar'];
    }
}

//echo $qtypro;


// echo $sqlPro;


?>

<script>
    function printerFunc() {
        window.print(document);
        window.close();
    }
</script>

<body onload="printerFunc()" style="width:100%;height: 100%;">
    <center>
        <img src="barcode_pdf.php?text=<?php echo $codbar; ?> &size=50&orientation=horizontal&codetype=Code128&print=true">

    </center>


</body>