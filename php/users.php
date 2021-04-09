<?php include "php/conx.php"; 

if(!isset($_POST["buscar"])){
	$_POST["buscar"]="!";
	$buscar=$_POST["buscar"];
}

$buscar=$_POST["buscar"];
//Busquedas generales
	$query="SELECT * FROM usuarios WHERE id_u LIKE '%".$buscar."%' OR nombre LIKE '%".$buscar."%'" ;
	$b=mysqli_query($conexion, $query);

?>