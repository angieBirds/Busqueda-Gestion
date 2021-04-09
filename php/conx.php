<?php
	/*conexion con la base de datos*/
	$host="localhost";
	$usuario="root";
	$clave="";
	$db="murep";
	//$puerto="8080";
	$conexion = mysqli_connect($host, $usuario, $clave, $db);
	if (mysqli_connect_errno()) {
	 	printf("Hubo un error en la conexión: %s <br>", mysqli_connect_error());
	 	exit();
	 } 
?>