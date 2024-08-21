<?php
function conexionDB(){
  $data = "mysql:host=localhost;dbname=webgenerator";
  $conexion = new PDO($data, 'adm_webgenerator', 'webgenerator2024');
  return $conexion;
}
?>
<?php
// shell_exec("rm -r ../web");
$email= filter_input(INPUT_POST,'email');
$password= filter_input(INPUT_POST,'password');
$ingresar=filter_input(INPUT_POST,'ingresar');
$ta_mal="";
if ($ingresar) {
		if ($email=="admin@server.com" && $password=="serveradmin") {
				session_start();
				$_SESSION['email']  = $email;
				$_SESSION['password'] = $password;
				$_SESSION['id'] = "admin";
				header("Location: panel.php");
		}

}
if ($ingresar) {
	$conexion = conexionDB();
	$consulta = $conexion->prepare(" SELECT * FROM `usuarios` WHERE 
		email= :email AND password=:password ");

	$consulta->execute(array(
		':email' => $email,
		':password' => $password
	));

	$aux=$consulta->fetch(PDO::FETCH_ASSOC);
	
	if ($aux) {
		session_start();
		$_SESSION['email']  = $email;
		$_SESSION['id'] = $aux['idUsuario'];
		header("Location: panel.php");
		
	}else {

		$ta_mal="El password o el email no es correcto.";
	}
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Webgenerator Luca Cabral</title>
</head>
<body>
	<h1>Webgenerator Luca Cabral</h1>
	<form method="post">
		Email:<input type="email" name="email" rows="10" cols="30"><br>
		Password:<input type="password" name="password" rows="10" cols="30"><br>
		<input type="submit" value="ingresar" name="ingresar"><br>
		<a href="register.php">registrar</a>
		
	</form>
		<?= $ta_mal ?>

</body>
</html>