<?php
require_once('../../conexion.php');
include('../session_user.php');
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>REPORTES GRAFICOS</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script src="Highcharts/js/highcharts.js"></script>
        <script src="Highcharts/js/highcharts-3d.js"></script>
        <script src="Highcharts/js/modules/exporting.js"></script>
        <style type="text/css">
            body{
                margin: 0;
                padding: 0;
                overflow-x: hidden;
            }
        </style>
        <script type="text/javascript">
            $(document).ready(function () {

                var hoy = new Date();
                var mm = hoy.getMonth()+1;
                var yyyy = hoy.getFullYear();
                horizontal(yyyy);
                pastel(yyyy);
                barra(mm);
            });


            function horizontal(year) {
                $('#horizontal').load('load/horizontal.php?year=' + year);
            }
            function pastel(year) {
                $('#pastel').load('load/pastel.php?year=' + year);
            }
            function barra(year) {
                $('#barra').load('load/barra.php?year=' + year);
            }
        </script>
    </head>
    <body>
       

      
        <div  style="justify-content: center;align-items: center;">
            <div class="col-7">
                <div id="barra" style="height: 300px"></div>
            </div>

            <!-- Force next columns to break to new line at md breakpoint and up -->
            <div class="w-100 d-none d-md-block"></div>

            <div class="col-7">  <select class="form-control" onchange="barra(this.value);">
                    <?php    
$Meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
       'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

for ($i=1; $i<=12; $i++) {
     if ($i == date('m'))
echo '<option value="'.$i.'"selected>'.$Meses[($i)-1].'</option>';
     else
echo '<option value="'.$i.'">'.$Meses[($i)-1].'</option>';
     }
?>
                </select>
            </div>
           <div align="center"><img src="../../images/line2.png" width="100%" height="5" /></div>
            <div >
                <div id="horizontal" style="height: 300px;" ></div>
            </div>

            <!-- Force next columns to break to new line at md breakpoint and up -->
            <div ></div>

            <div >  <select  onchange="horizontal(this.value);">
                    <?php
                    for ($i = 2020; $i < 2025; $i++) {
                        if ($i == 2020) {
                            echo "<option value=" . $i . " selected>" . $i . "</option>";
                        } else {
                            echo "<option value=" . $i . ">" . $i . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div align="center"><img src="../../images/line2.png" width="100%" height="5" /></div>
            <div class="col-7">
                <div id="pastel" style="height: 300px"></div>
            </div>

            <!-- Force next columns to break to new line at md breakpoint and up -->
            <div class="w-100 d-none d-md-block"></div>

            <div class="col-7">  <select class="form-control" onchange="pastel(this.value);">
                    <?php
                    for ($i = 2020; $i < 2025; $i++) {
                        if ($i == 2020) {
                            echo "<option value=" . $i . " selected>" . $i . "</option>";
                        } else {
                            echo "<option value=" . $i . ">" . $i . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            
            <div align="center"><img src="../../images/line2.png" width="100%" height="5" /></div>
            
        </div>
    </body>
</html>