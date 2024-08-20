
 <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Generar y Descargar ZIP</title>
</head>
<body>
    <?php
    $file = $_GET['dominio']; 

    shell_exec("zip -r web/$file/$file.zip web/$file   ");
    
if ($file) {
    
    // echo "$file";
    echo '<a href="web/'.$file.'/'.$file.'.zip">descargar aqui</a>';
}
    
?>
<br>
<a href="./panel.php">Volver al panel</a> 
</body>
</html>
