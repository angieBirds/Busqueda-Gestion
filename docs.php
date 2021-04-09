<!--general details
type user:Turista-->
<?php 	include "php/conx.php"; 
include "php/conx.php";
include "php/sesion.php";
if($_SESSION['tipo'] !=1 )
	{
		header("location:index.php");
	}
$varsession= $_SESSION['id_u'];
if($varsession==null|| $varsession==''){ ?>
	<h3 class="bad">ACCESO NO PERMITIDO</h3>
	<?php
	die();
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Motor de Busqueda y Gestión</title>
	<link rel="icon" href="images/mrp.ico">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
</html>

<?php
//Visualización del pdf
$id_r=$_GET["id_r"];
$query="SELECT * FROM registro WHERE id_r=".$id_r;
$r=mysqli_query($conexion, $query); 
	while ($data = mysqli_fetch_assoc($r)) { 
	
		$ruta=opendir("archivo");
		if($ruta){
			while($e_sd=readdir($ruta)){
				if($data["e_sd"]==$e_sd){
					header("Content-type: application/pdf");
					header("Content-Disposition: inline; filename=documento.pdf");
					readfile("archivo/".$data["e_sd"]);
				}
			} 
			if(mysqli_fetch_assoc($r)==''){
				print "<br><br><br><br><br><h3 class='bad'>NO SE ENCONTRÓ EL ARCHIVO</h3>";
				break;
			}
		}else{
			print "<br><br><br><br><br><h3 class='bad'>ERROR AL ABRIR LA CARPETA</h3>";
		}

		mysqli_free_result($r);
		mysqli_close($conexion);
	}
?>

