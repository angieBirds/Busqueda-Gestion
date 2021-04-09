<?php include "conx.php"; 

if(!isset($_POST["buscar"])){
	$_POST["buscar"]="!";
	$buscar=$_POST["buscar"];
}

$buscar=$_POST["buscar"];
//Busquedas generales
	$query="SELECT * FROM registro WHERE id_r LIKE '%".$buscar."%' OR nombre LIKE '%".$buscar."%' OR exposicion LIKE '%".$buscar."%' OR sala LIKE '%".$buscar."%' OR periodo LIKE '%".$buscar."%'" ;
	$b=mysqli_query($conexion, $query);
//	$n=mysqli_num_rows($b);

#mysqli_free_result($b);
#mysqli_close($conexion);

?>