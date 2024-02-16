<?php
require_once("./config/p1_lib.php");
require_once("./appdata/p1/usuarios.php");
if(isset($_POST["username"]) && isset($_POST["password"]) ){
    $login = $_POST["username"];
    $password = $_POST["password"];
    $passwordAuth = $_POST["passwordAuth"];
    $name = $_POST["name"];
    $lastname1 = $_POST["lastname1"];
    $lastname2 = isset($_POST["lastname2"]) ? $_POST["lastname2"] : NULL;
    $date = $_POST["date"];
    $email = $_POST["email"];
    $avatar = isset($_FILES["avatar"]) ? $_FILES["avatar"] : NULL;
    $direccion = ($_POST["location"]);
    $codigoPostal = ($_POST["CP"]);
    $estado = 0;
    $perfil = 0;



} else if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
} else {
    header("Location: index.php");
    exit;
}

$e = isset($_GET["e"]) ? $_GET["e"] : null;




$err = isset($_GET["err"]) ? $_GET["err"] : null;

/*

$res = validarUsuario($login, $email, $e);
if ($res == 0) {
    header('location:signup.php?e=' . $e);
    exit;
}

// Validar existencia de usuario
$act = validarExistenciaUsuario($login, $email, $e);
if ($act == 0) {
    header('location:signup.php?e=' . $e);
    exit;
}
*/

// Validar contraseña
$result = validarContraseña($password, $passwordAuth, $e);
if ($result == 0) {
    header('location:signup.php?e=' . $e);
    exit;
}

// Validar edad
$resultado = validarEdad($date, $e);
if ($resultado == 0) {
    header('location:signup.php?e=' . $e);
    exit;
}

// Validar imagen
if ($avatar["name"] !== "") {
    $img = validarImagen($avatar, $err);
if ($img == 0) {
    header('location:signup.php?e=' . $err);
    exit;
}
$rutaImagenAvatar = $_FILES['avatar']['tmp_name'];

$contenidoImagen = file_get_contents($rutaImagenAvatar);

} else {
    $contenidoImagen = NULL;
}





/*
// Guardar imagen
$directorio = DATA_FILE;
$guardar = guardarImagen($avatar, $directorio, $e);
if ($guardar == 0) {
    header('location:signup.php?e=' . $err);
    exit;
}*/

// Crear conexion
$conn = get_connection();

// Crear nuevo usuario
/*
$fields = */
$usuario = new Usuarios();
$usuario->username = $login;
$usuario->pass = $password;
$usuario->email = $email;
$usuario->nombre = $name;
$usuario->apellido1 = $lastname1;
$usuario->apellido2 = $lastname2;
$usuario->perfil = $perfil;
$usuario->fechaNac = $date;
$usuario->estado = $estado;
$usuario->direccion = $direccion;
$usuario->avatar = $contenidoImagen;

// Añadir nuevo usuario a la base de datos
$usuario->add();



// Añadir nuevo usuario a la base de datos
/*
$usuario = new Usuarios($login, $password, $email, $name, $lastname1, $lastname2, $perfil, $date, $estado, $direccion, $contenidoImagen);
// Registrar usuario
$registrar = registrar_usuario($conn, $usuario);
*/
//$registrar = registrarUsuario($login, $password, $date, $email, $guardar, $e);
/*if (!$registrar) {
    header('location:signup.php?e=' . $err);
    exit;
}*/

header('location:index.php');
exit;
    
?>