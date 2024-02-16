<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" href="./style/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <?php 
        require_once("./config/p1_lib.php");
        require_once("./appdata/p1/usuarios.php");
        require_once("./appdata/p1/productos.php");
        
        $e = isset($_GET["e"]) ? $_GET["e"] : null;
        define("REGISTROS_POR_PAGINA", 4);
        $conn = get_connection();
        //$usuario = Usuarios::getById($conn, $_SESSION["id"]);

        $productos = Productos::getProducts($conn);
        $countProducts = count($productos);
        $total_paginas = ceil($countProducts / REGISTROS_POR_PAGINA);

        /*
        echo $countProducts;
        echo $total_paginas;
        echo "Número de registros encontrados: " . $countProducts . "<br>";
        echo "Se muestran páginas de " . REGISTROS_POR_PAGINA . " registros cada una y mostradas en ".$total_paginas." páginas en total<br>";
        */
        if (isset($_GET['pagina'])) {
            $pagina = $_GET['pagina'];
        } else {
            $pagina = 1;
        }
   
        $inicio = ($pagina - 1) * REGISTROS_POR_PAGINA;
        $productos_paginados = array_slice($productos, $inicio, REGISTROS_POR_PAGINA);

        foreach ($productos_paginados as $producto) {
            // Obtener las imágenes asociadas al producto actual
            $fotos_productos = Productos::getAllImagenesProducto($conn, $producto->IDPRODUCTO);

            // Inicializar la variable $imagen_src con la imagen predeterminada
            $imagen_src = './img/product.png';

            // Verificar si se recuperaron imágenes para el producto actual
            if ($fotos_productos !== null) {
                // Iterar sobre las imágenes y establecer $imagen_src con la primera imagen válida encontrada
                $carousel_content = '';
                foreach ($fotos_productos as $foto) {
                    // Verificar si la imagen es válida
                    if ($foto !== null && $foto !== "") {
                        // Si se encuentra una imagen válida, establecer $imagen_src y salir del bucle
                        $imagen_src = 'data:image/jpeg;base64,' . base64_encode($foto->IMAGEN);
                        break;
                    }
                }
            }

    // Mostrar el producto con su imagen y otros detalles
    ?>





    <div class="card m-2 h-25 w-25">
        <a href="producto.php?id=<?php echo $producto->IDPRODUCTO; ?>">
            <img src="<?php echo $imagen_src; ?>" class="card-img-top h-100 w-100" alt="Producto">
        </a>
        <div class="card-body">
            <p class="card-text fw-bold"><?php echo $producto->TITULO; ?></p>
            <small class="text-secondary"><?php echo $producto->PRECIO; ?></small>
        </div>
    </div>
        <?php
        }
        ?>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <!-- Mostrar enlaces de paginación -->
                    <?php for ($i = 1; $i <= $total_paginas; $i++) : ?>
                        <li class="page-item <?php if ($pagina == $i) echo 'active'; ?>">
                            <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
            
            <div class="container my-2  mt-3 p-3">
    <div class="row">
        <?php
        foreach ($productos_paginados as $producto) {
          $numProductos = count($productos_paginados);
          if($numProductos<4) {
            // Obtener las imágenes asociadas al producto actual
            $fotos_productos = Productos::getAllImagenesProducto($conn, $producto->IDPRODUCTO);
        ?>
            <div class="card h-25 w-25 col-lg-3 col-sm-6">
                <div id="carousel_<?php  $idProd = ($numProductos < 4 && (end($productos_paginados) == $producto->IDPRODUCTO)) ? 0 : $producto->IDPRODUCTO; echo $idProd;?>" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        // Iterar sobre las imágenes del producto para crear los elementos del carousel
                        foreach ($fotos_productos as $index => $foto) {
                        ?>
                            <div class="carousel-item <?php if ($index === 0) echo 'active'; ?>">
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($foto->IMAGEN); ?>" class="d-block w-100" alt="Slide">
                            </div>
                        <?php } ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel_<?php echo $producto->IDPRODUCTO; ?>" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel_<?php echo $producto->IDPRODUCTO; ?>" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <div class="card-body">
                    <h5 class="card-text fw-bold"><?php echo $producto->TITULO;?><h5>
                    <small class="text-secondary"><h5><?php echo $producto->PRECIO; ?>€</h5></small>
                    <h6 class="text-secondary"><?php echo $producto->DESCRIPCION; ?></h6>
                    <button type="button" class="btn btn-primary opacity-100">Comprar</button>
                </div>
            </div>
        <?php }
      } ?>
    </div>
</div>
</head>
<body>
    
</body>
</html>