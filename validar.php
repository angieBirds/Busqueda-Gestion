<?php
include "php/conx.php"; 
$id_u=$_POST['id_u'];
$contraseña=$_POST['contraseña'];
session_start();
$_SESSION['id_u']=$id_u;
$_SESSION['id_u']=time();

$consulta="SELECT*FROM usuarios where id_u='$id_u' and contraseña='$contraseña'";
$resultado=mysqli_query($conexion,$consulta);
//mysqli_close($conexion);

$result = mysqli_num_rows($resultado);
$_SESSION['tipo']    = 0;
if($result > 0) {
    $data = mysqli_fetch_array($resultado);
    $_SESSION['contraseña']   = $data['contraseña'];
    $_SESSION['tipo']    = $data['tipo'];
}

if($_SESSION['tipo']==1){ //administrador
    header("location:principal.php");

}else
if($_SESSION['tipo']==2){ //trabajador
    header("location:inicio.php");

}else
if($_SESSION['tipo']==3){ //consultor
    header("location:consultas.php");
}
else{
    ?>
     <h3 class="bad">ERROR EN LA AUTENTIFICACION</h3>
    <?php
    include "index.php";
}

mysqli_free_result($resultado);
mysqli_close($conexion);
