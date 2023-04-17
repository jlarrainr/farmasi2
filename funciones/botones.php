<?php
$i = 0;
$sql = "SELECT * FROM color_modulo";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
  while ($row = mysqli_fetch_array($result)) {
    $i++;
    $Botonesclientesventas   = $row["Botonesclientesventas"];
    $primero                 = $row["primero"];
    $anterior                = $row["anterior"];
    $siguiente               = $row["siguiente"];
    $ultimo                = $row["ultimo"];
    $ver                    = $row["ver"];
    $nuevo                   = $row["nuevo"];
    $modificar               = $row["modificar"];
    $eliminar                = $row["eliminar"];
    $grabar                  = $row["grabar"];
    $buscar                  = $row["buscar"];
    $cancelar                = $row["cancelar"];
    $preliminar              = $row["preliminar"];
    $imprimir                = $row["imprimir"];
    $consulta                = $row["consulta"];
    $salir                   = $row["salir"];
    $prodstock               = $row["prodstock"];
    $prodincent            = $row["prodincent"];
    $prodnormal            = $row["prodnormal"];
    $regresar               = $row["regresar"];
    $limpiar                = $row["limpiar"];
    $prodstock                = $row["prodstock"];
    $prodincent              = $row["prodincent"];
    $prodnormal              = $row["prodnormal"];
    $cobrar                  = $row["cobrar"];
    $grabarventa             = $row["grabarventa"];
  }
}
?>
<style type="text/css">
  input.primero {


    color: #fff;
    width: auto;
    font-weight: bold;
    display: inline-block;
    padding: 5px 15px;
    font-size: 1.25em cursor: pointer;
    text-align: center;
    text-decoration: none;
    outline: none;
    background-color: <?php echo $primero ?>;
    border: none;
    border-radius: 3px;
    box-shadow: 0px 3px 0px #2980b9;
  }

  input.primero:hover {
    background-color: #2980b9
  }

  input.primero:active {
    background-color: #416780;
    box-shadow: 0 5px #4f767c;
    transform: translateY(4px);
  }

  input.siguiente {
    color: #fff;
    width: auto;
    font-weight: bold;
    display: inline-block;
    padding: 5px 15px;
    font-size: 1.25em cursor: pointer;
    text-align: center;
    text-decoration: none;
    outline: none;
    background-color: <?php echo $siguiente ?>;
    border: none;
    border-radius: 3px;
    box-shadow: 0px 3px 0px #2980b9;

  }

  input.siguiente:hover {
    background-color: #2980b9
  }

  input.siguiente:active {
    background-color: #416780;
    box-shadow: 0 5px #4f767c;
    transform: translateY(4px);
  }

  input.anterior {
    color: #fff;
    width: auto;
    font-weight: bold;
    display: inline-block;
    padding: 5px 15px;
    font-size: 1.25em cursor: pointer;
    text-align: center;
    text-decoration: none;
    outline: none;
    background-color: <?php echo $anterior ?>;
    border: none;
    border-radius: 3px;
    box-shadow: 0px 3px 0px #2980b9;

  }

  input.anterior:hover {
    background-color: #2980b9
  }

  input.anterior:active {
    background-color: #416780;
    box-shadow: 0 5px #4f767c;
    transform: translateY(4px);
  }

  input.ultimo {
    color: #fff;
    width: auto;
    font-weight: bold;
    display: inline-block;
    padding: 5px 15px;
    font-size: 1.25em cursor: pointer;
    text-align: center;
    text-decoration: none;
    outline: none;
    background-color: <?php echo $ultimo ?>;
    border: none;
    border-radius: 3px;
    box-shadow: 0px 3px 0px #2980b9;

  }

  input.ultimo:hover {
    background-color: #2980b9
  }

  input.ultimo:active {
    background-color: #416780;
    box-shadow: 0 5px #4f767c;
    transform: translateY(4px);
  }

  input.ver {
    color: #fff;
    width: auto;
    font-weight: bold;
    display: inline-block;
    padding: 5px 15px;
    font-size: 1.25em cursor: pointer;
    text-align: center;
    text-decoration: none;
    outline: none;
    background-color: <?php echo $ver ?>;
    border: none;
    border-radius: 3px;
    box-shadow: 0px 3px 0px #2980b9;

  }

  input.ver:hover {
    background-color: #2980b9
  }

  input.ver:active {
    background-color: #416780;
    box-shadow: 0 5px #4f767c;
    transform: translateY(4px);
  }

  input.nuevo {
    color: #fff;
    width: auto;
    font-weight: bold;
    display: inline-block;
    padding: 5px 15px;
    font-size: 1.25em cursor: pointer;
    text-align: center;
    text-decoration: none;
    outline: none;
    background-color: <?php echo $nuevo ?>;
    border: none;
    border-radius: 3px;
    box-shadow: 0px 3px 0px #d35400;

  }

  input.nuevo:hover {
    background-color: #d35400
  }

  input.nuevo:active {
    background-color: #416780;
    box-shadow: 0 5px #4f767c;
    transform: translateY(4px);
  }

  input.modificar {
    color: #fff;
    width: auto;
    font-weight: bold;
    display: inline-block;
    padding: 5px 15px;
    font-size: 1.25em cursor: pointer;
    text-align: center;
    text-decoration: none;
    outline: none;
    background-color: <?php echo $modificar ?>;
    border: none;
    border-radius: 3px;
    box-shadow: 0px 3px 0px #d35400;

  }

  input.modificar:hover {
    background-color: #d35400
  }

  input.modificar:active {
    background-color: #416780;
    box-shadow: 0 5px #4f767c;
    transform: translateY(4px);
  }

  input.eliminar {
    color: #fff;
    width: auto;
    font-weight: bold;
    display: inline-block;
    padding: 5px 15px;
    font-size: 1.25em cursor: pointer;
    text-align: center;
    text-decoration: none;
    outline: none;
    background-color: <?php echo $eliminar ?>;
    border: none;
    border-radius: 3px;
    box-shadow: 0px 3px 0px #c0392b;

  }

  input.eliminar:hover {
    background-color: #c0392b
  }

  input.eliminar:active {
    background-color: #416780;
    box-shadow: 0 5px #4f767c;
    transform: translateY(4px);
  }

  input.grabarventa {
    color: #fff;
    width: auto;
    font-weight: bold;
    display: inline-block;
    padding: 5px 15px;
    font-size: 1.25em cursor: pointer;
    text-align: center;
    text-decoration: none;
    outline: none;
    background-color: <?php echo $grabarventa ?>;
    border: none;
    border-radius: 3px;
    box-shadow: 0px 3px 0px #27ae60;

  }

  input.grabarventa:hover {
    background-color: #27ae60
  }

  input.grabarventa:active {
    background-color: #416780;
    box-shadow: 0 5px #4f767c;
    transform: translateY(4px);
  }


  input.grabar {
    color: #fff;
    width: 70px;
    font-weight: bold;
    display: inline-block;
    padding: 5px 15px;
    font-size: 1.25em cursor: pointer;
    text-align: center;
    text-decoration: none;
    outline: none;
    background-color: <?php echo $grabar ?>;
    border: none;
    border-radius: 3px;
    box-shadow: 0px 3px 0px #27ae60;

  }

  input.grabar:hover {
    background-color: #27ae60
  }

  input.grabar:active {
    background-color: #416780;
    box-shadow: 0 5px #4f767c;
    transform: translateY(4px);
  }

  input.cobrar {
    color: #fff;
    width: 1240px;
    font-weight: bold;
    display: inline-block;
    padding: 5px 15px;
    font-size: 1.45em;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    outline: none;
    background-color: <?php echo $grabar ?>;
    border: none;
    border-radius: 3px;
    box-shadow: 0px 3px 0px #27ae60;

  }

  input.cobrar:hover {
    background-color: #27ae60
  }

  input.cobrar:active {
    background-color: #416780;
    box-shadow: 0 5px #4f767c;
    transform: translateY(4px);
  }


  input.buscar {
    color: #fff;
    width: auto;
    font-weight: bold;
    display: inline-block;
    padding: 5px 15px;
    font-size: 1.25em cursor: pointer;
    text-align: center;
    text-decoration: none;
    outline: none;
    background-color: <?php echo $buscar ?>;
    border: none;
    border-radius: 3px;
    box-shadow: 0px 3px 0px #2980b9;


  }

  input.buscar:hover {
    background-color: #2980b9
  }

  input.buscar:active {
    background-color: #416780;
    box-shadow: 0 5px #4f767c;
    transform: translateY(4px);
  }



  input.preliminar {
    color: #fff;
    width: auto;
    font-weight: bold;
    display: inline-block;
    padding: 5px 15px;
    font-size: 1.25em cursor: pointer;
    text-align: center;
    text-decoration: none;
    outline: none;
    background-color: <?php echo $preliminar ?>;
    border: none;
    border-radius: 3px;
    box-shadow: 0px 3px 0px #2980b9;

  }

  input.preliminar:hover {
    background-color: #2980b9
  }

  input.preliminar:active {
    background-color: #416780;
    box-shadow: 0 5px #4f767c;
    transform: translateY(4px);
  }


  input.Botonesclientesventas {
    color: #fff;
    width: auto;
    font-weight: bold;
    display: inline-block;
    padding: 5px 25px;
    font-size: 1.25em cursor: pointer;
    text-align: center;
    text-decoration: none;
    outline: none;
    background-color: <?php echo $Botonesclientesventas ?>;
    border: none;
    border-radius: 3px;
    box-shadow: 0px 3px 0px #2980b9;
  }

  input.Botonesclientesventas:hover {
    background-color: #2980b9
  }

  input.Botonesclientesventas:active {
    background-color: #416780;
    box-shadow: 0 5px #4f767c;
    transform: translateY(4px);
  }



  input.cancelar {
    color: #fff;
    width: auto;
    font-weight: bold;
    display: inline-block;
    padding: 5px 15px;
    font-size: 1.25em cursor: pointer;
    text-align: center;
    text-decoration: none;
    outline: none;
    background-color: <?php echo $cancelar ?>;
    border: none;
    border-radius: 3px;
    box-shadow: 0px 3px 0px #c0392b;

  }

  input.cancelar:hover {
    background-color: #c0392b
  }

  input.cancelar:active {
    background-color: #416780;
    box-shadow: 0 5px #4f767c;
    transform: translateY(4px);
  }



  input.imprimir {
    color: #fff;
    width: auto;
    font-weight: bold;
    display: inline-block;
    padding: 5px 15px;
    font-size: 1.25em cursor: pointer;
    text-align: center;
    text-decoration: none;
    outline: none;
    background-color: <?php echo $imprimir ?>;
    border: none;
    border-radius: 3px;
    box-shadow: 0px 3px 0px #2c3e50;

  }

  input.imprimir:hover {
    background-color: #2c3e50
  }

  input.imprimir:active {
    background-color: #416780;
    box-shadow: 0 5px #4f767c;
    transform: translateY(4px);
  }

  input.consultar {
    color: #fff;
    width: auto;
    font-weight: bold;
    display: inline-block;
    padding: 5px 15px;
    font-size: 1.25em cursor: pointer;
    text-align: center;
    text-decoration: none;
    outline: none;
    background-color: <?php echo $consulta ?>;
    border: none;
    border-radius: 3px;
    box-shadow: 0px 3px 0px #2980b9;

  }

  input.consultar:hover {
    background-color: #2980b9
  }

  input.consultar:active {
    background-color: #416780;
    box-shadow: 0 5px #4f767c;
    transform: translateY(4px);
  }

  input.regresar {
    color: #fff;
    width: auto;
    font-weight: bold;
    display: inline-block;
    padding: 5px 15px;
    font-size: 1.25em cursor: pointer;
    text-align: center;
    text-decoration: none;
    outline: none;
    background-color: <?php echo $regresar ?>;
    border: none;
    border-radius: 3px;
    box-shadow: 0px 3px 0px #c0392b;
  }

  input.regresar:hover {
    background-color: #c0392b
  }

  input.regresar:active {
    background-color: #416780;
    box-shadow: 0 5px #4f767c;
    transform: translateY(4px);
  }

  input.limpiar {
    color: #fff;
    width: auto;
    font-weight: bold;
    display: inline-block;
    padding: 5px 15px;
    font-size: 1.25em cursor: pointer;
    text-align: center;
    text-decoration: none;
    outline: none;
    background-color: <?php echo $limpiar ?>;
    border: none;
    border-radius: 3px;
    box-shadow: 0px 3px 0px #d35400;

  }

  input.limpiar:hover {
    background-color: #d35400
  }

  input.limpiar:active {
    background-color: #416780;
    box-shadow: 0 5px #4f767c;
    transform: translateY(4px);
  }

  input.salir {
    color: #fff;
    width: 70px;
    font-weight: bold;
    display: inline-block;
    padding: 5px 15px;
    font-size: 1.25em cursor: pointer;
    text-align: center;
    text-decoration: none;
    outline: none;
    background-color: <?php echo $salir ?>;
    border: none;
    border-radius: 3px;
    box-shadow: 0px 3px 0px #c0392b;


  }

  input.salir:hover {
    background-color: #c0392b
  }

  input.salir:active {
    background-color: #416780;
    box-shadow: 0 5px #4f767c;
    transform: translateY(4px);
  }

  input.prodRMedica {
    background: <?php echo $prodstock ?>;
    width: 20px;
  }
  
  input.prodstock {
    background: #be69e9;
    width: 20px;
  }

  input.prodincent {
    background: <?php echo $prodincent ?>;
    width: 20px;
  }

  input.prodnormal {
    background: <?php echo $prodnormal ?>;
    width: 20px;
  }

  .prodRMedica:link {
    color: #be69e9;
  }

  .prodRMedica:visited {
    color: #be69e9;
  }

  .prodRMedica:hover {
    color: #be69e9;
  }

  .prodRMedica:active {
    color: #be69e9;
  }















.prodstock:link {
    color: <?php echo $prodstock ?>;
  }

  .prodstock:visited {
    color: <?php echo $prodstock ?>;
  }

  .prodstock:hover {
    color: <?php echo $prodstock ?>;
  }

  .prodstock:active {
    color: <?php echo $prodstock ?>;
  }
  .prodincent:link {
    color: <?php echo $prodincent ?>;
  }

  .prodincent:visited {
    color: <?php echo $prodincent ?>;
  }

  .prodincent:hover {
    color: <?php echo $prodincent ?>;
  }

  .prodincent:active {
    color: <?php echo $prodincent ?>;
  }

  .prodnormal:link {
    color: <?php echo $prodnormal ?>;
  }

  .prodnormal:visited {
    color: <?php echo $prodnormal ?>;
  }

  .prodnormal:hover {
    color: <?php echo $prodnormal ?>;
  }

  .prodnormal:active {
    color: <?php echo $prodnormal ?>;
  }

  .text_prodRMedica {
    font-family: Trebuchet MS;
    font-size: 17px;
    line-height: normal;
    color: #be69e9;
  }
  
  .text_prodstock {
    font-family: Trebuchet MS;
    font-size: 17px;
    line-height: normal;
    color: <?php echo $prodstock ?>;
  }

  .text_prodincent {
    font-family: Trebuchet MS;
    font-size: 17px;
    line-height: normal;
    color: <?php echo $prodincent ?>;
  }

  .text_prodnormal {
    font-family: Trebuchet MS;
    font-size: 17px;
    line-height: normal;
    color: <?php echo $prodnormal ?>;
  }
</style>