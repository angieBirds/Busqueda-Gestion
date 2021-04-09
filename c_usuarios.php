<!--Users management
type user:Administrador-->
<?php
include "php/users.php";
include "php/sesion.php"; 
if($_SESSION['tipo'] !=1) {
	header("location:index.php");
}

$varsession= $_SESSION['id_u'];
if($varsession==null|| $varsession==''){ ?>
	<h3 class="bad">ACCESO NO PERMITIDO</h3>
	<?php
	die();
} ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<!--metadata-->
	<meta charset="utf-8"/>
	<meta name="viewport" content="width-devise-width, initial-scale=1.0"/>
	<title>Motor de Búsqueda y Gestión</title>
	<link rel="icon" href="images/mrp.ico">

	<?php
	/* VARIABLES*/
	$msg=array();
	$tipo="";
	/*Modos
	A_Alta      B_Borrar
	C_Modificar D_Eliminiar
    S_Select(Mostrar)*/
	
	if(isset($_POST["nombre"])){
		#does exist this user or is new?
		$nombre=$_POST["nombre"];
		$id_u=(isset($_POST["id_u"]))?$_POST["id_u"] : "";
		 #new user
		if($id_u==""){
		 	#busacar el ultimo id
		 	$is=mysqli_query($conexion, "SELECT MAX(id_u) as id_max FROM usuarios");
		 	if($rr=mysqli_fetch_array($is)){
		 		$id_max=$rr['id_max'];
		 		$id_max++;
		 	}
		 	$id_u=date("Y").date("W").date("i").$id_max;
		 	$nombre=mysqli_real_escape_string($conexion,$_POST["nombre"]);
		 	$contraseña=mysqli_real_escape_string($conexion,$_POST["contraseña"]);
		 	$tipo=mysqli_real_escape_string($conexion,$_POST["tipo"]);		
			#access database insert new user
			$query= "INSERT INTO usuarios(id_u,nombre,contraseña, tipo) VALUES('".$id_u."', '".$nombre."', '".$contraseña."', '".$tipo."')";
			if(mysqli_query($conexion, $query)){
				array_push($msg, "Se inserto correctamente");
			}else{
				array_push($msg, "Error al intentar la conexion");
			}
	}else{
		#edit usr
		if ($nombre=="")  {
			array_push($msg,"El nombre no puede estar vacío");
		} else{
			$nombre=mysqli_real_escape_string($conexion,$_POST["nombre"]);
		} 
		if (isset($_POST["contraseña"])!="") {
			$contraseña=mysqli_real_escape_string($conexion,$_POST["contraseña"]);
		} elseif ($contraseña=="") {
			array_push($msg,"La contraseña no puede estar vacía");
		} 
		if (isset($_POST["tipo"])!="")  {
			$tipo=mysqli_real_escape_string($conexion,$_POST["tipo"]);
		} elseif ($tipo==""){
			array_push($msg,"Seleccione un tipo de usuario");		
		} 
			$query = "UPDATE usuarios SET nombre='$nombre',contraseña='$contraseña',tipo='$tipo' WHERE id_u='$id_u'";
			//$r=mysqli_query($conexion, $query);
			if (mysqli_query($conexion, $query)) {
				array_push($msg,"Se modificó el registro correctamente");
			} else {
				array_push($msg,"Error al modificar el registro");
				}
			} #end query
		} #end if-else
	
	#verifica que modo es
	if(isset($_GET["m"])){
		$m=$_GET["m"];
	}else{
		$m="S";
	}
	#Borrar definitivamente un usuario
	if ($m=="D") {
		if(isset($_GET["id_u"])){
		$id_u=$_GET["id_u"];
		$query="DELETE FROM usuarios WHERE id_u= $id_u";
		if(mysqli_query($conexion, $query)){
			array_push($msg, "Registro borrado con éxito");
		}else{
			array_push($msg, "No se pudo eliminar el registro");
			}
		}
		$m="S";
	}
	#Mostrar a todos los usuarios
	if ($m=="S") {
		$query="SELECT * FROM usuarios ORDER BY id_u ASC";
		$r=mysqli_query($conexion, $query);
		$n=mysqli_num_rows($r);
	}
	#Modificar los datos de un usuario
	if ($m=="C" || $m=="B") {
		$id_u=$_GET["id_u"];
		$query="SELECT * FROM usuarios WHERE id_u= $id_u";
		$r=mysqli_query($conexion, $query);
		}
	?>

<script>
	window.onload = function(){
		<?php
			# Botón para dar de alta
			if($m=="S"){ ?>
				document.getElementById("alta").onclick=function(){
					window.open("c_usuarios.php?m=A", "_self");
				}
			<?php }?>
			//Botón para borrar definitivamente "si"/"no"
			<?php if($m=="B"){?>
				document.getElementById("si").onclick=function(){
					var id_u = <?php print $id_u; ?>;
					window.open("c_usuarios.php?m=D&id_u="+id_u, "_self");
				} 
				document.getElementById("no").onclick=function(){
					var id_u=<?php print $id_u; ?>;
					window.open("c_usuarios.php", "_self");
				}
		<?php }?>
	} //end function
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
				<a href="principal.php">
				<img src="images/mrp.png" class="app-logo" alt="logotipo" href="principal.php"></a>
			</div>
			<!--Menu-->
			<nav id="menu" class="estilo">
				<ul>
					<li>
						<a href="principal.php">Registros</a>
					</li>
					<li>
						<a href="c_usuarios.php">Usuarios</a>
					</li><li>
						<a href="php/salir.php">Salir</a>
					</li>
				</ul>
			</nav>
			<!--Limpiar lo flotado-->
			<div class="clearfix"></div>
		</div>
	</header>

	<!--Cuerpo de la pagina-->

	<!--buscador-->
	<?php if ($m=="S") { ?>
		<div class="center">
			<label for="alta"></label>
			<input type="button" name="alta" value="Nuevo Usuario" id="alta"  class="usuario" />
			<section id="contentin">
				<form action="c_usuarios.php" method="POST" enctype="multipart/form-data">
					<input type="text" name="buscar" placeholder="Buscar usuario por ID o Nombre" />
					<input type="submit" value="Buscar" id="btn-white" class="buscar"  />
				</form>
			</section>
			<!---nuevo registro-ALTA/SELECT-->
		</div>
	<?php	} ?>
	
	<div id="main-container">
	<!--desplegado de errores-->
	<?php
	if ($m=="A"||$m=="C"||$m=="B") {
		if (count($msg)>0) {
			print"<div>";
			foreach ($msg as $key => $valor) {
				print"<stong>*".$valor."</strong>";
			}
	        print"</div>";
	 	}
	} ?>
	</div>
	
	<!---condicional de altas y cambios-->
	<?php if($m=="A" || $m=="C"){
		if($m=="C") $data=mysqli_fetch_assoc($r);  ?>
		<!--formulario para altas y cambios-->
		<div  id="slider" class="usuarios">
			<h2>Registro de Usuario</h2>
			<form method="POST" action="c_usuarios.php" enctype="multipart/form-data">
				<label for="id_u"><br>Id de usuario</label>
				<?php if ($m=="A") { ?>
					<input type="text"  id="id_u" name="id_u" placeholder="ID GENERADO POR EL SISTEMA" disabled="disabled" />
					<?php	}elseif($m=="C"){?>
						<input type="text"  id="id_u" name="id_u" placeholder="Id de usuario" value= "<?php if($m=='C') print $data['id_u']; ?>"/>
				<?php } ?>
				<label for="nombre"><br>Nombre de usuario<br></label>
				<input type="text" id="nombre" name="nombre" placeholder="Nombre" value="<?php if($m=='C') print $data['nombre']; ?>" required pattern="[A-Za-z ]{1,15}" maxlength="40" title="Ingresar nombre válido"/>
				<label for="contraseña"><br>Contraseña<br></label>
				<input type="text"  id="contraseña" name="contraseña" placeholder="Contraseña" value="<?php if($m=='C') print $data['contraseña']; ?>"  pattern="[A-Za-z 0-9]{1,15}" minlength="10" required="contraseña"/> <br>
				<label for="tipo">Tipo de usuario</label>
				<select id="tipo" name="tipo" class="selector" required="required" /> 
				<?php if($m=='C') { ?>	
					<option value="<?php print $data['tipo']; ?>">
						<?php if($data["tipo"]==1){ print"Administrador";}
							if($data["tipo"]==2){	print"Trabajador";	}
							if($data["tipo"]==3){	print"Consultor"; } ?></option>
						<?php }else{?>
					<option value="">Seleccionar</option>
				<?php }?>
					<option value='1'>Administrador</option>
					<option value=2>Trabajador</option>
					<option value=3>Consultor</option>
					<!---Turista es considerado como un tipo de usuario, pero no se registra-->
				</select>
				<input type="hidden" name="id_u" id="id_u" value="<?php print (isset($id_u))?$id_u:'';?>">
				<input type="submit" value="Aceptar" id="btn-white" class="agregar" />
			</form>
		</div>
	<?php } ?>

	<!--Limpiar lo flotado-->
	<div class="clearfix"></div>

	<div id="main-container">
	<!---condicional de borrado/consulta, cuando la opcionn es B, solo se muestra un objeto-->
	<?php if($m=="S" || $m=="B"){ ?>
		<table>
			<thead>
				<th>Id</th>
				<th>Nombre</th>
				<?php if($m=="S"){ ?>
				<th>Contraseña</th>
				<th>Tipo</th>
				<th>Opciones</th>
				<th> </th>
				<?php } ?>
			</thead>
			<tbody>
			<?php	//Mostrar los datos de usuarios registrados BD
			while ($data = mysqli_fetch_assoc($b)) {
				print"<tr>";
					print"<td>" .$data["id_u"]. "</td>";
					print"<td>" .$data["nombre"]. "</td>";
					print"<td>" .$data["contraseña"]. "</td>";
					if($data["tipo"]==1){
						print"<td>Administrador</td>";
					}
					if($data["tipo"]==2){
						print"<td>Trabajador</td>";
					}
					if($data["tipo"]==3){
						print"<td>Consultor</td>";
					}
					if($m=="S"){ 
						print"<td><a href='c_usuarios.php?m=C&id_u=".$data['id_u']."'><img src='images/editar.png' width='37' height='30'class='app-logo' alt='editar'></a></td>";
						print"<td><a href='c_usuarios.php?m=B&id_u=".$data['id_u']."'><img src='images/borrar.png' width='30' height='30'class='app-logo' alt='borrar'></a></td>";
					} 
				print"</tr>";
			}?>
			</tbody>
		</table>
	<?php 
		#Confirmación de eliminación de un usuario
		if($m=="B"){
			while ($data = mysqli_fetch_assoc($r)) {
			  	print"<table>";
					print"<tr><td>".$data["id_u"]. "</td>";
					print"<td>".$data["nombre"]. "</td></tr>";
					print "<table>";
				}
			print "<label for='si'>¿Desea borrar este registro de forma PERMANENTE? </label>";
			print "<input type='button' id='si' value='Si'  class='btn-des'/>";
			print "<input type='button' id='no' value='No' class='btn-des'/><br>";
			}
		} ?>
		
	<!--Limpiar lo flotado-->
	<div class="clearfix"></div>	 
	</div>
	
	<footer id="footer">
		<div class="center">
			 version 1.0 
		</div>
	</footer>
</body>
</html>