<?php include('../session_user.php');

$sql = "SELECT codgrup FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codgrup    = $row['codgrup'];
    }
}


$m6 = 0;
$m7 = 0;
$m8 = 0;
$m9 = 0;
$m10 = 0;
$m11 = 0;
$m12 = 0;
$m14 = 0;


//////ITEM = M6
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'M6' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrem6 = $row['nombre'];
    }
    $m6 = 1;
}
//////ITEM = M7
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'M7' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrem7 = $row['nombre'];
    }
    $m7 = 1;
}
//////ITEM = M8
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'M8' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrem8 = $row['nombre'];
    }
    $m8 = 1;
}
//////ITEM = M9
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'M9' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrem9 = $row['nombre'];
    }
    $m9 = 1;
}
//////ITEM = M10
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'M10' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrem10 = $row['nombre'];
    }
    $m10 = 1;
}
//////ITEM = M11
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'M11' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrem11 = $row['nombre'];
    }
    $m11 = 1;
}
//////ITEM = M12
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'M12' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrem12 = $row['nombre'];
    }
    $m12 = 1;
}
//////ITEM = M12
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'M13' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrem13 = $row['nombre'];
    }
    $m13 = 1;
}

//////ITEM = M14
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'M14' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrem14 = $row['nombre'];
    }
    $m14 = 1;
}
