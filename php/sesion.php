<?php 
session_start();
$limite = 60*15;

if(isset($_SESSION))
	if(time()-$_SESSION["id_u"]>$limite){
		header("location:index.php?error=true");
		session_unset();
		exit;
	} else if (isset($_SESSION["id_u"])==false){
		header("location:index.php?error=true");
		session_unset();
		exit;
	} else{
		$_SESSION["id_u"] = time();
}?> 
