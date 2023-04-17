<?php
session_set_cookie_params(0);
session_start();

$resolucion = $_SESSION['resolucion'];
require_once('conexion.php');
require_once("funciones/functions.php");
require_once('funciones/button_clave.php');
require_once('titulo_sist.php');
require_once("funciones/botones.php"); //COLORES DE LOS BOTONES

/////otros campos/////////
$usu = isset($_REQUEST['usu']) ? ($_REQUEST['usu']) : "";
$ingreso = isset($_REQUEST['filtro']) ? ($_REQUEST['filtro']) : "";

$error = isset($_REQUEST['error']) ? ($_REQUEST['error']) : "";
$pc = isset($_REQUEST['pc']) ? ($_REQUEST['pc']) : "";
if ($ingreso == 1) {
    $ingresotext = "UD ya tiene una session abierta en el sistema en desarrollo aun";
}
if ($error == 2) {
    $desc = "Usuario o Contrase&ntilde;a no validos";
}
if ($error == 3) {
    $desc = "UD ha sido dado de baja en el sistema";
}
if ($error == 4) {
    $desc = "IP invalido para utilizar el sistema";
}
if ($error == 5) {
    $desc = "Falta archivo de configuración para acceder al sistema";
}
if ($error == 6) {
    $desc = "Los datos de configuración no corresponden";
}
if ($error == 7) {
    $desc = "Ordenador no autorizado";
}
if ($usu != '') {
    $sql = "SELECT nomusu FROM usuario where usecod = '$usu'";
    $result = mysqli_query($conexion2, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $zznombre = $row['nomusu'];
        }
    }
}
$sqlUsuX = "SELECT logo FROM xcompa where logo <> ''";
$resultUsu2 = mysqli_query($conexion, $sqlUsuX);
if (mysqli_num_rows($resultUsu2)) {
    while ($row = mysqli_fetch_array($resultUsu2)) {
        $logo = $row['logo'];
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="iconoNew.ico">

    <title><?php echo $desemp ?></title>



    <!-- Bootstrap core CSS -->
    <link href=" bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
    <script src="bootstrap/iconos/js/all.min.js"></script>
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    <link href="funciones/alertify/alertify.min.css" rel="stylesheet" />
    <script src="funciones/alertify/alertify.min.js"></script>
</head>



<body class="text-center">
    <?php
    if ($ingreso == 1) {

        $sql = "SELECT nomusu FROM usuario where usecod = '$usu'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $zznombre = $row['nomusu'];
            }
        }
    ?>
        <script>
            alertify
                .confirm("<h1 style='color:red;font-family:Arial, Helvetica;font-size:60px;'><strong><center>CUIDADO </center></strong></h1>", "<h3 style='font-family:Arial, Helvetica;font-size:20px;margin-top: -55px;'> USUARIO: <?php echo "<a style='color:#33beff;' >" . $zznombre . "</a>" . ", "; ?> Usted se encuentra con una sesi&oacute;n abierta en el sistema, si cierra sesi&oacute;n se perder&eacute; los procesos realizados en la sesi&oacute;n ya abierta, con peligro de errores.<br><br>  <a style='color:#7433ff;' ><blink> AUN ESTA EN DESARROLLO SOLO DARLE EN (SI CERRAR SESION )</blink> </a><br><br>Estas seguro que desea cerrar sesion?</h3>",
                    function() {
                        alertify.success("<h1 style='color:#FFF;font-family:Arial, Helvetica;font-size:18px;'><center>CERRO SESI&Oacute;N</center></h1>")

                        var f = document.form1;
                        f.method = "POST";
                        f.target = "_top";
                        f.action = "filtrosesion.php?usu=<?php echo $usu ?>";
                        f.submit();
                    },
                    function() {
                        alertify.error("<h1 style='color:#FFF;font-family:Arial, Helvetica;font-size:18px;'><center>NO CERRO SESI&Oacute;N</center></h1>")
                    }).set('labels', {
                    ok: 'SI CERRAR SESI&Oacute;N',
                    cancel: 'NO CERRAR SESI&Oacute;N'
                });
        </script>
    <?php } ?>
    <!-- Fixed navbar -->
    <!-- <header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top " style="background-color: #2a3f54;">
      <a class="navbar-brand" href="#">EL SISTEMA DE VENTA Y GESTION PARA BOTICAS Y FARNACIAS</a>
    </nav>
  </header> -->
    <!-- Fixed navbar -->
    <br>
    <br>
    <br>
    <br>
    
    <form class="form-signin" id="form1" name="form1" method="post" action="verifica.php">

       
        <?php if ($logo <> "") { ?>
          
           

            <img src="data:image/jpg;base64,<?php echo base64_encode($logo); ?>" />
              <hr>
            
        <?php } else{?>
        <hr>
         <img class="mb-4" src="../LOGOINDEX.png" alt="" style="width:auto;height:auto;" width="72" height="72">
        <?php } ?>
        <h1 class="h3 mb-3 font-weight-normal">SEGURIDAD DEL SISTEMA</h1>


        <label for="inputEmail" class="sr-only">Usuario</label>
        <input type="text" name="user" id="user" onclick="this.value = ''" value="" onkeypress="return ent1(event);" class="form-control" placeholder="Ingrese su Usuario . . . ." required autofocus>

        <label for="inputPassword" class="sr-only"> Contraseña</label>
        <input type="password" name="text" id="text" onKeyPress="return ent(event)" class="form-control" placeholder="Ingrese su Contrase&ntilde;a . . . ." required>


        <button class="btn btn-lg btn-primary btn-block" type="submit">INGRESAR <i class="fas fa-sign-in-alt mx-auto "></i></button>

        <!-- ALERTA DE MENSAJE DE ERROR -->
        <?php if ($error <> "") { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> <?php echo $desc; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php } ?>
        <!-- ALERTA DE MENSAJE DE ERROR -->
    </form>

    <?php require('footer.php'); ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="bootstrap/jquery/jquery-3.5.1.slim.min.js"></script>
    <script src="bootstrap/dist/umd/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>