<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel='stylesheet' href='./style/bootstrap.min.css'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
          .carousel-item img {
        width: 100%;
        height: 400px; /* Establece la altura deseada */
    }
    .card-img {
        height: 200px; /* Establece la altura deseada */
        object-fit: cover; /* Escala la imagen para que cubra el contenedor */
    }

    /* Estilos para el contenedor de card-body */
    .card-body {
        height: 200px; /* Establece la altura deseada */
        overflow: hidden; /* Oculta el contenido adicional */
    }
    </style>

</head>
<body>
    
<?php 
        require_once("./config/p1_lib.php");
        require_once("./appdata/p1/usuarios.php");
        require_once("./appdata/p1/productos.php");
        
        $e = isset($_GET["e"]) ? $_GET["e"] : null;
        define("REGISTROS_POR_PAGINA", 4);
        $conn = get_connection();
        $usuario = Usuarios::getById($conn, $_SESSION["id"]);

        if (!(isset($_SESSION["username"]) && isset($_SESSION["pass"])) || $usuario->ESTADO == 1) {
          header("location:index.php");
          exit;
      }

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
            <nav class="navbar navbar-expand-lg navbar-light bg-light position-relative top-0 start-0 w-100">
    <div class="container">
        <a class="navbar-brand d-lg-none" href="index.php">HISPANO</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse p-2 flex-column" id="navbarContent">
            <div class="d-flex justify-content-center justify-content-lg-between flex-column flex-lg-row w-100">
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Buscar" />
                        <button class="btn btn-outline-dark" type="submit">
                            <i class="fa fa-search"></i>    
                        </button>
                </form>
                <a class="navbar-brand d-none d-lg-block" href="home.php">HISPANO</a>
                <ul class="navbar-nav">
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link mx-2" href="myaccount.php">
                            <i class="fa fa-user"></i>Mi cuenta
                        </a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link mx-2" href="products.php">
                            <i class="fa fa-upload" aria-hidden="true"></i>Subir Producto
                        </a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link mx-2" href="carrito.php">
                          <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>Mi Carrito
                          <?php
                          $carrito = unserialize($_COOKIE["carrito"]);
                            if (isset($_COOKIE["carrito"]) && $carrito["idUsuario"] == $_SESSION["id"]) {
                                $suma = 0;
                                foreach ($carrito as $id => $cantidad) {
                                    $suma += $cantidad;
                                }
                                echo "($suma)";
                            } else {
                                echo "(0)";
                            }
                        
                            ?>
                        </a>
                    </li>
                    <?php
                        require_once("./config/configDB.php");
                        if(!$e == null){
                        echo "<p style = 'color:red; font-size:1.2em'>$ERROR_DB[$e]</p>";
                        }
                        db_usuario_admin($conn, $_SESSION["username"]);
                     ?>
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link mx-2" href="logout.php">
                            <i class="fas fa-sign-out-alt" aria-hidden="true"></i>Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>
            <div>
                <ul class="navbar d-flex justify-content-center align-items-center pt-3">
                    <li class="nav-item mx-2" style="list-style-type: none;">
                        <a class="nav-link" href="#">
                            <i class="fa fa-music" aria-hidden="true"></i>
                            Música
                        </a>
                    </li>
                    <li class="nav-item mx-2" style="list-style-type: none;">
                        <a class="nav-link" href="#">
                            <i class="fa fa-car" aria-hidden="true"></i>
                            Automóviles
                        </a>
                    </li>
                    <li class="nav-item mx-2" style="list-style-type: none;">
                        <a class="nav-link" href="#">
                            <i class="fa fa-motorcycle" aria-hidden="true"></i>
                            Motos
                        </a>
                    </li>
                    <li class="nav-item mx-2" style="list-style-type: none;">
                        <a class="nav-link" href="#">
                        <i class="fa fa-laptop" aria-hidden="true"></i> 
                            Tecnología
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="container my-2 mt-3 p-3">
    <div class="row">
        <?php
        $numProductos = count($productos_paginados);
        $minProductos = 4;
        if ($numProductos < $minProductos) {
            $productosFaltantes = $minProductos - $numProductos;
            for ($i = 0; $i < $productosFaltantes; $i++) {
                $producto_por_defecto = new stdClass();
                $producto_por_defecto->IDPRODUCTO = 0; 
                $producto_por_defecto->TITULO = "Producto por defecto";
                $producto_por_defecto->PRECIO = "0";
                $producto_por_defecto->DESCRIPCION = "Descripción del producto por defecto";

                // Agregar el producto por defecto al arreglo de productos paginados
                $productos_paginados[] = $producto_por_defecto;
            }
        }

        foreach ($productos_paginados as $producto) {
            if ($producto->IDPRODUCTO == 0) {
                $imagen_producto = "img/product.png"; 
            } else {
                $fotos_productos = Productos::getAllImagenesProducto($conn, $producto->IDPRODUCTO);
            }
        ?>
            <div class="card h-25 w-25 col-lg-3 col-sm-6">
                <div id="carousel_<?php echo $producto->IDPRODUCTO; ?>" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php if ((isset($fotos_productos)) && !(isset($imagen_producto))) {
                            foreach ($fotos_productos as $index => $foto) { ?>
                                <div class="carousel-item <?php if ($index === 0 && !(isset($imagen_producto))) echo 'active'; ?>">
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($foto->IMAGEN); ?>" class="d-block w-100" alt="Producto">
                                </div>
                        <?php }
                        } else { ?>
                            <div class="carousel-item active">
                                <img src="<?php echo $imagen_producto; ?>" class="d-block w-100" alt="Producto">
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
                    <h5 class="card-text fw-bold"><?php echo $producto->TITULO;?></h5>
                    <small class="text-secondary"><h5><?php echo $producto->PRECIO; ?>€</h5></small>
                    <h6 class="text-secondary"><?php echo $producto->DESCRIPCION; ?></h6>
                    <?php if ($producto->IDPRODUCTO != 0) {
                        $boton ='<a href="anadirCarrito.php?id='.$producto->IDPRODUCTO.'"><button type="button" class="btn btn-primary opacity-100">Comprar</button></a>'; echo $boton;
                    } ?>
                </div>
            </div>
        <?php } $conn = null;?>
    </div>
</div>








<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>