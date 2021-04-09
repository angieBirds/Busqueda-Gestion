<!--Login registered users
Tipo de usuario: Administrador/Trabajador/Consultor-->
<?php 
include "php/conx.php"; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<!--Area de metadatos-->
	<meta charset="utf-8"/>
	<meta name="viewport" content="width-devise-width, initial-scale=1.0"/>
	<title>Motor de Busqueda y Gestión</title>
	<link rel="icon" href="images/mrp.ico">
</head>
<body>
	<?php 
	if (isset($_GET["error"])){
		print "<h4 class='bad'>NO SE ENCONTRO SESION ABIERTA</h4>";
	} 	?>
	<!--HOJA DE ESTILOS CSS-->
	<link rel="stylesheet" type="text/css" href="css/style.css">

	<!--Login--->
	<div  id="slider" class="login">
		<img src="images/mrp.png" class="log-log" alt="logotipo">
		<form method="POST" action="validar.php">
			<h3 for="id_u">Ingresar</h3>
			<input type="text" id="id_u" name="id_u" placeholder="Id de usuario" required pattern="[A-Za-z0-9 ]{1,25}" maxlength="25" title="Ingresa tu usuario" />
		
			<input type="password" id="contraseña" name="contraseña" placeholder="Contraseña" required pattern="[A-Za-z0-9 ]{1,25}" maxlength="25" title="Ingresa tu contraseña" />
			<input type="hidden" name="flag" id="flag" value="flag">
				&nbsp <input type="submit" name="agregar" value="Ingresar" id="btn-white" class="agregar" />
					</form>

			<!--Limpiar lo flotado-->
		<div class="clearfix"></div>
	</div>
</body>
</html>