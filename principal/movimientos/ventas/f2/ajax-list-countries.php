<?php 
require_once('../../../../conexion.php');	//CONEXION A BASE DE DATOS
if(isset($_REQUEST['getCountriesByLetters']) && isset($_REQUEST['letters']))
{
	$letters = $_REQUEST['letters'];
	//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
	$sql="SELECT limite FROM datagen_det";
    $result = mysqli_query($conexion,$sql);
    if (mysqli_num_rows($result))
	{
		while ($row = mysqli_fetch_array($result))
		{
			$limit             = $row["limite"];
		}
	}
	if ($limit == 0)
	{
	    $limit = 15;
	}
	$res = mysqli_query($conexion, "select codcli,descli,puntos,dnicli,ruccli,telcli from cliente where descli like '%".$letters."%' or dnicli like '%".$letters."%' or ruccli like '%".$letters."%' or codcli like '".$letters."%'  or telcli like '".$letters."%' limit $limit") or die(mysqli_error());
		while($inf = mysqli_fetch_array($res))
		{
		    if(strlen($inf['ruccli']) == 11){
		        
		        $documento= $inf['ruccli'];
		        $texto='RUC';
		    }else{
		        $documento= $inf['dnicli'];
		         $texto='DNI';
		    }
		    
			$ruccli = $inf['ruccli'];
			{
				$cad = "<u><b>His:</b> ".$inf['codcli']." <strong>$texto</strong> ".$documento." ".$inf['descli']."<strong> tel:</strong>".$inf['telcli']." Puntos:".$inf['puntos']." </u>"."|";
			}
            echo $inf["codcli"]."###".$cad;
		}
    
}
	
?>
