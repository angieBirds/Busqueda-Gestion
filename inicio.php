<!--Search and general details 
type user:Trabajador
Editar registro
type user:Trabajador-->
<?php 
include "php/reader.php"; 
include "php/sesion.php"; 

#validación de usuario
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
	<title>Motor de Busqueda y Gestión</title>
	<link rel="icon" href="images/mrp.ico">
	<?php
	/* VARIABLES*/
	$msg=array();

	/*Modos
	A_Alta, B_Borrar, C_Modificar, S_Select(Mostrar)*/
	//Se recibe el comando elegido por el usuario
	if(isset($_POST["nombre"])){
		#Verificar si ya existe o es un nevo registro
		$nombre=$_POST["nombre"];
		$id_r=(isset($_POST["id_r"]))?$_POST["id_r"] : "";
		 //Alta
		if($id_r==""){
		 	#busacar el ultimo id
		 	$is=mysqli_query($conexion, "SELECT MAX(id_r) as id_max FROM registro");
		 	if($rr=mysqli_fetch_array($is)){
		 		$id_max=$rr['id_max'];
		 		$id_max++;
		 	}
		 	$id_r=$id_max.date("Y");
			$nombre=mysqli_real_escape_string($conexion, $_POST["nombre"]);
			$name=mysqli_real_escape_string($conexion, $_POST["name"]);
			$descripcion=mysqli_real_escape_string($conexion, $_POST["descripcion"]);
			$description=mysqli_real_escape_string($conexion, $_POST["description"]);
			$exposicion=mysqli_real_escape_string($conexion,$_POST["exposicion"]);
			$sala=mysqli_real_escape_string($conexion,$_POST["sala"]);
			$ubicacion=mysqli_real_escape_string($conexion,$_POST["ubicacion"]);
			$recinto=mysqli_real_escape_string($conexion,$_POST["recinto"]);
			$tipobien=mysqli_real_escape_string($conexion,$_POST["tipobien"]);
			$epoca=mysqli_real_escape_string($conexion,$_POST["epoca"]);
			$periodo=mysqli_real_escape_string($conexion,$_POST["periodo"]);
			$tiempo=mysqli_real_escape_string($conexion,$_POST["tiempo"]);
			$no_inventario=mysqli_real_escape_string($conexion,$_POST["no_inventario"]);
			$no_registro=mysqli_real_escape_string($conexion,$_POST["no_registro"]);
			$no_catalogo=mysqli_real_escape_string($conexion,$_POST["no_catalogo"]);
			$status=mysqli_real_escape_string($conexion,$_POST["status"]);
			$edo_conservacion=mysqli_real_escape_string($conexion,$_POST["edo_conservacion"]);
			$avaluos=mysqli_real_escape_string($conexion,$_POST["avaluos"]);
			$anio=mysqli_real_escape_string($conexion,$_POST["anio"]);
			$e_s=mysqli_real_escape_string($conexion,$_POST["e_s"]);
			$e_sd=mysqli_real_escape_string($conexion,$_POST["e_sd"]);
			$observaciones=mysqli_real_escape_string($conexion,$_POST["observaciones"]);
			$foto=mysqli_real_escape_string($conexion,$_POST["foto"]);
			
			#acceso a la base de datos para altas
			$query= "INSERT INTO registro(id_r,nombre, name, descripcion, description, exposicion, sala, ubicacion, recinto, tipobien, epoca, periodo, tiempo, no_inventario, no_catalogo, no_registro, status, edo_conservacion, avaluos, anio, e_s, e_sd, observaciones, foto) VALUES('".$id_r."', '".$nombre."', '".$name."', '".$descripcion."', '".$description."', '".$exposicion."', '".$sala."',  '".$ubicacion."',  '".$recinto."','".$tipobien."','".$epoca."',  '".$periodo."',  '".$tiempo."','".$no_inventario."', '".$no_catalogo."', '".$no_registro."','".$status."', '".$edo_conservacion."', '".$avaluos."', '".$anio."', '".$e_s."', '".$e_sd."',  '".$observaciones."', '".$foto."')";
			
			if(mysqli_query($conexion, $query)){
				array_push($msg, "Se inserto correctamente");
			}else{
				array_push($msg, "Error al intentar la conexion");
			}
	}else{
		#Modificaciones
			if ($nombre=="")  {
				array_push($msg,"El nombre no puede estar vacío");
			} else{
				$nombre=mysqli_real_escape_string($conexion,$_POST["nombre"]);
			} 

			if (isset($_POST["name"])!="") {
				$name=mysqli_real_escape_string($conexion,$_POST["name"]);
				
			} elseif ($name=="") {
				array_push($msg,"Name can not is empty");
			} 

			if (isset($_POST["descripcion"])!="") {
				$descripcion=mysqli_real_escape_string($conexion,$_POST["descripcion"]);
				
			} elseif ($descripcion=="") {
				array_push($msg,"La descripción no puede estar vacía");
			} 

			if (isset($_POST["description"])!="") {
				$description=mysqli_real_escape_string($conexion,$_POST["description"]);
				
			} elseif ($description=="") {
				array_push($msg,"Description can not is empty");
			} 
			
			if (isset($_POST["exposicion"])!="")  {
				$exposicion=mysqli_real_escape_string($conexion,$_POST["exposicion"]);
			} elseif ($exposicion==""){
				array_push($msg,"Seleccione un tipo de exposicion");		
			} 
			
			if (isset($_POST["sala"])!="")  {
				$sala=mysqli_real_escape_string($conexion,$_POST["sala"]);
			} elseif ($sala==""){
				array_push($msg,"Seleccione un tipo de sala");		
			} 
		
			if (isset($_POST["ubicacion"])!="")  {
				$ubicacion=mysqli_real_escape_string($conexion,$_POST["ubicacion"]);
			} elseif ($ubicacion==""){
				array_push($msg,"Seleccione un tipo de ubicacion");		
			}
			if (isset($_POST["recinto"])!="")  {
				$recinto=mysqli_real_escape_string($conexion,$_POST["recinto"]);
			} elseif ($recinto==""){
				array_push($msg,"Seleccione un tipo de ubicacion");		
			}
			if (isset($_POST["tipobien"])!="")  {
				$tipobien=mysqli_real_escape_string($conexion,$_POST["tipobien"]);
			} elseif ($tipobien==""){
			array_push($msg,"Seleccione un tipo de bien");		 
			}

			if (isset($_POST["epoca"])!="")  {
				$epoca=mysqli_real_escape_string($conexion,$_POST["epoca"]);
			} elseif ($epoca==""){
				array_push($msg,"Seleccione una epoca");		 
			}
			if (isset($_POST["periodo"])!="")  {
				$periodo=mysqli_real_escape_string($conexion,$_POST["periodo"]);
			} elseif ($periodo==""){
			array_push($msg,"Seleccione un periodo");		
			}		
			
			if (isset($_POST["tiempo"])!="")  {
				$tiempo=mysqli_real_escape_string($conexion,$_POST["tiempo"]);
			} elseif ($tiempo==""){
				array_push($msg,"Ingrese el tiempo");		 
			}

			if (isset($_POST["no_inventario"])!="")  {
				$no_inventario=mysqli_real_escape_string($conexion,$_POST["no_inventario"]);
			} elseif ($no_inventario==""){
				array_push($msg,"Ingrese el número de Inventario");	
			}

			if (isset($_POST["no_registro"])!="")  {
				$no_registro=mysqli_real_escape_string($conexion,$_POST["no_registro"]);
			} elseif ($no_registro==""){
				array_push($msg,"Ingrese el numero de registro");		
			}

			if (isset($_POST["no_catalogo"])!="")  {
				$no_catalogo=mysqli_real_escape_string($conexion,$_POST["no_catalogo"]);
			} elseif ($no_catalogo==""){
				array_push($msg,"Ingrese un numero de Catalogo");		 
			}

			if (isset($_POST["status"])!="")  {
				$status=mysqli_real_escape_string($conexion,$_POST["status"]);
			} elseif ($status==""){
				array_push($msg,"Seleccione un status");		
			}	
			if (isset($_POST["edo_conservacion"])!="")  {
				$edo_conservacion=mysqli_real_escape_string($conexion,$_POST["edo_conservacion"]);
			} elseif ($edo_conservacion==""){
				array_push($msg,"Seleccione el Estado de conservación");		
			} 
			if (isset($_POST["avaluos"])!="")  {
				$avaluos=mysqli_real_escape_string($conexion,$_POST["avaluos"]);
			} elseif ($avaluos==""){
				array_push($msg,"Ingrese el avalúo");		
			}	
			if (isset($_POST["anio"])!="")  {
				$anio=mysqli_real_escape_string($conexion,$_POST["anio"]);
			} elseif ($anio==""){
				array_push($msg,"Seleccione un anio");		 
			}	
			if (isset($_POST["e_s"])!="")  {
				$e_s=mysqli_real_escape_string($conexion,$_POST["e_s"]);
			} elseif ($e_s==""){
				array_push($msg,"Seleccione un tipo de sala");		
			}
			if (isset($_POST["observaciones"])!="") {
				$observaciones=mysqli_real_escape_string($conexion,$_POST["observaciones"]);
			} elseif ($observaciones=="") {
				array_push($msg,"Ingrese sus observaciones");
			} 

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
    			//  $errores_array[]="Ya existe"; }
    			if(empty($errores_array)){
    				copy($_FILES["foto"]['tmp_name'],"fotos/".$fileName);
    				$id_r=(isset($_POST["id_r"]))?$_POST["id_r"] : "";
    				$foto=mysqli_real_escape_string($conexion,$fileName);
				}
			}
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
   				//  if(file_exists("fotos/".$fileName)){
   				//  $errores_array[]="Ya existe"; }
     			if(empty($errores_array)){
      				copy($_FILES["doc"]['tmp_name'],"archivo/".$fileName);
      				$id_r=(isset($_POST["id_r"]))?$_POST["id_r"] : "";
				    $e_sd=mysqli_real_escape_string($conexion,$fileName);
  				}
  		}
		#Consulta a bd para actualización de modificaciones 
			$query= "UPDATE registro SET nombre='$nombre', name='$name', descripcion='$descripcion', description='$description', exposicion='$exposicion', ubicacion='$ubicacion', sala='$sala', recinto='$recinto', tipobien='$tipobien', epoca='$epoca', periodo='$periodo', tiempo='$tiempo', no_inventario='$no_inventario', no_catalogo='$no_catalogo', no_registro= '$no_registro', status='$status', edo_conservacion='$edo_conservacion', anio='$anio', e_s= '$e_s', observaciones='$observaciones', avaluos='$avaluos' WHERE id_r='$id_r'";

			if (mysqli_query($conexion, $query)) {
				array_push($msg,"Se modificó el registro correctamente");
			} else {
				array_push($msg,"Error al modificar el registro");
			}
		}
	}

	#mood
	if(isset($_GET["m"])){
		$m=$_GET["m"];
	}else{
		$m="S";
	}
	
	#Mostrar todos los registros relacionados con la búsqueda
	if ($m=="S") {
		$query="SELECT * FROM registro ORDER BY id_r ASC";
		$r=mysqli_query($conexion, $query);
	//	$n=mysqli_num_rows($r);
	}
	#edit data user
	if ($m=="C") {
		$id_r=$_GET["id_r"];
		$query="SELECT * FROM registro WHERE id_r= $id_r";
		$r=mysqli_query($conexion, $query);
		}
	?>

	<script>
		//evitar reenvio de formulario
		if (window.history.replaceState) { // verificamos disponibilidad
			window.history.replaceState(null, null, window.location.href);
		}// fin if

		window.onload = function(){
		<?php
			#Botón dar de alta a un registro
			if($m=="S"){ ?>
				document.getElementById("alta").onclick=function(){
				window.open("inicio.php?m=A", "_self");
			}
		<?php }	?>
		} //fin function
	</script>

</head>
<body>
	<!--HOJA DE ESTILOS CSS-->
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="jq/jquery-ui-1.12.1.custom/jquery-ui.css">
	<script src="jq/jquery-3.5.1.min.js"></script>
	<script src="jq/jquery-ui-1.12.1.custom/jquery-ui.js"></script>

	<!---Cabecera de la pagina-->
	<header id=header>
		<div class="center">
			<!--Logo--->
			<div id="logo">
				<a href="inicio.php">
					<img src="images/mrp.png" class="app-logo" alt="logotipo" href="inicio.php"></a>
			</div>
			<!--Menu-->
			<nav id="menu" class="estilo" data-tab="lop">
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
	<?php if($m=="S") { ?>
	<div class="center">
		<label for="alta"></label>
		<input type="button" name="alta" value="Nuevo Registro" id="alta"  class="usuario" />
		
		<!--Buscador---->
		<section id="contentin" >
			<form action="inicio.php" method="POST" enctype="multipart/form-data">
				<input type="text" name="buscar" placeholder="¿Qué estas buscando?" />
				<input type="submit" value="Buscar" id="btn-white" class="buscar"  />
			</form>
		</section>
	</div>

	<?php } #fin mood "S"

    if($m=="A" || $m=="C"){ 
		#mood edit
		if($m=="C") $data=mysqli_fetch_assoc($r); ?>

		<div class="center">
			<div  id="slider" class="registro">
				<h2>Registro</h2>
				<!---Formulario de altas y cambios de registro-->
				<form name="registro" method="POST" action="inicio.php"  enctype="multipart/formdata">
					<table>
						<tr>
							<td><label for="id_r">Id</label></td>
							<td><label for="nombre">Nombre</label></td>
							<td><label for="name">Name</label></td>
						</tr>
						<tr>
							<td><input type="text"  id="id_r" name="id_r" placeholder="ID GENERADO POR EL SISTEMA" disabled="disabled" value="<?php if($m=='C') print $data['id_r']; ?>" /></td> 
							<td><input type="text" name="nombre" id="nombre" placeholder="Nombre" required pattern="[A-Za-z0-9ñÑáéíóúÁÉÍÓÚ ]{1,25}" maxlength="25" value="<?php if($m=='C') print $data['nombre']; ?>"/></td>
							<td><input type="text" name="name" id="name" placeholder="Name" pattern="[A-Za-z0-9ñÑáéíóúÁÉÍÓÚ ]{1,25}" maxlength="25" value="<?php if($m=='C') print $data['name']; ?>"/></td>
						</tr>
					</table>
					<td><label for="foto">Seleccionar foto</label></td>
					<td><input type="file" name="foto" id="btn-white" class="examinar" <?php if($m=='C') {?> disabled="disabled"<?php } ?>></td>
					<td><label for="descripcion">Descripción</label></td>		
					<td><textarea id="descripcion" name="descripcion" required="required" placeholder="Agregar Descripción" pattern="[A-Za-z0-9A-Za-z0-9ñÑáéíóúÁÉÍÓÚ  ]{1,800}" maxlength="200"><?php if($m=='C') print $data['descripcion']; ?></textarea></td>
					<td><label for="description">Description</label></td>		
					<td><textarea id="description" name="description" placeholder="Add description" pattern="[A-Za-z0-9A-Za-z0-9ñÑáéíóúÁÉÍÓÚ  ]{1,800}" maxlength="200"><?php if($m=='C') print $data['description']; ?></textarea></td>
					<!---Exposición/sala/ubicación--->
					<table>
						<tr>
							<td><label for="exposicion">Exposición</label></td>
							<td><label for="sala">Sala</label></td>
							<td><label for="ubicacion">Ubicación</label></td>
							<td><label for="recinto">Recinto</label></td>
						</tr>
						<tr>
							<td><select id="exposicion" name="exposicion" class="selector" required="required" />
								<?php if($m=='C') { ?>	
									<option value="<?php print $data['exposicion']; ?>"><?php print $data['exposicion']; ?></option>
								<?php }else{?>
							<option value=" ">Seleccionar</option>
							<?php }?>
								<option value="Permanente">Permanente</option>
								<option value="Temporal">Temporal</option>
							</select></td>
							<td><select id="sala" name="sala" class="selector" required="required">
								<?php if($m=='C') { ?>	
									<option value="<?php print $data['sala']; ?>"><?php print $data['sala']; ?></option>
								<?php }else{?>
								<option value="">Seleccionar</option>
								<?php }?>
								<option value="Paleontología">Paleontología</option>
								<option value="Arqueología">Arqueología</option>
								<option value="Historia">Historia</option>
								<option value="Etnografía">Etnografía</option>
							</select></td>
							<td><select id="ubicacion" name="ubicacion" id="ubicacion" required="ubicacion" class="selector" required="required"/><?php if($m=='C') { ?>	
									<option value="<?php print $data['ubicacion']; ?>"><?php print $data['ubicacion']; ?></option>
								<?php }else{?>
								<option value="">Seleccionar</option>
								<?php }?>
								<option value="Restauración">Restauración</option>
								<option value="Museografía">Museografía</option>
								<option value="Depósito">Depósito</option>
								<option value="En préstamo">En préstamo</option>
							</select></td>
							<td><input type="text" name="recinto" id="recinto" placeholder="Lugar dónde se encuentra" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ  ]{1,25}" maxlength="25" title="Ingresar nombre válido"  value="<?php if($m=='C') print $data['recinto']; ?>"/></td>
						</tr>
					<!---Tipo de bien/época/periodo/anios--->				
						<tr>
							<td><label for="tipobien">Tipo de bien</label></td>
							<td><label for="epoca">Época</label></td>
							<td><label for="periodo">Periodo</label></td>
							<td><label for="tiempo">Año</label></td>
						</tr>
						<tr>
							<td><select id="tipobien" name="tipobien" class="selector" required="required" />
								<?php if($m=='C') { ?>	
									<option value="<?php print $data['tipobien']; ?>"><?php print $data['tipobien']; ?></option>
								<?php }else{?>
								<option value="">Seleccionar</option>
								<?php }?>
								<option value="Paleontológico">Paleontológico</option>
								<option value="Arqueológico">Arqueológico</option>
								<option value="Histórico">Histórico</option>
								<option value="Etnográfico">Etnográfico</option>
							</select></td>				
							<td><select id="epoca" name="epoca" class="selector" required="required">
								<?php if($m=='C') { ?>	
									<option value="<?php print $data['epoca']; ?>"><?php print $data['epoca']; ?></option>
								<?php }else{?>
								<option value="">Seleccionar</option>
								<?php }?>
								<option value="Prehistoria">Prehistoria</option>
								<option value="Prehispánica">Prehispánica</option>
								<option value="Conquista de México">Conquista de México</option>
								<option value="Colonial">Colonial</option>
								<option value="Periodo Independiente">Periodo Independiente</option>
								<option value="Porfiriato">Porfiriato</option>
								<option value="Revolución Mexicana">Revolución Mexicana</option>
								<option value="Tecnología Regional de Puebla">Tecnología Regional de Puebla</option>
								<option value="Vida Cotidiana">Vida Cotidiana</option>
								<option value="Danza en las regiones del Estado">Danza en las regiones del Estado</option>
								<option value="Ciclo de la vida">Ciclo de la vida</option>
							</select></td>
							<td><select id="periodo" name="periodo" class="selector" required="required">
								<?php if($m=='C') { ?>	
									<option value="<?php print $data['periodo']; ?>"><?php print $data['periodo']; ?></option>
								<?php }else{?>
								<option value="">Seleccionar</option>
								<?php }?>
								<option value="Arqueolítico"> Arqueolítico</option>
								<option value="Paleolítico">Paleolítico</option>
								<option value="Preclásico">Preclásico</option>
								<option value="Clásico">Clásico</option>
								<option value="Postclásico">Postclásico</option>
							</select></td>
							<td><input type="text" name="tiempo" id="tiempo" placeholder="p.e. 1970" pattern="[0-9]{1,4}" maxlength="4" title="Ingresar año válido"  value="<?php if($m=='C') print $data['tiempo']; ?>"/></td>
						</tr>					
					<!---Inventario/Registro/Catalogo--->					
						<tr>
							<td><label for="no_inventario">No. Inventario</label></td>
							<td><label for="no_registro">No. Registro</label></td>
							<td><label for="no_catalogo">No. Catálogo</label></td>
						</tr>
						<script>
							//insertar guión después de 3 digitos
							function mascara(valor) {
								if (valor.match(/^\d{3}$/) !== null) {
	    							return valor + '-';
	 						 	} 
	 						 	return cadena;
							} 
						</script>
						<tr>
							<td><input type="text" name="no_inventario" id="no_inventario" placeholder="000-000000" onkeyup="this.value = mascara(this.value)" pattern="[0-9-]{1,10}" maxlength="10" title="Ingresar número válido" size="10" value="<?php if($m=='C') print $data['no_inventario']; ?>" /></td>
							<td><input type="text" name="no_registro" id="no_registro" placeholder="000-000000" onkeyup="this.value = mascara(this.value)" pattern="[0-9]|-|{1,10}" maxlength="10" title="Ingresar número válido"size="10" value="<?php if($m=='C') print $data['no_registro']; ?>"/></td>
							<td><input type="text" name="no_catalogo" id="no_catalogo" placeholder="000-000000" onkeyup="this.value = mascara(this.value)" pattern="[0-9]|-|{1,10}" maxlength="10" title="Ingresar número válido"size="10" value="<?php if($m=='C') print $data['no_catalogo']; ?>"/></td>
						</tr>
					
					<!---Status/edo_conservación/avalúo/fecha--->
						<tr>
							<td><label for="status">Status</label></td>
							<td><label for="edo_conservacion">Estado de conservación</label></td>
							<td><label for="avaluo">Avalúos</label></td>
							<td><label for="anio">Fecha de adquisición</label></td>
						</tr>
						<tr>
							<td>
								<select name="status" class="selector" required="required"/>
								<?php if($m=='C') { ?>	
									<option value="<?php print $data['status']; ?>"><?php print $data['status']; ?>
										<?php if($data["status"]=="1"){?> <?php print"25%";}
										if($data["status"]=="2"){	print"50% ";	}
										if($data["status"]=="3"){	print"75% ";    }
										if($data["status"]=="4"){	print"100% ";   } ?>
									</option>
								<?php }else{?>
								<option value="">Seleccionar</option>
								<?php }?>
									<option value="1" style="background-color: red";>25%</option>
									<option value="2" style="background-color: #ffff00";>50%</option>
									<option value="3" style="background-color: #ffa31a";>75%</option>
									<option value="4"style="background-color: #33cc33";>100%</option>
								</select>
							</td>
									
							<td>
								<select name="edo_conservacion" class="selector" required="required">
								<?php 
								if($m=='C') { ?>	
									<option value="<?php print $data['edo_conservacion']; ?>"><?php print $data['edo_conservacion']; ?></option>
								<?php 
								}else{?>
									<option value="">Seleccionar</option>
								<?php }?>

									<option value="10">10%</option>
									<option value="20">20%</option>
									<option value="30">30%</option>
									<option value="40">40%</option>
									<option value="50">50%</option>
									<option value="60">60%</option>
									<option value="70">70%</option>
									<option value="80">80%</option>
									<option value="90">90%</option>
									<option value="100">100%</option>
								</select></td>
								 
							<td><input type="text" name="avaluos" id="avaluos" placeholder="Avalúo. MXN" pattern="[0-9.,$ ]{1,15}" maxlength="25" title="Ingresar nombre válido" value="<?php if($m=='C') print $data['avaluos']; ?>"/></td>
							<td><input type="text" name="anio" required="anio" id="anio" placeholder="CALENDARIO" value="<?php if($m=='C') print $data['anio']; ?>"/></td>
							<script type="text/javascript">
								$( function() {
									$( "#anio" ).datepicker({
										changeMonth: true,
	    							  	changeYear: true,
	    							});
	 							} );
							</script>
						</tr>
					</table>
					<td><label for="e_s">Entrada/Salida</label></td>	
					<td><textarea id="e_s" name="e_s" required="required" placeholder="Detalles de entradas y salidas" pattern="[A-Za-z0-9A-Za-z0-9ñÑáéíóúÁÉÍÓÚ  ]{1,150}" maxlength="200" ><?php if($m=='C') print $data['e_s']; ?></textarea></td>

					<table><input type="file" name="e_sd" id="btn-white" class="examinar" <?php if($m=='C') {?> disabled="disabled"<?php } ?>></table>
					
					<td><label for="observaciones">Observaciones</label></td>
					<td><textarea id="observaciones" name="observaciones" placeholder="Observaciones" pattern="[A-Za-z0-9A-Za-z0-9ñÑáéíóúÁÉÍÓÚ  ]{1,150}" maxlength="200"><?php if($m=='C') print $data['observaciones']; ?></textarea></td>
			
					<!--Bandera para verificar-->
					<input type="hidden" name="id_r" id="id_r" value="<?php print (isset($id_r))?$id_r:'';?>">
					<input type="submit"  value="Aceptar" id="btn-white" class="agregar" />
				</form>

			</div> <!--Fin registro-->
		</div> <!--Fin center-->

	<?php } ?>

	<!--Limpiar lo flotado-->
	<div class="clearfix"></div>

	<section id="sec">
		<?php
		#resultados de la busqueda
		while($data = mysqli_fetch_assoc($b)){ ?>
			<div id= "busqueda" class="center">
				<div id="foto"> 
					<?php	print"<a href='detalles_r.php?m=C&id_r=".$data['id_r']."'>"; ?>
					<td> 
					<?php 
					$ruta=opendir("fotos");
					if($ruta){
						while($foto=readdir($ruta)){
							if($data["foto"]==$foto){
								if($foto!="."&& $foto !=".."){
									print"<br>";
									print"<img src='fotos/".$foto."' width='130' height='130' />";
								}
							}
						}
					}?>
					</td>
				</div><!--Fin foto-->
				<div id="detalles"> 
					<?php
					print"".$data["id_r"]. "<br>";
					print"" .$data["nombre"]. "<br>";	?>
				</div><!--Fin detalles-->
			</div> <!--Fin búsqueda-->
		<?php } 

		if($m=="B"){
			#Modo borrar pregunta de advertencia
			print "<label for='si'>¿Desea borrar este registro de forma PERMANENTE? </label>";
			print "<input type='button' id='si' value='Si'/>";
			print "<input type='button' id='no' value='No'/><br>";
			
			mysqli_free_result($r);
			mysqli_close($conexion);
		}?>
	</section>

	<!--Limpiar lo flotado-->
	<div class="clearfix"></div>

	<footer id="footer">
		<div class="center">
			version 1.0 
		</div>
	</footer>
</body>
</html>