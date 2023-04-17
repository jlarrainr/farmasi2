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
	$l = substr($letters,0,1);
	if (($l <> "0") and ($l <> "1") and ($l <> "2") and ($l <> "3") and ($l <> "4") and ($l <> "5") and ($l <> "6") and ($l <> "7") and ($l <> "8") and ($l <> "9"))
	{
		$res = mysqli_query($conexion, "select codcli,descli,puntos,dnicli,ruccli from cliente where descli like '".$letters."%' limit $limit") or die(mysqli_error());
		while($inf = mysqli_fetch_array($res))
		{
			$ruccli = $inf['ruccli'];
			if (strlen($ruccli)>0)
			{
				$cad = "<u><b>RUC:</b> ".$inf['ruccli']." - <b>DNI:</b> ".$inf['dnicli']." - ".$inf['descli']." Puntos:".$inf['puntos']." </u>"."|";
			}
			else
			{
				$cad = "<u><b>DNI:</b> ".$inf['dnicli']." ".$inf['descli']." Puntos:".$inf['puntos']." </u>"."|";
			}
            echo $inf["codcli"]."###".$cad;
		}
	}
	else
	{
	    if (strlen($letters)==8)
	    {
	    	$res = mysqli_query($conexion, "select codcli,descli,puntos,dnicli,ruccli from cliente where dnicli = '".$letters."' limit $limit") or die(mysqli_error());
			while($inf = mysqli_fetch_array($res))
			{
				$ruccli = $inf['ruccli'];
				if (strlen($ruccli)>0)
				{
					$cad = "<u><b>RUC:</b> ".$inf['ruccli']." - <b>DNI:</b> ".$inf['dnicli']." - "."".$inf['descli']." Puntos:".$inf['puntos']." </u>"."|";
				}
				else
				{
					$cad = "<u><b>DNI:</b> ".$inf['dnicli']." - "."".$inf['descli']." Puntos:".$inf['puntos']." </u>"."|";
				}
				echo $inf['codcli']."###".$cad;
			}
	    }
	    else
	    {
	        if (strlen($letters)==11)
	        {
	            $res = mysqli_query($conexion, "select codcli,descli,puntos,dnicli,ruccli from cliente where ruccli = '".$letters."' limit $limit") or die(mysqli_error());
				while($inf = mysqli_fetch_array($res))
				{
					$ruccli = $inf['ruccli'];
					if (strlen($ruccli)>0)
					{
						$cad = "<u><b>RUC:</b> ".$inf['ruccli']." - <b>DNI:</b> ".$inf['dnicli']." - ".$inf['descli']." Puntos:".$inf['puntos']." </u>"."|";
					}
					else
					{
						$cad = "<u><b>DNI:</b> ".$inf['dnicli']." - "."".$inf['descli']." Puntos:".$inf['puntos']." </u>"."|";
					}
					echo $inf['codcli']."###".$cad;
				}
	        }
	    }
	}
}
?>
