

<?php
function conexionDB(){
  $data = "mysql:host=localhost;dbname=6829";
  $conexion = new PDO($data, '6829', 'rata.higuera.guante');
  return $conexion;
}
?>



// <?php
//function conexionDB(){
//  $data = "mysql:host=localhost;nombredb=webgenerator";
//  $conexion = new PDO($data, 'adm_webgenerator', 'webgenerator2024');
  //return $conexion;
//}
//?> 

<?php
$Email= filter_input(INPUT_POST,'Email');
$password= filter_input(INPUT_POST,'password');
$password_2= filter_input(INPUT_POST,'password_2');
$ingresar=filter_input(INPUT_POST,'ingresar');
$password_ta_mal="";
$ta_bien="";
$ta_mal="";
if ($ingresar) {

    if ($password==$password_2) {
        
        
    $conexion = conexionDB();
    $verifica = $conexion->prepare("SELECT * FROM `usuarios` WHERE `email` = :email");
    $verifica->execute(array(':email' => $Email));
    $correoExiste = $verifica->fetchColumn();

    if ($correoExiste == 0) {
        $consulta = $conexion->prepare("INSERT INTO `usuarios` (`idUsuario`,`email`, `password`, `fechaRegistro`) 
            VALUES (NULL,:email, :password, :fechaRegistro)");
        $consulta->execute(array(
            ':email' => $Email,
        ':password' => $password, 
        ':fechaRegistro' => date("Y-m-d")
    ));

        $ta_bien="El correo electrónico se registrado correcta mente.";
    } else {
            $ta_mal="El correo electrónico ya está registrado. Inténtalo con otro correo.";
    }

}else{
    $password_ta_mal="Los passwords no son iguales.";

}
}
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Registrarte es simple.</h1>
    <form method="post">
        Email:<input type="email" name="Email" rows="10" cols="30"><br>
        password: <input type="password" name="password" rows="10" cols="30"><br>
        repetir password: <input type="password" name="password_2" rows="10" cols="30"><br>
        <input type="submit" value="Registrarse" name="ingresar"><br>
        <a href="login.php">login</a>
         
    </form>

    
     <?= $password_ta_mal ?>
    <?= $ta_mal ?>
    <?= $ta_bien?>
    <?php 
        if ($ta_bien) {
                    header("Location: login.php");
        }
     ?>
</body>
</html>
