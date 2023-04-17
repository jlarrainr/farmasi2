<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
    <?php  $nombre= basename(__DIR__);
    
    
    if ($nombre == 'prueba') {
            $nombreSistemax = 'farmasisPrueba22';
        }
    ?>
    
     <input id="sistemaN" name="sistemaN" type="hidden" value="<?php echo $nombreSistemax?>">
     <input id="localIngreso" name="localIngreso" type="hidden" value="<?php echo $zzcodloc?>">
     <input id="fechaVenci" name="fechaVenci" type="hidden" value="<?php echo date('Y-m-d')?>">
     
    <div class="container">

        
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Modal Header</h4>
                    </div>
                    <div class="modal-body">
                        <p id="error"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>

    </div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"> </script>
    <script>
        var accion = "alertaPago";
        var nombreSistema   = $("#sistemaN").val();
        var idLocalSistema  = $("#localIngreso").val();
        var fechaVenci      = $("#fechaVenci").val();
        var uri = "https://www.farmasis.us/sisreg/Modelo/apiAlertas.php?accion=" + accion + "&nombreSistema=" + nombreSistema + "&idLocalSistema=" + idLocalSistema + "&fechaVenci=" + fechaVenci + "";
        console.log(uri);
        $(document).ready(function() {
            $.ajax({
                url: uri,
                type: "GET",
                //data: datos,
                cache: false,
                processData: false,
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(respuestaHosting) {
                    console.log(respuestaHosting['data'][0]["mensajePantalla"]);
                    var mensaje = respuestaHosting['data'][0]["mensajePantalla"];
                   // if (respuestaHosting['total'] > 0) {
                        //  $('#myModal').modal("show");
                   //     alertify.alert("FARMASIS", "<h1><strong><center>" + mensaje + "</center></strong></h1>");
                   // }
                    //console.log(respuestaHosting.length);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    //console.log("some error");
                }
            });


        });
    </script>

</body>

</html>