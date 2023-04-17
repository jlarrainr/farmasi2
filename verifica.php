<?php

session_set_cookie_params(0);
session_start();
include('conexion.php');
$datetime = date('Y-m-d H:i:s');
//include ('detecta_ip.php');
//$ip		= $detect_ip;
/* $sql="SELECT codloc FROM numberip where ip = '$ip'";
  $result = mysqli_query($conexion,$sql);
  if (mysqli_num_rows($result)){
  while ($row = mysqli_fetch_array($result)){
  $local    = $row['codloc'];
  }
 */
 $sql="SELECT * FROM usuario WHERE logusu='$_POST[user]' and pasusu='$_POST[text]' ";
//echo $sql."<br>";
$usuarios = mysqli_query($conexion, "SELECT * FROM usuario WHERE logusu='$_POST[user]' and pasusu='$_POST[text]' ");

 
if ($user_ok = mysqli_fetch_array($usuarios)) {
    //si existe comenzamos con la sesion, si no, al index
    //SI EXISTE EN LA DATA INGRESA A ESTE CODIGO
    if ((($user_ok["ingreso"]) == 1) && (($user_ok["estado"]) == 1)) {
        $usuariofiltro = $user_ok["usecod"];
        header("Location: index.php?filtro=1&usu=$usuariofiltro"); //el codigo no esta activado

    } else {
        if (($user_ok["estado"]) == 0) {
            header("Location: index.php?error=3"); //el codigo no esta activado
        } else {
            //damos valores a las variables de la sesi�n
            $_SESSION['codigo_user'] = $user_ok["usecod"];
            $usuario = $user_ok["usecod"];
            $codgrup = $user_ok["codgrup"];
            $codloc = $user_ok["codloc"];
            $sql = "SELECT nomgrup FROM grupo_user where codgrup = '$codgrup'";
            $result = mysqli_query($conexion, $sql);
            if (mysqli_num_rows($result)) {
                while ($row = mysqli_fetch_array($result)) {
                    $nomgrup = $row["nomgrup"];
                }
            }


            //$sql="SELECT codloc FROM numberip where ip = '$ip' and codloc = '$codloc'";
            //$result = mysqli_query($conexion,$sql);
            //if (mysqli_num_rows($result)){
            $existe = 1;
            //}
            //else
            //{
            //$existe = 0;
            //}
            //	if ($nomgrup == "ADMINISTRADOR DEL SISTEMA")
            if (preg_match("/ADM/", "$nomgrup")) {
                //mysqli_query($conexion,"UPDATE usuario set codloc = '$local' where usecod = '$usuario'");
                // PARA EL ULTIMO LOGEO
                // mysqli_query($conexion, "UPDATE usuario set ultilogeo = '$datetime',ingreso='1',ingreso2=ingreso2 + 1 where usecod = '$usuario'");
                mysqli_query($conexion, "UPDATE usuario set ultilogeo = '$datetime' where usecod = '$usuario'");
                header("Location: principal/index.php?entra=1");
            } else {
                if ($existe == 1) {
                    //mysqli_query($conexion,"UPDATE usuario set codloc = '$local' where usecod = '$usuario'");
                    // PARA EL ULTIMO LOGEO
                    // mysqli_query($conexion, "UPDATE usuario set ultilogeo = '$datetime',ingreso='1',ingreso2=ingreso2 + 1 where usecod = '$usuario'");
                    mysqli_query($conexion, "UPDATE usuario set ultilogeo = '$datetime' where usecod = '$usuario'");

                    //if ($nomgrup == "VENDEDOR")
                    if (preg_match("/VEN/", "$nomgrup")) {
                        header("Location: principal/movimientos/ventas/ventas_registro.php");
                    } else {

                        header("Location: principal/index.php?entra=1");
                    }
                } else {
                    header("Location: index.php?error=4");
                }
            }
        }
    }
} else {
    header("Location: index.php?error=2"); //no se encuentra en el sist
}
/*}
else
{
Header("Location: index.php?error=4");
}*/
