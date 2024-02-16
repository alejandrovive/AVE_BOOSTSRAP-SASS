<?php
/*
//Importamos la librería que contiene nuestras funciones
require_once("./config/p1_lib.php");

if(isset($_POST["username"]) && isset($_POST["password"]) ){
    $login = $_POST["username"];
    $pass = $_POST["password"];
} else if (isset($_SESSION["username"]) && isset($_SESSION["password"]) ){
    $login = $_SESSION["username"];
    $pass = $_SESSION["password"];
    echo $login;
    echo $pass;
} else {
    header("Location: index.php");
    exit;
}

// Conéctate a la base de datos
$conn = get_connection();

// Intenta autenticar al usuario
$user = db_get_usuario($conn, $login, $pass);
if ($user === null) {
    header("Location: index.php");
    exit;
}
header("Location: home.php");
$conn->close();
exit;



$res = autentificar_usuario ($login, $pass, $e);
if($res==0){
    header('location:index.php?e='.$e);
    exit;
} else {
    header('location:home.php');

}
*/
//Importamos la librería que contiene nuestras funciones
require_once("./config/p1_lib.php");
require_once("./appdata/p1/usuarios.php");



if(isset($_POST["username"]) && isset($_POST["password"]) ){
    $login = $_POST["username"];
    $pass = $_POST["password"];
} else if (isset($_SESSION["username"]) && isset($_SESSION["password"]) ){
    $login = $_SESSION["username"];
    $pass = $_SESSION["password"];
    echo $login;
    echo $pass;
} else {
    header("Location: index.php");
    exit;
}

$e = isset($_GET["e"]) ? $_GET["e"]: null;

// Establecemos una conexión a la base de datos
$conn = get_connection();

// Autenticamos al usuario, si no es correto lo redirigimos al index
$user = db_get_usuario($conn, $login, $pass, $e);
if ($user === 0) {

    header("Location: index.php");
    exit;
}

$usuario = Usuarios::getById($conn, $user->IDUSUARIO);
if($usuario->ESTADO == 1){
    $e = 'BLOCK';
    header("Location: index.php?e=" .$e);
    exit;
}

// Si llega aqui es que el usuario es correcto y por ende se le dirige al home

header("Location: home.php");
$conn=null;
exit;


?>

