<?php
	session_start();
	session_destroy();
	#redireccionar para iniciar sesion
	header("location:../index.php");
 ?>