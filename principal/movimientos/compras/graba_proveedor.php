<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$btn	    = $_POST['btn'];
$paginas	= $_POST['paginas'];
function quitar($mensaje)
{
					$mensaje = str_replace("<","&lt;",$mensaje);
					$mensaje = str_replace(">","&gt;",$mensaje);
					$mensaje = str_replace("\'","&#39;",$mensaje);
					$mensaje = str_replace('\"',"&quot;",$mensaje);
					$mensaje = str_replace("\\\\","&#92;",$mensaje);
					return $mensaje;
}
if ($_POST['ext'])
{
	header("Location: mov_proveedor.php?pageno=$paginas");
}
if ($btn == 4)
{
/////GARABA O MODIFICA DATOS
	$nom			= $_POST['nom'];	
	$ruc			= $_POST['ruc'];		
	$direccion		= $_POST['direccion'];		
	$departamento	= $_POST['departamento'];	
	$provincia		= $_POST['provincia'];	
	$representante	= $_POST['representante'];		
	$distrito		= $_POST['distrito'];
	$fono			= $_POST['fono'];
	$tipo			= $_POST['tipo'];
	$val			= $_POST['val'];
	$lcredito    	= $_POST['lcredito'];
	$nextel      	= $_POST['nextel'];
	$mail       	= $_POST['mail'];
	if ($departamento == 0)			////PARA EL CASO DE MODIFICAR
	{
	$departamento	= $_POST['dpto'];	
	$provincia		= $_POST['prov'];	
	$distrito		= $_POST['dist'];	
	}
	if ($val == 1)
	{
		$cod		= $_POST['cod_nuevo'];
		//////////////////////////////////////////////////
//		$sql = "SELECT rucpro, despro FROM proveedor WHERE rucpro <> '' and (rucpro='".quitar($HTTP_POST_VARS["ruc"])."' or despro='".quitar($HTTP_POST_VARS["nom"])."')";
                $sql = "SELECT rucpro, despro FROM proveedor WHERE rucpro <> '' and rucpro='$ruc'";
		$result = mysqli_query($conexion,$sql);
		if($row = mysqli_fetch_array($result))
		{
			header("Location: mov_proveedor.php?error=2&pageno=$paginas");
		}
		else
		{
				/////////VERIFICO QUE ESTE CODIGO NO SEA UTILIZADO
				$sql="SELECT codpro FROM proveedor where codpro = '$cod'";
				$result = mysqli_query($conexion,$sql);
				if (mysqli_num_rows($result)){
				$cod = $cod + 1;
				$t = 0;
					while($t == 1)
					{
						$sql1="SELECT codpro FROM proveedor where codpro = '$cod'";
						$result1 = mysqli_query($conexion,$sql1);
						if (mysqli_num_rows($result1)){
						$cod = $cod + 1;
						}
						else
						{
						$t = 1;
						}
					}
				}
		mysqli_query($conexion,"INSERT INTO proveedor (codpro,despro,dirpro,dptpro,propro,dispro,rucpro,telpro,tipcli,codusu,lcredito,representante,nextel,mail) values ('$cod','$nom','$direccion','$departamento','$provincia','$distrito','$ruc','$fono','$tipo','$usuario','$lcredito','$representante','$nextel','$mail')");
	
//		header("Location: actualiza_compra.php?alfa1=$cod"); 
		header("Location: mov_proveedor.php?close=1&country_ID2=$cod"); 
		}
	}
	////MODIFICO DATOS
	if ($val == 2)
	{
			
			$codigo		= $_POST['cod_modif_del'];
			$sql="SELECT rucpro,rucpro FROM proveedor where codpro = '$codigo'";
			$result = mysqli_query($conexion,$sql);
			if (mysqli_num_rows($result) ){
			while ($row = mysqli_fetch_array($result)){
				 $descripcion_pro		 = $row["despro"];
				 $ruc_pro		         = $row["rucpro"];
			}
			}
			if (($ruc == $ruc_pro) and ($nom == $descripcion_pro))
			{
			mysqli_query($conexion,"update proveedor set dirpro = '$direccion', dptpro = '$departamento', propro = '$provincia', dispro = '$distrito', telpro = '$fono', tipcli = '$tipo',lcredito = '$lcredito',representante = '$representante',nextel = '$nextel',mail = '$mail'  where codpro = '$codigo'");
			header("Location: mov_proveedor.php?up=1&pageno=$paginas");
			}
			else
			{
					if (($ruc == $ruc_pro) && ($ruc <> ""))
					{
						$sql = "SELECT despro FROM proveedor WHERE despro='$nom'";
						$result = mysqli_query($conexion,$sql);
						if($row = mysqli_fetch_array($result))
						{
						header("Location: mov_proveedor.php?error=2&pageno=$paginas");
						}
						else
						{
						mysqli_query($conexion,"update proveedor set despro = '$nom', dirpro = '$direccion', dptpro = '$departamento', propro = '$provincia', dispro = '$distrito', telpro = '$fono', tipcli = '$tipo',lcredito = '$lcredito',representante = '$representante',nextel = '$nextel',mail = '$mail' where codpro = '$codigo'");
						header("Location: mov_proveedor.php?up=1&pageno=$paginas");
						}				
					}
					else
					{
						if ($nom == $descripcion_pro)
						{
							$sql = "SELECT rucpro FROM proveedor WHERE rucpro <> '' and rucpro='$ruc'";
							$result = mysqli_query($conexion,$sql);
							if($row = mysqli_fetch_array($result))
							{
							header("Location: mov_proveedor.php?error=2&pageno=$paginas");
							}
							else
							{
							mysqli_query($conexion,"update proveedor set rucpro = '$ruc', dirpro = '$direccion', dptpro = '$departamento', propro = '$provincia', dispro = '$distrito', telpro = '$fono', tipcli = '$tipo',lcredito = '$lcredito',representante = '$representante',nextel = '$nextel',mail = '$mail' where codpro = '$codigo'");
							header("Location: mov_proveedor.php?up=1&pageno=$paginas");
							}
					    }
						else
						{
							$sql = "SELECT rucpro, despro FROM proveedor WHERE despro='$nom' or rucpro='$ruc'";
							$result = mysqli_query($conexion,$sql);
							if($row = mysqli_fetch_array($result))
							{
							header("Location: mov_proveedor.php?error=2&pageno=$paginas");
							}
							else
							{
							mysqli_query($conexion,"update proveedor set despro = '$nom', rucpro = '$ruc', dirpro = '$direccion', dptpro = '$departamento', propro = '$provincia', dispro = '$distrito', telpro = '$fono', tipcli = '$tipo',lcredito = '$lcredito',representante = '$representante',nextel = '$nextel',mail = '$mail' where codpro = '$codigo'");
							header("Location: mov_proveedor.php?up=1&pageno=$paginas");
							}
						}
					}
			}
	}	
}
if ($btn == 5)
{
			$codigo		= $_POST['cod_modif_del'];
			mysqli_query($conexion,"DELETE from proveedor where codpro = '$codigo'");
			header("Location: mov_proveedor.php?del=1");
}
if ($btn == 6)
{
			header("Location: ../../index.php");
}
?>