<?php
require('../../../conexion.php');
include('../../session_user.php');
require_once('../../../titulo_sist.php');
$year = $_GET['year'];
?>

<script type="text/javascript">
    $(function () {
        $('#horizontal').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Grafica Horizontal'
            },
            subtitle: {
                text: 'reporte de venta'
            },
            xAxis: {
                categories: [
<?php
//$sql1 = "SELECT * FROM venta where YEAR(invfec)='$year' group by usecod ";
$sql1 = "SELECT U.nomusu FROM venta as V   INNER JOIN usuario as U ON V.usecod=U.usecod where YEAR(V.invfec)='$year' and V.sucursal='$zzcodloc' and V.estado ='0' and V.val_habil='0' group by V.usecod";
$result1 = mysqli_query($conexion, $sql1);
while ($row = mysqli_fetch_array($result1)) {
    ?>

                        ['<?php echo $row[0] ?>'],
    <?php
}
?>

                ],
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Soles',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ''
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -40,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                shadow: true
            },
            credits: {
                enabled: false
            },
            series: [{
                    name: 'Venta',
                    data: [
<?php
$sql = "SELECT sum(invtot) as venta FROM venta where YEAR(invfec)='$year' and sucursal='$zzcodloc' and estado ='0' and val_habil='0' group by usecod";
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

<div id="horizontal" style="height: 400px;"></div>