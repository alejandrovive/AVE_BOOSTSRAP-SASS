<?php
// Incluir fichero de configuración de DB
require_once("configDB.php");
    
    // Conectar a la base de datos
    $conexion = new PDO("mysql:host=" . HOST . ";", USER, PASSWORD);

    // Ruta al archivo SQL
    $sqlFile = './datos.sql';

    $sqlContent = file_get_contents($sqlFile);

    // Ejecutar las consultas SQL
    $conexion->exec($sqlContent);

    // Cerrar la conexión
    
    $conexion = null;
    
    $conexion2 = new PDO("mysql:host=" . HOST . ";dbname=" . DB, USER, PASSWORD);

    $sqlFile2 = './datos2.sql';

    $sqlContent = file_get_contents($sqlFile2);

    $conexion->exec($sqlContent2);
    

    ?>
