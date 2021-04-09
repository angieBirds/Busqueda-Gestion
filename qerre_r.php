<!--general details
type user:Turista-->
<?php 
include "php/conx.php"; 
include "php/reader.php"; 
include "php/sesion.php"; 
#Generar codigoQR
include'php/phpqrcode/qrlib.php';

if($_SESSION['tipo'] !=2){
	header("location:index.php");
}

$varsession= $_SESSION['id_u'];
if($varsession==null|| $varsession==''){ 
	print"<h3 class='bad'>ACCESO NO PERMITIDO</h3>";
	die();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<!--Area de metadatos-->
	<meta charset="utf-8"/>
	<meta name="viewport" content="width-devise-width, initial-scale=1.0"/>
	<title>Museo Regional de Puebla</title>
	<link rel="icon" href="images/mrp.ico">
</head>
<body>
	<!--HOJA DE ESTILOS CSS-->
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<!---Cabecera de la pagina-->
	<header id=header>
		<div class="center">
			<!--Logo--->
			<div id="logo">
				<a href="inicio.php">
					<img src="images/mrp.png" class="app-logo" alt="logotipo" href="inicio.php"></a>
			</div>
			<!--Menu-->
			<nav id="menu" class="estilo">
				<ul>
					<li>
						<a href="inicio.php">Registros</a>
					</li>
					<li>
						<a href="php/salir.php">Salir</a>
					</li>
				</ul>
			</nav>
			<!--Limpiar lo flotado-->
			<div class="clearfix"></div>
		</div>
	</header>
	<body>
	<!--Cuerpo de la pagina--->
	<div class="center">
		
		<!---Detalles del registro--->
		<?php 
		$id_r=$_GET["id_r"];
		$query="SELECT * FROM registro WHERE id_r=".$id_r;
		$r=mysqli_query($conexion, $query); 
		$dir = 'temp/';
		if (!file_exists($dir))
			$mkdir($dir);
		$host= $_SERVER["HTTP_HOST"];
		$url= $_SERVER["REQUEST_URI"];
		#echo "http://" . $host . $url;
		$filename= $dir. $id_r.'.png';
		$tam=10;
		$level='H';
		$frameSize=5;
		$contenido= "http://" . $host . $url;
		QRcode::png($contenido, $filename, $level, $tam, $frameSize);
		while ($data = mysqli_fetch_assoc($r)) {
			print '<img src= "'.$filename.'"/>';
			
		}
		mysqli_free_result($r);
		mysqli_close($conexion);
		?>
	</div>

	<!--Limpiar lo flotado-->
	<div class="clearfix"></div>

	<!---Pie de pagina--->
	<footer id="footer">
		<div class="center">
		 versión 1.0
		</div>
	</footer>
</body>
</html>