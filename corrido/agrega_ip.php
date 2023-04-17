<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>AGREGA IP`S</title>
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <script>
    function validar() {
      var f = document.form1;
      if (f.ip.value == "") {
        alert("Ingrese el numero IP del Cliente");
        f.ip.focus();
        return;
      }
      f.method = "POST";
      f.action = "graba_ip.php";
      f.submit();
    }
  </script>
</head>
<?php require_once('conexion.php');  //CONEXION A BASE DE DATOS
?>
<?php require_once('funciones/funct_principal.php');  //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
require_once('detecta_ip.php');
$ok = $_GET['ok'];
$error = $_GET['error'];
if ($ok == 1) {
  $desc = "SE LOGRO GRABAR EXITOSAMENTE ESTE IP";
  $color = "#0066CC";
}
if ($error == 2) {
  $desc = "NO SE PUDO GRABAR YA QUE ESTA IP EXISTE EN EL SISTEMA";
  $color = "#990000";
}
?>

<body>
  <form id="form1" name="form1">
    <table width="412" border="0">
      <tr>
        <td>MI IP </td>
        <td><?php echo $detect_ip; ?></td>
      </tr>
      <tr>
        <td width="59">LOCAL</td>
        <td width="343"><label>
            <select name="local" class="Estilodany" id="local">
              <?php
              $sql = "SELECT * FROM xcompa where habil = '1' order by codloc";
              $result = mysqli_query($conexion, $sql);
              while ($row = mysqli_fetch_array($result)) {
              ?>
                <option value="<?php echo $row["codloc"] ?>" class="Estilodany"><?php echo strtoupper($row["nomloc"]) ?></option>
              <?php } ?>
            </select>
          </label></td>
      </tr>
      <tr>
        <td>IP</td>
        <td><label>
            <input name="ip" type="text" id="ip" size="40" onKeyPress="return decimal(event)" />
            <input type="button" name="Submit" value="Grabar" onclick="validar()" />
          </label></td>
      </tr>
    </table>
    <br>
    <font color="<?php echo $color ?>">
      <?php echo $desc;
      ?>
    </font>
  </form>
</body>

</html>