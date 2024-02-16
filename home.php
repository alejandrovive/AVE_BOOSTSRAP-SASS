<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="./style/bootstrap.min.css">
    <link rel="stylesheet" href="home.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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

       $productos = Productos::getProducts($conn);
       /*
       $countProducts = Productos::getCountProductos($conn);
       
       echo $countProducts->TOTAL;
        if (!empty($productos)) {
            foreach ($productos as $producto) {
                echo "Nombre: " . $producto->TITULO . "<br>";
                echo "Precio: " . $producto->PRECIO . "<br>";
                echo "<hr>";
            }
        } else {
            echo "No se encontraron productos.";
        }
       exit;
       
       $paginacion = Productos::getPaginacion($conn, $countProducts->TOTAL);
      
       */
       if (!(isset($_SESSION["username"]) && isset($_SESSION["pass"])) || $usuario->ESTADO == 1) {
           header("location:index.php");
           exit;
       }
       
       
       
    ?>
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
                    <?php
                        require_once("./config/configDB.php");
                        $conn = get_connection();
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
<div class="container position-relative text-center mt-5">
    <header class="position-relative text-center text-white mb-5">
        <img src="./img/picasso.jpeg" class="w-75 h-25" alt="home"/> 
            <div class="position-absolute top-50 start-50 translate-middle-x w-100 px-3">
                <h1 class="display-4">Lo que buscas en un click</h1>
                <form action="uploadimage.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="product">
                    <button type="submit" class="btn btn-light">Subir Imagen</button>
                </form>
            </div>
    </header>
    <h2 class="display-6 py-5">Equipate para este otoño</h1>
    <div class="d-flex justify-content-between align-items-center flex-column flex-lg-row my-5" id="new">
        <div class="card m-2">
            <a href="producto.php">
                <img src="./img/picasso.jpeg" class="card-img-top"  height="300" alt="Producto"/> 
            </a>
            <div class="card-body">
                <p class="card-text fw-bold">Vespa Vintage</p>
                <small class="text-secondary">350€</small>
            </div>
        </div>
        <div class="card m-2">
            <a href="./img/user.jpg">
                <img src="./img/crema.jpeg" class="card-img-top"  height="300" alt="Producto"/> 
            </a>
            <div class="card-body">
                <p class="card-text fw-bold">Crema hidratante</p>
                <small class="text-secondary">5€</small>
            </div>
        </div>
        <div class="card m-2">
            <a href="./img/user.jpg">
                <img src="./img/cafe.jpeg" class="card-img-top" height="300" alt="Producto"/> 
            </a>
            <div class="card-body">
                <p class="card-text fw-bold">Café arabico 1KG</p>
                <small class="text-secondary">35€</small>
            </div>
        </div>
        <div class="card m-2">
            <a href="./img/user.jpg">
                <img src="./img/camara.jpeg" class="card-img-top"  height="300" alt="Producto"/> 
            </a>
            <div class="card-body">
                <p class="card-text fw-bold">Canon 300DX</p>
                <small class="text-secondary">500€</small>
            </div>
        </div>
    </div>
    <a href="productos.php" class="btn btn-outline-dark my-5"> 
        Ver todos los productos
    </a>
    <div class="d-flex justify-content-between align-items-center flex-column flex-lg-row my-5" id="new">
        <div class="position-relative m-2">
            <img src="./img/musica.jpeg" class="card-img-top"  height="300" alt="Producto"/> 
            <a href="#" class="btn btn-light position-absolute start-0 bottom-0 ms-2 mb-2 d-block"> 
            Música
            </a>
        </div>
        <div class="position-relative m-2">
            <img src="./img/coches.jpeg" class="card-img-top"  height="300" alt="Producto"/> 
            <a href="#" class="btn btn-light position-absolute start-0 bottom-0 ms-2 mb-2 d-block"> 
            Automóviles
            </a>
        </div>
        <div class="position-relative m-2">
            <img src="./img/moto.jpeg" class="card-img-top"  height="300" alt="Producto"/> 
            <a href="#" class="btn btn-light position-absolute start-0 bottom-0 ms-2 mb-2 d-block"> 
            Motos
            </a>
        </div>
        <div class="position-relative m-2">
            <img src="./img/tecnologia.jpeg" class="card-img-top"  height="300" alt="Producto"/> 
            <a href="#" class="btn btn-light position-absolute start-0 bottom-0 ms-2 mb-2 d-block"> 
            Tecnología
            </a>
        </div>
    </div>
        <footer class="d-flex justify-content-between my-5 mt-auto text-start flex-wrap bg-light">
            <ul class="nav flex-column">
                <li class="fw-bold nav-item">
                    <a href="#" class="nav-link text-dark"> 
                    Productos
                    </a>
                </li> 
                <li class="nav-item">
                    <a href="#" class="nav-link text-muted"> 
                    Coches
                    </a>
                </li>  
                <li class="nav-item">
                    <a href="#" class="nav-link text-muted"> 
                    Música
                    </a>
                </li> 
                <li class="nav-item">
                    <a href="#" class="nav-link text-muted"> 
                    Motos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-muted"> 
                    Tecnología
                    </a>
                </li>     
            </ul>
            <ul class="nav flex-column">
                <li class="fw-bold nav-item text-dark">
                    <a href="#" class="nav-link text-dark"> 
                    Ayuda
                    </a>
                </li> 
                <li class="nav-item">
                    <a href="#" class="nav-link text-muted"> 
                    Política
                    </a>
                </li>  
                <li class="nav-item">
                    <a href="#" class="nav-link text-muted"> 
                    Contacto
                    </a>
                </li>  
                <li class="nav-item">
                    <a href="#" class="nav-link text-muted"> 
                    Devoluciones
                    </a>
                </li> 
                <li class="nav-item">
                    <a href="#" class="nav-link text-muted"> 
                    Historia
                    </a>
                </li>  
            </ul>
            <ul class="nav flex-column">
                <li class="fw-bold nav-item text-dark">
                    <a href="#" class="nav-link text-dark"> 
                    Contenido
                    </a>
                </li> 
                <li class="nav-item">
                    <a href="#" class="nav-link text-muted"> 
                    Sobre nosotros
                    </a>
                </li> 
                <li class="nav-item">
                    <a href="#" class="nav-link text-muted"> 
                    Linkedin
                    </a>
                </li> 
                <li class="nav-item">
                    <a href="#" class="nav-link text-muted"> 
                    Términos y condiciones
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-muted"> 
                    Novedades
                    </a>
                </li>     
            </ul>
            <ul class="nav flex-column">
                <li class="fw-bold nav-item text-dark">
                    <a href="#" class="nav-link text-dark"> 
                    Términos y condiciones
                    </a>
                </li> 
                <li class="nav-item">
                    <a href="#" class="nav-link text-muted"> 
                    Privacidad
                    </a>
                </li> 
                <li class="nav-item">
                    <a href="#" class="nav-link text-muted"> 
                    Responsabilidad Social
                    </a>
                </li> 
                <li class="nav-item">
                    <a href="#" class="nav-link text-muted"> 
                    Seguridad
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-muted"> 
                    Requisitos y obligaciones
                    </a>
                </li>     
            </ul>
        </footer>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>