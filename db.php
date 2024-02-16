<?php 
/* Ejercicio 1: Crear una función denominada get_connection() 
utilizando llamadas a procedimientos/funciones
y llamadas a métodos */

// Utilizando Procedimientos
require_once("configDB.php");

function get_connection(){
    $db = mysqli_connect (HOST, USER, PASSWORD);
    if (!$db) {
        die("La conexion fallo".mysqli_connect_error());
    }
    return $db;
}
$database = get_connection();
// Utilizando Orientada a Objetos
 function get_connection2 (){
    $db = new mysqli(HOST, USER, PASSWORD, DB);
    if ($db -> connect_errno) {
        die("Error de conexion".$db->connect_error);
    }
    return $db;
 }
 print_r(PDO::getAvailableDrivers());
 $database2 = get_connection2();
 var_dump($database2);

 /* Ejercicio 2: Cambiar de base de datos por defecto utilizando
Estilo orientado a objetos */
function change_database($dbname, $mysqli) {
    // mysqli::select_db($dbname);
    $mysqli->select_db($dbname);
    /*if (!mysqli::) {
        echo "Error de conexión";
    }
    return mysqli::;*/
    return $mysqli;
}
$dbempresa = "dbempresa";

$db = change_database($dbempresa, $database2);
var_dump($db);

 /* Ejericio 3 Comprobar el método que me permite cerrar conexión tras finalizar con las
operaciones a realizar contra la base de datos y poder liberar los recursos utilizados. */
//Orientada a objetos
$database2->close();
//Procedimiento
mysqli_close($database);
//PDO
$database = null;

$conexion = get_connection2();
/* Ejercicio 4 Comprobar cómo puedo ejecutar sentencias SQL mediante procedimientos y métodos. 
    Ejecutar una sentencia SQL
*/
$sql = "SELECT * FROM TClientes";
$resultado = $conexion->query($sql);
// Obtener los resultados
while ($fila = $resultado->fetch_assoc()) {
    // Manejar cada fila de resultados
    // ...
}
/* ¿Qué tipo de dato devuelven las sentencias de tipo INSERT, DELETE o UPDATE?
a. ¿Cómo puedo saber el número de registros afectados? */
// Ejecutar una sentencia INSERT, DELETE o UPDATE
$sql = "INSERT INTO TClientes (cNombre, cApellido1, cApellido2, nEdad, cTelefono, cEmail) 
        VALUES ('Ejemplo', 'Apellido', 'Apellido2', 25, '123456789', 'ejemplo@email.com')";
$resultado = $conexion->query($sql);

// Obtener el número de registros afectados
$num_registros_afectados = $conexion->affected_rows;
echo "Número de registros afectados: " . $num_registros_afectados;

/*
$servername = "localhost";
$database = "db_tienda_segunda_mano";
$username = "administrador_tiendas";
$password = "alejandro";

*/

/* function get_connection($servername, $username, $password, $database){

$conn = new mysqli ($servername, $username, $password, $database);
if (!($conn)) {
    die("La conexión fallo".mysql_error());
} else {
echo "Conexión éxitosa";
return $conn;
}
*/
/*
$conn =mysqli_connect($servername, $username, $password, $database);
if (!($conn)) {
    echo "La conexión falló";
} else {
    return $conn;
}
}
$conn = get_connection($servername, $username, $password, $database);
var_dump($conn);
*/



/*
Estilo por procedimientos
mysqli_select_db(mysqli $link, string $dbname): bool 
//mysqli_select_db($link, "segunda_base_de_datos");


Ejercicio 3: Cerrar conexión tras finalizar con las operaciones y liberar recursos 
mediante el comando mysqli_close, si no se especifica, se usará el último abierto

mysqli_close($link_identifier = NULL);

function close_connection($linkDatabase){
$close = mysqli_close($linkDatabase);
if (!$close) {
    die("La conexión falló".mysql_error());
}
echo "Conexión aprobada";
return $close;
}
$close = close_connection($conn);
var_dump($close);

/*
Ejercicio 4: Comprobar cómo puedo ejecutar sentencias SQL
mediante procedimientos y métodos

function executeQuery($query, $conn){
if ($mysqli) {
mysqli_query(mysqli $link, string $query,int $resultMode);
}
}

function
*/

?>