<?php
// Importamos la librería que contiene nuestras funciones
require_once("./config/p1_lib.php");
require_once("./appdata/p1/usuarios.php");

if (isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
} else if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
    $usernameRoot = $_SESSION["username"];
    $passwordRoot = $_SESSION["password"];
} else {
    header("Location: index.php");
    exit;
}

//$infraccion = 0;
$email = $_POST["email"];
$id = $_SESSION["id"];
$avatar = isset($_FILES['avatar']) ? $_FILES['avatar'] : null;
$passwordChange = isset($_POST["passwordChange"]) ? $_POST["passwordChange"] : null;
$passwordAuth = isset($_POST["passwordAuth"]) ? $_POST["passwordAuth"] : null;
$date = isset($_POST["date"]) ? $_POST["date"] : null;
$direccion = isset($_POST["location"]) ? $_POST["location"] : null;
$name = isset($_POST["name"]) ? $_POST["name"] : null;
$lastname1 = isset($_POST["lastname1"]) ? $_POST["lastname1"] : null;
$lastname2 = isset($_POST["lastname2"]) ? $_POST["lastname2"] : null;

$e = isset($_GET["e"]) ? $_GET["e"] : null;

$conn = get_connection();
$usuario = Usuarios::getById($conn, $id);

// Verificar si modifica alguno de los valores clave
if ($email !== $usuario->EMAIL || $date !== $usuario->FECHANAC) {
    //$infraccion++;
    header("Location: myaccount.php");
    exit;
}

// Validar y actualizar contraseña
if ($passwordChange !== "" && $password === $_SESSION["pass"]) {
    $password = $passwordChange;
    $res = validarContraseña($passwordChange, $passwordAuth, $e);
    if ($res == 0) {
        header("Location: myaccount.php?e=".$e);
        exit;
    }
    $usuario->PASS = password_hash($password, PASSWORD_DEFAULT);
}


// Validar y actualizar avatar
if ($avatar['name'] !== "") {
    $img = validarImagen($avatar, $e);
    if (!$img) {
        header("Location: myaccount.php?e=".$e);
        exit;
    }

$rutaImagenAvatar = $_FILES['avatar']['tmp_name'];

$contenidoImagen = file_get_contents($rutaImagenAvatar);
/*
echo var_dump($contenidoImagen);
 */ 
$usuario->AVATAR = $contenidoImagen;
} 

$usuario->USERNAME = $username;
$usuario->NOMBRE = $name;
$usuario->APELLIDO1 = $lastname1;
$usuario->APELLIDO2 = $lastname2;
$usuario->DIRECCION = $direccion;

//$usuario->update($conn, $id);
$usuario = Usuarios::updateUserChange($usuario, $conn,$id);
/*
$res2 = update_usuario($conn, $username, $password, $name, $lastname1, $lastname2, $contenidoImagen, $direccion, $_SESSION["id"]);
if (!$res2) {
    echo 'Ha ocurrido un error';
    exit;
}*/

// Redireccionar a myaccount.php si todo ha ido como se esperaba
header('Location: myaccount.php');
exit;
?>

