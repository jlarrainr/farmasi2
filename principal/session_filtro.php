<?php
//include('session_user.php');
//require_once('../conexion.php');



// $_SESSION['count'] = $ingreso2;

// session_start();
if (isset($_SESSION['eduardo'])) {
  $sql = "SELECT ingreso2 FROM usuario where usecod = '$usuario'";
  $result = mysqli_query($conexion, $sql);
  if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
      $ingreso2 = $row['ingreso2'];
    }
  }
  if ($_SESSION['eduardo'] == "") {
    $_SESSION['eduardo'] = $ingreso2;
  }
  // $eduardo_muestra = $_SESSION['eduardo'];
} else {
  $sql = "SELECT ingreso2 FROM usuario where usecod = '$usuario'";
  $result = mysqli_query($conexion, $sql);
  if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
      $ingreso2 = $row['ingreso2'];
    }
  }
  if ($_SESSION['eduardo'] == "") {
    $_SESSION['eduardo'] = $ingreso2;
  }
  // $eduardo_muestra = $_SESSION['eduardo'];
}
