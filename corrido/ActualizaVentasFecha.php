<?php
require_once('conexion.php');
function CalculaFechaHoraX($fechaValor)
{
    $fechaValor = explode("-",$fechaValor); 
    $Fecha = mktime(0,0,0,$fechaValor[0], $fechaValor[1] - 1, $fechaValor[2]);
    return date("Y-m-d", $Fecha);exit;
}
function CalculaHoraX($hora)
{
    if (($hora >= 0) and ($hora <= 4))
    {
        if ($hora == 0)
        {
            return 19;
        }
        if ($hora == 1)
        {
            return 20;
        }
        if ($hora == 2)
        {
            return 21;
        }
        if ($hora == 3)
        {
            return 22;
        }
        if ($hora == 4)
        {
            return 23;
        }
    }
    else
    {
        $hora = $hora - 5;
        if ($hora < 0)
        {
            $HorasCalcular = $hora * -1;
            return intval(24 - $HorasCalcular);
        }
        else
        {
            return $hora;
        }
    }
}
$sql= "SELECT invnum,hora,invfec FROM venta where invnum <= 1681 order by invnum";
$result = mysqli_query($conexion,$sql);	
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    $invnum = $row['invnum'];
    $Hora   = $row['hora'];
    $Invfec = $row['invfec'];
    if (strlen($Hora)> 0)
    {
        //FORMATEAR FECHA A FORMATO M,D,Y
        $FechaFormat = explode("-", $Invfec);
        $Year = $FechaFormat[0];
        $Mes  = $FechaFormat[1];
        $Dia  = $FechaFormat[2];
        $FechaFotrmat2 = $Mes."-".$Dia."-".$Year;
        //FIN DE FORMATEO
        $horaSplit = explode(":", $Hora);
        $MinSplit  = explode(" ", $horaSplit[1]);
        $HoraC     = $horaSplit[0];
        $CalculaFecha = $HoraC - 5;
        if ($CalculaFecha < 0)
        {
            $date      = CalculaFechaHoraX($FechaFotrmat2);
        }
        else
        {
            $date      = $Invfec;
        }
        //echo ($HoraC)."xxxxxxxxxx";
        $hour      = CalculaHoraX($HoraC);
        $min	   = $MinSplit[0];
        if ($hour >= 12)
        {
            $PmAm = "pm";
        }
        else
        {
            if (($hour < 12) and ($hour > 0))
            {
                $PmAm = "am";
            }
            else
            {
                $PmAm = "pm";
            }
        }
        $HoraFinal = $hour.":".$min." ".$PmAm;
        //mysqli_query($conexion,"UPDATE venta set hora = '$HoraFinal',invfec = '$date' where invnum = '$invnum'");
        echo $invnum." = ".$Invfec." - ".$date." ".$Hora." - ".$HoraFinal."<br>";
    }
}
}
?>
