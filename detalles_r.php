<!--Details
type user:Trabajador
Editar registros
type user:Trabajador-->
<?php
include "php/conx.php";
include "php/sesion.php";
if($_SESSION['tipo'] !=2)
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
<html lang="es">
<head>
	<!--Area de metadatos-->
	<meta charset="utf-8"/>
	<meta name="viewport" content="width-devise-width, initial-scale=1.0"/>
	<title>Motor de Busqueda y Gestión</title>
	<link rel="icon" href="images/mrp.ico">
	
<?php
	
	$msg=array();
	/*Modos
	A_Alta, B_Borrar, C_Modificar, S_Select(Mostrar)
	F_ Modificar foto, H_Modificar Documento*/
	
	if(isset($_GET["m"])){
		$m=$_GET["m"];
	}else{
		$m="C";
	}
	//Borrar deefinitivamente un usuario
	if ($m=="D") {
		$id_r=$_GET["id_r"];
		$query="DELETE FROM registro WHERE id_r=".$id_r;
		print $query;
		if(mysqli_query($conexion, $query)){
			array_push($msg, "Registro borrado con éxito");
		}else{
			array_push($msg, "No se pudo eliminar el registro");
		}
		header("location:inicio.php");
	}
	
	//Modificar foto
	if ($m=="F") { 
		$id_r=$_GET["id_r"];
		$query="SELECT * FROM registro WHERE id_r=".$id_r;
		$r=mysqli_query($conexion, $query);
	}

	#Modificar documento
	if ($m=="H") { 
		$id_r=$_GET["id_r"];
		$query="SELECT * FROM registro WHERE id_r=".$id_r;
		$r=mysqli_query($conexion, $query);
	}


	//Modificar los datos de un usuario
	if ($m=="C" || $m=="B") {
		$id_r=$_GET["id_r"];
		$query="SELECT * FROM registro WHERE id_r=".$id_r;
		$r=mysqli_query($conexion, $query);
	}

	?>

	<script>
		window.onload = function(){

			<?php if($m=="F" || $m=="H"){?>
				
				document.getElementById("volver").onclick=function(){
					var id_r=<?php print $id_r; ?>;
					<?php $id_r=$_GET["id_r"];?>;
					window.open("detalles_r.php?m=C&id_r="+id_r, "_self");
				} 
				
			<?php }  ?>		
			<?php if($m=="B"){?>
				
				document.getElementById("si").onclick=function(){
					var id_r=<?php print $id_r; ?>;
					<?php $id_r=$_GET["id_r"];?>;
					window.open("detalles_r.php?m=D&id_r="+id_r, "_self");
				} 
				document.getElementById("no").onclick=function(){
					var id_r=<?php print $id_r; ?>;
					window.open("detalles_r.php?m=C&id_r="+id_r, "_self");
				}

			<?php }?>
		}
	</script>

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


	<!--Cuerpo de la pagina--->
	<!--Desplegado de errores--->
	<?php if($m=="A" || $m=="C" || $m=="B") { 
		if (count($msg)>0) {
			print "<div>";
			foreach ($msg as $key => $valor) {
				print "<strong>* ".$valor."</strong>";
			}
			print "</div>";
		}
	 } ?>

	
	<!---Detalles del registro--->
	<aside id="sidebar">
		<div id="nav-bar" class="sidebar-item">
			<?php if($m=="C"){ ?>
				
				<!--Foto de la pieza---->
				<?php
				while ($data = mysqli_fetch_assoc($r)) { 
					print"<a href='detalles_r.php?m=F&id_r=".$data["id_r"]."'>";
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
									if(validarFoto($foto)){
									print"<img src='fotos/".$foto."' width='470' height='400'/>";
									}
								}
							}
							
						}else{
							print"Error al abrir la carpeta";
						} 
					print"</a>"; 
					print"	</section>";
					print"<a href='detalles_r.php?m=F&id_r=".$data["id_r"]."' id='si'><img src='images/foto.jpg' width='33' height='30'class='app-logo' alt='editar'></a>";

					#Tabla de detalles
					print"<table>";
						print"<h3>DETALLES | ID:   " .$data["id_r"]. "</h3>";
						print"<td><h4>NOMBRE</h4></td><td>" .$data["nombre"]. "</td></tr>";	
						print"<td><h4>NAME</h4></td><td>" .$data["name"]. "</td></tr>";											
						print"<tr><td><h4>DESCRIPCIÓN</h4></td><td>" .$data["descripcion"]. "</td></tr>";
						print"<tr><td><h4>DESCRIPTION</h4></td><td>" .$data["description"]. "</td></tr>";
					print "</table>";
					print "<table>";
							print"<tr><td><h3>EXPOSICIÓN</h3></td>";
							print"<td><h3>SALA</h3></td>";
							print"<td><h3>UBICACIÓN</h3></td>";
							print"<td><h3>RECINTO</h3></td></tr>";
							print"<tr><td>" .$data["exposicion"]. "</td>";
							print"<td>" .$data["sala"]. "</td>";
							print"<td>" .$data["ubicacion"]. "</td>";
							print"<td>" .$data["recinto"]. "</td></tr>";
							print"<tr><td><h3>TIPO DE BIEN</h3></td>";
							print"<td><h3>ÉPOCA</h3></td>";
							print"<td><h3>PERIODO</h3></td>";
							print"<td><h3>AÑO</h3></td></tr>";
							print"<tr><td>" .$data["tipobien"]. "</td>";
							print"<td>" .$data["epoca"]. "</td>";
							print"<td>" .$data["tipobien"]. "</td>";
							print"<td>" .$data["tiempo"]. "</td></tr>";
							print"<tr><td><h3>NO. INVENTARIO</h3></td>";
							print"<td><h3>NO. CATÁLOGO</h3></td>";
							print"<td><h3>NO. REGISTRO</h3></td></tr>";
							print"<tr><td>" .$data["no_inventario"]. "</td>";
							print"<td>" .$data["no_catalogo"]. "</td>";
							print"<td>" .$data["no_registro"]. "</td></tr>";
							print"<tr><td><h3>STATUS</h3></td>";
							print"<td><h3>ESTADO DE CONSERVACIÓN</h3></td>";
							print"<td><h3>FECHA DE ADQUISICIÓN</h3></td>";
							print"<td><h3>AVALÚO</h3></td></tr>";?>
							<tr><td> 
							<?php  if($data["status"]=="1"){ print"<img src='images/rojo.jpg' width='30' height='15'/> ";}
								if($data["status"]=="2"){	print"<img src='images/amarillo.jpg' width='30' height='15'/> ";	}
								if($data["status"]=="3"){	print"<img src='images/naranja.png' width='30' height='15'/> ";}
								if($data["status"]=="4"){	print"<img src='images/verde.png' width='30' height='15'/> "; } ?></td>
							<?php	
							print"<td>" .$data["edo_conservacion"]. " %</td>";
							print"<td>" .$data["anio"]. "</td>";
							print"<td>" .$data["avaluos"]. "</td></tr>";
							print"<tr><td><h4>ENTRADAS Y SALIDAS</h4></td><td>" .$data["e_s"]. "</td></tr>";
							print"<tr><td><h4>OBSERVACIONES</h4></td><td>" .$data["observaciones"]. "</td></tr>";
							print"<tr><td><h4>Archivos almacenados</h4>";
							print"<a href='detalles_r.php?m=H&id_r=".$data["id_r"]."' id='si'><img src='images/archivo.jpg' width='30' height='28'class='app-logo' alt='editar'></a>"; 
							print"</td><td><a href ='doc.php?=&id_r=".$data["id_r"]." ' target='_blank'>".$data["e_sd"]."</a></td></tr>";

					print"</table>";
					print"<a href='inicio.php?m=C&id_r=".$data["id_r"]."' id='si'><img src='images/editar.jpg' width='33' height='30'class='app-logo' alt='editar'></a>";
					print"<a href='detalles_r.php?m=B&id_r=".$data["id_r"]."' id='si'><img src='images/borrar.png' width='30' height='30'class='app-logo' alt='borrar'></a>";
					print"<a href='qerre_r.php?=&id_r=".$data["id_r"]."'id='si'><img src='images/qr.png' width='30' height='30'class='app-logo' alt='generar qr'></a>";
				} //fin while
			} //fin modo "C"

			if($m=="B"){  ?>
			<?php
				while ($data = mysqli_fetch_assoc($r)) {
				  	print"<table>";
						print"<tr><td>ID:   " .$data["id_r"]. "</td>";
						print"<td>NOMBRE:   " .$data["nombre"]. "</td></tr>";
						print"<tr><td> DESCRIPCIÓN: </td><td>" .$data["descripcion"]. "</td></tr>";
					print "</table>";
				}
				if($m=="B"){ //comprobacion de borrado de registro 
				?>
				<script>
					window.alert("El archivo se borrará definitivamente si continúa");
				</script>
				<?php
					print "<label for='si'>¿Desea borrar este registro de forma PERMANENTE? </label>";
					print "<input type='button' id='si' value='Si'  class='usuario'/>";
					print "<input type='button' id='no' value='No' class='usuario'/><br>";
				}
			}#fin modo B
			if($m=="F"){
				#modificar fotos
				if (isset($_FILES['foto']) && is_uploaded_file($_FILES['foto']['tmp_name'])) {
					#  $nombre = "foto".date("YmdHis");
					$errores_array = array();
					$fileName = $_FILES['foto']['name'];
					$fileSize = $_FILES['foto']['size'];
					$fileTmp = $_FILES['foto']['tmp_name'];
					$fileType = $_FILES['foto']['type'];
					$fileExt = strtolower(end(explode(".",$fileName)));
					$extensiones= array("jpg", "jpeg", "png" );
					if(in_array($fileExt, $extensiones)==false){
						$errores_array[]="Archivo no permitido";
					}
					if($fileSize > 1024*1000*800){
						$errores_array[]="El archivo es demasiado grande";
					}
					//  if(file_exists("fotos/".$fileName)){
						//  $errores_array[]="Ya existe";
					//}
					if(empty($errores_array)){
						copy($_FILES["foto"]['tmp_name'],"fotos/".$fileName);
						$id_r=(isset($_POST["id_r"]))?$_POST["id_r"] : "";
						$foto=mysqli_real_escape_string($conexion,$fileName);
						$query= "UPDATE registro SET foto='$foto' WHERE id_r='$id_r'";
						$r=mysqli_query($conexion, $query);
					}else{
						print_r($errores_array);
				} 
			} 
 			?>
 			<!--Formularios para cambiar foto--->
 			<div class="center">
 				<aside id="sidebar">
 					<div id="nav-bar" class="sidebar-item">
 						<form  enctype="multipart/form-data"  method="POST">
 							<label for="foto"> <h2>Actualizar foto<h2></label>  
 								<input id="btn-white" class="examinar" type="file" name="foto">
 								<input type="hidden" name="id_r" id="id_r" value="<?php print (isset($id_r))?$id_r:'';?>">
 								<input type="submit" value="Aceptar" id="alta" class="agregar" />
 						</form>
 					</div>
    				<input type='button' id='volver' value='Volver'  class='usuario'/>
    			</aside>
    		</div>

    		<?php
    		} #fin modo "F"

    		if($m=="H"){
    			#modificar documento
    			if (isset($_FILES['doc']) && is_uploaded_file($_FILES['doc']['tmp_name'])) {
    				#  $nombre = "foto".date("YmdHis");
    				$errores_array = array();
				    $fileName = $_FILES['doc']['name'];
				    $fileSize = $_FILES['doc']['size'];
				    $fileTmp = $_FILES['doc']['tmp_name'];
				    $fileType = $_FILES['doc']['type'];
				    $fileExt = strtolower(end(explode(".",$fileName)));
				    $extensiones= array("pdf" );
				    if(in_array($fileExt, $extensiones)==false){
				   		$errores_array[]="Archivo no permitido";
				    }
				    if($fileSize > 1024*1000*800){
				    	$errores_array[]="El archivo es demasiado grande";
			    }
				    //  if(file_exists("archivo/".$fileName)){
   					//  $errores_array[]="Ya existe";
   					//}
     			if(empty($errores_array)){
     				copy($_FILES["doc"]['tmp_name'],"archivo/".$fileName);
      				$id_r=(isset($_POST["id_r"]))?$_POST["id_r"] : "";
					$e_sd=mysqli_real_escape_string($conexion,$fileName);
       			    $query= "UPDATE registro SET e_sd='$e_sd' WHERE id_r='$id_r'";
    				$r=mysqli_query($conexion, $query);
      			}else{
      				print_r($errores_array);
    			} 
  			}
			?>
			<!--Formulario para cambiar documento--->
			<div class="center">
 				<aside id="sidebar">
 					<div id="nav-bar" class="sidebar-item">
 						<form  enctype="multipart/form-data"  method="POST">
 							<label for="foto"> <h2>Actualizar Documento<h2></label>  
 								<input id="btn-white" class="examinar" type="file" name="doc">
 								<input type="hidden" name="id_r" id="id_r" value="<?php print (isset($id_r))?$id_r:'';?>">
 								<input type="submit" value="Aceptar" id="alta" class="agregar" />
 						</form>
 					</div>
    				<input type='button' id='volver' value='Volver'  class='usuario'/>
    			</aside>
    		</div>

			<?php
			} #fin modo "H"
			$r=0;
			// mysqli_free_result($r);
			mysqli_close($conexion);
			?>

		</div> <!---Fin sidebar-item---->
	</aside>

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