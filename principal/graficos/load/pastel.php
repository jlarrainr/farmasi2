<?php
require('../../../conexion.php');
include('../../session_user.php');
require_once('../../../titulo_sist.php');
$year = $_GET['year'];
?>

<script type="text/javascript">
    $(function () {
        $('#pastel').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'grafico de pastel'
            },
            subtitle: {
                text: 'reporte de venta'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                    name: 'ventas',
                    colorByPoint: true,
                    data: [
<?php
$sql1x = "SELECT U.nomusu,sum(V.invtot)   FROM venta as V   INNER JOIN usuario as U ON V.usecod=U.usecod where YEAR(V.invfec)='$year' and V.sucursal='$zzcodloc' and V.estado ='0' and V.val_habil='0' group by V.usecod";
$result1x = mysqli_query($conexion, $sql1x);
while ($row = mysqli_fetch_array($result1x)) {
    ?>

                            ['<?php echo $row[0] ?>',<?php echo $row[1] ?>],
<?php } ?>
                    ],
                }]
        });
    });
</script>

<div id="pastel" style="height: 400px;"></div>