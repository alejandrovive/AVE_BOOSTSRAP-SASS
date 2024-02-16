<?php
require_once("./config/p1_lib.php");
require_once("./appdata/p1/usuarios.php");

if (isset($_SESSION["username"])) {
    $usernameRoot = $_SESSION["username"];
} else {
    header("Location: index.php");
    exit;
}

$conn = get_connection();
// Recupera los valores de los checkboxes
$usuariosParaCambiar = isset($_POST["adminCheckbox"]) ? $_POST["adminCheckbox"] : [];
$usuariosParaBloquear = isset($_POST["bloquearCheckbox"]) ? $_POST["bloquearCheckbox"] : [];
$usuariosParaEliminar = isset($_POST["eliminarCheckbox"]) ? $_POST["eliminarCheckbox"] : [];

// Procesa cada usuario para cambiar el rol a administrador
foreach ($usuariosParaCambiar as $userId) {
    // Llama a la función estática updateAdmin sin crear una instancia
    Usuarios::updateAdmin($conn, $userId);
}

foreach($usuariosParaBloquear as $userId) {
    
    Usuarios::userDisabled($conn, $userId);
    
}

foreach ($usuariosParaEliminar as $userId) {
    
    Usuarios::userDelete($conn, $userId);
    
}

// Repite el proceso para otros checkboxes (bloquear/desbloquear, eliminar, etc.)

// Redirige a la página principal o muestra un mensaje de éxito, según sea necesario
header("Location: home.php");
exit;
?> 
