<!--general details
type user:Turista-->
<?php 	
include "php/conx.php"; ?>
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
				<img src="images/mrp.png" class="app-logo" alt="logotipo">
			</div>
			<!--Menu-->
			<?php 

			if(isset($_GET["id_r"])){
				$id_r=$_GET["id_r"];
				$query="SELECT * FROM registro WHERE id_r=".$id_r;
				$r=mysqli_query($conexion, $query); 
				while ($data = mysqli_fetch_assoc($r)) { ?>
					<nav id="menu" class="estilo" data-tab="lop">
						<ul>
							<li>
								<?php print"<a href ='detalles_t.php?=&id_r=".$data["id_r"]." '><img src='images/mex.png' width='32' height='23'class='app-logo' alt='editar'></a>";?>
							</li>
							<li>
								<?php print"<a href ='details.php?=&id_r=".$data["id_r"]." '><img src='images/usa.png' width='32' height='23'class='app-logo' alt='editar'></a>";?>
							</li>
				<?php }?>
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
		$r=mysqli_query($conexion, $query); ?>
		<aside id="sidebar">
			<div id="nav-bar" class="sidebar-item">
			<?php
				while ($data = mysqli_fetch_assoc($r)) { 
					print"<section id='content'>";
						function validarFoto($imagen){
							$patron="%\.(gif|jpe?g|png)$%i";
							$bandera=preg_match($patron, $imagen)==1?true:false;
							return $bandera;
						}
						$ruta=opendir("fotos");
						if($ruta){
							while($foto=readdir($ruta)){
								if($data["foto"]==$foto){
									if($foto!="."&& $foto !=".." && validarFoto($foto)){
										print"<img src='fotos/".$foto."' width='470' height='400'/>";
									}
								}
							}
						}else{
							print"Error al abrir la carpeta";
						} #fin if-else 
					print"	</section>";
					print"<table>";
						print"<h3>DETALLES | " .$data["nombre"]. "</h3>";
						print"<tr><td><h4>DESCRIPCIÓN: </h4>" .$data["descripcion"]. "</td></tr>";
						print"<td><h4>SALA: </h4>" .$data["sala"]. "</td></tr>";
					print"</table>";
			 	}
			}else{
			 	print "<br><br><br><br><br><h3 class='bad'>ACCESO NO PERMITIDO</h3>";
			 }
			 $r=0;
			 //mysqli_free_result($r);
			mysqli_close($conexion);?>
			</div>
		</aside>

	</div>

	<!--Limpiar lo flotado-->
	<div class="clearfix"></div>

	<!---Pie de pagina--->
	<footer id="footer">
		<div class="center">
		  Av. Ejércitos de Oriente, Calz. de los Fuertes S/N, 72270 Puebla, Pue.
		</div>
	</footer>
</body>
</html>