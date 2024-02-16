<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producto 1</title>
    <link rel="stylesheet" href="./style/bootstrap.min.css">
    <link rel="stylesheet" href="home.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
<?php
        require_once("./config/p1_lib.php");
        $e = isset($_GET["e"]) ? $_GET["e"]: null ;

        if(!(isset($_SESSION["username"]) && isset($_SESSION["password"]))){
            header("location:index.php");
            exit;
        }
    ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light position-relative top-0 start-0 w-100">
    <div class="container">
        <a class="navbar-brand d-lg-none" href="#">HISPANO</a>
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
                <a class="navbar-brand d-none d-lg-block" href="#">HISPANO</a>
                <ul class="navbar-nav">
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link mx-2" href="home.php">
                            <i class="fa fa-home"></i>Home
                        </a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link mx-2" href="myaccount.php">
                            <i class="fas fa-user"></i>Mi cuenta
                        </a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link mx-2" href="products.php">
                            <i class="fa fa-upload" aria-hidden="true"></i>Subir Producto
                        </a>
                    </li>
                    <?php
                        $conn = get_connection();
                        db_usuario_admin($conn, $_SESSION["username"]);
                        $conn ->close();
                     ?>
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link mx-2" href="logout.php">
                            <i class="fa fa-sign-out-alt" aria-hidden="true"></i>Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>
            <div>
                <ul class="navbar d-flex justify-content-center align-items-center pt-3">
                    <li class="nav-item mx-2" style="list-style-type: none;">
                        <a class="nav-link" href="#">
                            <i class="fa fa-music" aria-hidden="true"></i>
                            Musica
                        </a>
                    </li>
                    <li class="nav-item mx-2" style="list-style-type: none;">
                        <a class="nav-link" href="#">
                            <i class="fa fa-car" aria-hidden="true"></i>
                            Automoviles
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
                            Tecnologia
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<div class="row py-5 g-5">
    <div class="col-12 col-lg-6">
        <img src="./img/picasso.jpeg" class="m-1 w-100" alt="producto"/>
    </div>
    <div class="col-12 col-lg-6 d-flex flex-column">
        <h2>Vespa Vintage</h2>
        <h3 class="text-muted">Lucía S</h3>
        <h4 class="my-3">350 €</h2>
        <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat 
            non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
            <div class="border text-center my-5">
                <h2>Garantía HISPANO</h2>
                <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat 
            non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
            <button type="button" class="btn btn-primary btn-lg d-block mx-auto mt-auto" style="width:30em">
            Comprar
            </button>
    </div>
</div>
</body>
</html>