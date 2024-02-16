<?php 
// archivo cargar_subcategorias.php
require_once("./config/p1_lib.php");
require_once("./appdata/p1/productos.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);


if (isset($_GET['categoriaId'])) {
    $conn = get_connection();
    $subcategorias = Productos::getSubcategoriasPorCategoria($conn, $_GET["categoriaId"]);

    // Devolver las subcategorías como respuesta JSON
    header('Content-Type: application/json');
    echo json_encode($subcategorias);
}
?>