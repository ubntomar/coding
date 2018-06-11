<?php
session_start();
if ( !isset($_SESSION['login']) || $_SESSION['login'] !== true) 
		{
		header('Location: login/index.php');
		exit;
		}
else    {
		$user=$_SESSION['username'];
		}
include("login/db.php");
$mysqli = new mysqli($server, $db_user, $db_pwd, $db_name);
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: " . $mysqli->connect_error;
	}	
mysqli_set_charset($mysqli,"utf8");
$today = date("Y-m-d");   
$convertdate= date("d-m-Y" , strtotime($today));
$hourMin = date('H:i');
$usuario=$_SESSION['username'];

$debug=0;
if($_POST['idClient']) {	
			$idClient = mysqli_real_escape_string($mysqli, $_REQUEST['idClient']);
			$detalle = mysqli_real_escape_string($mysqli, $_REQUEST['detalle']);	
			$source = mysqli_real_escape_string($mysqli, $_REQUEST['source']);
			$sqlSearch="SELECT `afiliados`.`pago` FROM `afiliados` WHERE `afiliados`.`id`=$idClient ";
			if ($result = $mysqli->query($sqlSearch)) {
				$rowf = $result->fetch_assoc();
				$valorPlan=$rowf["pago"];
				$sqlInsert="INSERT INTO `redesagi_facturacion`.`activaciones` (`id`, `id-cliente`, `accion`, `fecha`, `detalle`, `user`, `valor-plan`) VALUES (NULL, '$idClient', '$source', '$today', '$detalle', '$usuario', '$valorPlan');";					
				if ($result = $mysqli->query($sqlInsert)) {
					$sqlUpd="UPDATE `redesagi_facturacion`.`afiliados` SET `afiliados`.`suspender`=1 WHERE `afiliados`.`id`=$idClient";
					//echo $sqlUpd;
					if($result2 = $mysqli->query($sqlUpd)){						
						echo "Actualizado con éxito!!";	
					}
					else{
						echo "Error al actualizar cliente(Udpate suspender.)";	
					}
				}

				else{
					echo "Error al actualizar cliente(Insertar Activación)";
				}
			}
			else{
				echo "Error al consultar valor plan del cliente";
			}		
			
}
?>