<?php
//Importamos la librería que contiene nuestras funciones
require_once("./config/p1_lib.php");
require_once("./appdata/p1/fotosproductos.php");
require_once("./appdata/p1/productos.php");
if(isset($_POST["name"]) && isset($_POST["price"]) ){
    $name = $_POST["name"];
    $price = $_POST["price"];
} else if (isset($_SESSION["username"]) && isset($_SESSION["pass"]) ){
    header("location:products.php");
    exit;
} else {
    header("Location: index.php");
    exit;
}
$conn = get_connection();
$e = isset($_GET["e"]) ? $_GET["e"]: null;
$imgagenProducto = $_FILES["imgProduct"];
$descripcion = $_POST["descripcion"];
$categoria = $_POST["categoria"];
$subcategoria = $_POST["subcategoria"];
$idVendedor = $_SESSION["id"];


// Validar precio

$result = validarPrecio($price, $e);

if(!$result){
    header("location:products.php?e=" . $e);
    exit;
}
$texto1 = validarTextoProducto($name, $e);
if (!$texto1) {
    header("location:products.php?e=" . $e);
    exit;
}

if ($descripcion != "") {
    $texto2 = validarTextoProducto($descripcion, $e);
    if (!$texto2) {
        header("location:products.php?e=" . $e);
        exit;
    }
}


$producto = new Productos();
$producto->titulo = $name;
$producto->descripcion = $descripcion;
$producto->precio = $price;
$producto->idVendedor = $idVendedor; 
$producto->idCategoria = $categoria;
$producto->idSubcategoria = $subcategoria;

$imagenesValidas = true;


foreach ($_FILES["imgProduct"]["name"] as $key => $nombre) {
    $imagenProducto = array(
        "name" => $_FILES["imgProduct"]["name"][$key],
        "type" => $_FILES["imgProduct"]["type"][$key],
        "tmp_name" => $_FILES["imgProduct"]["tmp_name"][$key],
        "size" => $_FILES["imgProduct"]["size"][$key]
    );

    if ($imagenProducto["name"] !== "") {
        // Validar la imagen
        $imgValida = validarImagen($imagenProducto, $e);

        if ($imgValida == 0) {
            // Si una imagen no es válida, marca la bandera como falsa
            $imagenesValidas = false;
            break;  // No es necesario continuar con la validación si una imagen no es válida
        }
    }
    
    if (count($_FILES["imgProduct"]["name"]) > 5) {
        $e = 'FILE_NUMBER';
        header("location: products.php?e=" . $e);
        exit;
    }
}

if (!$imagenesValidas) {
    // Si al menos una imagen no es válida, redirige con el error
    header("location:products.php?e=" . $e);
    exit;
}

// Añadir el producto y obtener el idProducto recién insertado
$producto->add();
$productoId = Productos::getIdProducto($conn);
$idProducto = $productoId->IDPRODUCTO;

// Recorrer las imágenes y almacenarlas en fotosproductos
foreach ($_FILES["imgProduct"]["name"] as $key => $nombre) {
    $imagenProducto = array(
        "name" => $_FILES["imgProduct"]["name"][$key],
        "tmp_name" => $_FILES["imgProduct"]["tmp_name"][$key],
    );

    if ($imagenProducto["name"] !== "") {
        // Procesar la imagen y almacenarla en fotosproductos
        $rutaImagenProducto = $imagenProducto["tmp_name"];
        $contenidoImagen = file_get_contents($rutaImagenProducto);

        // Crear un objeto de la clase fotosProductos
        $fotosProducto = new fotosProductos();
        $fotosProducto->imagen = $contenidoImagen;
        $fotosProducto->idProducto = $idProducto;
        // Añadir la imagen a la tabla fotosproductos
        $fotosProducto->add();
    }
}

header("location:home.php");
exit;

?>