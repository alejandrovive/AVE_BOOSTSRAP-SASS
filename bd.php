<?php
// Ejecutar el script para crear la base de datos

// Conectar a la base de datos

require_once("./config/configDB.php");

$e = isset($_GET["e"]) ? $_GET["e"]: null;

$conn = new mysqli(HOST, USER, PASSWORD, "");

$sqlScript = "./config/SQL Practica2 V2.sql";

function ejecutarSQL($rutaArchivo, $conn)
{
  $queries = explode(';', file_get_contents($rutaArchivo));
  foreach($queries as $query)
  {
    if($query != '')
    {
      $conn->query($query); // Asumo un objeto conexión que ejecuta consultas
      if ($conn->query($query) === FALSE) {
        echo "Error en la consulta: " . $conn->error;
      }
    } else {
      echo "Base de datos creada correctamente";
    }
  }
}




ejecutarSQL($sqlScript, $conn);

$conn = null;


?>