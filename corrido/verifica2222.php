<?php
session_set_cookie_params(0);
session_start();
//$location = "file:///C|/WINDOWS/system32/config_file.php";
//$location = "C:\WINDOWS\system32\config_file.php";
include ('conexion.php');	
include ('detecta_ip.php');
	$usuarios=mysqli_query($conexion,"SELECT usecod,codgrup FROM usuario WHERE logusu='$_POST[user]' and pasusu='$_POST[text]' and estado = '1'" );
	$local = '1';
	if($user_ok = mysqli_fetch_array($usuarios))
	{
			if (($user_ok["estado"])=="0"){
			Header("Location: index.php?error=3");
			}
			else
			{
			$_SESSION['codigo_user']			= $user_ok["usecod"]; 
			$usuario						= $user_ok["usecod"];  
			$codgrup						= $user_ok["codgrup"];  
			$sql="SELECT nomgrup FROM grupo_user where codgrup = '$codgrup'";
			$result = mysqli_query($conexion,$sql);
			if (mysqli_num_rows($result) ){
			while ($row = mysqli_fetch_array($result)){
					$nomgrup          = $row["nomgrup"];
			}
			}
			mysqli_query($conexion,"UPDATE usuario set codloc = '$local' where usecod = '$usuario'");
			mysqli_free_result($usuarios);
			mysqli_close($conexion); 
				if ($nomgrup == "ADMINISTRADOR DEL SISTEMA")
				{
					header("Location: principal/index.php");
				}
				else
				{
					if ($nomgrup == "VENDEDOR")
					{
					header("Location: principal/movimientos/ventas/ventas_registro.php");
					}
					else
					{
					header("Location: principal/index.php");
					}	
				}
			}
	}
	else
	{
		Header("Location: index.php?error=2");
	}
?>