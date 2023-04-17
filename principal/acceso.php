<?php include('session_user.php');

$sql = "SELECT codgrup FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codgrup    = $row['codgrup'];
    }
}

$a1 = 0;
$a2 = 0;
$a3 = 0;
$a4 = 0;
$a5 = 0;
$a6 = 0;
$a7 = 0;
$a8 = 0;
$a9 = 0;
$a10 = 0;
$a11 = 0;
$a12 = 0;
$a13 = 0;
$a14 = 0;
$a15 = 0;
$a16 = 0;
$a17 = 0;
$a18 = 0;
$a19 = 0;
$a21 = 0;
$a22 = 0;
$a23 = 0;
$a24 = 0;
$m1 = 0;
$m2 = 0;
$m3 = 0;
$m4 = 0;
$m5 = 0;
$m6 = 0;
$m7 = 0;
$m8 = 0;
$m9 = 0;
$m10 = 0;
$m11 = 0;
$m12 = 0;



$f1 = 0;
$f2 = 0;
$u1 = 0;
$u2 = 0;
$u3 = 0;
$u4 = 0;
$r1 = 0;
$r2 = 0;
$r3 = 0;
$r4 = 0;
$r5 = 0;
$r6 = 0;
$r7 = 0;
$r8 = 0;
$r9 = 0;
$r10 = 0;
$r11 = 0;
$r12 = 0;
$r13 = 0;
$r14 = 0;
$r15 = 0;
$r16 = 0;
$r17 = 0;
$r18 = 0;
$r19 = 0;
$r20 = 0;
$r21 = 0;
$r22 = 0;
$r23 = 0;
$r24 = 0;
$r25 = 0;
$r26 = 0;
$r27 = 0;
$r28 = 0;
$r29 = 0;
$r30 = 0;
$r31 = 0;
$r32 = 0;
$r33 = 0;
$c1 = 0;
$c2 = 0;
$c3 = 0;
$c4 = 0;
$c5 = 0;
$c6 = 0;
$c7 = 0;
$c8 = 0;
$c9 = 0;
$c10 = 0;
$c11 = 0;

$s1 = 0;
$s2 = 0;
$s3 = 0;
$s4 = 0;
$s5 = 0;
$s6 = 0;
/*
$sql="SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where codgrup = '$codgrup'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
	$accesos = mysqli_fetch_all($result);
}

error_log("accesos:" . print_r($accesos));
*/
/////ARCHIVOS//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////ITEM = A1
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'A1' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrea1 = $row['nombre'];
    }

    $a1 = 1;
}
//////ITEM = A2
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'A2' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrea2 = $row['nombre'];
    }
    $a2 = 1;
}
//////ITEM = A3
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'A3' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrea3 = $row['nombre'];
    }
    $a3 = 1;
}
//////ITEM = A4
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'A4' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrea4 = $row['nombre'];
    }
    $a4 = 1;
}
//////ITEM = A5
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'A5' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrea5 = $row['nombre'];
    }
    $a5 = 1;
}
//////ITEM = A6
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'A6' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    $a6 = 1;
    while ($row = mysqli_fetch_array($result)) {
        $nombrea6 = $row['nombre'];
    }
    $a6 = 1;
}
//////ITEM = A7
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'A7' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrea7 = $row['nombre'];
    }
    $a7 = 1;
}
//////ITEM = A8
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'A8' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrea8 = $row['nombre'];
    }
    $a8 = 1;
}
//////ITEM = A9
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'A9' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrea9 = $row['nombre'];
    }
    $a9 = 1;
}
//////ITEM = A10
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'A10' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrea10 = $row['nombre'];
    }
    $a10 = 1;
}
//////ITEM = A11
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'A11' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrea11 = $row['nombre'];
    }
    $a11 = 1;
}
//////ITEM = A12
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'A12' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrea12 = $row['nombre'];
    }
    $a12 = 1;
}
//////ITEM = A13
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'A13' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrea13 = $row['nombre'];
    }
    $a13 = 1;
}
//////ITEM = A14
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'A14' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrea14 = $row['nombre'];
    }
    $a14 = 1;
}
//////ITEM = A15
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'A15' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrea15 = $row['nombre'];
    }
    $a15 = 1;
}
//////ITEM = A16
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'A16' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrea16 = $row['nombre'];
    }
    $a16 = 1;
}
//////ITEM = A17
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'A17' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrea17 = $row['nombre'];
    }
    $a17 = 1;
}
//////ITEM = A18
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'A18' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrea18 = $row['nombre'];
    }
    $a18 = 1;
}
//////ITEM = A19
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'A19' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrea19 = $row['nombre'];
    }
    $a19 = 1;
}
//////ITEM = A20
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'A20' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrea20 = $row['nombre'];
    }
    $a20 = 1;
}
//////ITEM = A21
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'A21' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrea21 = $row['nombre'];
    }
    $a21 = 1;
}
//////ITEM = A22
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'A22' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrea22 = $row['nombre'];
    }
    $a22 = 1;
}
//////ITEM = A23
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'A23' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrea23 = $row['nombre'];
    }
    $a23 = 1;
}
//////ITEM = A24
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'A24' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrea24 = $row['nombre'];
    }
    $a24 = 1;
}
/////MOVIMIENTOS//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////ITEM = M1
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'M1' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrem1 = $row['nombre'];
    }
    $m1 = 1;
}
//////ITEM = M2
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'M2' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrem2 = $row['nombre'];
    }
    $m2 = 1;
}
//////ITEM = M3
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'M3' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrem3 = $row['nombre'];
    }
    $m3 = 1;
}
//////ITEM = M4
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'M4' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrem4 = $row['nombre'];
    }
    $m4 = 1;
}
//////ITEM = M5
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'M5' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrem5 = $row['nombre'];
    }
    $m5 = 1;
}
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
/////FINANZAS//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////ITEM = F1
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'F1' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombref1 = $row['nombre'];
    }
    $f1 = 1;
}
//////ITEM = F2
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'F2' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombref2 = $row['nombre'];
    }
    $f2 = 1;
}
/////AUDITOR//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////ITEM = U1
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'U1' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombreu1 = $row['nombre'];
    }
    $u1 = 1;
}
//////ITEM = U2
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'U2' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombreu2 = $row['nombre'];
    }
    $u2 = 1;
}
//////ITEM = U3
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'U3' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombreu3 = $row['nombre'];
    }
    $u3 = 1;
}
//////ITEM = U4
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'U4' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombreu4 = $row['nombre'];
    }
    $u4 = 1;
}
/////REPORTES//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////ITEM = R1
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R1' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer1 = $row['nombre'];
    }
    $r1 = 1;
}
//////ITEM = R2
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R2' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer2 = $row['nombre'];
    }
    $r2 = 1;
}
//////ITEM = R3
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R3' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer3 = $row['nombre'];
    }
    $r3 = 1;
}
//////ITEM = R4
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R4' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer4 = $row['nombre'];
    }
    $r4 = 1;
}

//////ITEM = R5
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R5' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer5 = $row['nombre'];
    }
    $r5 = 1;
}

//////ITEM = R6
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R6' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer6 = $row['nombre'];
    }
    $r6 = 1;
}

//////ITEM = R7
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R7' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer7 = $row['nombre'];
    }
    $r7 = 1;
}

//////ITEM = R8
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R8' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer8 = $row['nombre'];
    }
    $r8 = 1;
}

//////ITEM = R9
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R9' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer9 = $row['nombre'];
    }
    $r9 = 1;
}

//////ITEM = R10
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R10' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer10 = $row['nombre'];
    }
    $r10 = 1;
}

//////ITEM = R11
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R11' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer11 = $row['nombre'];
    }
    $r11 = 1;
}

//////ITEM = R12
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R12' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer12 = $row['nombre'];
    }
    $r12 = 1;
}

//////ITEM = R13
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R13' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer13 = $row['nombre'];
    }
    $r13 = 1;
}

//////ITEM = R14
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R14' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer14 = $row['nombre'];
    }
    $r14 = 1;
}

//////ITEM = R15
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R15' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer15 = $row['nombre'];
    }
    $r15 = 1;
}

//////ITEM = R16
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R16' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer16 = $row['nombre'];
    }
    $r16 = 1;
}

//////ITEM = R17
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R17' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer17 = $row['nombre'];
    }
    $r17 = 1;
}

//////ITEM = R17
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R18' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer18 = $row['nombre'];
    }
    $r18 = 1;
}

//////ITEM = R19
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R19' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer19 = $row['nombre'];
    }
    $r19 = 1;
}

//////ITEM = R20
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R20' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer20 = $row['nombre'];
    }
    $r20 = 1;
}
//////ITEM = R21
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R21' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer21 = $row['nombre'];
    }
    $r21 = 1;
}
//////ITEM = R22
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R22' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer22 = $row['nombre'];
    }
    $r22 = 1;
}
//////ITEM = R23
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R23' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer23 = $row['nombre'];
    }
    $r23 = 1;
}
//////ITEM = R24
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R24' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer24 = $row['nombre'];
    }
    $r24 = 1;
}

//////ITEM = R25
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R25' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer25 = $row['nombre'];
    }
    $r25 = 1;
}
//////ITEM = R26
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R26' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer26 = $row['nombre'];
    }
    $r26 = 1;
}



//////ITEM = R27
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R27' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer27 = $row['nombre'];
    }
    $r27 = 1;
}

//////ITEM = R28
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R28' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer28 = $row['nombre'];
    }
    $r28 = 1;
}
//////ITEM = R29
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R29' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer29 = $row['nombre'];
    }
    $r29 = 1;
}//////ITEM = R30
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R30' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer30 = $row['nombre'];
    }
    $r30 = 1;
}

$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R31' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer31 = $row['nombre'];
    }
    $r31 = 1;
}

$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R32' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer32 = $row['nombre'];
    }
    $r32 = 1;
}

$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'R33' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrer33 = $row['nombre'];
    }
    $r33 = 1;
}


/////CONFIGURACION/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////ITEM = C1
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'C1' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrec1 = $row['nombre'];
    }
    $c1 = 1;
}

//////ITEM = C2
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'C2' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrec2 = $row['nombre'];
    }
    $c2 = 1;
}

//////ITEM = C3
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'C3' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrec3 = $row['nombre'];
    }
    $c3 = 1;
}

//////ITEM = C4
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'C4' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrec4 = $row['nombre'];
    }
    $c4 = 1;
}

//////ITEM = C5
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'C5' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrec5 = $row['nombre'];
    }
    $c5 = 1;
}

//////ITEM = C6
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'C6' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrec6 = $row['nombre'];
    }
    $c6 = 1;
}

//////ITEM = C7
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'C7' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrec7 = $row['nombre'];
    }
    $c7 = 1;
}

//////ITEM = C8
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'C8' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrec8 = $row['nombre'];
    }
    $c8 = 1;
}

//////ITEM = C9
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'C9' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrec9 = $row['nombre'];
    }
    $c9 = 1;
}

//////ITEM = C10
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'C10' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrec10 = $row['nombre'];
    }
    $c10 = 1;
}
//////ITEM = C11
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'C11' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombrec11 = $row['nombre'];
    }
    $c11 = 1;
}

//////ITEM = s1
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'S1' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombres1 = $row['nombre'];
    }
    $s1 = 1;
}

//////ITEM = s2
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'S2' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombres2 = $row['nombre'];
    }
    $s2 = 1;
}

//////ITEM = s3
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'S3' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombres3 = $row['nombre'];
    }
    $s3 = 1;
}
//////ITEM = s4
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'S4' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombres4 = $row['nombre'];
    }
    $s4 = 1;
}
//////ITEM = s5
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'S5' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombres5 = $row['nombre'];
    }
    $s5 = 1;
}

//////ITEM = s6
$sql = "SELECT acceso.idacceso,acceso.nombre FROM acceso inner join detalle_acceso on acceso.idacceso = detalle_acceso.idacceso where item = 'S6' and codgrup = '$codgrup'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nombres6 = $row['nombre'];
    }
    $s6 = 1;
}
