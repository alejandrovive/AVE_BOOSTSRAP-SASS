<!doctype html>
 <html lang="es">
 <head>
 	<meta charset="UTF-8">
 	<title>Añadir productos</title>
 	<link rel="stylesheet" href="estilos.css">
 	<?php 
 		require_once "./appdata/p1/productos.php";
		require_once "./config/p1_lib.php";
 	 ?>
 </head>
 <body>
<?php 
	if(isset($_GET["id"])){
		$idRef=$_GET["id"];
		if(isset($_COOKIE["carrito"])){
			$carrito=unserialize($_COOKIE["carrito"]);
			$carrito["idUsuario"]=$_SESSION["id"];

		}
		else{
			foreach ($listaProductos as $id => $producto) {
				$carrito[$id]=0;
				
			}
		}
		$carrito["idUsuario"] = $_SESSION["id"];
		if(isset($carrito["idUsuario"]) && $carrito["idUsuario"] == $_SESSION["id"]) {
			// Verificamos si el producto ya está en el carrito, si no, lo agregamos
			if(isset($carrito[$idRef])) {
				$carrito[$idRef]++;
			} else {
				$carrito[$idRef] = 1; // Inicializamos la cantidad del producto en 1
			}
		//guardamos el array en la cookie, serializado y tiene una duración de 1 hora	
		setcookie("carrito",serialize($carrito),time()+3600);	
		header("Location:productos7.php?add=$idRef");	
	}
	else{
		header("Location:index.php");	
	}


?> 	
 </body>
 </html>