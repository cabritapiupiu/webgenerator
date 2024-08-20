<?php
function conexionDB(){
  $data = "mysql:host=localhost;dbname=6829";
  $conexion = new PDO($data, '6829', 'rata.higuera.guante');
  return $conexion;
}
?>
<?php 
session_start();
$generar=filter_input(INPUT_POST,'generar');
$nombre=filter_input(INPUT_POST,'nombre');
$ta_bien="";
$admin=0;
if ($_SESSION['email'] =='admin@server.com' && $_SESSION['password'] =='serveradmin') {
$admin=1;
$conexion = conexionDB();
$verifica = $conexion->prepare("SELECT * FROM `webs`");
$verifica->execute();
$aux_admin=$verifica->fetchAll(PDO::FETCH_ASSOC);
// var_dump($aux_admin);
$verifica = $conexion->prepare("SELECT * FROM `usuarios`");
$verifica->execute();
$aux=$verifica->fetchAll(PDO::FETCH_ASSOC);
// var_dump($aux);
// $aux['email'];

}

if ($generar) {
	$conexion = conexionDB();
	$verifica = $conexion->prepare("SELECT * FROM `webs` WHERE `dominio` = :dominio");
	$verifica->execute(array(':dominio' => $_SESSION['id'].$nombre));
	$dominioExiste = $verifica->fetchColumn();

	if ($dominioExiste == 0) {
		$consulta = $conexion->prepare("INSERT INTO `webs` (`idWeb`,`idUsuario`, `dominio`, `fechaCreacion`) 
			VALUES (NULL,:idUsuario, :dominio, :fechaCreacion)");
		$consulta->execute(array(
			':idUsuario' => $_SESSION['id'],
			':dominio' => $_SESSION['id'].$nombre, 
			':fechaCreacion' => date("Y-m-d")
		));
		$dominio=$_SESSION['id'].$nombre;
		$ta_bien="El dominio se registrado correctamente.";
		shell_exec("./wix.sh " .$_SESSION['id'].$nombre);        
		shell_exec("zip -r $dominio.zip $dominio");
	}else{
		$ta_mal="El dominio ya esta  registrado.";
	}     
}

$conexion = conexionDB();
$verifica = $conexion->prepare("SELECT * FROM `webs` WHERE idUsuario = :idUsuario");
$verifica->execute(array(':idUsuario' => $_SESSION['id']));
$aux=$verifica->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=, initial-scale=1.0">
	<title>Bienvenido a tu panel</title>
</head>
<body>
	<?php  
	if ($admin==1) {
		echo "<h1>Bienvenido a tu panel</h1>";
		echo "<a href='logout.php'>Cerrar sesión de Admin</a>";
		echo "<h2>Todas las Webs</h2>";
		echo '<table border="1">
		<tr><th>Dominio</th><th>ID del Usuario</th><th>Fecha de creacion</th></tr>';
				foreach ($aux_admin as  $clave => $valor) {
							echo "<tr>
							<td>" . $valor['dominio'] . "</td>
							<td>". $valor['idUsuario'] ."</td>
							<td>". $valor['fechaCreacion'] ."</td>
							</tr>";
		}

			
		

		echo '</table>';
		

	}else{
		echo "<h1>Bienvenido a tu panel</h1>";
		echo "<a href='logout.php'>Cerrar sesión de " . $_SESSION['id'] . "</a>";

		echo "<h2>Generar Web de:</h2>";	
		echo '<form method="post">
		Nombre de la web: <input type="text" name="nombre"><br>
		<input type="submit" value="ingresar" name="generar"><br>
		
		</form>';

		echo "<h2>Mis Webs</h2>";
		echo '<table border="1">
		<tr><th>Dominio</th><th>-</th><th>-</th></tr>';

		foreach ($aux as $clave => $valor) {
			
			
				echo "<tr>
			<td><a href='./".$valor['dominio']."/index.php'>".$valor['dominio']."</a></td>
			<td><a href='".$valor['dominio'].".zip'>Descarga</a></td>
			<td><a href='eliminar.php?dominio=".$valor['dominio']."'>Eliminar</a></td>
			</tr>";	
		}
		echo '</table>';
	}
	?>
</body>
</html>





