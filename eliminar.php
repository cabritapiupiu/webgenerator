<?php
function conexionDB(){
  $data = "mysql:host=localhost;dbname=webgenerator";
  $conexion = new PDO($data, 'adm_webgenerator', 'webgenerator2024');
  return $conexion;
}
?>


<?php
    $file = $_GET['dominio']; 

    
    
if ($file) {
    $conexion=conexionDB();
    shell_exec("rm -r $file");
    shell_exec("rm -r $file.zip");
    $verifica = $conexion->prepare("DELETE FROM `webs` WHERE dominio = :dominio");
    $verifica->execute(array(':dominio' => $file));
    header("Location: panel.php");
}
    
?>