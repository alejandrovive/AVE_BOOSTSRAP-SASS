<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
</head>
    <?php 
		require_once "./appdata/p1/productos.php";
	 ?>
<body>
<div id="cabecera">
		<h1>Carrito de la compra</h1>		
	</div>
	<div id="contenedor">
		<div id="contenido">
			<?php 
				if(isset($_COOKIE["carrito"])==false){
					echo "<p class='error'>El carrito está vacío</p>";
				}
				else{
					$carrito=unserialize($_COOKIE["carrito"]);					
					echo "<h2>Lista de productos comprados</h2>";
					echo "<ul>";
						$total=0;
						foreach ($carrito as $id => $cantidad) {
							if($cantidad>0){
								echo "<li>".
								 "<img class='izda' src='img/{$listaProductos[$id]["imagenPeque"]}' >".
								 "<span class='tam2'>{$listaProductos[$id]["nombre"]}</span><br> ".
								 "Precio {$listaProductos[$id]["precio"]} &euro; <br>".
								 "Cantidad $cantidad <br></li>";
								 $total+=$cantidad*$listaProductos[$id]["precio"];
							}
						}
					echo "</ul>";
					echo "<h2>Total: $total &euro;</h2>";
				}
			 ?>
			<p class="enlace"><a href="vaciar.php">Vaciar el carrito</a></p>
			<p class="enlace"><a href="index.php">Volver a lista de productos</a></p>
		</div>
	</div>
    
</body>
</html>