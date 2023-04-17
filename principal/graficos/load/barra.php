<?php
require('../../../conexion.php');
include('../../session_user.php');
require_once('../../../titulo_sist.php');
$year = $_GET['year'];


?>

<script type="text/javascript">
    $(function () {
        $('#barra').highcharts({
            chart: {
                type: 'column',
                margin:95,
                options3d:{
                    enabled:true,
                    alpha:10,
                    beta:25,
                    depth:70
                }
            },
            title: {
                text: 'Grafica Horizontal'
            },
            subtitle: {
                text: 'reporte de venta'
            },
            plotOptions:{
                column:{
                  depth:25  
                }
            },
            xAxis: {
                categories: [
<?php

$sql1 = "SELECT U.nomusu FROM venta as V   INNER JOIN usuario as U ON V.usecod=U.usecod where MONTH(V.invfec)='$year' and V.sucursal='$zzcodloc' and V.estado ='0' and V.val_habil='0'  group by V.usecod";
$result1 = mysqli_query($conexion, $sql1);
while ($row = mysqli_fetch_array($result1)) {
    ?>

                        ['<?php echo $row[0] ?>'],
    <?php } ?>
                ]
                
            },
            yAxis: {
                title: {
                    text: null
                }
            },
            
            series: [{
                    name: 'Venta',
                    data: [
<?php
$sql = "SELECT sum(invtot) as venta FROM venta where MONTH(invfec)='$year' and sucursal='$zzcodloc' and estado ='0' and val_habil='0' group by usecod";
$result = mysqli_query($conexion, $sql);
while ($row = mysqli_fetch_array($result)) {
    ?>
                            [<?php echo $row['venta'] ?>],
    <?php
}
?>
                    ]
                }]
        });
    });
</script>

<div id="barra" style="height: 400px;"></div>