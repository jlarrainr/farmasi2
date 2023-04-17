<?php 
//require_once('../../../conexion.php');
//include('../../../conexion.php');
function generaSelect()
{
    
    $usuario = $_SESSION['codigo_user'];
    $sql1="SELECT * FROM usuario where usecod = '$usuario'";
    $result1 = mysqli_query($conexion,$sql1);
    if (mysqli_num_rows($result1))
    {
        while ($row1 = mysqli_fetch_array($result1))
        {
            $codloc  = $row1['codloc'];
        }
    }
    $sql="SELECT codloc, nomloc, nombre FROM xcompa where habil = '1' and codloc <> '$codloc' order by codloc";
    $result = mysqli_query($conexion,$sql); 
    // Voy imprimiendo el primer select compuesto por los paises
    echo "<select name='local' id='local' onChange='cargaContenido(this.id)'>";
    echo "<option value='0'>Seleccione un Local</option>";
    while($row=mysqli_fetch_array($result))
    {
            ?>
            <option value="<?php echo $row[0]?>"><?php if ($row[2]<>''){echo $row[2];} else{echo $row[1];}?></option>
            <?php
    }
    echo "</select>";
}
?>